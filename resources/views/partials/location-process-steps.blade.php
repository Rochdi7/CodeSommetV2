{{-- SECTION: How to Get Started in 3 Simple Steps (reusable for location pages) --}}
<section id="process" class="py-16 md:py-24 bg-[#F5F5F5] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3 md:mb-4" style="font-family: var(--font-heading);">How to Get Started in 3 Simple Steps</h2>
            <p class="text-base md:text-lg text-[var(--text-secondary)] max-w-2xl mx-auto px-4">From first call to project delivery - see exactly how we work together</p>
        </div>

        {{-- Mobile: Stacked cards with embedded visuals --}}
        <div class="lg:hidden space-y-8">
            {{-- Step 1: Choose Your Plan --}}
            <div id="mob-step1" class="bg-white rounded-3xl p-6 shadow-lg overflow-hidden">
                <div class="mb-6">
                    <div class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold bg-[var(--text-primary)] text-white">Step 1</div>
                </div>
                <div class="mb-6 overflow-hidden relative" style="height: 320px;">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="relative w-full max-w-[280px] mx-auto">
                            <div class="relative" style="height: 320px;">
                                {{-- Retainer card (behind, tilted) --}}
                                <div id="mob-retainer" class="absolute top-1/2 left-1/2 bg-white rounded-2xl border border-gray-200 shadow-lg" style="width: 200px; height: 270px; padding: 16px; transform: translateX(-50%) translateY(-50%) rotate(0deg) scale(0.9); opacity: 0;">
                                    <h3 class="font-semibold mb-3 italic text-base" style="font-family: var(--font-heading);">Retainer</h3>
                                    <div class="space-y-1.5 text-xs text-gray-600">
                                        <div class="py-1.5 px-2.5 bg-gray-50 rounded-xl italic">1 active project</div>
                                        <div class="py-1.5 px-2.5 bg-gray-50 rounded-xl italic">Unlimited revisions</div>
                                        <div class="py-1.5 px-2.5 bg-gray-50 rounded-xl italic">Design &amp; development</div>
                                        <div class="py-1.5 px-2.5 bg-gray-50 rounded-xl italic">SEO &amp; content</div>
                                    </div>
                                </div>
                                {{-- Website Development card (front) --}}
                                <div id="mob-website" class="absolute top-1/2 left-1/2 bg-gradient-to-br from-black to-[#1A1A1A] rounded-2xl overflow-hidden shadow-xl" style="width: 200px; height: 270px; transform: translateX(-50%) translateY(-50%) scale(0.9); opacity: 0;">
                                    {{-- Plan details (visible initially) --}}
                                    <div id="mob-plan-details" style="padding: 16px;">
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="text-white"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                            <span class="text-xs text-white/90 font-medium italic">Recommended</span>
                                        </div>
                                        <h3 class="font-semibold mb-3 text-white italic text-lg" style="font-family: var(--font-heading);">Website Development</h3>
                                        <div class="space-y-1.5 text-xs">
                                            <div class="text-white/90 py-1.5 px-2.5 bg-white/10 rounded-xl backdrop-blur-sm italic">Custom landing page</div>
                                            <div class="text-white/90 py-1.5 px-2.5 bg-white/10 rounded-xl backdrop-blur-sm italic">Full development</div>
                                            <div class="text-white/90 py-1.5 px-2.5 bg-white/10 rounded-xl backdrop-blur-sm italic">SEO optimization</div>
                                            <div class="text-white/90 py-1.5 px-2.5 bg-white/10 rounded-xl backdrop-blur-sm italic">7-10 day delivery</div>
                                            <div id="mob-book-btn" class="w-full py-1.5 px-2.5 rounded-xl font-medium text-center text-xs bg-white text-gray-900">Book your Slot</div>
                                        </div>
                                    </div>
                                    {{-- "You have done your part" state --}}
                                    <div id="mob-plan-done" class="absolute inset-0 flex flex-col items-center justify-center" style="padding: 16px; opacity: 0;">
                                        <div class="flex items-center gap-2 mb-3">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" class="text-white"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                            <span class="text-xs text-white/90 font-medium">Recommended</span>
                                        </div>
                                        <div class="flex justify-center mb-4">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" class="text-white process-spin-icon">
                                                <path d="M12 3V6M12 18V21M6 12H3M21 12H18M5.64 5.64L7.76 7.76M16.24 16.24L18.36 18.36M5.64 18.36L7.76 16.24M16.24 7.76L18.36 5.64" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
                                            </svg>
                                        </div>
                                        <div class="text-center space-y-2">
                                            <h3 class="font-bold text-white leading-snug text-base" style="font-family: var(--font-heading);">You have done<br>your part</h3>
                                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-3 py-2">
                                                <p class="text-white font-medium text-sm">It's our turn now</p>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Cursor --}}
                                    <div id="mob-plan-cursor" class="absolute pointer-events-none z-20" style="opacity:0; bottom:40px; right:40px;">
                                        <svg width="18" height="17" viewBox="0 0 24 23" fill="none"><path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xl font-semibold text-[var(--text-primary)]" style="font-family: var(--font-heading);">Choose Your Plan</h3>
                    <p class="text-base text-gray-600 leading-relaxed">Select Website Development or Monthly Retainer tailored to your needs</p>
                </div>
            </div>

            {{-- Step 2: Submit Your Request --}}
            <div id="mob-step2" class="bg-white rounded-3xl p-6 shadow-lg overflow-hidden">
                <div class="mb-6">
                    <div class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold bg-[var(--text-primary)] text-white">Step 2</div>
                </div>
                <div class="mb-6 overflow-hidden relative" style="height: 400px;">
                    <div class="max-w-full mx-auto absolute inset-0 flex items-center justify-center" style="max-width: 300px;">
                        <div id="mob-backlog-card" class="bg-white rounded-2xl shadow-xl border border-gray-200 w-full p-5" style="transform: rotate(-3deg);">
                            <h3 class="font-semibold text-lg mb-4 text-gray-900" style="font-family: var(--font-heading);">Your Design Backlogs</h3>
                            <div id="mob-backlog-list" class="space-y-2 relative">
                                <div class="mob-backlog-item flex items-center justify-between p-3 rounded-xl border-2 border-gray-200 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                        <span class="text-xs font-medium text-gray-700">Pitch deck for Client</span>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 font-medium">Request</span>
                                </div>
                                <div class="mob-backlog-item flex items-center justify-between p-3 rounded-xl border-2 border-gray-200 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                        <span class="text-xs font-medium text-gray-700">New infographics for Instagram</span>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 font-medium">Request</span>
                                </div>
                                <div class="mob-backlog-item flex items-center justify-between p-3 rounded-xl border-2 border-gray-300 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                        <span class="text-xs font-medium text-gray-700">Add a contact page</span>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-[#00AEEF]/10 text-[var(--color-primary-orange)] font-medium">Urgent</span>
                                </div>
                                <div class="mob-backlog-item flex items-center justify-between p-3 rounded-xl border-2 border-gray-200 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded border-2 border-gray-300 flex-shrink-0"></div>
                                        <span class="text-xs font-medium text-gray-700">New Logo</span>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 font-medium">Request</span>
                                </div>
                                {{-- Animated cursor --}}
                                <div id="mob-backlog-cursor" class="absolute pointer-events-none z-20" style="left:20px; top:20px; opacity:0;">
                                    <svg width="18" height="17" viewBox="0 0 24 23" fill="none"><path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xl font-semibold text-[var(--text-primary)]" style="font-family: var(--font-heading);">Submit Your Request</h3>
                    <p class="text-base text-gray-600 leading-relaxed">Share your requirements and we'll prioritize your tasks</p>
                </div>
            </div>

            {{-- Step 3: Watch Us Deliver --}}
            <div id="mob-step3" class="bg-white rounded-3xl p-6 shadow-lg overflow-hidden">
                <div class="mb-6">
                    <div class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold bg-[var(--text-primary)] text-white">Step 3</div>
                </div>
                <div class="mb-6 overflow-hidden relative" style="height: 400px;">
                    <div class="max-w-full mx-auto absolute inset-0 flex items-center justify-center" style="max-width: 300px;">
                        <div id="mob-checklist-card" class="bg-white rounded-2xl shadow-xl border border-gray-200 w-full p-5" style="transform: rotate(-3deg);">
                            <div class="flex items-center gap-3 pb-4 border-b border-gray-100 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-[var(--color-primary-orange)] flex items-center justify-center">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-white"><path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm" style="font-family: var(--font-heading);">Project Tasks</h3>
                                    <p class="text-xs text-gray-500">Your design backlog</p>
                                </div>
                            </div>
                            <div id="mob-checklist-list" class="space-y-2 relative">
                                @foreach(['Design Homepage', 'Create Brand Assets', 'Develop Components', 'Final Review'] as $task)
                                <div class="mob-checklist-item flex items-center gap-2 rounded-xl p-2">
                                    <div class="mob-check-box w-5 h-5 rounded-md border-2 border-gray-300 flex items-center justify-center flex-shrink-0">
                                        <svg class="mob-check-icon w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" style="opacity:0; transform:scale(0);"><path d="M5 12L10 17L20 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                    <span class="mob-check-text text-xs text-gray-700 font-medium">{{ $task }}</span>
                                </div>
                                @endforeach
                                {{-- Animated cursor --}}
                                <div id="mob-checklist-cursor" class="absolute pointer-events-none z-20" style="left:12px; top:15px; opacity:0;">
                                    <svg width="18" height="17" viewBox="0 0 24 23" fill="none"><path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path></svg>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-gray-100 mt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
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
                    <h3 class="text-xl font-semibold text-[var(--text-primary)]" style="font-family: var(--font-heading);">Watch Us Deliver</h3>
                    <p class="text-base text-gray-600 leading-relaxed">Track progress in real-time as we complete your project</p>
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
                                <div class="py-2 px-4 bg-gray-50 rounded-xl italic">1 active project</div>
                                <div class="py-2 px-4 bg-gray-50 rounded-xl italic">Unlimited revisions</div>
                                <div class="py-2 px-4 bg-gray-50 rounded-xl italic">Design &amp; development</div>
                                <div class="py-2 px-4 bg-gray-50 rounded-xl italic">SEO &amp; content</div>
                            </div>
                        </div>
                        {{-- Website Development card (front) --}}
                        <div id="plan-card-website" class="absolute top-1/2 left-1/2 bg-gradient-to-br from-black to-[#1A1A1A] rounded-3xl overflow-hidden shadow-xl" style="width:300px;height:400px;transform:translateX(-50%) translateY(-50%)">
                            {{-- Plan details (visible initially) --}}
                            <div id="plan-details" class="transition-opacity duration-500" style="padding:28px">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="text-white"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    <span class="text-xs text-white/90 font-medium italic">Recommended</span>
                                </div>
                                <h3 class="font-semibold mb-6 text-white italic text-3xl" style="font-family:var(--font-heading)">Website Development</h3>
                                <div class="space-y-3 text-sm">
                                    <div class="text-white/90 py-2 px-4 bg-white/10 rounded-xl backdrop-blur-sm italic">Custom landing page</div>
                                    <div class="text-white/90 py-2 px-4 bg-white/10 rounded-xl backdrop-blur-sm italic">Full development</div>
                                    <div class="text-white/90 py-2 px-4 bg-white/10 rounded-xl backdrop-blur-sm italic">SEO optimization</div>
                                    <div class="text-white/90 py-2 px-4 bg-white/10 rounded-xl backdrop-blur-sm italic">7-10 day delivery</div>
                                    <div id="plan-book-btn" class="w-full py-3 px-4 rounded-xl font-medium text-center transition-colors bg-white text-gray-900">Book your Slot</div>
                                </div>
                            </div>
                            {{-- "You have done your part" state (hidden initially) --}}
                            <div id="plan-done" class="absolute inset-0 flex flex-col items-center justify-center transition-opacity duration-500 opacity-0 pointer-events-none" style="padding:28px">
                                <div class="flex items-center gap-2 mb-6">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="text-white"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    <span class="text-xs text-white/90 font-medium">Recommended</span>
                                </div>
                                <div class="flex justify-center mb-8">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" class="text-white process-spin-icon">
                                        <path d="M12 3V6M12 18V21M6 12H3M21 12H18M5.64 5.64L7.76 7.76M16.24 16.24L18.36 18.36M5.64 18.36L7.76 16.24M16.24 7.76L18.36 5.64" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div class="text-center space-y-4">
                                    <h3 class="font-bold text-white leading-snug text-2xl" style="font-family:var(--font-heading)">You have done<br>your part</h3>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-4">
                                        <p class="text-white font-medium text-base">It's our turn now</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Cursor for clicking the button --}}
                            <div id="plan-cursor" class="absolute pointer-events-none z-20" style="opacity:0;bottom:60px;right:80px">
                                <svg width="20" height="19" viewBox="0 0 24 23" fill="none"><path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STATE 2: Design Backlogs card (Step 2) --}}
                <div id="process-card-2" class="process-card-state absolute inset-0 flex items-center justify-center transition-all duration-700 ease-out opacity-0 pointer-events-none" style="transform:translateY(30px)">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 w-full max-w-md p-6" style="transform:rotate(-5deg)">
                        <h3 class="font-semibold text-xl mb-4 text-gray-900" style="font-family:var(--font-heading)">Your Design Backlogs</h3>
                        <div class="space-y-3 relative backlog-list">
                            @foreach([
                                ['title' => 'Pitch deck for Client', 'tag' => 'Request', 'urgent' => false],
                                ['title' => 'New infographics for Instagram', 'tag' => 'Request', 'urgent' => false],
                                ['title' => 'Add a contact page', 'tag' => 'Urgent', 'urgent' => true],
                                ['title' => 'New Logo', 'tag' => 'Request', 'urgent' => false],
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
                                <svg width="20" height="19" viewBox="0 0 24 23" fill="none"><path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STATE 3: Project Tasks card with animated checks (Step 3) --}}
                <div id="process-card-3" class="process-card-state absolute inset-0 flex items-center justify-center transition-all duration-700 ease-out opacity-0 pointer-events-none" style="transform:translateY(30px)">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 w-full max-w-md p-6" style="transform:rotate(-5deg)">
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100 mb-6">
                            <div class="w-10 h-10 rounded-lg bg-[var(--color-primary-orange)] flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="text-white"><path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-base" style="font-family:var(--font-heading)">Project Tasks</h3>
                                <p class="text-xs text-gray-500">Your design backlog</p>
                            </div>
                        </div>
                        <div class="space-y-3 relative checklist-list">
                            @foreach(['Design Homepage', 'Create Brand Assets', 'Develop Components', 'Final Review'] as $task)
                            <div class="checklist-item flex items-center gap-3 rounded-xl hover:bg-gray-50 transition-colors p-3">
                                <div class="checklist-box w-6 h-6 rounded-md border-2 border-gray-300 flex items-center justify-center flex-shrink-0 transition-all duration-300">
                                    <svg class="checklist-check w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" style="opacity:0;transform:scale(0)"><path d="M5 12L10 17L20 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="checklist-text text-sm text-gray-700 font-medium transition-all duration-300">{{ $task }}</span>
                            </div>
                            @endforeach
                            {{-- Animated cursor --}}
                            <div id="checklist-cursor" class="absolute pointer-events-none z-20" style="left:15px;top:20px;opacity:0">
                                <svg width="20" height="19" viewBox="0 0 24 23" fill="none"><path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="black" stroke="white" stroke-width="2" stroke-miterlimit="10"></path></svg>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100 mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium text-gray-600">Progress</span>
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
                        <div class="process-step-badge inline-block px-4 py-1.5 rounded-full text-sm font-semibold transition-colors duration-300 bg-[var(--text-primary)] text-white">Step 1</div>
                        <h3 class="process-step-title text-xl font-semibold transition-colors duration-300 text-[var(--text-primary)]" style="font-family:var(--font-heading)">Choose Your Plan</h3>
                        <p class="process-step-desc text-base leading-relaxed transition-colors duration-300 text-gray-600">Select Website Development or Monthly Retainer tailored to your needs</p>
                    </div>
                    <div class="process-step-bar absolute left-0 top-1/2 -translate-y-1/2 w-1 h-12 bg-[var(--text-primary)] rounded-r-full transition-opacity duration-300 opacity-100"></div>
                </div>
                <div class="process-step relative p-6 rounded-xl cursor-pointer transition-all duration-300 bg-gray-50 hover:bg-white hover:shadow-md" data-step="2">
                    <div class="space-y-2.5">
                        <div class="process-step-badge inline-block px-4 py-1.5 rounded-full text-sm font-semibold transition-colors duration-300 bg-gray-200 text-gray-600">Step 2</div>
                        <h3 class="process-step-title text-xl font-semibold transition-colors duration-300 text-gray-700" style="font-family:var(--font-heading)">Submit Your Request</h3>
                        <p class="process-step-desc text-base leading-relaxed transition-colors duration-300 text-gray-500">Share your requirements and we'll prioritize your tasks</p>
                    </div>
                    <div class="process-step-bar absolute left-0 top-1/2 -translate-y-1/2 w-1 h-12 bg-[var(--text-primary)] rounded-r-full transition-opacity duration-300 opacity-0"></div>
                </div>
                <div class="process-step relative p-6 rounded-xl cursor-pointer transition-all duration-300 bg-gray-50 hover:bg-white hover:shadow-md" data-step="3">
                    <div class="space-y-2.5">
                        <div class="process-step-badge inline-block px-4 py-1.5 rounded-full text-sm font-semibold transition-colors duration-300 bg-gray-200 text-gray-600">Step 3</div>
                        <h3 class="process-step-title text-xl font-semibold transition-colors duration-300 text-gray-700" style="font-family:var(--font-heading)">Watch Us Deliver</h3>
                        <p class="process-step-desc text-base leading-relaxed transition-colors duration-300 text-gray-500">Track progress in real-time as we complete your project</p>
                    </div>
                    <div class="process-step-bar absolute left-0 top-1/2 -translate-y-1/2 w-1 h-12 bg-[var(--text-primary)] rounded-r-full transition-opacity duration-300 opacity-0"></div>
                </div>
            </div>
        </div>
    </div>
</section>
