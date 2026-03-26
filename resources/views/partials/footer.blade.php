{{-- Pied de page --}}
<footer class="relative bg-black text-white overflow-hidden min-h-[600px]">
    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 h-full min-h-[600px]">

        {{-- Texte SVG d'arrière-plan "codesommet" --}}
        <div class="absolute bottom-0 left-0 pointer-events-none w-full flex justify-center md:justify-start">
            <svg viewBox="0 0 1600 250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMax meet" aria-hidden="true" class="h-auto will-change-transform">
                <defs>
                    <linearGradient id="textStrokeGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#C0C0C0" stop-opacity="1"></stop>
                        <stop offset="85%" stop-color="#000000" stop-opacity="1"></stop>
                    </linearGradient>
                </defs>
                <text x="20" y="200" fill="none" stroke="url(#textStrokeGradient)" stroke-width="1.5" font-size="200" font-weight="bold" font-family="var(--font-heading)">codesommet</text>
            </svg>
        </div>

        <div class="relative z-10 pt-16 pb-8">

            {{-- Section supérieure : marque + colonnes de navigation --}}
            <div class="md:flex md:gap-12 lg:gap-20 mb-16">

                {{-- Bloc marque --}}
                <div class="space-y-6 mb-12 md:mb-0 md:max-w-sm flex-shrink-0">
                    <a class="inline-flex items-center gap-1" href="{{ route('home') }}">
                        <div class="w-10 h-10">
                            <img src="{{ asset('logo-white.svg') }}" alt="CodeSommet" class="w-full h-full object-contain" />
                        </div>
                        <span style="font-family:var(--font-heading)" class="text-2xl font-bold text-white">CodeSommet</span>
                    </a>
                    <p class="text-[#A0A0A0] leading-relaxed text-sm">
                        CodeSommet est une agence digitale spécialisée dans le développement web sur mesure, le design UI/UX, le branding, le SEO et les solutions e-commerce. Nous aidons les entreprises à développer leur présence en ligne avec des solutions digitales modernes et performantes.
                    </p>
                </div>

                {{-- Colonnes de navigation --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-6 lg:gap-8 mb-12 md:mb-0 flex-1">

                    {{-- Villes --}}
                    <div class="space-y-4">
                        <h3 class="text-base font-medium text-[#E0E0E0]">Emplacements</h3>
                        <ul class="space-y-2.5">
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('location', 'casablanca') }}">Casablanca</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('location', 'marrakech') }}">Marrakech</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('location', 'rabat') }}">Rabat</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('location', 'tangier') }}">Tanger</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('location', 'worldwide') }}">International</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('locations') }}">Tous les Emplacements →</a></li>
                        </ul>
                    </div>

                    {{-- Industries --}}
                    <div class="space-y-4">
                        <h3 class="text-base font-medium text-[#E0E0E0]">Secteurs</h3>
                        <ul class="space-y-2.5">
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('service', 'education-website-development') }}">Éducation & EdTech</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('service', 'healthcare-website-development') }}">Santé & Médical</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('service', 'study-abroad-website-development') }}">Études à l'Étranger</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('service', 'saas-platform-development') }}">SaaS & Logiciel B2B</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('service', 'ecommerce-website-development') }}">E-commerce</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('service', 'fintech-platform-development') }}">FinTech & Finance</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('industries') }}">Tous les Secteurs →</a></li>
                        </ul>
                    </div>

                    {{-- Popular Tools --}}
                    <div class="space-y-4">
                        <h3 class="text-base font-medium text-[#E0E0E0]">Outils Populaires</h3>
                        <ul class="space-y-2.5">
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('tool', 'website-analyzer') }}">Analyseur de Site Web</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('tool', 'website-readiness-checker') }}">Vérificateur de Site</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('tool', 'meta-tag-generator') }}">Générateur de Balises Meta</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('tool', 'blog-title-generator') }}">Générateur de Titres</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('tool', 'heading-analyzer') }}">Analyseur de Titres</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('tool', 'color-palette-generator') }}">Générateur de Palette</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('tools') }}">Tous les Outils →</a></li>
                        </ul>
                    </div>

                    {{-- Légal --}}
                    <div class="space-y-4">
                        <h3 class="text-base font-medium text-[#E0E0E0]">Légal</h3>
                        <ul class="space-y-2.5">
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('get-quote') }}">Demander un Devis</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('privacy-policy') }}">Politique de Confidentialité</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('refund-policy') }}">Politique de Remboursement</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('cookie-policy') }}">Politique de Cookies</a></li>
                            <li><a class="text-sm text-[#A0A0A0] hover:text-white transition-colors duration-200 inline-block" href="{{ route('acceptable-use') }}">Utilisation Acceptable</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            {{-- Icônes sociales --}}
            <div class="flex justify-center md:justify-end items-center mb-32 md:mb-0">
                <div class="flex items-center gap-3">
                    {{-- LinkedIn --}}
                    <a aria-label="LinkedIn" target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full bg-[#404040] hover:bg-[#505050] flex items-center justify-center transition-all duration-200"
                       href="https://www.linkedin.com/in/codesommet">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-linkedin w-4 h-4 text-white" aria-hidden="true">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                            <rect width="4" height="12" x="2" y="9"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </a>

                    {{-- Instagram --}}
                    <a aria-label="Instagram" target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full bg-[#404040] hover:bg-[#505050] flex items-center justify-center transition-all duration-200"
                       href="https://www.instagram.com/code_sommet/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram w-4 h-4 text-white" aria-hidden="true">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                        </svg>
                    </a>

                    {{-- Facebook --}}
                    <a aria-label="Facebook" target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full bg-[#404040] hover:bg-[#505050] flex items-center justify-center transition-all duration-200"
                       href="https://www.facebook.com/codesommetagency">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>

                    {{-- YouTube --}}
                    <a aria-label="YouTube" target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full bg-[#404040] hover:bg-[#505050] flex items-center justify-center transition-all duration-200"
                       href="https://www.youtube.com/@codesommet">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"></path>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</footer>
