/**
 * Compresseur d'images — /tools/image-compressor
 * Réencodage par le moteur canvas du navigateur : aucune image n'est envoyée.
 */
(function (root) {
    'use strict';

    var MAX_FILES = 30;
    var MAX_BYTES = 25 * 1024 * 1024;
    var ACCEPTED = /^image\/(jpeg|png|webp)$/;

    /** Dimensions de sortie (jamais d'agrandissement). */
    function targetSize(w, h, maxWidth) {
        if (!maxWidth || w <= maxWidth) return { width: w, height: h };
        return { width: maxWidth, height: Math.max(1, Math.round(h * maxWidth / w)) };
    }

    function outputName(name, mime) {
        var ext = { 'image/webp': 'webp', 'image/jpeg': 'jpg', 'image/png': 'png' }[mime] || 'img';
        return name.replace(/\.[^.]+$/, '') + '-optimise.' + ext;
    }

    function formatBytes(n) {
        if (n < 1024) return n + ' o';
        if (n < 1048576) return (n / 1024).toFixed(1).replace('.', ',') + ' Ko';
        return (n / 1048576).toFixed(2).replace('.', ',') + ' Mo';
    }

    if (typeof module !== 'undefined' && module.exports) { module.exports = { targetSize: targetSize, outputName: outputName, formatBytes: formatBytes }; }
    if (typeof root.document === 'undefined' || !root.ToolsV2) return;

    var T = root.ToolsV2;
    var $ = T.$;
    var esc = T.escapeHtml;
    var last = null;
    var objectUrls = [];

    function loadImage(file) {
        return new Promise(function (resolve, reject) {
            var url = URL.createObjectURL(file);
            var img = new Image();
            img.onload = function () { resolve({ img: img, url: url }); };
            img.onerror = function () { URL.revokeObjectURL(url); reject(new Error('Image illisible')); };
            img.src = url;
        });
    }

    function encode(file, mime, quality, maxWidth) {
        return loadImage(file).then(function (loaded) {
            var size = targetSize(loaded.img.naturalWidth, loaded.img.naturalHeight, maxWidth);
            var canvas = document.createElement('canvas');
            canvas.width = size.width;
            canvas.height = size.height;
            var ctx = canvas.getContext('2d');
            if (mime === 'image/jpeg') { ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, size.width, size.height); } // pas de transparence en JPEG
            ctx.drawImage(loaded.img, 0, 0, size.width, size.height);
            URL.revokeObjectURL(loaded.url);
            return new Promise(function (resolve) {
                canvas.toBlob(function (blob) {
                    resolve({ blob: blob, width: size.width, height: size.height, original: { width: loaded.img.naturalWidth, height: loaded.img.naturalHeight } });
                }, mime, mime === 'image/png' ? undefined : quality);
            });
        });
    }

    function run() {
        var files = Array.prototype.slice.call($('ix-files').files || []);
        if (!files.length) throw new Error('Sélectionnez au moins une image.');
        if (files.length > MAX_FILES) throw new Error('Maximum ' + MAX_FILES + ' images par lot.');
        var format = $('ix-format').value;
        var quality = parseFloat($('ix-quality').value);
        var maxWidth = parseInt($('ix-width').value, 10) || 0;
        objectUrls.forEach(function (u) { URL.revokeObjectURL(u); });
        objectUrls = [];

        return files.reduce(function (chain, file) {
            return chain.then(function (rows) {
                if (!ACCEPTED.test(file.type)) { rows.push({ name: file.name, before: file.size, error: 'Format non pris en charge (JPEG, PNG ou WebP uniquement)' }); return rows; }
                if (file.size > MAX_BYTES) { rows.push({ name: file.name, before: file.size, error: 'Fichier trop lourd (25 Mo maximum)' }); return rows; }
                var mime = format === 'keep' ? file.type : format;
                return encode(file, mime, quality, maxWidth).then(function (r) {
                    if (!r.blob) { rows.push({ name: file.name, before: file.size, error: 'Ce navigateur ne sait pas produire ce format' }); return rows; }
                    var url = URL.createObjectURL(r.blob);
                    objectUrls.push(url);
                    rows.push({ name: file.name, out: outputName(file.name, r.blob.type || mime), before: file.size, after: r.blob.size, url: url, width: r.width, height: r.height, original: r.original });
                    return rows;
                }, function (e) { rows.push({ name: file.name, before: file.size, error: e.message }); return rows; });
            });
        }, Promise.resolve([])).then(function (rows) {
            var ok = rows.filter(function (r) { return !r.error; });
            var before = ok.reduce(function (s, r) { return s + r.before; }, 0);
            var after = ok.reduce(function (s, r) { return s + r.after; }, 0);
            last = { rows: rows, before: before, after: after };
            T.stat('ix-stat-count', ok.length);
            T.stat('ix-stat-before', formatBytes(before));
            T.stat('ix-stat-after', formatBytes(after));
            T.stat('ix-stat-saving', before ? Math.round((1 - after / before) * 100) + ' %' : '—');
            $('ix-table').innerHTML = T.table([
                { key: 'name', label: 'Image', render: function (r) { return '<span class="tv-break">' + esc(r.name) + '</span>' + (r.original ? '<div class="text-xs text-gray-500">' + r.original.width + '×' + r.original.height + (r.width !== r.original.width ? ' → ' + r.width + '×' + r.height : '') + '</div>' : ''); } },
                { key: 'before', label: 'Avant', render: function (r) { return formatBytes(r.before); } },
                { key: 'after', label: 'Après', render: function (r) {
                    if (r.error) return T.badge('fail', r.error);
                    var gain = Math.round((1 - r.after / r.before) * 100);
                    return formatBytes(r.after) + ' ' + (gain > 0 ? T.badge('pass', '−' + gain + ' %') : T.badge('warn', 'plus lourd : gardez l\'original'));
                } },
                { key: 'dl', label: 'Fichier', render: function (r) { return r.url ? '<a class="text-[#00AEEF] font-semibold hover:underline" href="' + r.url + '" download="' + esc(r.out) + '">Télécharger</a>' : ''; } }
            ], rows, 'Aucune image traitée.');
            return last;
        });
    }

    T.onReady(function () {
        $('ix-files').addEventListener('change', function () {
            var n = ($('ix-files').files || []).length;
            $('ix-picked').textContent = n ? n + ' image(s) sélectionnée(s). Elles restent sur votre appareil.' : 'Aucun fichier sélectionné. Les images restent sur votre appareil.';
        });
        T.register({
            slug: 'image-compressor',
            usageText: 'lots compressés',
            run: run,
            fileHint: function () { return 'images'; },
            summary: function () {
                return last ? last.rows.map(function (r) { return r.name + ' : ' + (r.error ? r.error : formatBytes(r.before) + ' → ' + formatBytes(r.after)); }).join('\n') : '';
            },
            rows: function () {
                return last ? last.rows.map(function (r) { return { image: r.name, fichier: r.out || '', avant_octets: r.before, apres_octets: r.after || '', erreur: r.error || '' }; }) : [];
            }
        });
    });
})(typeof window !== 'undefined' ? window : globalThis);
