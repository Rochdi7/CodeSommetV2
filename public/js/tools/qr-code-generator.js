/**
 * QR Code Generator Tool
 * Uses Google Charts API for QR code generation (no library needed)
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('qr-code-generator')) return;
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        var inputs = toolSection.querySelectorAll('input[type="text"], input[type="url"], textarea');
        var contentInput = inputs[0];
        var selects = toolSection.querySelectorAll('select');
        var sizeSelect = selects.length > 0 ? selects[0] : null;

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var content = contentInput ? contentInput.value.trim() : '';
            if (!content) { CodeSommetTools.showError('Please enter a URL or text'); return; }

            var size = sizeSelect ? parseInt(sizeSelect.value) || 256 : 256;
            CodeSommetTools.incrementUsage('qr-code-generator');
            showResult(content, size);
        });

        function showResult(content, size) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            // Use a QR code generation approach via canvas
            var qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=' + size + 'x' + size + '&data=' + encodeURIComponent(content) + '&format=png&ecc=M';

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8 text-center">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F] mb-6">Generated QR Code</h3>' +
                '<div class="inline-block p-6 bg-white border-2 border-gray-100 rounded-2xl shadow-sm">' +
                '<img id="qr-image" src="' + qrUrl + '" alt="QR Code" width="' + size + '" height="' + size + '" class="mx-auto" crossorigin="anonymous">' +
                '</div>' +
                '<div class="mt-6 flex justify-center gap-4">' +
                '<button id="download-qr-btn" class="flex items-center gap-2 px-6 py-3 text-sm font-medium rounded-full bg-[#00AEEF] text-white hover:bg-[#0071BC] transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> Download PNG</button>' +
                '<button id="copy-url-btn" class="flex items-center gap-2 px-6 py-3 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy URL</button>' +
                '</div>' +
                '<div class="mt-4 grid grid-cols-2 gap-4 max-w-md mx-auto">' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg"><div class="text-sm font-semibold text-[#00AEEF]">Size</div><div class="text-xs text-gray-600">' + size + 'x' + size + ' px</div></div>' +
                '<div class="bg-[#F8F8F8] p-3 rounded-lg"><div class="text-sm font-semibold text-[#00AEEF]">Content</div><div class="text-xs text-gray-600 truncate">' + escapeHtml(content.substring(0, 50)) + '</div></div>' +
                '</div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);

            document.getElementById('download-qr-btn')?.addEventListener('click', function () {
                var img = document.getElementById('qr-image');
                var canvas = document.createElement('canvas');
                canvas.width = size;
                canvas.height = size;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, size, size);
                var link = document.createElement('a');
                link.download = 'qr-code.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });

            document.getElementById('copy-url-btn')?.addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(content, this);
            });
        }

        function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('qr-code-generator', 'QR codes generated');
    });
})();
