/**
 * Readability Score Analyzer Tool
 * Client-side readability algorithms (Flesch, SMOG, Coleman-Liau)
 */
(function () {
    'use strict';
    CodeSommetTools.onReady(function () {
        var toolSection = document.querySelector('section.max-w-5xl');
        if (!toolSection) return;
        if (!CodeSommetTools.isTool('readability-analyzer')) return;
        var textarea = toolSection.querySelector('textarea');
        var actionBtn = toolSection.querySelector('button[class*="bg-gradient"], button.w-full');
        if (!textarea || !actionBtn) return;
        actionBtn.id = 'tool-action-btn';

        // Tab toggle
        var tabBtns = toolSection.querySelectorAll('.bg-white.rounded-2xl[class*="border"][class*="p-2"] button');
        var inputMode = 'text';

        if (tabBtns.length >= 2) {
            tabBtns[0].addEventListener('click', function () {
                inputMode = 'text';
                tabBtns[0].classList.add('bg-[#00AEEF]', 'text-white');
                tabBtns[1].classList.remove('bg-[#00AEEF]', 'text-white');
            });
            tabBtns[1].addEventListener('click', function () {
                inputMode = 'url';
                tabBtns[1].classList.add('bg-[#00AEEF]', 'text-white');
                tabBtns[0].classList.remove('bg-[#00AEEF]', 'text-white');
            });
        }

        actionBtn.addEventListener('click', function () {
            CodeSommetTools.hideError();
            if (inputMode === 'url') {
                CodeSommetTools.showError('L\'analyse par URL nécessite un traitement côté serveur. Veuillez coller votre texte directement.');
                return;
            }
            var text = textarea.value.trim();
            if (!text) { CodeSommetTools.showError('Veuillez coller un texte'); return; }
            if (text.split(/\s+/).length < 30) { CodeSommetTools.showError('Veuillez saisir au moins 30 mots pour une analyse précise'); return; }

            var scores = analyzeReadability(text);
            CodeSommetTools.incrementUsage('readability-analyzer');
            showResult(scores);
        });

        /* ── Détection de langue ───────────────────────────────────────────
         * Les formules de lisibilité sont calibrées par langue. Appliquer
         * Flesch (anglais) à un texte français surestime systématiquement la
         * difficulté, car le français compte davantage de syllabes par mot.
         * On détecte donc la langue avant de choisir la formule.
         */
        function detectLanguage(text) {
            var lower = text.toLowerCase();
            // Mots grammaticaux très fréquents, discriminants entre FR et EN.
            var frMarkers = /\b(le|la|les|des|une|est|sont|pour|dans|avec|vous|nous|que|qui|plus|cette|ces|leur|mais|sur|par)\b/g;
            var enMarkers = /\b(the|and|for|are|with|you|this|that|from|have|been|will|your|they|what|which|their|would)\b/g;
            var fr = (lower.match(frMarkers) || []).length;
            var en = (lower.match(enMarkers) || []).length;
            // Les diacritiques renforcent l'hypothèse française.
            var accents = (lower.match(/[àâäéèêëïîôöùûüÿçœæ]/g) || []).length;
            return (fr + accents * 0.5) > en ? 'fr' : 'en';
        }

        /* ── Comptage de syllabes ──────────────────────────────────────────
         * L'ancienne version faisait `replace(/[^a-z]/g,'')`, ce qui supprimait
         * purement et simplement toutes les lettres accentuées : « activité »
         * était réduit à « activit » et comptait 3 syllabes au lieu de 4,
         * « créons » 1 au lieu de 2. Sur un site francophone, l'erreur était
         * systématique. On conserve désormais les voyelles accentuées.
         */
        function countSyllablesEn(word) {
            word = word.toLowerCase().replace(/[^a-z]/g, '');
            if (!word) return 0;
            if (word.length <= 3) return 1;
            word = word.replace(/(?:[^laeiouy]es|ed|[^laeiouy]e)$/, '');
            word = word.replace(/^y/, '');
            var matches = word.match(/[aeiouy]{1,2}/g);
            return matches ? matches.length : 1;
        }

        function countSyllablesFr(word) {
            // On garde les voyelles accentuées : elles portent la syllabe.
            word = word.toLowerCase().replace(/[^a-zàâäéèêëïîôöùûüÿçœæ]/g, '');
            if (!word) return 0;

            var V = 'aeiouyàâäéèêëïîôöùûüÿœæ';
            var groups = word.match(new RegExp('[' + V + ']+', 'g'));
            if (!groups) return 1;

            // Un groupe vocalique ne vaut pas toujours une syllabe : « eau »
            // n'en fait qu'une, tandis que « éo » dans « créons » en fait deux
            // (hiatus). On compte donc les noyaux à l'intérieur de chaque groupe
            // au lieu de compter les groupes.
            var count = 0;
            groups.forEach(function (g, i) {
                // Le dernier groupe suit des règles propres (hiatus « -ie »).
                var isFinal = (i === groups.length - 1) && word.endsWith(g);
                count += countNucleiInGroup(g, isFinal);
            });

            // « e » final muet : « porte » = 1 syllabe. Un « e » accentué se
            // prononce (« café »), d'où la classe restreinte au « e » nu.
            if (/[^aeiouyàâäéèêëïîôöùûüÿœæ]e$/.test(word) && count > 1) count--;
            // « -es » muet : « portes », « parles ».
            else if (/[^aeiouyàâäéèêëïîôöùûüÿœæ]es$/.test(word) && count > 1) count--;
            // « -ent » muet UNIQUEMENT en finale verbale (« parlent » = 2 :
            // par-lent, le « -ent » ne se prononce pas mais « par » et « l' »
            // portent déjà 2 noyaux comptés plus haut).
            // Attention : dans « référencement » ou « moment », « -ment » est
            // un suffixe nominal bien prononcé — d'où l'exclusion de « -ment ».
            // Le retrait n'est appliqué que s'il reste au moins 2 syllabes,
            // sans quoi « parlent » tomberait à 1.
            else if (/[^aeiouyàâäéèêëïîôöùûüÿœæ]ent$/.test(word) && !/ment$/.test(word) && count > 2) count--;

            return Math.max(1, count);
        }

        /* Nombre de noyaux syllabiques dans un groupe de voyelles contiguës.
         * Les digrammes/trigrammes français (ai, au, eau, ou, oi, eu…) forment
         * un seul son ; ce qui reste après les avoir retirés est un hiatus et
         * compte pour une syllabe supplémentaire. */
        function countNucleiInGroup(g, isFinal) {
            if (g.length === 1) return 1;

            // « -ie » final compte pour un seul noyau : « vie » = 1,
            // « stratégie » = stra-té-gie (3, dont « gie » = 1). Le « e » final
            // muet est traité par la règle générale dans countSyllablesFr.
            if (isFinal && g === 'ie') return 1;

            // Retire les combinaisons stables, de la plus longue à la plus courte.
            var reduced = g
                .replace(/eau|aie|oei/g, 'A')
                .replace(/ai|au|ei|eu|ou|oi|oe|ue|ui|ya|yo|œu|ae/g, 'A');
            // Chaque « A » vaut un noyau ; chaque voyelle restante aussi.
            var nuclei = (reduced.match(/A/g) || []).length
                + (reduced.match(/[aeiouyàâäéèêëïîôöùûüÿœæ]/g) || []).length;
            return Math.max(1, nuclei);
        }

        function analyzeReadability(text) {
            var lang = detectLanguage(text);
            var countSyllables = lang === 'fr' ? countSyllablesFr : countSyllablesEn;

            // \w ne reconnaît pas les accents : on utilise une classe explicite
            // pour ne pas découper « activité » en « activit » + « é ».
            var words = text.match(/[A-Za-zÀ-ÖØ-öø-ÿŒœÆæ0-9'’-]+/g) || [];
            var sentences = text.split(/[.!?…]+/).filter(function (s) { return s.trim().length > 0; });
            var wordCount = words.length;
            var sentenceCount = sentences.length;

            // Garde-fou : sans mot ni phrase, toutes les formules divisent par
            // zéro et renvoyaient NaN, affiché tel quel dans l'interface.
            if (wordCount === 0 || sentenceCount === 0) {
                return {
                    empty: true, lang: lang,
                    flesch: 0, fkGrade: 0, smog: 0, coleman: 0,
                    gradeLevel: 'Texte insuffisant pour une analyse',
                    wordCount: 0, sentenceCount: 0, avgWordsPerSentence: 0,
                    complexCount: 0, complexPct: 0, readingTime: 0, passed: false
                };
            }

            var totalSyllables = words.reduce(function (sum, w) { return sum + countSyllables(w); }, 0);
            var complexCount = words.filter(function (w) { return countSyllables(w) >= 3; }).length;
            var avgWordsPerSentence = wordCount / sentenceCount;
            var avgSyllablesPerWord = totalSyllables / wordCount;
            var charsCount = words.join('').length;

            var flesch, formulaName;
            if (lang === 'fr') {
                // Kandel & Moles (1958) : adaptation française de Flesch,
                // recalibrée sur la densité syllabique du français.
                flesch = 207 - (1.015 * avgWordsPerSentence) - (73.6 * avgSyllablesPerWord);
                formulaName = 'Kandel-Moles (adaptation française)';
            } else {
                flesch = 206.835 - (1.015 * avgWordsPerSentence) - (84.6 * avgSyllablesPerWord);
                formulaName = 'Flesch Reading Ease';
            }
            flesch = Math.max(0, Math.min(100, Math.round(flesch * 10) / 10));

            var fkGrade = (0.39 * avgWordsPerSentence) + (11.8 * avgSyllablesPerWord) - 15.59;
            fkGrade = Math.max(0, Math.round(fkGrade * 10) / 10);

            // SMOG exige au moins 3 phrases pour être défini.
            var smog = sentenceCount >= 3
                ? 1.0430 * Math.sqrt(complexCount * (30 / sentenceCount)) + 3.1291
                : 0;
            smog = Math.round(smog * 10) / 10;

            var L = (charsCount / wordCount) * 100;
            var S = (sentenceCount / wordCount) * 100;
            var coleman = (0.0588 * L) - (0.296 * S) - 15.8;
            coleman = Math.max(0, Math.round(coleman * 10) / 10);

            var gradeLevel;
            if (flesch >= 90) gradeLevel = lang === 'fr' ? 'Très facile (niveau primaire)' : '5th Grade (Very Easy)';
            else if (flesch >= 80) gradeLevel = lang === 'fr' ? 'Facile (niveau collège)' : '6th Grade (Easy)';
            else if (flesch >= 70) gradeLevel = lang === 'fr' ? 'Assez facile' : '7th Grade (Fairly Easy)';
            else if (flesch >= 60) gradeLevel = lang === 'fr' ? 'Standard (grand public)' : '8th-9th Grade (Standard)';
            else if (flesch >= 50) gradeLevel = lang === 'fr' ? 'Assez difficile (niveau lycée)' : '10th-12th Grade (Fairly Difficult)';
            else if (flesch >= 30) gradeLevel = lang === 'fr' ? 'Difficile (niveau supérieur)' : 'College (Difficult)';
            else gradeLevel = lang === 'fr' ? 'Très difficile (spécialisé)' : 'College Graduate (Very Difficult)';

            // Vitesse de lecture : ~200 mots/min en français, ~238 en anglais.
            var wpm = lang === 'fr' ? 200 : 238;

            return {
                empty: false, lang: lang, formulaName: formulaName,
                flesch: flesch, fkGrade: fkGrade, smog: smog, coleman: coleman,
                gradeLevel: gradeLevel, wordCount: wordCount, sentenceCount: sentenceCount,
                avgWordsPerSentence: Math.round(avgWordsPerSentence * 10) / 10,
                avgSyllablesPerWord: Math.round(avgSyllablesPerWord * 100) / 100,
                complexCount: complexCount,
                complexPct: Math.round((complexCount / wordCount) * 100),
                readingTime: Math.max(1, Math.round(wordCount / wpm)),
                passed: flesch >= 50
            };
        }

        function showResult(s) {
            var existing = document.getElementById('tool-results');
            if (existing) existing.remove();

            var color = s.flesch >= 60 ? 'green' : s.flesch >= 40 ? 'yellow' : 'red';

            var html = '<div id="tool-results" class="space-y-6 mt-8">';

            // Main score
            html += '<div class="rounded-2xl border-2 p-8 bg-' + color + '-50 border-' + color + '-200 text-center">' +
                '<div class="text-6xl font-bold text-' + color + '-600 mb-2">' + s.flesch + '</div>' +
                '<div class="text-lg font-semibold text-' + color + '-900">Indice de lisibilité Flesch</div>' +
                '<div class="text-sm text-' + color + '-700 mt-1">' + s.gradeLevel + '</div></div>';

            // Score cards
            html += '<div class="grid grid-cols-2 md:grid-cols-4 gap-4">' +
                scoreCard(s.fkGrade, 'Flesch-Kincaid Grade') +
                scoreCard(s.smog || 'N/A', 'SMOG Index') +
                scoreCard(s.coleman, 'Coleman-Liau') +
                scoreCard(s.readingTime + ' min', 'Reading Time') +
                '</div>';

            // Stats
            html += '<div class="grid md:grid-cols-2 gap-6">' +
                '<div class="bg-[#F8F8F8] rounded-xl p-6"><h3 class="text-lg font-bold text-black mb-4">Statistiques du texte</h3><div class="space-y-3">' +
                statRow('Words', s.wordCount) +
                statRow('Sentences', s.sentenceCount) +
                statRow('Avg Words/Sentence', s.avgWordsPerSentence) +
                statRow('Complex Words', s.complexCount + ' (' + s.complexPct + '%)') +
                '</div></div>' +
                '<div class="bg-[#F8F8F8] rounded-xl p-6"><h3 class="text-lg font-bold text-black mb-4">Recommendations</h3><div class="space-y-3 text-sm">';

            if (s.avgWordsPerSentence > 20) html += '<p class="text-yellow-700">• Shorten sentences to under 20 words for better readability</p>';
            if (s.complexPct > 15) html += '<p class="text-yellow-700">• Replace complex words with simpler alternatives (' + s.complexPct + '% complex)</p>';
            if (s.flesch < 50) html += '<p class="text-red-700">• Content is difficult to read. Aim for a score above 60 for general audiences</p>';
            if (s.flesch >= 60) html += '<p class="text-green-700">• Good readability! Content is accessible to a wide audience</p>';

            html += '</div></div></div></div>';

            actionBtn.closest('section').querySelector('.space-y-6.mb-8, .space-y-6').insertAdjacentHTML('afterend', html);
        }

        function scoreCard(v, l) {
            return '<div class="bg-white rounded-xl border border-gray-100 p-6"><div class="text-2xl font-bold text-[#00AEEF]">' + v + '</div><div class="text-sm text-gray-600 mt-1">' + l + '</div></div>';
        }
        function statRow(l, v) {
            return '<div class="flex justify-between items-center"><span class="text-gray-600">' + l + '</span><span class="font-semibold text-black">' + v + '</span></div>';
        }

        CodeSommetTools.initUsageCounter('readability-analyzer', 'texts analyzed');
    });
})();
