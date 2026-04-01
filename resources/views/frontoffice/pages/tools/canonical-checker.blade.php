@extends('frontoffice.layouts.app')

@section('title', 'Vérificateur d\'URL Canonical - Validateur de Balise Canonical Gratuit | CodeSommet')
@section('meta_description', 'Vérifiez les balises canonical sur n\'importe quelle page. Validez les URL canonical, détectez les problèmes et évitez les pénalités de contenu dupliqué. Outil SEO gratuit.')
@section('meta_keywords', 'canonical checker,canonical URL,duplicate content,canonical tag validator,SEO canonical,URL canonicalization')
@section('og_title', 'Vérificateur d\'URL Canonical - Validateur de Balise Canonical Gratuit')
@section('og_description', 'Vérifiez et validez les URL canonical pour éviter les problèmes de contenu dupliqué')
@section('twitter_description', 'Vérifiez et validez les URL canonical pour éviter les problèmes de contenu dupliqué')

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
        <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span class="text-black font-medium">Vérificateur d'URL Canonical</span></nav>
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">Vérificateur d'URL Canonical</h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">Détectez les problèmes de balises canonical qui peuvent nuire à vos classements SEO</p>
        </div>
        <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
            <div class="relative">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
            </div><span class="text-green-700 font-medium">Gratuit • Aucune inscription requise</span>
        </div>
    </div>
</section>
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="space-y-8">
        <div class="bg-white rounded-2xl border-2 border-gray-200 p-8">
            <div class="space-y-6">
                <div class="space-y-2"><label class="block text-sm font-medium text-black">URL de la page<span class="text-[#00AEEF] ml-1">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 w-5 h-5" aria-hidden="true">
                                <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                <line x1="8" x2="16" y1="12" y2="12"></line>
                            </svg></div><input type="url" placeholder="https://example.com/blog/post" required="" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60 pl-11" value="" />
                    </div>
                </div><button class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full w-full" tabindex="0">Vérifier l'URL Canonical</button>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Comment utiliser cet outil</h3>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">1</div>
                    <p class="text-sm text-gray-700">Entrez l'URL de n'importe quelle page web que vous souhaitez vérifier</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">2</div>
                    <p class="text-sm text-gray-700">L'outil extraira la balise URL canonical et l'analysera</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold">3</div>
                    <p class="text-sm text-gray-700">Examinez les problèmes, les recommandations et corrigez les erreurs trouvées</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-question-mark w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                    <h3 class="text-xl md:text-2xl font-bold text-black">Questions Fréquemment Posées</h3>
                </div>
                <p class="text-sm md:text-base text-gray-600">Questions courantes sur cet outil et comment l'utiliser efficacement</p>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4 md:p-6">
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">1</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Qu'est-ce qu'une URL canonical et pourquoi est-ce important ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Une URL canonical est un élément HTML qui indique aux moteurs de recherche quelle version d'une page est la copie « principale » lorsqu'un contenu dupliqué ou similaire existe. Elle empêche les pénalités de contenu dupliqué, consolide l'équité des liens de plusieurs URL vers une version préférée, et garantit que la bonne page est classée dans les résultats de recherche. Sans balises canonical appropriées, votre classement SEO peut en souffrir considérablement.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">2</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Qu'est-ce qu'une balise canonical auto-référente ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Une balise canonical auto-référente pointe vers la même URL que la page sur laquelle elle se trouve (par exemple, une page sur example.com/blog pointe vers elle-même). C'est considéré comme une bonne pratique par Google car elle déclare explicitement la page comme la version canonical et empêche la duplication accidentelle causée par les paramètres d'URL ou les identifiants de session. Même si votre page n'a pas de doublons, ajouter une canonical auto-référente est recommandé.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">3</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Quand utiliser des balises canonical inter-domaines ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Les canonical inter-domaines sont utilisées lorsque vous republiez le même contenu sur plusieurs domaines et souhaitez attribuer le crédit à la source originale. Par exemple, si vous syndiquez un article de blog sur Medium ou LinkedIn, vous pouvez ajouter une balise canonical pointant vers votre article original. Cela indique à Google d'attribuer toute la valeur SEO à l'URL originale plutôt que de traiter les deux comme du contenu dupliqué.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">4</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Que se passe-t-il avec plusieurs balises canonical sur une page ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Plusieurs balises canonical créent des signaux contradictoires et déroutent les moteurs de recherche. Google en choisira généralement une arbitrairement ou les ignorera toutes, ce qui annule l'objectif des balises canonical. Cela se produit généralement lorsque des thèmes, des plugins ou plusieurs outils SEO injectent leurs propres balises canonical. Assurez-vous toujours qu'une seule balise canonical existe par page.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">5</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Les balises canonical peuvent-elles nuire au SEO si mal implémentées ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Oui, des balises canonical incorrectes peuvent gravement endommager le SEO. Les erreurs courantes incluent pointer vers une page 404, utiliser des URL relatives au lieu d'absolues, mélanger les versions HTTP et HTTPS, ou canonicaliser vers la mauvaise page. Ces erreurs peuvent amener Google à désindexer des pages ou perdre tous les signaux de classement, rendant critique l'audit régulier des balises canonical.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">6</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Comment Google gère les balises canonical vs les redirections 301 ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Les balises canonical sont des indications que Google peut choisir d'ignorer, tandis que les redirections 301 sont des directives qui doivent être suivies. Utilisez les redirections 301 lorsque vous déplacez définitivement du contenu vers une nouvelle URL. Utilisez les balises canonical lorsque vous avez du contenu dupliqué légitime qui doit exister sur plusieurs URL pour l'expérience utilisateur (comme les versions d'impression, les versions mobiles ou le contenu paginé).</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">7</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Quelles sont les erreurs d'URL canonical les plus courantes ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Les principales erreurs sont : ne pas utiliser d'URL absolues (domaine manquant), avoir plusieurs balises canonical, une canonical pointant vers une page 404 ou une redirection, mélanger les protocoles HTTP/HTTPS, oublier les balises canonical sur les pages paginées, et utiliser des balises canonical sur des pages noindex (signaux contradictoires). Des audits réguliers avec des outils comme celui-ci aident à détecter ces problèmes avant qu'ils n'impactent le classement.</p>
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
        <div class="grid md:grid-cols-3 gap-6 mb-8"><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/duplicate-content-checker">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect>
                            <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Duplicate Content Checker</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Comparez des blocs de texte pour détecter le contenu dupliqué ou similaire</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/heading-analyzer">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M3 5h.01"></path>
                            <path d="M3 12h.01"></path>
                            <path d="M3 19h.01"></path>
                            <path d="M8 5h13"></path>
                            <path d="M8 12h13"></path>
                            <path d="M8 19h13"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Analyseur de Structure des Titres</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Arbre visuel H1-H6 avec validation SEO</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/broken-link-checker">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                            <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                            <line x1="8" x2="16" y1="12" y2="12"></line>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Broken Link Checker</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Trouvez les liens brisés, redirections et délais d'attente</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span></div>
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
                      rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px" href="https://cal.com/codesommet/discovery">
                        <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel Découverte</span>
                    </a></div>
                <p class="text-sm text-white/50 pt-2">50+ projets réussis • Livraison en 48h • Sans engagement</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/tools-common.js') }}" defer></script>
<script src="{{ asset('js/tools/api-tools.js') }}" defer></script>
@endpush