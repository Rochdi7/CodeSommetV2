/**
 * Color Palette Generator Tool
 * Extracts dominant colors from images using Canvas (fully client-side)
 */
(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        if (!CodeSommetTools.isTool('color-palette-generator')) return;
        // Find elements - this tool uses max-w-4xl not max-w-5xl
        var dropZone = document.querySelector('.border-dashed');
        var fileInput = document.querySelector('input[type="file"]');
        var chooseBtn = dropZone ? dropZone.querySelector('button') : null;
        var generateBtn = document.querySelector('button[class*="bg-gradient"]');
        if (!fileInput || !generateBtn) return;
        generateBtn.id = 'tool-action-btn';

        var selectedFile = null;
        var previewEl = null;

        // Wire up "Choose Image" button to trigger file input
        if (chooseBtn) {
            chooseBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.click();
            });
        }

        // Wire up drop zone click
        if (dropZone) {
            dropZone.addEventListener('click', function (e) {
                if (e.target === chooseBtn || chooseBtn?.contains(e.target)) return;
                fileInput.click();
            });

            // Drag and drop
            dropZone.addEventListener('dragover', function (e) {
                e.preventDefault();
                dropZone.classList.add('border-[#00AEEF]', 'bg-blue-50');
            });
            dropZone.addEventListener('dragleave', function () {
                dropZone.classList.remove('border-[#00AEEF]', 'bg-blue-50');
            });
            dropZone.addEventListener('drop', function (e) {
                e.preventDefault();
                dropZone.classList.remove('border-[#00AEEF]', 'bg-blue-50');
                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    handleFile(e.dataTransfer.files[0]);
                }
            });
        }

        // File input change
        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files[0]) {
                handleFile(fileInput.files[0]);
            }
        });

        function handleFile(file) {
            if (!file.type.startsWith('image/')) {
                CodeSommetTools.showError('Please upload an image file (JPG, PNG, WebP, SVG)');
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                CodeSommetTools.showError('File too large. Maximum size is 5MB.');
                return;
            }
            selectedFile = file;
            generateBtn.disabled = false;
            generateBtn.classList.remove('opacity-50');

            // Show preview
            showPreview(file);
        }

        function showPreview(file) {
            if (previewEl) previewEl.remove();
            var reader = new FileReader();
            reader.onload = function (e) {
                previewEl = document.createElement('div');
                previewEl.className = 'mt-4 flex items-center gap-3 p-3 bg-green-50 border border-green-200 rounded-lg';
                previewEl.innerHTML = '<img src="' + e.target.result + '" class="w-12 h-12 rounded-lg object-cover border border-gray-200">' +
                    '<div class="flex-1"><p class="text-sm font-medium text-green-900">' + escapeHtml(file.name) + '</p>' +
                    '<p class="text-xs text-green-700">' + (file.size / 1024).toFixed(1) + ' KB</p></div>' +
                    '<button class="text-red-500 hover:text-red-700 text-sm" id="remove-file">✕</button>';
                if (dropZone) dropZone.insertAdjacentElement('afterend', previewEl);

                document.getElementById('remove-file')?.addEventListener('click', function () {
                    selectedFile = null;
                    previewEl.remove();
                    previewEl = null;
                    generateBtn.disabled = true;
                    generateBtn.classList.add('opacity-50');
                    fileInput.value = '';
                });
            };
            reader.readAsDataURL(file);
        }

        // Generate button click
        generateBtn.addEventListener('click', function () {
            if (!selectedFile) {
                CodeSommetTools.showError('Please upload an image first');
                return;
            }
            CodeSommetTools.hideError();
            CodeSommetTools.setLoading(true);

            var reader = new FileReader();
            reader.onload = function (e) {
                var img = new Image();
                img.crossOrigin = 'anonymous';
                img.onload = function () {
                    try {
                        var colors = extractColors(img, 6);
                        CodeSommetTools.setLoading(false);
                        CodeSommetTools.incrementUsage('color-palette-generator');
                        showResult(colors, e.target.result);
                    } catch (err) {
                        CodeSommetTools.setLoading(false);
                        CodeSommetTools.showError('Failed to extract colors: ' + err.message);
                    }
                };
                img.onerror = function () {
                    CodeSommetTools.setLoading(false);
                    CodeSommetTools.showError('Failed to load image');
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(selectedFile);
        });

        /**
         * Extract dominant colors from image using Canvas + k-means-like quantization
         */
        function extractColors(img, numColors) {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            // Scale down for performance
            var scale = Math.min(1, 200 / Math.max(img.width, img.height));
            canvas.width = Math.floor(img.width * scale);
            canvas.height = Math.floor(img.height * scale);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            var data = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            var pixels = [];
            for (var i = 0; i < data.length; i += 4) {
                var r = data[i], g = data[i + 1], b = data[i + 2], a = data[i + 3];
                if (a < 128) continue; // Skip transparent
                // Skip near-white and near-black
                if (r > 240 && g > 240 && b > 240) continue;
                if (r < 15 && g < 15 && b < 15) continue;
                pixels.push([r, g, b]);
            }

            if (pixels.length === 0) {
                return [{ hex: '#333333', rgb: [51, 51, 51], name: 'Dark Gray' }];
            }

            // Simple color quantization using buckets
            var buckets = {};
            pixels.forEach(function (p) {
                // Round to nearest 32 for bucketing
                var key = [
                    Math.round(p[0] / 32) * 32,
                    Math.round(p[1] / 32) * 32,
                    Math.round(p[2] / 32) * 32
                ].join(',');
                if (!buckets[key]) buckets[key] = { sum: [0, 0, 0], count: 0 };
                buckets[key].sum[0] += p[0];
                buckets[key].sum[1] += p[1];
                buckets[key].sum[2] += p[2];
                buckets[key].count++;
            });

            // Sort by frequency
            var sorted = Object.values(buckets).sort(function (a, b) { return b.count - a.count; });

            // Get top colors with minimum distance
            var result = [];
            for (var j = 0; j < sorted.length && result.length < numColors; j++) {
                var avg = [
                    Math.round(sorted[j].sum[0] / sorted[j].count),
                    Math.round(sorted[j].sum[1] / sorted[j].count),
                    Math.round(sorted[j].sum[2] / sorted[j].count)
                ];
                // Check minimum distance from existing results
                var tooClose = result.some(function (existing) {
                    return colorDistance(existing.rgb, avg) < 60;
                });
                if (!tooClose) {
                    var hex = rgbToHex(avg[0], avg[1], avg[2]);
                    var hsl = rgbToHsl(avg[0], avg[1], avg[2]);
                    result.push({
                        hex: hex,
                        rgb: avg,
                        hsl: hsl,
                        name: getColorName(avg[0], avg[1], avg[2]),
                        usage: getColorUsage(result.length),
                        contrast: getContrastRatio(avg, [255, 255, 255]),
                        wcag: getContrastRatio(avg, [255, 255, 255]) >= 4.5 ? 'AA Pass' : 'AA Fail'
                    });
                }
            }

            return result;
        }

        function colorDistance(a, b) {
            return Math.sqrt(Math.pow(a[0] - b[0], 2) + Math.pow(a[1] - b[1], 2) + Math.pow(a[2] - b[2], 2));
        }

        function rgbToHex(r, g, b) {
            return '#' + [r, g, b].map(function (c) { return c.toString(16).padStart(2, '0'); }).join('');
        }

        function rgbToHsl(r, g, b) {
            r /= 255; g /= 255; b /= 255;
            var max = Math.max(r, g, b), min = Math.min(r, g, b);
            var h, s, l = (max + min) / 2;
            if (max === min) { h = s = 0; }
            else {
                var d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                if (max === r) h = ((g - b) / d + (g < b ? 6 : 0)) / 6;
                else if (max === g) h = ((b - r) / d + 2) / 6;
                else h = ((r - g) / d + 4) / 6;
            }
            return [Math.round(h * 360), Math.round(s * 100), Math.round(l * 100)];
        }

        function getContrastRatio(fg, bg) {
            function lum(rgb) {
                var a = rgb.map(function (v) { v /= 255; return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4); });
                return 0.2126 * a[0] + 0.7152 * a[1] + 0.0722 * a[2];
            }
            var l1 = lum(fg), l2 = lum(bg);
            var lighter = Math.max(l1, l2), darker = Math.min(l1, l2);
            return Math.round(((lighter + 0.05) / (darker + 0.05)) * 100) / 100;
        }

        function getColorName(r, g, b) {
            var hsl = rgbToHsl(r, g, b);
            var h = hsl[0], s = hsl[1], l = hsl[2];
            if (s < 10) return l < 30 ? 'Dark Gray' : l < 70 ? 'Gray' : 'Light Gray';
            if (h < 15 || h >= 345) return l < 40 ? 'Dark Red' : 'Red';
            if (h < 45) return l < 40 ? 'Brown' : 'Orange';
            if (h < 70) return l < 40 ? 'Olive' : 'Yellow';
            if (h < 160) return l < 40 ? 'Dark Green' : 'Green';
            if (h < 200) return l < 40 ? 'Teal' : 'Cyan';
            if (h < 260) return l < 40 ? 'Dark Blue' : 'Blue';
            if (h < 300) return l < 40 ? 'Purple' : 'Violet';
            return l < 40 ? 'Dark Pink' : 'Pink';
        }

        function getColorUsage(idx) {
            var usages = ['Primary Brand Color', 'Secondary Color', 'Accent Color', 'Background Tint', 'Text/UI Color', 'Highlight Color'];
            return usages[idx] || 'Supporting Color';
        }

        function showResult(colors, imageSrc) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var html = '<div id="tool-results" class="space-y-8 mt-8">';

            // Image + palette preview
            html += '<div class="bg-white rounded-2xl border-2 border-gray-200 p-8">' +
                '<h3 class="text-lg font-bold text-black mb-6">Extracted Color Palette</h3>' +
                '<div class="flex gap-6 flex-col md:flex-row">' +
                '<img src="' + imageSrc + '" class="w-32 h-32 rounded-xl object-cover border border-gray-200 flex-shrink-0">' +
                '<div class="flex-1"><div class="flex rounded-xl overflow-hidden h-20 shadow-sm">';
            colors.forEach(function (c) {
                html += '<div class="flex-1" style="background-color:' + c.hex + '" title="' + c.hex + '"></div>';
            });
            html += '</div><p class="text-sm text-gray-500 mt-2">' + colors.length + ' colors extracted</p></div></div></div>';

            // Color cards
            html += '<div class="grid grid-cols-2 md:grid-cols-3 gap-4">';
            colors.forEach(function (c) {
                var textColor = c.contrast > 4.5 ? 'white' : 'black';
                html += '<div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">' +
                    '<div class="h-28 flex items-end p-3" style="background-color:' + c.hex + '">' +
                    '<span class="text-xs font-bold px-2 py-1 rounded-full" style="color:' + textColor + ';background:rgba(0,0,0,0.2)">' + c.name + '</span></div>' +
                    '<div class="p-4 space-y-2">' +
                    '<div class="flex items-center justify-between"><span class="font-mono text-sm font-bold">' + c.hex.toUpperCase() + '</span>' +
                    '<button class="copy-color-btn text-xs px-2 py-1 rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors" data-color="' + c.hex + '">Copy</button></div>' +
                    '<div class="text-xs text-gray-500 space-y-1">' +
                    '<div>RGB: ' + c.rgb.join(', ') + '</div>' +
                    '<div>HSL: ' + c.hsl[0] + '°, ' + c.hsl[1] + '%, ' + c.hsl[2] + '%</div>' +
                    '<div>Contrast: ' + c.contrast + ':1 <span class="px-1.5 py-0.5 rounded text-[10px] font-bold ' +
                    (c.wcag === 'AA Pass' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') + '">' + c.wcag + '</span></div>' +
                    '<div class="text-gray-400">' + c.usage + '</div>' +
                    '</div></div></div>';
            });
            html += '</div>';

            // CSS Variables
            var cssVars = ':root {\n';
            colors.forEach(function (c, i) {
                var names = ['primary', 'secondary', 'accent', 'background', 'text', 'highlight'];
                cssVars += '  --color-' + (names[i] || 'color-' + (i + 1)) + ': ' + c.hex + ';\n';
            });
            cssVars += '}';

            // Tailwind config
            var tailwind = 'colors: {\n';
            colors.forEach(function (c, i) {
                var names = ['primary', 'secondary', 'accent', 'background', 'text', 'highlight'];
                tailwind += "  '" + (names[i] || 'color-' + (i + 1)) + "': '" + c.hex + "',\n";
            });
            tailwind += '}';

            html += '<div class="grid md:grid-cols-2 gap-4">' +
                '<div class="bg-white rounded-xl border border-gray-200 p-6"><div class="flex items-center justify-between mb-3">' +
                '<h4 class="font-bold text-black">CSS Variables</h4>' +
                '<button id="copy-css-btn" class="text-xs px-3 py-1 rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy</button></div>' +
                '<pre class="text-xs font-mono bg-[#F8F8F8] rounded-lg p-3 border border-gray-200 overflow-x-auto">' + escapeHtml(cssVars) + '</pre></div>' +
                '<div class="bg-white rounded-xl border border-gray-200 p-6"><div class="flex items-center justify-between mb-3">' +
                '<h4 class="font-bold text-black">Tailwind Config</h4>' +
                '<button id="copy-tw-btn" class="text-xs px-3 py-1 rounded-full bg-gray-100 hover:bg-[#00AEEF] hover:text-white transition-colors">Copy</button></div>' +
                '<pre class="text-xs font-mono bg-[#F8F8F8] rounded-lg p-3 border border-gray-200 overflow-x-auto">' + escapeHtml(tailwind) + '</pre></div></div>';

            html += '</div>';

            // Insert after the form section
            var formSection = document.querySelector('section.max-w-4xl');
            if (formSection) formSection.insertAdjacentHTML('afterend', html);

            // Copy handlers
            document.querySelectorAll('.copy-color-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    CodeSommetTools.copyToClipboard(btn.dataset.color, btn);
                });
            });
            document.getElementById('copy-css-btn')?.addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(cssVars, this);
            });
            document.getElementById('copy-tw-btn')?.addEventListener('click', function () {
                CodeSommetTools.copyToClipboard(tailwind, this);
            });
        }

        function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

        CodeSommetTools.initUsageCounter('color-palette-generator', 'palettes generated');
    });
})();
