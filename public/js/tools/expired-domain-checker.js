/**
 * Vérificateur de domaines expirés — /tools/expired-domain-checker
 *
 * Interrogation des registres (RDAP) et du DNS côté serveur
 * (ExpiredDomainCheckerTool, API d'exécution /api/v2) ; ce script affiche
 * les résultats et les exports.
 */
(function () {
    'use strict';

    var T = window.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;

    var STATUS = {
        available: ['pass', 'Disponible'],
        registered: ['muted', 'Enregistré'],
        unknown: ['warn', 'À vérifier']
    };

    function run() {
        var raw = $('rt-domains').value.trim();
        if (!raw) throw new Error('Collez au moins un nom de domaine.');
        return window.ToolRuns.start('expired-domain-checker', { domains: raw }).then(function (data) {
            last = data;
            var s = data.summary;
            T.stat('ed-stat-total', s.total);
            T.stat('ed-stat-available', s.available);
            T.stat('ed-stat-registered', s.registered);
            T.stat('ed-stat-unknown', s.unknown);
            T.stat('ed-stat-expiring', s.expiringWithin30Days);

            var invalid = $('ed-invalid');
            if (data.invalid && data.invalid.length) {
                invalid.textContent = 'Ignorés (format invalide) : ' + data.invalid.join(', ');
                invalid.classList.remove('hidden');
            } else {
                invalid.classList.add('hidden');
            }

            $('ed-table').innerHTML = T.table([
                { key: 'domain', label: 'Domaine', render: function (r) { return '<span class="tv-mono">' + esc(r.domain) + '</span>'; } },
                { key: 'status', label: 'Statut', render: function (r) {
                    var st = STATUS[r.status] || STATUS.unknown;
                    return T.badge(st[0], st[1]) + (r.reason ? '<div class="text-xs text-gray-500 mt-1">' + esc(r.reason) + '</div>' : '');
                } },
                { key: 'registrar', label: 'Registraire', render: function (r) { return esc(r.registrar || '—'); } },
                { key: 'created', label: 'Création', render: function (r) { return esc(r.created || '—') + (typeof r.ageYears === 'number' ? '<div class="text-xs text-gray-500">' + r.ageYears + ' an(s)</div>' : ''); } },
                { key: 'expires', label: 'Expiration', render: function (r) {
                    if (!r.expires) return '—';
                    var d = r.daysUntilExpiry;
                    var note = typeof d === 'number' ? (d >= 0 ? 'dans ' + T.fmt(d) + ' j' : 'dépassée') : '';
                    return esc(r.expires) + (note ? '<div class="text-xs ' + (typeof d === 'number' && d <= 30 ? 'text-red-600' : 'text-gray-500') + '">' + note + '</div>' : '');
                } },
                { key: 'dns', label: 'DNS', render: function (r) { return r.dns === true ? 'Résout' : (r.dns === false ? 'Aucun' : '—'); } }
            ], data.rows, 'Aucun domaine vérifié.');
            return data;
        });
    }

    T.onReady(function () {
        T.register({
            slug: 'expired-domain-checker',
            usageText: 'vérifications',
            run: run,
            fileHint: function () { return 'domaines'; },
            summary: function () {
                if (!last) return '';
                return last.rows.map(function (r) {
                    return r.domain + ' — ' + (STATUS[r.status] || STATUS.unknown)[1] + (r.expires ? ' (expire le ' + r.expires + ')' : '');
                }).join('\n');
            },
            rows: function () {
                if (!last) return [];
                return last.rows.map(function (r) {
                    return {
                        domain: r.domain, status: r.status, registrar: r.registrar || '', created: r.created || '',
                        expires: r.expires || '', days_until_expiry: typeof r.daysUntilExpiry === 'number' ? r.daysUntilExpiry : '',
                        dns: r.dns === true ? 'oui' : (r.dns === false ? 'non' : ''), note: r.reason || ''
                    };
                });
            }
        });
    });
})();
