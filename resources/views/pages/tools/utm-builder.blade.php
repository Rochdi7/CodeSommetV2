@extends('layouts.app')

@section('title', "Constructeur UTM - Générateur Gratuit d'''URL de Campagne | CodeSommet")
@section('meta_description', 'Create UTM tracking URLs for marketing campaigns with our free UTM builder. Track campaign performance in Google Analytics with utm_source, utm_medium, utm_campaign, and more. Generate clean, optimized tracking URLs instantly.')
@section('meta_keywords', 'UTM builder,UTM generator,campaign URL,UTM parameters,Google Analytics UTM,tracking URL,utm_source,utm_medium,utm_campaign,marketing analytics,campaign tracking,URL builder,analytics tracking,traffic source tracking')
@section('og_title', "Constructeur UTM - Générateur Gratuit d'''URL de Campagne")
@section('og_description', 'Create UTM tracking URLs for marketing campaigns with our free UTM builder. Track campaign performance in Google Analytics with utm_source, utm_medium, utm_campaign, and more.')
@section('twitter_description', 'Create UTM tracking URLs for marketing campaigns. Track campaign performance in Google Analytics instantly.')

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
        <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span class="text-black font-medium">Constructeur de Paramètres UTM</span></nav>
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">Constructeur de Paramètres UTM</h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">Créez des URL de campagne traçables avec des paramètres UTM pour Google Analytics</p>
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
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Générateur d'URL de Campagne</h3>
            <div class="space-y-6">
                <div class="space-y-2"><label class="block text-sm font-medium text-black">URL du Site Web<span class="text-[#00AEEF] ml-1">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 w-5 h-5" aria-hidden="true">
                                <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                <line x1="8" x2="16" y1="12" y2="12"></line>
                            </svg></div><input type="url" placeholder="https://example.com/page" required="" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60 pl-11" value="" />
                    </div>
                    <p class="text-sm text-gray-500">L'URL complète du site web (ex. : https://codesommet.com/services)</p>
                </div>
                <div class="space-y-4">
                    <p class="text-sm font-medium text-gray-900">Paramètres Requis</p>
                    <div class="space-y-2"><label class="block text-sm font-medium text-black">Source de Campagne<span class="text-[#00AEEF] ml-1">*</span></label>
                        <div class="relative"><input type="text" placeholder="google" required="" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60" value="" /></div>
                        <p class="text-sm text-gray-500">Indique d'où provient le trafic (ex. : google, newsletter, facebook)</p>
                    </div>
                    <div class="space-y-2"><label class="block text-sm font-medium text-black">Canal de Campagne<span class="text-[#00AEEF] ml-1">*</span></label>
                        <div class="relative"><input type="text" placeholder="cpc" required="" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60" value="" /></div>
                        <p class="text-sm text-gray-500">Indique le canal marketing (ex. : cpc, email, social, banner)</p>
                    </div>
                    <div class="space-y-2"><label class="block text-sm font-medium text-black">Nom de Campagne<span class="text-[#00AEEF] ml-1">*</span></label>
                        <div class="relative"><input type="text" placeholder="summer_sale" required="" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60" value="" /></div>
                        <p class="text-sm text-gray-500">Indique le produit, la promotion ou le slogan (ex. : summer_sale, product_launch)</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <p class="text-sm font-medium text-gray-900">Paramètres Optionnels</p>
                    <div class="space-y-2"><label class="block text-sm font-medium text-black">Terme de Campagne</label>
                        <div class="relative"><input type="text" placeholder="ai+websites" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60" value="" /></div>
                        <p class="text-sm text-gray-500">Mots-clés payants (ex. : running+shoes, ai+websites)</p>
                    </div>
                    <div class="space-y-2"><label class="block text-sm font-medium text-black">Contenu de Campagne</label>
                        <div class="relative"><input type="text" placeholder="ad_variant_1" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60" value="" /></div>
                        <p class="text-sm text-gray-500">Permet de différencier des annonces ou des liens (ex. : logo_link, ad_variant_1)</p>
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm font-medium text-gray-900 mb-3">Préréglages Rapides</p>
                    <div class="flex flex-wrap gap-2"><button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">Campagne Google Ads</button><button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">Newsletter par E-mail</button><button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">Publication Réseaux Sociaux</button></div>
                </div>
                <div class="flex gap-3"><button class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] border border-[var(--border-default)] text-[var(--text-primary)] bg-transparent hover:border-[var(--color-primary-orange)] hover:text-[var(--color-primary-orange)] hover:bg-[var(--hover-primary)] h-10 px-6 text-base rounded-full flex-1" tabindex="0">Réinitialiser le Formulaire</button></div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Comment Utiliser les Paramètres UTM</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-semibold text-gray-900 mb-2">Que sont les Paramètres UTM ?</p>
                    <p class="text-sm text-gray-700 leading-relaxed">UTM parameters are tags you add to URLs to track the effectiveness of marketing campaigns in Google Analytics. They help you identify which campaigns, sources, and content drive the most traffic and conversions.</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 mb-2">Référence des Paramètres</p>
                    <div class="space-y-2">
                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-900">utm_source (Required)</p>
                            <p class="text-xs text-gray-600">Identifie la source du trafic (google, newsletter, facebook)</p>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-900">utm_medium (Required)</p>
                            <p class="text-xs text-gray-600">Identifie le canal marketing (cpc, email, social, banner)</p>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-900">utm_campaign (Required)</p>
                            <p class="text-xs text-gray-600">Identifie le nom de la campagne (summer_sale, product_launch)</p>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-900">utm_term (Optional)</p>
                            <p class="text-xs text-gray-600">Identifie les mots-clés payants pour les campagnes de recherche</p>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-sm font-medium text-gray-900">utm_content (Optional)</p>
                            <p class="text-xs text-gray-600">Différencie des contenus ou liens similaires (ad_variant_1, header_cta)</p>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 mb-2">Meilleures Pratiques</p>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span>Utilisez des lettres minuscules et des underscores (ex. : summer_sale, pas Summer Sale)</span></li>
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span>Restez cohérent dans les conventions de nommage sur toutes les campagnes</span></li>
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span>Gardez les URL sous 2 000 caractères pour une compatibilité maximale</span></li>
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span>Testez vos URL avant de lancer des campagnes afin d'assurer un suivi correct</span></li>
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span>Documentez vos conventions de nommage UTM pour garantir la cohérence de toute l?équipe</span></li>
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 mb-2">Cas d'Utilisation Courants</p>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span><strong>Email campaigns:</strong> Track which emails drive traffic (source=newsletter, medium=email)</span></li>
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span><strong>Paid ads:</strong> Measure ROI for Google Ads, Facebook Ads (source=google, medium=cpc)</span></li>
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span><strong>Social media:</strong> Compare performance across platforms (source=linkedin, medium=social)</span></li>
                        <li class="flex items-start gap-2"><span class="text-[#00AEEF] font-bold">•</span><span><strong>Banner ads:</strong> Track display advertising effectiveness (medium=banner)</span></li>
                    </ul>
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
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">1</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Que sont les paramètres UTM et pourquoi les utiliser ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                        <p>UTM parameters are tags added to URLs that help track the performance of marketing campaigns in Google Analytics. They allow you to see exactly where your traffic comes from, which campaigns are most effective, and which content drives the most conversions. This data is essential for optimizing your marketing spend and strategy.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">2</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Quels paramètres UTM sont requis vs optionnels ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                        <p>Three parameters are required: utm_source (identifies traffic source like 'google'), utm_medium (identifies marketing channel like 'cpc' or 'email'), and utm_campaign (identifies the specific campaign like 'summer_sale'). Two are optional: utm_term (for paid search keywords) and utm_content (to differentiate similar ads or links).</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">3</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Quelles conventions de nommage suivre pour les paramètres UTM ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                        <p>Always use lowercase letters and replace spaces with underscores (e.g., 'summer_sale' not 'Summer Sale'). Be consistent across all campaigns-decide on a naming structure and stick to it. Avoid special characters and keep names descriptive but concise. Document your conventions so your entire team uses the same standards.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">4</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Comment les paramètres UTM fonctionnent-ils avec Google Analytics ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                        <p>When someone clicks a URL with UTM parameters, Google Analytics automatically captures those parameters and organizes your traffic data by source, medium, and campaign. You can view this data in the Acquisition reports to analyze campaign performance, compare traffic sources, and measure ROI on your marketing efforts.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">5</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Dois-je raccourcir les URL avec UTM avant de les partager ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                        <p>Yes, it's highly recommended to use URL shorteners like Bitly or TinyURL for UTM-tagged URLs, especially for social media and printed materials. Long URLs with multiple parameters look unprofessional and may get truncated. URL shorteners preserve all tracking parameters while making links clean and shareable.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">6</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Quelles sont les erreurs courantes à éviter avec les paramètres UTM ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                        <p>Avoid inconsistent naming (using both 'Facebook' and 'facebook'), using spaces instead of underscores, adding UTM parameters to internal links (this breaks your analytics), forgetting to encode special characters, and creating URLs longer than 2000 characters. Always test your URLs before launching campaigns to ensure tracking works correctly.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-5 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">7</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Puis-je utiliser des paramètres UTM pour le trafic non payant ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden pr-4 pb-6 pt-1 pl-4 sm:pl-14 text-sm md:text-[15px] text-gray-700 leading-[1.7]">
                        <p>Absolutely! UTM parameters work for any traffic source, not just paid ads. Use them for email newsletters (medium=email), organic social posts (medium=social), blog guest posts (medium=referral), QR codes (medium=qr_code), and any other marketing channel. This gives you complete visibility into all your traffic sources, not just paid campaigns.</p>
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
        <div class="grid md:grid-cols-3 gap-6 mb-8"><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/og-preview-generator">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Aperçu Open Graph</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Prévisualisez les cartes de réseaux sociaux pour 4 plateformes majeures</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
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
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Arborescence visuelle H1-H6 avec validation SEO</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/keyword-density-analyzer">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                            <path d="M18 17V9"></path>
                            <path d="M13 17V5"></path>
                            <path d="M8 17v-3"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Analyseur de Densité de Mots-clés</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Détectez le bourrage de mots-clés et le contenu insuffisant</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
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
<script src="{{ asset('js/tools/utm-builder.js') }}" defer></script>
@endpush