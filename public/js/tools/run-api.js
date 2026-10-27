/**
 * Client of the versioned analysis-run API (docs/reverse-engineering/seosignalx/
 * phase-a-api-contract.md): POST /api/v2/tools/{slug}/runs, then — only when
 * the server queued the run (202) — poll GET /api/v2/runs/{id}.
 *
 * Used by the tools whose analysis is persisted as a run (llms-txt-generator,
 * meta-extractor, expired-domain-checker). Errors are thrown as Error with the
 * server's user-safe message, so ToolsV2.register() displays them as-is.
 */
(function () {
    'use strict';

    var POLL_MAX = 90; // ≈ 3 min; the server reports stale runs as failed anyway

    function csrf() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') : '';
    }

    function readJson(res) {
        return res.text().then(function (text) {
            var json = {};
            try { json = JSON.parse(text); } catch (e) { /* non-JSON error page */ }
            return { status: res.status, json: json, retryAfter: res.headers.get('Retry-After') };
        });
    }

    function message(body) {
        var e = body && body.error;
        if (e && typeof e === 'object') {
            if (e.fields) {
                var first = Object.keys(e.fields)[0];
                if (first && e.fields[first] && e.fields[first][0]) return e.fields[first][0];
            }
            if (e.message) return e.message;
        }
        return 'L\'analyse a échoué. Vérifiez votre saisie et réessayez.';
    }

    function setStage(text) {
        var el = document.getElementById('tool-run-status');
        if (el) { el.textContent = text || ''; el.hidden = !text; }
    }

    function poll(id, token, attempt) {
        if (attempt >= POLL_MAX) return Promise.reject(new Error('L\'analyse prend plus de temps que prévu. Réessayez dans quelques minutes.'));
        return new Promise(function (resolve) { setTimeout(resolve, attempt < 5 ? 1000 : 2000); })
            .then(function () {
                return fetch('/api/v2/runs/' + encodeURIComponent(id), { headers: { 'Accept': 'application/json', 'X-Run-Token': token } });
            })
            .then(readJson)
            .then(function (r) {
                var run = (r.json && r.json.run) || {};
                if (r.status === 200 && run.status === 'completed') { setStage(''); return r.json.result; }
                if (r.status !== 200 || run.status === 'failed') { setStage(''); throw new Error(message(r.json)); }
                setStage(run.stage || 'Analyse en cours…');
                return poll(id, token, attempt + 1);
            });
    }

    function start(slug, payload) {
        return fetch('/api/v2/tools/' + encodeURIComponent(slug) + '/runs', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf() },
            body: JSON.stringify(payload || {})
        })
            .then(readJson, function () { throw new Error('Connexion interrompue. Vérifiez votre réseau et réessayez.'); })
            .then(function (r) {
                var body = r.json || {};
                if (r.status === 201 && body.result) return body.result;
                if (r.status === 202 && body.run) { setStage('Analyse en file d\'attente…'); return poll(body.run.id, body.accessToken, 0); }
                if (r.status === 429) throw new Error('Limite de requêtes atteinte. Réessayez dans ' + (parseInt(r.retryAfter || '60', 10)) + ' secondes.');
                throw new Error(message(body));
            });
    }

    window.ToolRuns = { start: start };
})();
