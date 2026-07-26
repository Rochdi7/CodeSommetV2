@extends('layouts.app')

@section('title', 'Analyseur de Lisibilité - Outil Gratuit de Lisibilité de Contenu | CodeSommet')
@section('meta_description', 'Vérifiez la lisibilité du contenu avec les scores Flesch-Kincaid. Analysez le niveau de lecture, améliorez la clarté du contenu. Vérificateur de lisibilité gratuit.')
@section('meta_keywords', 'readability analyzer,Flesch-Kincaid,reading level,content readability,readability score,text analysis')
@section('og_title', 'Analyseur de Lisibilité - Outil Gratuit de Lisibilité de Contenu')
@section('og_description', 'Analysez la lisibilité et améliorez la compréhension du contenu')
@section('twitter_description', 'Analysez la lisibilité et améliorez la compréhension du contenu')

@section('content')
<section class="relative overflow-hidden pt-28 pb-16 bg-white">
    <div class="absolute inset-0 pointer-events-none" style="z-index:0">
        <div class="absolute inset-0 w-full h-full" style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);background-size:30px 30px;background-position:center center"></div>
        <div class="absolute inset-0 w-full h-full" style="background:radial-gradient(
            ellipse 70% 70% at center,
            transparent 0%,
            transparent 10%,
            rgba(255, 255, 255, 0.1425) 25%,
            rgba(255, 255, 255, 0.33249999999999996) 40%,
            rgba(255, 255, 255, 0.57) 60%,
            rgba(255, 255, 255, 0.8075) 80%,
            rgba(255, 255, 255, 0.95) 100%
          )"></div>
    </div>
    <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
        <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span class="text-black font-medium">Analyseur de Score de Lisibilité</span></nav>
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">Analyseur de Score de Lisibilité</h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">Analysez la lisibilité de votre contenu à l'aide de plusieurs algorithmes. Obtenez des niveaux de lecture, des scores de lisibilité et des conseils pratiques pour rendre votre écriture plus claire et plus accessible.to users with disabilities, which aligns with Google's emphasis on inclusive web experiences.</p>
        </div>
    </div>
    <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
            <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">3</span></div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base md:text-lg font-semibold text-black">Quelle est la différence entre Flesch Reading Ease et Flesch-Kincaid Grade ?</h3>
            </div>
            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg></div>
        </button>
        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
            <p>Flesch Reading Ease utilise une échelle de 0 à 100 où des scores plus élevés signifient une lecture plus facile. Flesch-Kincaid Grade montre le niveau scolaire américain nécessaire pour comprendre le texte (ex. : 8.0 = 4ème). Ils sont calculés différemment mais mesurent tous deux la lisibilité - utilisez Reading Ease pour une évaluation rapide et Grade Level pour cibler des niveaux d'éducation spécifiques.</p>
        </div>
    </div>
    <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
            <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">4</span></div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base md:text-lg font-semibold text-black">Dois-je toujours viser le score de lisibilité le plus élevé ?</h3>
            </div>
            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg></div>
        </button>
        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
            <p>Pas nécessairement. Équilibrez la lisibilité avec l'expertise de votre audience. Les blogs techniques, le contenu académique et la rédaction juridique peuvent nécessiter un langage complexe. L'essentiel est d'adapter la complexité de votre contenu à votre public cible - ne simplifiez pas excessivement le contenu expert, mais ne compliquez pas inutilement le contenu grand public.</p>
        </div>
    </div>
    <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
            <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">5</span></div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base md:text-lg font-semibold text-black">Comment améliorer mon score de lisibilité sans simplifier le contenu ?</h3>
            </div>
            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg></div>
        </button>
        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
            <p>Divisez les longues phrases en phrases plus courtes, utilisez la voix active au lieu de la voix passive, remplacez le jargon par un langage simple lorsque c'est possible, et ajoutez des phrases de transition pour la fluidité. Vous pouvez maintenir la profondeur et l'expertise tout en améliorant la clarté - c'est une question de structure et de choix de mots, pas de qualité du contenu.</p>
        </div>
    </div>
    <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
            <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">6</span></div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base md:text-lg font-semibold text-black">Que signifient les 'mots complexes' dans l'analyse de lisibilité ?</h3>
            </div>
            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg></div>
        </button>
        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
            <p>Les mots complexes sont généralement définis comme des mots de 3 syllabes ou plus. Bien que tous les mots longs ne soient pas difficiles, ils nécessitent généralement plus d'effort cognitif pour être traités. L'outil les met en évidence pour que vous puissiez décider si des alternatives plus simples existent sans changer votre sens ou sacrifier la précision.</p>
        </div>
    </div>
    <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
            <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">7</span></div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base md:text-lg font-semibold text-black">Puis-je utiliser cet outil pour vérifier la lisibilité dans d'autres langues que l'anglais ?</h3>
            </div>
            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg></div>
        </button>
        <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
            <p>Actuellement, cet outil est optimisé pour le contenu en anglais uniquement. Les algorithmes (Flesch, SMOG, Coleman-Liau) sont basés sur les modèles de la langue anglaise comme le nombre de syllabes et la structure des phrases, qui ne se traduisent pas précisément dans d'autres langues. Pour le contenu non anglais, recherchez des outils de lisibilité spécifiques à la langue.</p>
        </div>
    </div>
    </div>
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 mb-2">Vous avez encore des questions ?</p><a href="/contact" class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">Contactez notre équipe pour obtenir de l'aide<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg></a>
    </div>
    </div>
    </div>
</section>
<section class="py-16 bg-white border-t border-gray-100">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-black mb-3" style="font-family:var(--font-heading)">Outils Connexes Qui Pourraient Vous Intéresser</h2>
            <p class="text-gray-600 text-lg">Continuez à optimiser votre site web avec ces outils complémentaires</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 mb-8"><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/word-counter">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M12 4v16"></path>
                            <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                            <path d="M9 20h6"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Word &amp; Character Counter</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Comptez les mots, les caractères et vérifiez les limites des plateformes</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">content</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/html-to-text">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-code w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M10 12.5 8 15l2 2.5"></path>
                            <path d="m14 12.5 2 2.5-2 2.5"></path>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">HTML to Plain Text Converter</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Convertissez le HTML en texte brut propre et lisible instantanément</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">content</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/text-case-converter">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M12 4v16"></path>
                            <path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"></path>
                            <path d="M9 20h6"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Text Case Converter</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Convertissez le texte entre majuscules, minuscules, casse de titre et plus</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">content</span></div>
            </a></div>
        <div class="text-center"><a class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors" href="/tools">Parcourir les <!-- -->41<!-- --> Outils Gratuits<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg></a></div>
    </div>
</section>
<section class="py-12 bg-[#F5F5F5]">
    <div class="max-w-5xl mx-auto px-4">
        <div class="relative overflow-hidden rounded-2xl px-6 py-8 md:py-10" style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
            <div class="absolute inset-0 z-0" style="background-image:linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
                                 linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);background-size:50px 50px"></div>
            <div class="absolute inset-0 z-[1]" style="background:radial-gradient(
                  ellipse 70% 70% at center,
                  transparent 0%,
                  rgba(10, 10, 10, 0.3) 50%,
                  rgba(10, 10, 10, 0.8) 100%
                )"></div>
            <div class="relative z-10 text-center space-y-6">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight text-white" style="font-family:var(--font-display)">Besoin d'un Outil Personnalisé pour Votre Entreprise ?</h2>
                <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">Nous créons des outils alimentés par l'IA, des tableaux de bord et des automatisations qui génèrent de vrais résultats</p>
                <div class="pt-2"><a target="_blank" rel="noopener noreferrer" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden transition-transform hover:scale-105" style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                      rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                      rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                      rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px" href="https://cal.com/code-sommet/new-client-meeting">
                        <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel Découverte</span>
                    </a></div>
                <p class="text-sm text-white/50 pt-2">50+ projets réussis • Livraison en 48h • Sans engagement à long terme</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/tools-common.js') }}" defer></script>
<script src="{{ asset('js/tools/readability-analyzer.js') }}" defer></script>
@endpush