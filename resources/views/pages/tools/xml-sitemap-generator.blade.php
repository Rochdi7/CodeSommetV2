@extends('layouts.app')

@section('title', 'Générateur de Sitemap XML - Créateur de Sitemap Gratuit | CodeSommet')
@section('meta_description', 'Générez des sitemaps XML pour votre site web. Aidez les moteurs de recherche à découvrir et indexer vos pages. Générateur de sitemap gratuit avec téléchargement instantané.')
@section('meta_keywords', 'XML sitemap generator,sitemap creator,sitemap builder,SEO sitemap,sitemap tool,website sitemap')
@section('og_title', 'Générateur de Sitemap XML - Créateur de Sitemap Gratuit')
@section('og_description', 'Générez des sitemaps XML appropriés pour une meilleure indexation par les moteurs de recherche')
@section('twitter_description', 'Générez des sitemaps XML appropriés pour une meilleure indexation par les moteurs de recherche')

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
        <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span class="text-black font-medium">Générateur de Sitemap XML</span></nav>
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">Générateur de Sitemap XML</h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">Générez des sitemaps XML optimisés SEO pour une meilleure exploration par les moteurs de recherche</p>
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
                <div class="space-y-2"><label class="block text-sm font-medium text-black">URLs <span class="text-[#00AEEF]">*</span></label><textarea placeholder="https://example.com https://example.com/about https://example.com/contact  Enter one URL per line..." rows="8" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-black placeholder:text-gray-400 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none transition-all duration-200 resize-none"></textarea>
                    <p class="text-xs text-gray-500">Entrez une URL par ligne. Appuyez sur Ctrl/Cmd + Entrée pour générer.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2"><label class="block text-sm font-medium text-black">Fréquence de Modification</label><select class="h-12 w-full px-4 bg-white border border-gray-200 rounded-xl text-black focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none transition-all duration-200">
                            <option value="always">Always</option>
                            <option value="hourly">Hourly</option>
                            <option value="daily">Daily</option>
                            <option value="weekly" selected="">Hebdomadaire (Recommandé)</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                            <option value="never">Never</option>
                        </select>
                        <p class="text-xs text-gray-500">À quelle fréquence le contenu de la page change</p>
                    </div>
                    <div class="space-y-2"><label class="block text-sm font-medium text-black">Priority: <!-- -->0.8</label><input type="range" min="0" max="1" step="0.1" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#00AEEF]" value="0.8" />
                        <div class="flex justify-between text-xs text-gray-500"><span>0.0 (Low)</span><span>0.5 (Medium)</span><span>1.0 (High)</span></div>
                        <p class="text-xs text-gray-500">Importance relative (0.0 à 1.0)</p>
                    </div>
                </div><button class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full w-full" tabindex="0">Générer le Sitemap XML</button>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Comment utiliser cet outil</h3>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5">1</div>
                    <div>
                        <p class="text-sm font-medium text-black">Entrez Vos URL</p>
                        <p class="text-sm text-gray-600">Ajoutez une URL par ligne. Incluez votre page d'accueil, les pages importantes, les articles de blog, etc.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5">2</div>
                    <div>
                        <p class="text-sm font-medium text-black">Configurer les Paramètres</p>
                        <p class="text-sm text-gray-600">Définissez la fréquence de modification (à quelle fréquence les pages sont mises à jour) et la priorité (importance 0.0-1.0)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5">3</div>
                    <div>
                        <p class="text-sm font-medium text-black">Generate &amp; Télécharger</p>
                        <p class="text-sm text-gray-600">Click &quot;Generate&quot; to create your sitemap.xml file, then download it</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5">4</div>
                    <div>
                        <p class="text-sm font-medium text-black">Uploader sur le Site Web</p>
                        <p class="text-sm text-gray-600">Uploadez sitemap.xml à la racine de votre site web (ex. : example.com/sitemap.xml)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-[#00AEEF] text-white flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5">5</div>
                    <div>
                        <p class="text-sm font-medium text-black">Envoyer to Google</p>
                        <p class="text-sm text-gray-600">Envoyer your sitemap in Google Search Console for faster indexing</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Meilleures Pratiques pour les Sitemaps XML</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF] flex-shrink-0 mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-black">Incluez Uniquement les Pages Importantes</p>
                            <p class="text-xs text-gray-600">N'incluez pas les pages admin, les pages de remerciement ou le contenu dupliqué</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF] flex-shrink-0 mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-black">Gardez Moins de 50 000 URL</p>
                            <p class="text-xs text-gray-600">Divisez en plusieurs sitemaps si vous avez plus de pages</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF] flex-shrink-0 mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-black">Utilisez des URL Absolues</p>
                            <p class="text-xs text-gray-600">Incluez toujours l'URL complète avec https://</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF] flex-shrink-0 mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-black">Mettez à Jour Régulièrement</p>
                            <p class="text-xs text-gray-600">Régénérez quand vous ajoutez de nouvelles pages ou changez la structure du site</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF] flex-shrink-0 mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-black">Envoyer to Search Engines</p>
                            <p class="text-xs text-gray-600">Ajoutez à Google Search Console, Bing Webmaster Tools</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#00AEEF] flex-shrink-0 mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-black">Add to robots.txt</p>
                            <p class="text-xs text-gray-600">Référencez votre sitemap dans le fichier robots.txt</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl border-2 border-orange-200 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Comprendre les Paramètres du Sitemap</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-semibold text-black mb-2">Change Frequency</p>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p><span class="font-medium">always:</span> Documents that change each time they&#x27;re accessed</p>
                        <p><span class="font-medium">hourly:</span> News sites, live data feeds</p>
                        <p><span class="font-medium">daily:</span> Blogs, news sections</p>
                        <p><span class="font-medium">weekly:</span> Regular content updates (most common)</p>
                        <p><span class="font-medium">monthly:</span> Infrequently updated pages</p>
                        <p><span class="font-medium">yearly:</span> Static pages, legal pages</p>
                        <p><span class="font-medium">never:</span> Archived content</p>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-black mb-2">Priority</p>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p><span class="font-medium">1.0:</span> Homepage, most important pages</p>
                        <p><span class="font-medium">0.8:</span> Category pages, main service pages</p>
                        <p><span class="font-medium">0.6:</span> Blog posts, individual pages</p>
                        <p><span class="font-medium">0.4:</span> Tag pages, less important content</p>
                        <p><span class="font-medium">0.0-0.3:</span> Rarely visited pages</p>
                    </div>
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
                            <h3 class="text-base md:text-lg font-semibold text-black">Qu'est-ce qu'un sitemap XML et pourquoi en ai-je besoin ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Un sitemap XML est un fichier qui liste toutes les pages importantes de votre site web pour aider les moteurs de recherche à explorer et indexer votre contenu efficacement. C'est essentiel pour le SEO car il garantit que les moteurs de recherche découvrent toutes vos pages, en particulier le nouveau contenu et les pages enfouies profondément dans la structure de votre site, ce qui mène à une meilleure visibilité dans les résultats de recherche.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">2</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">À quelle fréquence dois-je mettre à jour mon sitemap XML ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Mettez à jour votre sitemap chaque fois que vous ajoutez de nouvelles pages, supprimez d'anciennes pages ou modifiez significativement la structure de votre site. Pour les blogs et les sites d'actualités, envisagez d'automatiser ce processus pour une mise à jour quotidienne ou hebdomadaire. Après la mise à jour, resoumettez votre sitemap à Google Search Console et Bing Webmaster Tools pour que les moteurs de recherche explorent les changements.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">3</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Comment soumettre mon sitemap à Google Search Console ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Log in to Google Search Console, select your property, go to 'Sitemaps' in the left sidebar, and enter your sitemap URL (e.g., https://example.com/sitemap.xml). Click 'Envoyer' and Google will start crawling your pages. You can check the status to see if there are any errors or warnings that need attention.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">4</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Que dois-je définir pour les valeurs de priorité et changefreq ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Définissez la priorité à 1.0 pour votre page d'accueil et les pages les plus importantes, 0.8 pour les pages de catégorie/service et 0.6 pour les articles de blog. Pour changefreq, utilisez 'weekly' pour le contenu régulièrement mis à jour, 'monthly' pour les pages statiques et 'daily' pour le contenu fréquemment modifié comme les actualités. Notez que Google utilise principalement ces valeurs comme des indices, pas des règles strictes.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">5</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Dois-je inclure chaque page de mon site web ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Non, incluez uniquement les pages que vous voulez que les moteurs de recherche indexent. Excluez les pages admin, les pages de remerciement, le contenu dupliqué, les pages de connexion et les pages bloquées par robots.txt. Gardez votre sitemap concentré sur un contenu de haute qualité et unique qui apporte de la valeur aux utilisateurs.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">6</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Quelles sont les erreurs courantes de sitemap XML à éviter ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Les erreurs courantes incluent : lister des pages bloquées par robots.txt, inclure des URL non canoniques, oublier d'utiliser des URL absolues (incluez toujours https://), dépasser 50 000 URL par sitemap, inclure des pages 404 ou de redirection et oublier d'ajouter votre sitemap à robots.txt. Validez toujours votre sitemap avant la soumission.</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">7</span></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-black">Où dois-je uploader mon fichier sitemap.xml ?</h3>
                        </div>
                        <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg></div>
                    </button>
                    <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                        <p>Uploadez votre sitemap dans le répertoire racine de votre site web pour qu'il soit accessible à https://votredomaine.com/sitemap.xml. Ajoutez également une référence dans votre fichier robots.txt avec la ligne 'Sitemap: https://votredomaine.com/sitemap.xml' pour aider les moteurs de recherche à le trouver automatiquement.</p>
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
        <div class="grid md:grid-cols-3 gap-6 mb-8"><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/sitemap-validator">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"></path>
                            <path d="M15 5.764v15"></path>
                            <path d="M9 3.236v15"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Sitemap Validator</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Validez les sitemaps XML pour les meilleures pratiques SEO</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/robots-txt-generator">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                            <path d="M10 9H8"></path>
                            <path d="M16 13H8"></path>
                            <path d="M16 17H8"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Robots.txt Generator</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Contrôlez l'exploration des moteurs de recherche avec des fichiers robots.txt personnalisés</p>
                <div class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all"><span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></div>
                <div class="absolute top-4 right-4"><span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span></div>
            </a><a class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1" href="/tools/robots-validator">
                <div class="mb-4">
                    <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors" aria-hidden="true">
                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                        </svg></div>
                </div>
                <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">Robots.txt Validator</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Vérifiez la syntaxe robots.txt et les directives de crawl</p>
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
<script src="{{ asset('js/tools/xml-sitemap-generator.js') }}" defer></script>
@endpush