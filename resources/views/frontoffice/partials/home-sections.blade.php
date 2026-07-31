{{-- SECTION: Comment Commencer en 3 étapes Simples --}}
<section id="process" class="py-16 md:py-24 bg-[#F5F5F5] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3 md:mb-4" style="font-family: var(--font-heading);">Comment Commencer en 3 étapes Simples</h2>
            <p class="text-base md:text-lg text-[var(--text-secondary)] max-w-2xl mx-auto px-4">Du premier appel à la livraison du projet, voyez exactement comment nous travaillons ensemble</p>
        </div>

        {{-- Mobile : cartes empilées avec visuels intégrés --}}
        <div class="lg:hidden space-y-8">
            {{-- étape 1 : choisissez votre formule --}}
            <div id="mob-step1" class="bg-white rounded-3xl p-6 shadow-lg overflow-hidden">
                <div class="mb-6">
                    <div class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold bg-[var(--text-primary)] text-white">Étape 1</div>
                </div>
                <div class="mb-6 overflow-hidden relative" style="height: 320px;">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="relative w-full max-w-[280px] mx-auto">
                            <div class="relative" style="height: 320px;">
                                {{-- Retainer card (behind, tilted) --}}
                                <div id="mob-retainer" class="absolute top-1/2 left-1/2 bg-white rounded-2xl border border-gray-200 shadow-lg" style="width: 200px; height: 270px; padding: 16px; transform: translateX(-50%) translateY(-50%) rotate(0deg) scale(0.9); opacity: 0;">
                                    <p class="font-semibold mb-3 italic text-base" style="font-family: var(--font-heading);">Retainer</p>
                                    <div class="space-y-1.5 text-xs text-gray-600">
                                        <div class="py-1.5 px-2.5 bg-gray-50 rounded-xl italic">1 projet actif</div>
                                        <div class="py-1.5 px-2.5 bg-gray-50 rounded-xl italic">Révisions illimitées</div>
                                        <div class="py-1.5 px-2.5 bg-gray-50 rounded-xl italic">Design &amp; développement</div>
                                        <div class="py-1.5 px-2.5 bg-gray-50 rounded-xl italic">SEO &amp; contenu</div>
                                    </div>
                                </div>
                                {{-- Développement de Site Web card (front) --}}
                                <div id="mob-website" class="absolute top-1/2 left-1/2 bg-gradient-to-br from-black to-[#1A1A1A] rounded-2xl overflow-hidden shadow-xl" style="width: 200px; height: 270px; transform: translateX(-50%) translateY(-50%) scale(0.9); opacity: 0;">
                                    {{-- Plan details (visible initially) --}}
                                    <div id="mob-plan-details" style="padding: 16px;">
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="text-white">
                                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <span class="text-xs text-white/90 font-medium italic">Recommandé</span>
                                        </div>
                                        <p class="font-semibold mb-3 text-white italic text-lg" style="font-family: var(--font-heading);">Développement de Site Web</p>
                                        <div class="space-y-1.5 text-xs">
                                            <div class="text-white/90 py-1.5 px-2.5 bg-white/10 rounded-xl backdrop-blur-sm italic">Site web sur mesure</div>
                                            <div class="text-white/90 py-1.5 px-2.5 bg-white/10 rounded-xl backdrop-blur-sm italic">Design UI/UX & identité visuelle</div>
                                            <div class="text-white/90 py-1.5 px-2.5 bg-white/10 rounded-xl backdrop-blur-sm italic">Optimisation SEO</div>
                                            <div class="text-white/90 py-1.5 px-2.5 bg-white/10 rounded-xl backdrop-blur-sm italic">Vitrine en 10-20 jours</div>
                                            <div id="mob-book-btn" class="w-full py-1.5 px-2.5 rounded-xl font-medium text-center text-xs bg-white text-gray-900">Demandez un Devis Gratuit</div>
                                        </div>
                                    </div>
                                    {{-- "You have done your part" state --}}
                                    <div id="mob-plan-done" class="absolute inset-0 flex flex-col items-center justify-center" style="padding: 16px; opacity: 0;">
                                        <div class="flex items-center gap-2 mb-3">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="text-white">
                                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <span class="text-xs text-white/90 font-medium">Recommandé</span>
                                        </div>
                                        <div class="flex justify-center mb-4">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" class="text-white process-spin-icon">
                                                <path d="M12 3V6M12 18V21M6 12H3M21 12H18M5.64 5.64L7.76 7.76M16.24 16.24L18.36 18.36M5.64 18.36L7.76 16.24M16.24 7.76L18.36 5.64" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
                                            </svg>
                                        </div>
                                        <div class="text-center space-y-2">
                                            <p class="font-bold text-white leading-snug text-base" style="font-family: var(--font-heading);">Vous avez fait<br>votre part</p>
                                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-3 py-2">
                                                <p class="text-white font-medium text-sm">C'est notre tour maintenant</p>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Cursor --}}
                                    <div id="mob-plan-cursor" class="absolute pointer-events-none z-20" style="opacity:0; bottom:40px; right:40px;">
                                        <svg width="18" height="17" viewBox="0 0 24 23" fill="none">
                                            <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-xl font-semibold text-[var(--text-primary)]" style="font-family: var(--font-heading);">Choisissez Votre Formule</p>
                    <p class="text-base text-gray-600 leading-relaxed">Site vitrine, e-commerce ou forfait mensuel : choisissez la formule qui correspond à votre projet</p>
                </div>
            </div>

            {{-- étape 2 : soumettez votre demande --}}
            <div id="mob-step2" class="bg-white rounded-3xl p-6 shadow-lg overflow-hidden">
                <div class="mb-6">
                    <div class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold bg-[var(--text-primary)] text-white">Étape 2</div>
                </div>
                <div class="mb-6 overflow-hidden relative" style="height: 400px;">
                    <div class="max-w-full mx-auto absolute inset-0 flex items-center justify-center" style="max-width: 300px;">
                        <div id="mob-backlog-card" class="bg-white rounded-2xl shadow-xl border border-gray-200 w-full p-5" style="transform: rotate(-3deg);">
                            <p class="font-semibold text-lg mb-4 text-gray-900" style="font-family: var(--font-heading);">Vos Tâches de Design</p>
                            <div id="mob-backlog-list" class="space-y-2 relative">
                                <div class="mob-backlog-item flex items-center justify-between p-3 rounded-xl border-2 border-gray-200 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                        <span class="text-xs font-medium text-gray-700">Création du site vitrine</span>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 font-medium">Demande</span>
                                </div>
                                <div class="mob-backlog-item flex items-center justify-between p-3 rounded-xl border-2 border-gray-200 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                        <span class="text-xs font-medium text-gray-700">Design identité visuelle</span>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 font-medium">Demande</span>
                                </div>
                                <div class="mob-backlog-item flex items-center justify-between p-3 rounded-xl border-2 border-gray-300 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                        <span class="text-xs font-medium text-gray-700">Optimisation SEO On-Page</span>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-[#00AEEF]/10 text-[var(--color-primary-orange)] font-medium">Urgent</span>
                                </div>
                                <div class="mob-backlog-item flex items-center justify-between p-3 rounded-xl border-2 border-gray-200 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                        <span class="text-xs font-medium text-gray-700">Nouveau Logo</span>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 font-medium">Demande</span>
                                </div>
                                {{-- Animated cursor --}}
                                <div id="mob-backlog-cursor" class="absolute pointer-events-none z-20" style="left:20px; top:20px; opacity:0;">
                                    <svg width="18" height="17" viewBox="0 0 24 23" fill="none">
                                        <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-xl font-semibold text-[var(--text-primary)]" style="font-family: var(--font-heading);">Soumettez Votre Demande</p>
                    <p class="text-base text-gray-600 leading-relaxed">Décrivez ce dont vous avez besoin, nous mettons vos tâches en priorité</p>
                </div>
            </div>

            {{-- étape 3 : regardez-nous livrer --}}
            <div id="mob-step3" class="bg-white rounded-3xl p-6 shadow-lg overflow-hidden">
                <div class="mb-6">
                    <div class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold bg-[var(--text-primary)] text-white">Étape 3</div>
                </div>
                <div class="mb-6 overflow-hidden relative" style="height: 400px;">
                    <div class="max-w-full mx-auto absolute inset-0 flex items-center justify-center" style="max-width: 300px;">
                        <div id="mob-checklist-card" class="bg-white rounded-2xl shadow-xl border border-gray-200 w-full p-5" style="transform: rotate(-3deg);">
                            <div class="flex items-center gap-3 pb-4 border-b border-gray-100 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-[var(--color-primary-orange)] flex items-center justify-center">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-white">
                                        <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm" style="font-family: var(--font-heading);">Tâches du Projet</p>
                                    <p class="text-xs text-gray-500">Vos tâches de design</p>
                                </div>
                            </div>
                            <div id="mob-checklist-list" class="space-y-2 relative">
                                @foreach(['Designer la Page d\'Accueil', 'Créer l\'Identité de Marque', 'Développer le Site Web', 'Lancement & Livraison'] as $task)
                                <div class="mob-checklist-item flex items-center gap-2 rounded-xl p-2">
                                    <div class="mob-check-box w-5 h-5 rounded-md border-2 border-gray-300 flex items-center justify-center flex-shrink-0">
                                        <svg class="mob-check-icon w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" style="opacity:0; transform:scale(0);">
                                            <path d="M5 12L10 17L20 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <span class="mob-check-text text-xs text-gray-700 font-medium">{{ $task }}</span>
                                </div>
                                @endforeach
                                {{-- Animated cursor --}}
                                <div id="mob-checklist-cursor" class="absolute pointer-events-none z-20" style="left:12px; top:15px; opacity:0;">
                                    <svg width="18" height="17" viewBox="0 0 24 23" fill="none">
                                        <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-gray-100 mt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progression</span>
                                    <span id="mob-progress-count" class="text-xs font-semibold text-gray-900">0/4</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full overflow-hidden h-1.5">
                                    <div id="mob-progress-bar" class="h-full bg-[var(--color-primary-orange)] rounded-full" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-xl font-semibold text-[var(--text-primary)]" style="font-family: var(--font-heading);">Regardez-nous Livrer</p>
                    <p class="text-base text-gray-600 leading-relaxed">Votre projet avance, vous suivez chaque étape en direct</p>
                </div>
            </div>
        </div>

        {{-- Desktop: Two-column interactive layout --}}
        <div class="hidden lg:grid lg:grid-cols-2 gap-8 lg:gap-16 items-start">
            {{-- Left: Interactive cards --}}
            <div class="relative flex h-[600px] items-center justify-center">
                {{-- STATE 1: Two overlapping plan cards (Step 1) --}}
                <div id="process-card-1" class="process-card-state absolute inset-0 flex items-center justify-center transition-all duration-700 ease-out">
                    <div class="relative w-full max-w-md mx-auto" style="height:450px">
                        {{-- Retainer card (behind, tilted) --}}
                        <div id="plan-card-retainer" class="absolute top-1/2 left-1/2 bg-white rounded-3xl border border-gray-200 shadow-lg" style="width:300px;height:400px;padding:28px;transform:translateX(-90%) translateY(-35%) rotate(-8deg)">
                            <h3 class="font-semibold mb-6 italic text-2xl" style="font-family:var(--font-heading)">Retainer</h3>
                            <div class="space-y-3 text-sm text-gray-600">
                                <div class="py-2 px-4 bg-gray-50 rounded-xl italic">1 projet actif</div>
                                <div class="py-2 px-4 bg-gray-50 rounded-xl italic">Révisions illimitées</div>
                                <div class="py-2 px-4 bg-gray-50 rounded-xl italic">Design &amp; développement</div>
                                <div class="py-2 px-4 bg-gray-50 rounded-xl italic">SEO &amp; contenu</div>
                            </div>
                        </div>
                        {{-- Développement de Site Web card (front) --}}
                        <div id="plan-card-website" class="absolute top-1/2 left-1/2 bg-gradient-to-br from-black to-[#1A1A1A] rounded-3xl overflow-hidden shadow-xl" style="width:300px;height:400px;transform:translateX(-50%) translateY(-50%)">
                            {{-- Plan details (visible initially) --}}
                            <div id="plan-details" class="transition-opacity duration-500" style="padding:28px">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="text-white">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-xs text-white/90 font-medium italic">Recommandé</span>
                                </div>
                                <h3 class="font-semibold mb-6 text-white italic text-3xl" style="font-family:var(--font-heading)">Développement de Site Web</h3>
                                <div class="space-y-3 text-sm">
                                    <div class="text-white/90 py-2 px-4 bg-white/10 rounded-xl backdrop-blur-sm italic">Site web sur mesure</div>
                                    <div class="text-white/90 py-2 px-4 bg-white/10 rounded-xl backdrop-blur-sm italic">Design UI/UX & identité visuelle</div>
                                    <div class="text-white/90 py-2 px-4 bg-white/10 rounded-xl backdrop-blur-sm italic">Optimisation SEO</div>
                                    <div class="text-white/90 py-2 px-4 bg-white/10 rounded-xl backdrop-blur-sm italic">Vitrine en 10-20 jours</div>
                                    <div id="plan-book-btn" class="w-full py-3 px-4 rounded-xl font-medium text-center transition-colors bg-white text-gray-900">Demandez un Devis Gratuit</div>
                                </div>
                            </div>
                            {{-- "You have done your part" state (hidden initially) --}}
                            <div id="plan-done" class="absolute inset-0 flex flex-col items-center justify-center transition-opacity duration-500 opacity-0 pointer-events-none" style="padding:28px">
                                <div class="flex items-center gap-2 mb-6">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="text-white">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-xs text-white/90 font-medium">Recommandé</span>
                                </div>
                                <div class="flex justify-center mb-8">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" class="text-white process-spin-icon">
                                        <path d="M12 3V6M12 18V21M6 12H3M21 12H18M5.64 5.64L7.76 7.76M16.24 16.24L18.36 18.36M5.64 18.36L7.76 16.24M16.24 7.76L18.36 5.64" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="text-center space-y-4">
                                    <h3 class="font-bold text-white leading-snug text-2xl" style="font-family:var(--font-heading)">Vous avez fait<br>votre part</h3>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-4">
                                        <p class="text-white font-medium text-base">C'est notre tour maintenant</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Cursor for clicking the button --}}
                            <div id="plan-cursor" class="absolute pointer-events-none z-20" style="opacity:0;bottom:60px;right:80px">
                                <svg width="20" height="19" viewBox="0 0 24 23" fill="none">
                                    <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STATE 2: Design Backlogs card (Step 2) --}}
                <div id="process-card-2" class="process-card-state absolute inset-0 flex items-center justify-center transition-all duration-700 ease-out opacity-0 pointer-events-none" style="transform:translateY(30px)">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 w-full max-w-md p-6" style="transform:rotate(-5deg)">
                        <h3 class="font-semibold text-xl mb-4 text-gray-900" style="font-family:var(--font-heading)">Vos Tâches de Design</h3>
                        <div class="space-y-3 relative backlog-list">
                            @foreach([
                            ['title' => 'Création du site vitrine', 'tag' => 'Demande', 'urgent' => false],
                            ['title' => 'Design identité visuelle', 'tag' => 'Demande', 'urgent' => false],
                            ['title' => 'Optimisation SEO On-Page', 'tag' => 'Urgent', 'urgent' => true],
                            ['title' => 'Nouveau Logo', 'tag' => 'Demande', 'urgent' => false],
                            ] as $task)
                            <div class="backlog-item flex items-center justify-between p-4 rounded-xl border-2 {{ $task['urgent'] ? 'border-gray-300' : 'border-gray-200' }} bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="backlog-box w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                    <span class="text-sm font-medium text-gray-700">{{ $task['title'] }}</span>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full {{ $task['urgent'] ? 'bg-[#00AEEF]/10 text-[var(--color-primary-orange)]' : 'bg-gray-200 text-gray-600' }} font-medium">{{ $task['tag'] }}</span>
                            </div>
                            @endforeach
                            {{-- Animated cursor --}}
                            <div id="backlog-cursor" class="absolute pointer-events-none z-20" style="left:30px;top:20px;opacity:0">
                                <svg width="20" height="19" viewBox="0 0 24 23" fill="none">
                                    <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STATE 3: Project Tasks card with animated checks (Step 3) --}}
                <div id="process-card-3" class="process-card-state absolute inset-0 flex items-center justify-center transition-all duration-700 ease-out opacity-0 pointer-events-none" style="transform:translateY(30px)">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 w-full max-w-md p-6" style="transform:rotate(-5deg)">
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100 mb-6">
                            <div class="w-10 h-10 rounded-lg bg-[var(--color-primary-orange)] flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="text-white">
                                    <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-base" style="font-family:var(--font-heading)">Tâches du Projet</h3>
                                <p class="text-xs text-gray-500">Vos tâches de design</p>
                            </div>
                        </div>
                        <div class="space-y-3 relative checklist-list">
                            @foreach(['Designer la Page d\'Accueil', 'Créer l\'Identité de Marque', 'Développer le Site Web', 'Lancement & Livraison'] as $task)
                            <div class="checklist-item flex items-center gap-3 rounded-xl hover:bg-gray-50 transition-colors p-3">
                                <div class="checklist-box w-6 h-6 rounded-md border-2 border-gray-300 flex items-center justify-center flex-shrink-0 transition-all duration-300">
                                    <svg class="checklist-check w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" style="opacity:0;transform:scale(0)">
                                        <path d="M5 12L10 17L20 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <span class="checklist-text text-sm text-gray-700 font-medium transition-all duration-300">{{ $task }}</span>
                            </div>
                            @endforeach
                            {{-- Animated cursor --}}
                            <div id="checklist-cursor" class="absolute pointer-events-none z-20" style="left:15px;top:20px;opacity:0">
                                <svg width="20" height="19" viewBox="0 0 24 23" fill="none">
                                    <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100 mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium text-gray-600">Progression</span>
                                <span class="text-xs font-semibold text-gray-900">4/4</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full overflow-hidden h-2">
                                <div id="checklist-progress" class="h-full bg-[var(--color-primary-orange)] rounded-full" style="width:0%;transition:width 0.5s ease-out"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Step cards --}}
            <div class="space-y-4">
                <div class="process-step relative p-6 rounded-xl cursor-pointer transition-all duration-300 bg-white shadow-lg scale-[1.02]" data-step="1">
                    <div class="space-y-2.5">
                        <div class="process-step-badge inline-block px-4 py-1.5 rounded-full text-sm font-semibold transition-colors duration-300 bg-[var(--text-primary)] text-white">Étape 1</div>
                        <h3 class="process-step-title text-xl font-semibold transition-colors duration-300 text-[var(--text-primary)]" style="font-family:var(--font-heading)">Choisissez Votre Formule</h3>
                        <p class="process-step-desc text-base leading-relaxed transition-colors duration-300 text-gray-600">Sélectionnez Développement de Site Web ou le forfait mensuel adapté à vos besoins</p>
                    </div>
                    <div class="process-step-bar absolute left-0 top-1/2 -translate-y-1/2 w-1 h-12 bg-[var(--text-primary)] rounded-r-full transition-opacity duration-300 opacity-100"></div>
                </div>
                <div class="process-step relative p-6 rounded-xl cursor-pointer transition-all duration-300 bg-gray-50 hover:bg-white hover:shadow-md" data-step="2">
                    <div class="space-y-2.5">
                        <div class="process-step-badge inline-block px-4 py-1.5 rounded-full text-sm font-semibold transition-colors duration-300 bg-gray-200 text-gray-600">Étape 2</div>
                        <h3 class="process-step-title text-xl font-semibold transition-colors duration-300 text-gray-700" style="font-family:var(--font-heading)">Soumettez Votre Demande</h3>
                        <p class="process-step-desc text-base leading-relaxed transition-colors duration-300 text-gray-500">Partagez vos besoins et nous prioriserons vos tâches</p>
                    </div>
                    <div class="process-step-bar absolute left-0 top-1/2 -translate-y-1/2 w-1 h-12 bg-[var(--text-primary)] rounded-r-full transition-opacity duration-300 opacity-0"></div>
                </div>
                <div class="process-step relative p-6 rounded-xl cursor-pointer transition-all duration-300 bg-gray-50 hover:bg-white hover:shadow-md" data-step="3">
                    <div class="space-y-2.5">
                        <div class="process-step-badge inline-block px-4 py-1.5 rounded-full text-sm font-semibold transition-colors duration-300 bg-gray-200 text-gray-600">Étape 3</div>
                        <h3 class="process-step-title text-xl font-semibold transition-colors duration-300 text-gray-700" style="font-family:var(--font-heading)">Regardez-nous Livrer</h3>
                        <p class="process-step-desc text-base leading-relaxed transition-colors duration-300 text-gray-500">Suivez l'avancement en temps réel pendant que nous réalisons votre projet</p>
                    </div>
                    <div class="process-step-bar absolute left-0 top-1/2 -translate-y-1/2 w-1 h-12 bg-[var(--text-primary)] rounded-r-full transition-opacity duration-300 opacity-0"></div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ============================================== --}}
{{-- SECTION 2: Le Choix d'Investissement Intelligent --}}
{{-- ============================================== --}}
@php
$comparisons = [
['label' => 'Investissement', 'codesommet' => 'Tarification sur mesure', 'designer' => 'Coûts salariaux élevés', 'agency' => 'Tarifs premium'],
['label' => 'Rapidité de Livraison', 'codesommet' => '10 à 20 jours (vitrine)', 'designer' => '2-3 semaines', 'agency' => '3-6 mois'],
['label' => 'Garantie Qualité', 'codesommet' => 'Révisions illimitées', 'designer' => 'Qualité variable', 'agency' => '2-3 cycles de révision'],
['label' => 'Délai de Démarrage', 'codesommet' => 'Devis gratuit & immédiat', 'designer' => '4-8 semaines de recrutement', 'agency' => '2-4 semaines de lancement'],
['label' => 'Périmètre', 'codesommet' => 'Solution complète clé en main', 'designer' => 'Limité aux compétences', 'agency' => 'Nécessite souvent plusieurs prestataires'],
['label' => 'Technologie', 'codesommet' => 'Dernières IA &amp; frameworks', 'designer' => 'Dépend de l\'individu', 'agency' => 'Varie selon l\'agence'],
['label' => 'Spécialisation Sectorielle', 'codesommet' => 'Expertise spécialisée', 'designer' => 'Connaissances générales', 'agency' => 'Touche-à-tout'],
['label' => 'Flexibilité', 'codesommet' => 'Pause ou annulation à tout moment', 'designer' => 'Engagement à long terme', 'agency' => 'Pénalités contractuelles'],
];
@endphp
<section class="py-24 bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-6">
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4" style="font-family: var(--font-heading);">Le Choix d'Investissement Intelligent</h2>
            <p class="text-lg text-[var(--text-secondary)] max-w-2xl mx-auto">Comparez vos options et découvrez pourquoi CodeSommet offre le meilleur rapport qualité-prix. <a href="{{ route('get-quote') }}" class="text-[var(--color-primary-orange)] font-semibold hover:underline">Demandez Votre Devis Gratuit</a></p>
        </div>

        {{-- Single responsive table: fixed px columns + horizontal scroll on
             mobile, fluid fr columns with no scroll on desktop. Content
             renders once; only the grid-track sizing and scroll wrapper
             change per breakpoint. --}}
        <div class="overflow-x-auto lg:overflow-visible scrollbar-hide -mx-6 px-6 lg:mx-0 lg:px-0">
            <div class="min-w-[1000px] lg:min-w-0 pb-4 lg:pb-0">
                {{-- Column headers --}}
                <div class="grid grid-cols-[180px_240px_260px_280px] lg:grid-cols-[280px_1fr_1fr_1fr] gap-4 lg:gap-6 mb-6 pl-[20px] pr-6 lg:pl-[25px] lg:pr-0">
                    <div></div>
                    <div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-5 h-5 fill-black" aria-hidden="true">
                                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path>
                            </svg>
                            <h3 class="text-lg lg:text-xl font-bold" style="font-family: var(--font-heading);">CodeSommet</h3>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold" style="font-family: var(--font-heading);">Designer à temps plein</h3>
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold" style="font-family: var(--font-heading);">Autres agences</h3>
                    </div>
                </div>
                {{-- Table body --}}
                <div class="relative bg-gray-100 rounded-[32px] p-[5px] mr-6 lg:mr-0">
                    <div class="bg-white rounded-[27px] overflow-hidden">
                        @foreach ($comparisons as $index => $row)
                        <div class="grid grid-cols-[180px_240px_260px_280px] lg:grid-cols-[280px_1fr_1fr_1fr] gap-4 lg:gap-6">
                            <div class="px-4 py-5 lg:px-6 lg:py-6 bg-gray-100 ml-[5px] {{ $index === 0 ? 'rounded-tl-[27px] mt-[5px]' : '' }} {{ $index < count($comparisons) - 1 ? 'border-b-[5px] border-white' : 'rounded-bl-[27px] mb-[5px]' }}">
                                <p class="font-semibold text-gray-900 text-sm lg:text-base">{{ $row['label'] }}</p>
                            </div>
                            <div class="px-3 py-5 lg:px-4 lg:py-6 bg-white">
                                <div class="flex items-start gap-2 lg:gap-3">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="10" fill="#10B981" fill-opacity="0.1"></circle>
                                        <path d="M8 12.5L10.5 15L16 9.5" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-gray-900 text-sm lg:text-base">{!! $row['codesommet'] !!}</span>
                                </div>
                            </div>
                            <div class="px-3 py-5 lg:px-4 lg:py-6 bg-white">
                                <div class="flex items-start gap-2 lg:gap-3">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="10" fill="#EF4444" fill-opacity="0.1"></circle>
                                        <path d="M15 9L9 15M9 9L15 15" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-gray-900 text-sm lg:text-base">{!! $row['designer'] !!}</span>
                                </div>
                            </div>
                            <div class="px-4 py-5 lg:px-4 lg:py-6 bg-white">
                                <div class="flex items-start gap-2 lg:gap-3">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="10" fill="#EF4444" fill-opacity="0.1"></circle>
                                        <path d="M15 9L9 15M9 9L15 15" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-gray-900 text-sm lg:text-base">{!! $row['agency'] !!}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ============================================== --}}
{{-- SECTION 3: 6 Problèmes Courants de Sites Web que Nous Résolvons --}}
{{-- ============================================== --}}
<section class="w-full py-24 md:py-32 bg-[#F5F5F5]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="text-center mb-16">
            <h2 class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4 max-w-4xl mx-auto text-3xl md:text-4xl lg:text-5xl">6 Problèmes Courants de Sites Web que Nous Résolvons</h2>
            <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-2xl mx-auto">Transformez les défis en opportunités avec nos solutions éprouvées</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $problems = [
            ['title' => '1. Mauvaise Expérience Utilisateur', 'problem' => 'Chargement lent, navigation confuse et design obsolète qui frustrent les visiteurs.', 'solution' => 'Performance ultra-rapide, UX intuitive et design moderne qui ravit les utilisateurs.'],
            ['title' => '2. Pas d\'Intégration IA', 'problem' => 'Vous passez à côté des capacités IA que vos concurrents utilisent déjà.', 'solution' => 'Chatbots intelligents, recherche IA, automatisation et fonctionnalités intelligentes intégrées.'],
            ['title' => '3. Des Mois d\'Attente', 'problem' => 'Les agences traditionnelles prennent 3-6 mois pendant que vous perdez des opportunités.', 'solution' => 'Vitrine livrée en 10 à 20 jours. E-commerce ou SaaS en 3 à 6 semaines. Commencez à croître immédiatement.'],
            ['title' => '4. Image de Marque Non Professionnelle', 'problem' => 'Votre site web ne reflète pas la vraie valeur et l\'expertise de votre entreprise.', 'solution' => 'Design premium qui établit l\'autorité et inspire confiance instantanément.'],
            ['title' => '5. Tarification Opaque', 'problem' => 'Les agences cachent les coûts jusqu\'à ce que vous soyez engagé.', 'solution' => 'Processus transparent. Vous savez exactement ce que vous obtenez avant de vous engager.'],
            ['title' => '6. Faible Taux de Conversion', 'problem' => 'Le trafic ne convertit pas. Les visiteurs naviguent mais ne passent pas à l\'action.', 'solution' => 'CTAs stratégiques, formulaires optimisés et design orienté conversion.'],
            ];
            @endphp

            @foreach($problems as $item)
            <article class="relative h-[180px] flip-card group">
                <div class="relative w-full h-full flip-card-inner">
                    {{-- Front: Problem --}}
                    <div class="absolute inset-0 w-full h-full bg-white rounded-2xl flip-card-front">
                        <div class="w-full h-full bg-white rounded-2xl border-2 border-dashed border-[#E5E5E5] p-5 flex flex-col justify-between">
                            <div>
                                <h3 class="text-base font-semibold text-[var(--text-primary)] mb-3">{{ $item['title'] }}</h3>
                                <div class="hidden md:block bg-[#F8F8F8] rounded-lg px-4 py-2 mb-3">
                                    <p class="text-xs font-medium text-center text-[var(--text-primary)]">Problème</p>
                                </div>
                                <p class="text-sm text-[var(--text-secondary)] leading-normal">{{ $item['problem'] }}</p>
                            </div>
                            <button class="md:hidden bg-[#F8F8F8] rounded-lg px-4 py-2 hover:bg-[#ECECEC] transition-colors">
                                <p class="text-xs font-medium text-center text-[var(--text-primary)]">Appuyez pour résoudre</p>
                            </button>
                        </div>
                    </div>
                    {{-- Back: Solution --}}
                    <div class="absolute inset-0 w-full h-full flip-card-back">
                        <div class="w-full h-full bg-[#1A1A1A] rounded-2xl p-5 flex flex-col justify-between">
                            <div>
                                <div class="hidden md:block bg-[#2A2A2A] rounded-lg px-4 py-2 mb-3">
                                    <p class="text-xs font-medium text-center text-white">Solution</p>
                                </div>
                                <p class="text-sm text-[#CCCCCC] leading-normal">{{ $item['solution'] }}</p>
                            </div>
                            <button class="md:hidden bg-[#2A2A2A] rounded-lg px-4 py-2 hover:bg-[#3A3A3A] transition-colors">
                                <p class="text-xs font-medium text-center text-white">Appuyez pour fermer</p>
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>


{{-- SECTION: Custom Solutions, Transparent Pricing --}}
<section id="pricing" class="relative w-full py-16 md:py-24 bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight text-black mb-4" style="font-family:var(--font-heading)">Solutions Personnalisées, Conçues pour Vous</h2>
            <p class="text-lg md:text-xl text-black/70 max-w-3xl mx-auto">Réservez un appel découverte pour discuter de vos besoins et obtenir un devis personnalisé</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 max-w-6xl mx-auto">
            {{-- Développement de Site Web Card --}}
            <div class="relative bg-black rounded-[32px] p-3 text-white">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10">
                    <div class="bg-[var(--color-primary-orange)] text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-4 h-4" aria-hidden="true">
                            <path d="M16 7h6v6"></path>
                            <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                        </svg>Recommandé
                    </div>
                </div>
                <div class="relative rounded-[20px] p-6 md:p-8 mb-3 bg-[#1a1a1a] border border-transparent">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor w-6 h-6 text-white" aria-hidden="true">
                                    <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                                    <line x1="8" x2="16" y1="21" y2="21"></line>
                                    <line x1="12" x2="12" y1="17" y2="21"></line>
                                </svg>
                            </div>
                            <h3 class="text-3xl md:text-4xl font-bold text-white">Développement de Site Web</h3>
                        </div>
                    </div>
                    <div class="mb-6 p-4 rounded-2xl bg-white/5">
                        <p class="text-white/70">Site vitrine en 10-20 jours, e-commerce ou SaaS en 3-6 semaines. Dépôt de 40% pour démarrer, solde à la livraison.</p>
                    </div>
                    <div class="divide-y divide-white/10">
                        @foreach(['Sites vitrine, e-commerce & SaaS sur mesure', 'Applications mobiles (Flutter) & CRM', 'Design UI/UX responsive mobile-first', 'Identité visuelle & création de logo', 'SEO On-Page & Off-Page avancé', 'Intégration Shopify, WordPress, Laravel', 'Intégration de paiement prête', 'Analytics & suivi des conversions'] as $feature)
                        <div class="flex items-start gap-3 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-5 h-5 text-white/50 mt-0.5 flex-shrink-0" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>
                            <span class="text-white/80">{{ $feature }}</span>
                        </div>
                        @endforeach
                        <div class="flex items-start gap-3 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>
                            <span class="text-green-400 font-medium">Hébergement gratuit pendant 3 mois inclus</span>
                        </div>
                    </div>
                </div>
                <div class="px-6 md:px-8 pb-3">
                    <div class="mb-6">
                        <div class="flex flex-col">
                            <span class="text-lg md:text-xl font-medium text-white/70 mb-1">Investissement</span>
                            <div class="flex items-end gap-2">
                                <span class="text-3xl md:text-4xl font-bold">Devis Personnalisé</span>
                            </div>
                            <p class="text-white/60 text-sm mt-2">Adapté à la portée et aux objectifs de votre projet</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a class="flex-1 h-11 px-5 rounded-full inline-flex items-center justify-center whitespace-nowrap bg-white text-black text-sm font-semibold hover:bg-white/90 transition-colors" href="{{ route('get-quote') }}">Obtenez Votre Devis Gratuit</a>
                        <a href="https://wa.me/212632582096?text=Hi%20CodeSommet!%20I'd%20like%20to%20discuss%20a%20website%20development%20project.%20Can%20we%20schedule%20a%20call?" target="_blank" rel="noopener noreferrer" class="flex-1 h-11 px-5 rounded-full inline-flex items-center justify-center whitespace-nowrap border-2 border-white/20 text-white text-sm font-semibold hover:bg-white/10 transition-colors">Contactez-nous sur WhatsApp</a>
                    </div>
                </div>
            </div>
            {{-- Retainer Card --}}
            <div id="retainer-card" class="relative bg-white rounded-[32px] p-3 text-black border border-black/10">
                <div id="retainer-inner" class="relative rounded-[20px] p-6 md:p-8 mb-3 transition-all duration-700 ease-in-out bg-[#F5F5F5] overflow-hidden border-2 border-transparent">
                    {{-- Orange glow (hidden by default, shown when social active) --}}
                    <div id="retainer-glow" class="absolute inset-0 overflow-hidden pointer-events-none opacity-0 transition-opacity duration-700">
                        <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] bg-[var(--color-primary-orange)] opacity-10 blur-[120px] rounded-full"></div>
                    </div>
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <div id="retainer-icon-wrap" class="w-12 h-12 rounded-full bg-black/10 flex items-center justify-center transition-all duration-500">
                                {{-- Infinity icon (default) --}}
                                <svg id="retainer-icon-infinity" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-black transition-all duration-500" aria-hidden="true">
                                    <path d="M6 16c5 0 7-8 12-8a4 4 0 0 1 0 8c-5 0-7-8-12-8a4 4 0 1 0 0 8"></path>
                                </svg>
                                {{-- Share icon (social active) --}}
                                <svg id="retainer-icon-share" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2 w-6 h-6 text-[var(--color-primary-orange)] absolute hidden" aria-hidden="true">
                                    <circle cx="18" cy="5" r="3"></circle>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="19" r="3"></circle>
                                    <line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line>
                                    <line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>
                                </svg>
                            </div>
                            <h3 class="text-3xl md:text-4xl font-bold text-black">Retainer <span id="retainer-social-label" class="text-[var(--color-primary-orange)] hidden">+Social</span></h3>
                        </div>
                        <button id="retainer-toggle-btn" onclick="toggleRetainerSocial()" role="switch" aria-checked="false" aria-label="Inclure les Réseaux Sociaux" class="flex items-center rounded-full transition-all duration-400 ease-out gap-0 p-0 bg-transparent" style="margin-top: 9px;">
                            <div id="retainer-toggle-track" class="relative rounded-full transition-all duration-400 ease-out w-14 h-7 bg-black/20">
                                <div id="retainer-toggle-dot" class="absolute top-0.5 w-6 h-6 rounded-full bg-white transition-all duration-400 ease-out left-0.5"></div>
                            </div>
                            <span id="retainer-toggle-text" class="text-sm whitespace-nowrap overflow-hidden transition-all duration-400 ease-out ml-2">Inclure les Réseaux Sociaux</span>
                        </button>
                    </div>
                    {{-- Description --}}
                    <div class="mb-6 p-4 rounded-2xl bg-black/5 flex items-center gap-3">
                        <svg id="retainer-desc-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-5 h-5 transition-all duration-300 text-black/40 flex-shrink-0 hidden" aria-hidden="true">
                            <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg>
                        <p id="retainer-desc-text" class="text-black/70 transition-all duration-300">Parfait pour les startups, PME et grandes entreprises souhaitant une présence digitale continue avec développement, SEO et marketing.</p>
                    </div>
                    {{-- Features list --}}
                    <div class="divide-y divide-black/10">
                        {{-- Social media features (hidden by default) --}}
                        <div id="retainer-social-features" class="hidden">
                            <div class="flex items-start gap-3 py-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2 w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0" aria-hidden="true">
                                    <circle cx="18" cy="5" r="3"></circle>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="19" r="3"></circle>
                                    <line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line>
                                    <line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>
                                </svg>
                                <span class="text-[var(--color-primary-orange)]">Gestion professionnelle des réseaux sociaux</span>
                            </div>
                            <div class="flex items-start gap-3 py-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0" aria-hidden="true">
                                    <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                                    <path d="M20 2v4"></path>
                                    <path d="M22 4h-4"></path>
                                    <circle cx="4" cy="20" r="2"></circle>
                                </svg>
                                <span class="text-[var(--color-primary-orange)]">Création de contenu pour toutes les plateformes</span>
                            </div>
                            <div class="flex items-start gap-3 py-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0" aria-hidden="true">
                                    <path d="M8 2v4"></path>
                                    <path d="M16 2v4"></path>
                                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                    <path d="M3 10h18"></path>
                                </svg>
                                <span class="text-[var(--color-primary-orange)]">Publication stratégique & planification</span>
                            </div>
                            <div class="flex items-start gap-3 py-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column w-5 h-5 text-[var(--color-primary-orange)] mt-0.5 flex-shrink-0" aria-hidden="true">
                                    <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                    <path d="M18 17V9"></path>
                                    <path d="M13 17V5"></path>
                                    <path d="M8 17v-3"></path>
                                </svg>
                                <span class="text-[var(--color-primary-orange)]">Rapports mensuels d'analytics & de croissance</span>
                            </div>
                        </div>
                        {{-- Base retainer features --}}
                        @foreach(['1 projet actif à la fois', 'Cycles de révisions multiples jusqu\'à la perfection', 'Développement full-stack (React, Laravel, Shopify...)', 'SEO professionnel & marketing digital', 'Communication directe & suivi de projet', 'Maintenance, sécurité & hébergement inclus'] as $feature)
                        <div class="flex items-start gap-3 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-5 h-5 text-black/40 mt-0.5 flex-shrink-0" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>
                            <span class="text-black/80">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="px-6 md:px-8 pb-3">
                    <div class="mb-6">
                        <div class="flex flex-col">
                            <span class="text-lg md:text-xl font-medium text-black/60 mb-1">Investissement</span>
                            <div class="flex items-end gap-2">
                                <span class="text-3xl md:text-4xl font-bold">Contactez-nous pour un devis sur mesure</span>
                            </div>
                            <p class="text-black/60 text-sm mt-2">Pause ou annulation à tout moment</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' class="flex-1 h-11 px-5 rounded-full inline-flex items-center justify-center whitespace-nowrap bg-black text-white text-sm font-semibold hover:bg-black/90 transition-colors">Réserver un Appel Découverte</button>
                        <a href="https://wa.me/212632582096?text=Hi%20CodeSommet!%20I'd%20like%20to%20learn%20about%20your%20retainer%20plans.%20Can%20we%20schedule%20a%20call?" target="_blank" rel="noopener noreferrer" class="flex-1 h-11 px-5 rounded-full inline-flex items-center justify-center whitespace-nowrap border-2 border-black/20 text-black text-sm font-semibold hover:bg-black/5 transition-colors">Contactez-nous sur WhatsApp</a>
                    </div>
                </div>
            </div>
            <script>
                function toggleRetainerSocial() {
                    const inner = document.getElementById('retainer-inner');
                    const glow = document.getElementById('retainer-glow');
                    const iconInfinity = document.getElementById('retainer-icon-infinity');
                    const iconShare = document.getElementById('retainer-icon-share');
                    const socialLabel = document.getElementById('retainer-social-label');
                    const toggleTrack = document.getElementById('retainer-toggle-track');
                    const toggleDot = document.getElementById('retainer-toggle-dot');
                    const toggleText = document.getElementById('retainer-toggle-text');
                    const descIcon = document.getElementById('retainer-desc-icon');
                    const descText = document.getElementById('retainer-desc-text');
                    const socialFeatures = document.getElementById('retainer-social-features');
                    // Price elements removed - no longer showing specific amounts

                    const isActive = inner.classList.contains('border-[var(--color-primary-orange)]');
                    const toggleBtn = document.getElementById('retainer-toggle-btn');

                    if (!isActive) {
                        // Activate social
                        toggleBtn.setAttribute('aria-checked', 'true');
                        inner.classList.remove('border-transparent');
                        inner.classList.add('border-[var(--color-primary-orange)]');
                        glow.classList.remove('opacity-0');
                        glow.classList.add('opacity-100');
                        iconInfinity.classList.add('hidden');
                        iconShare.classList.remove('hidden', 'absolute');
                        socialLabel.classList.remove('hidden');
                        toggleTrack.classList.remove('bg-black/20');
                        toggleTrack.classList.add('bg-[var(--color-primary-orange)]');
                        toggleTrack.style.boxShadow = 'rgba(0, 174, 239, 0.4) 0px 0px 12px, rgba(0, 174, 239, 0.2) 0px 0px 24px';
                        toggleDot.classList.remove('left-0.5');
                        toggleDot.classList.add('left-7');
                        toggleText.classList.remove('ml-2');
                        toggleText.style.opacity = '0';
                        toggleText.style.width = '0';
                        toggleText.style.marginLeft = '0';
                        descIcon.classList.remove('hidden', 'text-black/40');
                        descIcon.classList.add('text-[var(--color-primary-orange)]');
                        descText.textContent = 'Transformation digitale complète avec gestion des réseaux sociaux, création de contenu et stratégie marketing.';
                        socialFeatures.classList.remove('hidden');
                    } else {
                        // Deactivate social
                        toggleBtn.setAttribute('aria-checked', 'false');
                        inner.classList.add('border-transparent');
                        inner.classList.remove('border-[var(--color-primary-orange)]');
                        glow.classList.add('opacity-0');
                        glow.classList.remove('opacity-100');
                        iconInfinity.classList.remove('hidden');
                        iconShare.classList.add('hidden', 'absolute');
                        socialLabel.classList.add('hidden');
                        toggleTrack.classList.add('bg-black/20');
                        toggleTrack.classList.remove('bg-[var(--color-primary-orange)]');
                        toggleTrack.style.boxShadow = 'none';
                        toggleDot.classList.add('left-0.5');
                        toggleDot.classList.remove('left-7');
                        toggleText.style.opacity = '1';
                        toggleText.style.width = 'auto';
                        toggleText.style.marginLeft = '';
                        toggleText.classList.add('ml-2');
                        descIcon.classList.add('hidden', 'text-black/40');
                        descIcon.classList.remove('text-[var(--color-primary-orange)]');
                        descText.textContent = 'Parfait pour les startups, PME et grandes entreprises souhaitant une présence digitale continue avec développement, SEO et marketing.';
                        socialFeatures.classList.add('hidden');
                    }
                }
            </script>
        </div>
    </div>
</section>


{{-- SECTION: Month Too Busy? Pause Anytime --}}
<div class="relative w-full px-4 py-3 bg-[#F5F5F5] isolate">
    <div class="max-w-7xl mx-auto relative">
        <div class="relative overflow-hidden rounded-[24px] md:rounded-[32px] px-6 py-8 md:py-12 isolate bg-black" style="z-index: 1;">
            <div class="relative z-10 text-center space-y-4 md:space-y-6">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white" style="font-family: var(--font-display);">Un Mois Trop Chargé ? Mettez en Pause à Tout Moment.</h2>
                <p class="text-base md:text-lg text-white/60 max-w-2xl mx-auto">Zéro pénalité. Reprenez quand vous voulez. Votre abonnement, vos règles.</p>
                <div class="flex justify-center pt-2">
                    <button data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' class="group relative inline-flex items-center gap-3 px-8 py-4 bg-white rounded-full hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <div class="relative z-10 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play w-5 h-5 text-black fill-black" aria-hidden="true">
                                <path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path>
                            </svg>
                        </div>
                        <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black">Commencez Sans Risque Aujourd'hui</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ============================================== --}}
{{-- SECTION 5: Ready to Build Something Extraordinary --}}
{{-- ============================================== --}}
<div class="relative w-full px-4 py-12 md:py-16 lg:py-20 bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto">
        <div class="relative overflow-hidden rounded-[24px] md:rounded-[32px] px-6 py-6 md:py-8" style="background: linear-gradient(135deg, rgb(26, 26, 26) 0%, rgb(10, 10, 10) 100%);">
            {{-- Grid overlay --}}
            <div class="absolute inset-0 z-0" style="background-image: linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
            <div class="absolute inset-0 z-[1]" style="background: radial-gradient(70% 70%, transparent 0%, transparent 10%, rgba(10, 10, 10, 0.15) 25%, rgba(10, 10, 10, 0.35) 40%, rgba(10, 10, 10, 0.6) 60%, rgba(10, 10, 10, 0.85) 80%, rgba(10, 10, 10, 0.95) 100%);"></div>

            <div class="relative z-10 text-center space-y-3 md:space-y-4">
                <h2 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-white px-4 pb-6 md:pb-8" style="font-family: var(--font-display);">Prêt à Construire Quelque Chose d'Extraordinaire ?</h2>

                <div class="flex flex-col items-center gap-4 md:gap-6">
                    {{-- Mobile CTAs --}}
                    <div class="flex flex-col sm:flex-row items-center gap-4 md:hidden">
                        <a target="_blank" rel="noopener noreferrer" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto" data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' href="#" style="background-color: rgba(0, 0, 0, 0.11); border-radius: 118px; box-shadow: rgba(0, 0, 0, 0.067) 0px 2.52px 2.52px -0.47px, rgba(0, 0, 0, 0.067) 0px 5.97px 5.97px -0.94px, rgba(0, 0, 0, 0.063) 0px 10.89px 10.89px -1.41px, rgba(0, 0, 0, 0.063) 0px 18.11px 18.11px -1.88px, rgba(0, 0, 0, 0.06) 0px 29.24px 29.24px -2.34px, rgba(0, 0, 0, 0.055) 0px 47.87px 47.87px -2.81px, rgba(0, 0, 0, 0.043) 0px 82.43px 82.43px -3.28px, rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px;">
                            <div class="shine-wrapper-hero">
                                <div class="shine-element-hero"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                            <div class="relative z-10 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg>
                            </div>
                            <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family: Inter, sans-serif; font-weight: 500; letter-spacing: -0.04em;">Réserver un Appel Découverte</span>
                        </a>
                        <a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" href="{{ route('tool', 'website-analyzer') }}" style="border-radius: 118px;">
                            <div class="relative z-10 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg>
                            </div>
                            <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white" style="font-family: Inter, sans-serif; font-weight: 500; letter-spacing: -0.04em;">Analysez Votre Site Web</span>
                        </a>
                    </div>

                    {{-- Desktop CTAs --}}
                    <div class="hidden md:flex flex-row items-center gap-4">
                        <button data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden" style="background-color: rgba(0, 0, 0, 0.11); border-radius: 118px; box-shadow: rgba(0, 0, 0, 0.067) 0px 2.52px 2.52px -0.47px, rgba(0, 0, 0, 0.067) 0px 5.97px 5.97px -0.94px, rgba(0, 0, 0, 0.063) 0px 10.89px 10.89px -1.41px, rgba(0, 0, 0, 0.063) 0px 18.11px 18.11px -1.88px, rgba(0, 0, 0, 0.06) 0px 29.24px 29.24px -2.34px, rgba(0, 0, 0, 0.055) 0px 47.87px 47.87px -2.81px, rgba(0, 0, 0, 0.043) 0px 82.43px 82.43px -3.28px, rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px;">
                            <div class="shine-wrapper-hero">
                                <div class="shine-element-hero"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                            <div class="relative z-10 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg>
                            </div>
                            <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family: Inter, sans-serif; font-weight: 500; letter-spacing: -0.04em;">Réserver un Appel Découverte</span>
                        </button>
                        <a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" href="{{ route('tool', 'website-analyzer') }}" style="border-radius: 118px;">
                            <div class="relative z-10 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg>
                            </div>
                            <span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white" style="font-family: Inter, sans-serif; font-weight: 500; letter-spacing: -0.04em;">Analysez Votre Site Web</span>
                        </a>
                    </div>

                    {{-- Cursor "Just click" --}}
                    <div class="relative mt-2 h-16">
                        <div class="absolute pointer-events-none" style="left: 50%; top: 50%;">
                            <div class="absolute left-0 -top-6 -translate-x-1/2">
                                <svg width="20" height="19" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg">
                                    <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="rgb(0, 0, 0)" stroke="rgb(255, 255, 255)" stroke-width="2" stroke-miterlimit="10"></path>
                                </svg>
                            </div>
                            <div class="absolute left-0 top-0 -translate-x-1/2 px-3 py-1 rounded-full border border-white/80 bg-black/90" style="font-size: 10px;">
                                <span class="text-white font-medium whitespace-nowrap">Cliquez ici</span>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-base md:text-lg text-white/70 font-medium">Rejoignez les startups, PME et entreprises qui ont choisi CodeSommet</p>
                <p class="text-sm md:text-base text-white/50">Discutons de la façon dont nous pouvons développer votre présence digitale depuis Marrakech</p>

                {{-- Technology pills marquee --}}
                <div class="mt-6">
                    <div class="relative w-full py-8">
                        <div class="flex items-center justify-center gap-0">
                            {{-- Left side: dashed border pills (scrolling) --}}
                            <section class="flex items-center overflow-hidden" style="width: 100%; max-width: 100%; mask-image: linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%);">
                                <ul class="flex items-center gap-3 list-none m-0 p-0 animate-marquee-left" style="will-change: transform;">
                                    @for($i = 0; $i < 3; $i++) @foreach(['React Js', 'Laravel 11' , 'Shopify' , 'WordPress' , 'Figma' , 'Flutter' , 'MySQL' , 'Docker' ] as $kw) <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div>
                                            <span class="text-[10px] font-medium text-white/40">{{ $kw }}</span>
                                        </div>
                                        </li>
                                        @endforeach
                                        @endfor
                                </ul>
                            </section>

                            {{-- Center: CodeSommet logo --}}
                            <div class="relative z-10 flex-shrink-0" style="margin-top: 5px;">
                                <div class="relative p-[2px] rounded-[12px]" style="background: linear-gradient(135deg, rgb(0, 174, 239), rgb(0, 113, 188), rgb(0, 136, 212)); animation: 2s ease-in-out 0s infinite normal none running pulse;">
                                    <div class="relative px-8 py-4 bg-[#1a1a1a] rounded-[10px] flex items-center justify-center">
                                        <img alt="CodeSommet" class="h-8 w-auto" width="220" height="150" src="{{ asset('logo-white.svg') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Right side: solid border pills with checkmarks (scrolling) --}}
                            <section class="flex items-center overflow-hidden" style="width: 100%; max-width: 100%; mask-image: linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%);">
                                <ul class="flex items-center gap-3 list-none m-0 p-0 animate-marquee-right" style="will-change: transform;">
                                    @for($i = 0; $i < 3; $i++) @foreach(['React Js', 'Laravel 11' , 'Shopify' , 'WordPress' , 'Figma' , 'Flutter' , 'MySQL' , 'Docker' ] as $kw) <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center">
                                                    <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span class="text-[10px] font-medium text-white/90">{{ $kw }}</span>
                                        </div>
                                        </li>
                                        @endforeach
                                        @endfor
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>