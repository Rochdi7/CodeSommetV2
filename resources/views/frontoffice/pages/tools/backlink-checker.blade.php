@extends('frontoffice.layouts.app')

@section('title', 'Vérificateur de Backlinks - Outil Gratuit d\'Analyse de Backlinks | CodeSommet')
@section('meta_description', 'Analysez le profil de backlinks de votre site web gratuitement. Vérifiez la qualité des backlinks, identifiez les liens dofollow vs nofollow, détectez les backlinks toxiques et surveillez vos efforts de création de liens avec notre outil complet de vérification de backlinks.')
@section('meta_keywords', 'backlink checker,backlink analyzer,link analysis,backlink profile,SEO backlinks,inbound links,link building tool,backlink audit,dofollow backlinks,nofollow backlinks,toxic backlinks,link quality checker')
@section('og_title', 'Vérificateur de Backlinks - Outil Gratuit d\'Analyse de Backlinks')
@section('og_description', 'Analysez le profil de backlinks de votre site web gratuitement. Vérifiez la qualité des backlinks, identifiez les liens dofollow vs nofollow, détectez les backlinks toxiques et surveillez vos efforts de création de liens.')
@section('twitter_description', 'Analysez le profil de backlinks de votre site web gratuitement. Vérifiez la qualité des backlinks, identifiez les liens dofollow vs nofollow, détectez les backlinks toxiques et surveillez vos efforts de création de liens.')

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
        <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span class="text-black font-medium">Backlink Checker</span></nav>
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">Backlink Checker</h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">Analysez les backlinks avec de vraies données de l'API Moz. Vérifiez le Domain Authority, le Page Authority, le Spam Score et découvrez les backlinks réels pointant vers n'importe quelle URL.</p>
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
    <div class="mb-8 p-6 bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl">
        <div class="flex items-start gap-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" aria-hidden="true">
                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
            </svg>
            <div>
                <h3 class="font-bold text-blue-900 mb-2 text-lg">Propulsé par Moz</h3>
                <p class="text-sm text-blue-800">Obtenez une analyse complète des backlinks avec <strong>des données réelles de l'index web leader de Moz</strong>. Analysez le Domain Authority, le Page Authority, le Spam Score et découvrez les backlinks les plus importants pour votre stratégie SEO.</p>
            </div>
        </div>
    </div>
    <div class="space-y-6 mb-8">
        <div class="space-y-4">
            <div class="space-y-2"><label class="block text-sm font-medium text-black">URL ou Domaine Cible<span class="text-[#00AEEF] ml-1">*</span></label>
                <div class="relative"><input type="url" placeholder="example.com or https://example.com" required="" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60" value="" /></div>
            </div><button class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-11 px-8 text-lg rounded-full w-full bg-[#00AEEF] hover:bg-[#0071BC] text-white" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap mr-2 h-5 w-5" aria-hidden="true">
                    <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                </svg>Analyser les Backlinks</button>
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
                        <h3 class="text-base md:text-lg font-semibold text-black">Qu'est-ce que le Domain Authority (DA) et pourquoi est-ce important ?</h3>
                    </div>
                    <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg></div>
                </button>
                <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                    <p>Le Domain Authority est un score (0-100) développé par Moz qui prédit la capacité d'un site web à se positionner dans les moteurs de recherche. Il est basé sur la qualité des backlinks, le nombre de domaines référents et d'autres facteurs. Un DA plus élevé signifie un meilleur potentiel SEO. DA 60+ est excellent, 40-60 est bon, 20-40 est moyen, et en dessous de 20 nécessite une amélioration.</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">2</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">Comment cet outil analyse-t-il les backlinks ?</h3>
                    </div>
                    <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg></div>
                </button>
                <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                    <p>Notre vérificateur de backlinks utilise l'index web leader de Moz pour fournir une analyse complète en deux étapes : d'abord, vous obtenez un accès instantané aux métriques Domain Authority, Page Authority, Spam Score et MozRank. Ensuite, vous pouvez optionnellement consulter des données détaillées sur les backlinks, y compris les 10 meilleurs backlinks, la distribution des textes d'ancrage et l'analyse des domaines référents.</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">3</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">Quelle est la différence entre le Page Authority et le Domain Authority ?</h3>
                    </div>
                    <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg></div>
                </button>
                <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                    <p>Le Domain Authority (DA) mesure la force de classement d'un domaine/site web entier, tandis que le Page Authority (PA) mesure le potentiel de classement d'une seule page. Un site web peut avoir un DA élevé mais les pages individuelles peuvent avoir des scores PA variables. Les deux utilisent une échelle de 0 à 100 et sont calculés en utilisant les backlinks, le MozRank et d'autres facteurs.</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">4</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">Qu'est-ce que le Spam Score et comment est-il calculé ?</h3>
                    </div>
                    <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg></div>
                </button>
                <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                    <p>Le Spam Score (0-100%) représente le pourcentage de sites ayant des caractéristiques similaires que Moz a signalés comme spam ou pénalisés par Google. 0-5% est un risque très faible (excellent), 6-15% est un risque faible (acceptable), 16-30% est un risque moyen (prudence), et 31%+ est un risque élevé (probablement problématique). Il est basé sur 27 indicateurs de spam courants.</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">5</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">Pourquoi devrais-je vérifier les backlinks régulièrement ?</h3>
                    </div>
                    <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg></div>
                </button>
                <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                    <p>La surveillance régulière des backlinks vous aide à : (1) Suivre les progrès SEO et les efforts de création de liens, (2) Identifier les liens toxiques ou spam qui pourraient nuire au classement, (3) Découvrir de nouvelles opportunités de backlinks, (4) Surveiller les profils de liens des concurrents, (5) Détecter les attaques de SEO négatif, et (6) Mesurer l'impact des campagnes RP et du marketing de contenu.</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">6</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">Comment puis-je améliorer mon score de Domain Authority ?</h3>
                    </div>
                    <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg></div>
                </button>
                <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                    <p>Concentrez-vous sur l'obtention de backlinks de haute qualité provenant de sites web faisant autorité dans votre niche. Les stratégies incluent : créer du contenu exceptionnel et partageable, publier des articles invités sur des sites réputés, être présenté dans des publications spécialisées, établir des relations avec des influenceurs, corriger les liens brisés et supprimer les backlinks toxiques. L'amélioration du DA prend du temps (minimum 3-6 mois).</p>
                </div>
            </div>
            <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">7</span></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-semibold text-black">Que dois-je faire si j'ai un Spam Score élevé ?</h3>
                    </div>
                    <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg></div>
                </button>
                <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                    <p>D'abord, auditez votre profil de backlinks en utilisant cet outil ou Google Search Console. Identifiez les liens toxiques provenant d'annuaires spam, de sites de faible qualité ou de domaines pénalisés. Supprimez ces liens en contactant les webmasters ou utilisez l'outil de désaveu de Google. Concentrez-vous sur la création de backlinks de qualité à l'avenir. Un spam score supérieur à 30% nécessite une action immédiate.</p>
                </div>
            </div>
        </div>
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 mb-2">Vous avez encore des questions ?</p><a href="/contact" class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">Contactez notre équipe pour obtenir de l'aide<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg></a>
        </div>
    </div>
</section>
<section class="py-16 bg-white border-t border-gray-100">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-black mb-3" style="font-family:var(--font-heading)">Outils Connexes Qui Pourraient Vous Intéresser</h2>
            <p class="text-gray-600 text-lg">Continuez à optimiser votre site web avec ces outils complémentaires</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 mb-8"><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/internal-link-analyzer">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                            <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                            <line x1="8" x2="16" y1="12" y2="12"></line>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Internal Link Analyzer</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Analysez la structure de liens internes et trouvez les liens brisés</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/nofollow-link-checker">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                            <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                            <line x1="8" x2="16" y1="12" y2="12"></line>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Nofollow Link Checker</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Analysez le HTML pour trouver les liens nofollow et les métriques de liens</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayer gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/domain-authority-checker">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Domain Authority Checker</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Vérifiez l'autorité de domaine et les métriques SEO</p>
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