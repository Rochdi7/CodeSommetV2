/**
 * Base64 Encoder/Decoder Tool
 * Purely client-side - uses btoa/atob for encoding/decoding
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('base64-encoder')) return;
        // Find elements
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Mode toggle buttons
        var toggleBtns = toolSection.querySelectorAll('.rounded-2xl[class*="border"] .rounded-full, .inline-flex > .rounded-full');
        var mode = 'encode';

        if (toggleBtns.length >= 2) {
            toggleBtns[0].addEventListener('click', function () {
                if (mode === 'encode') return;
                mode = 'encode';
                toggleBtns[0].classList.add('bg-[#00AEEF]', 'text-white', 'shadow-md');
                toggleBtns[0].classList.remove('text-[#0F0F0F]', 'hover:bg-gray-50');
                toggleBtns[1].classList.remove('bg-[#00AEEF]', 'text-white', 'shadow-md');
                toggleBtns[1].classList.add('text-[#0F0F0F]', 'hover:bg-gray-50');
                textarea.value = '';
                textarea.placeholder = 'Type or paste your text here...';
                removeResults();
                updateLabel('Enter Text to Encode');
                updateBtnText('Encode to Base64');
            });
            toggleBtns[1].addEventListener('click', function () {
                if (mode === 'decode') return;
                mode = 'decode';
                toggleBtns[1].classList.add('bg-[#00AEEF]', 'text-white', 'shadow-md');
                toggleBtns[1].classList.remove('text-[#0F0F0F]', 'hover:bg-gray-50');
                toggleBtns[0].classList.remove('bg-[#00AEEF]', 'text-white', 'shadow-md');
                toggleBtns[0].classList.add('text-[#0F0F0F]', 'hover:bg-gray-50');
                textarea.value = '';
                textarea.placeholder = 'Paste your Base64 encoded string here...';
                removeResults();
                updateLabel('Enter Base64 String to Decode');
                updateBtnText('Decode from Base64');
            });
        }

        function updateLabel(text) {
            var label = textarea.closest('.space-y-6')?.querySelector('label, .text-sm.font-medium');
            if (label) label.textContent = text;
        }

        function updateBtnText(text) {
            var svg = actionBtn.querySelector('svg');
            actionBtn.textContent = '';
            if (svg) actionBtn.appendChild(svg);
            actionBtn.appendChild(document.createTextNode(text));
        }

        // Character counter
        textarea.addEventListener('input', function () {
            var counter = textarea.closest('.space-y-6')?.querySelector('.text-xs.text-gray-500');
            if (counter) counter.textContent = textarea.value.length + ' characters';
        });

        // Main action
        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            var input = textarea.value.trim();
            if (!input) {
                CodeSommetTools.showError('Please enter some text');
                return;
            }

            var result;
            try {
                if (mode === 'encode') {
                    result = btoa(unescape(encodeURIComponent(input)));
                } else {
                    result = decodeURIComponent(escape(atob(input)));
                }
            } catch (e) {
                CodeSommetTools.showError(mode === 'encode' ? 'Failed to encode text. Please check your input.' : 'Invalid Base64 string. Please check your input.');
                return;
            }

            CodeSommetTools.incrementUsage('base64-encoder');
            showResult(input, result);
        });

        // Ctrl+Enter shortcut
        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && (e.metaKey || e.ctrlKey)) {
                e.preventDefault();
                actionBtn.click();
            }
        });

        function showResult(input, result) {
            removeResults();
            var inputLen = input.length;
            var resultLen = result.length;
            var sizeInfo = mode === 'encode' ? '<span>Size increase: ' + Math.round((resultLen / inputLen - 1) * 100) + '%</span>' : '';

            var html = '<div id="tool-results" class="space-y-6 mt-8">' +
                '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8">' +
                '<div class="space-y-4">' +
                '<div class="flex items-center justify-between">' +
                '<h3 class="text-lg font-semibold text-[#0F0F0F]">' + (mode === 'encode' ? 'Base64 Encoded Result' : 'Decoded Text') + '</h3>' +
                '<button id="copy-result-btn" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">' +
                '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy</button>' +
                '</div>' +
                '<div class="bg-[#F8F8F8] rounded-lg p-4 border border-gray-200">' +
                '<p class="text-sm text-[#0F0F0F] font-mono break-all whitespace-pre-wrap">' + escapeHtml(result) + '</p>' +
                '</div>' +
                '<div class="flex items-center justify-between text-xs text-gray-500">' +
                '<span>' + resultLen + ' characters</span>' + sizeInfo +
                '</div></div></div></div>';

            actionBtn.closest('.space-y-8, .space-y-6').insertAdjacentHTML('beforeend', html);

            document.getElementById('copy-result-btn').addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(result, this);
            });
        }

        function removeResults() {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();
        }

        function escapeHtml(str) {
            var div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        CodeSommetTools.initUsageCounter('base64-encoder', 'Base64 operations completed');
    });
})();
