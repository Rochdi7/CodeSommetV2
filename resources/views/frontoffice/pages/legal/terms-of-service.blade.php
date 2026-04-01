@extends('frontoffice.layouts.app')

@section('title', 'CodeSommet - Agence de Développement Web Propulsée par l\'IA | Maroc | CodeSommet')
@section('meta_description', 'Agence de développement web premium au Maroc spécialisée dans les sites web propulsés par l\'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement expert Next.js pour l\'éducation, la santé et les entreprises. Plus de 50 projets livrés.')
@section('meta_keywords', 'développement web Maroc,agence développement web IA,agence développement Next.js,développement tableaux de bord,développement SaaS,développement site éducation,développement site santé,développement React Maroc,développement TypeScript,développement web Maroc,intégration chatbot IA,conception tableau de bord personnalisé,agence web Maroc')
@section('og_title', 'CodeSommet - Agence de Développement Web Propulsée par l\'IA | Maroc')
@section('og_description', 'Agence de développement web premium au Maroc spécialisée dans les sites web propulsés par l\'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement expert Next.js pour l\'éducation, la santé et les entreprises. Plus de 50 projets livrés.')
@section('twitter_description', 'Agence de développement web premium spécialisée dans les sites web propulsés par l\'IA, les tableaux de bord intelligents et les plateformes SaaS. Plus de 50 projets livrés.')

@section('content')
<section class="relative min-h-[60vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 bg-white">
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
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scale w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                    <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path>
                    <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path>
                    <path d="M7 21h10"></path>
                    <path d="M12 3v18"></path>
                    <path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"></path>
                </svg><span class="text-sm font-medium text-[#0F0F0F]">Dernière mise à jour : Janvier 2026</span></div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight" style="font-family:var(--font-heading)">Conditions d'Utilisation</h1>
            <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">Ces conditions régissent votre utilisation de nos services. Veuillez les lire attentivement avant de vous engager avec CodeSommet.</p>
            <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#services" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Services</a><a href="#payment" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Conditions de paiement</a><a href="#intellectual-property" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Propriété intellectuelle</a></div>
        </div>
    </div>
</section>
<section class="w-full py-16 md:py-24 bg-[#F8F8F8]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-4" style="font-family:var(--font-heading)">Acceptation des conditions</h2>
                <div class="prose prose-lg max-w-none text-[#0F0F0F]/70 space-y-4">
                    <p>Bienvenue chez CodeSommet. Ces Conditions d'Utilisation (&quot;Conditions&quot;) constituent un accord juridiquement contraignant entre vous (&quot;Client&quot;, &quot;vous&quot; ou &quot;votre&quot;) et CodeSommet (&quot;nous&quot;, &quot;notre&quot;) concernant votre utilisation de notre site web, de nos services et de nos produits.</p>
                    <p class="font-medium text-[#0F0F0F]">En accédant à notre site web sur <a class="text-[#00AEEF] hover:underline" href="{{ route('home') }}">codesommet.com</a>, en faisant appel à nos services ou en effectuant un paiement, vous acceptez d'être lié par ces Conditions.</p>
                    <p>Si vous n'êtes pas d'accord avec une partie de ces Conditions, vous ne devez pas utiliser nos services. Nous nous réservons le droit de modifier ces Conditions à tout moment, et votre utilisation continue de nos services constitue l'acceptation de ces modifications.</p>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#F59E0B]/20 bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#F59E0B]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-4 h-4 text-[#F59E0B]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="text-[#0F0F0F] font-medium flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg><span>IMPORTANT : Veuillez lire attentivement ces Conditions. Elles contiennent des informations importantes sur vos droits légaux, recours et obligations, y compris des dispositions d'arbitrage obligatoire et de renonciation aux actions collectives.</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Définitions</h2>
                <div class="space-y-3 text-[#0F0F0F]/70">
                    <p><strong>&quot;Services&quot;</strong> désigne tous les services de développement web, de design, de branding et services connexes fournis par CodeSommet.</p>
                    <p><strong>&quot;Client&quot;</strong> désigne toute personne physique ou morale qui fait appel aux services de CodeSommet.</p>
                    <p><strong>&quot;Livrables&quot;</strong> désigne les produits de travail finaux créés et livrés par CodeSommet.</p>
                    <p><strong>&quot;Projet&quot;</strong> désigne la portée spécifique des travaux convenue entre le Client et CodeSommet.</p>
                    <p><strong>&quot;Forfait&quot;</strong> désigne nos plans de service d'abonnement mensuel tels que décrits dans votre proposition personnalisée.</p>
                    <p><strong>&quot;Projet ponctuel&quot;</strong> désigne notre service de développement de site web avec une tarification basée sur la portée et les exigences du projet.</p>
                </div>
            </div>
            <div id="services" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                            <path d="m9 11 3 3L22 4"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Services fournis</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">1. Services de forfait</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-[#0F0F0F] mb-2">Services de forfait mensuel</h4>
                                <p class="mb-2">Nos plans de forfait mensuel incluent généralement :</p>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li>Gestion de projet active</li>
                                    <li>Équipe de développement senior dédiée</li>
                                    <li>Appels de suivi et mises à jour réguliers</li>
                                    <li>Livraison rapide des tâches</li>
                                    <li>Demandes de révision telles que décrites dans votre accord</li>
                                    <li>Services complets de design et développement</li>
                                    <li>Optimisation SEO et rédaction de contenu</li>
                                    <li>Support de collaboration multicanal</li>
                                    <li>Services de branding et design</li>
                                </ul>
                                <p class="mt-3 text-sm italic">*Les fonctionnalités, tarifs et livrables spécifiques varient selon le projet et seront décrits dans votre proposition personnalisée et accord signé.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#0F0F0F] mb-2">Options de forfait amélioré</h4>
                                <p class="mb-2">Les plans de forfait premium peuvent également inclure :</p>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li>Gestion professionnelle des réseaux sociaux</li>
                                    <li>Création de contenu multi-plateformes</li>
                                    <li>Publication et planification stratégiques</li>
                                    <li>Rapports d'analyse et de croissance</li>
                                </ul>
                                <p class="mt-3 text-sm italic">*Disponible en tant que compléments ou dans les forfaits premium. Contactez-nous pour une tarification personnalisée.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">2. Développement de site web (Projets ponctuels)</h3>
                        <p class="mb-2"><strong>Tarification personnalisée selon la portée du projet</strong></p>
                        <p class="mb-3">Nos projets de développement de site web incluent généralement :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Design personnalisé axé sur la conversion</li>
                            <li>Entièrement responsive (mobile, tablette, bureau)</li>
                            <li>Rédaction de contenu professionnel</li>
                            <li>Optimisation SEO intégrée</li>
                            <li>Mises à jour régulières de l'avancement</li>
                            <li>Développement de site web multi-pages</li>
                            <li>Tours de révision tels que spécifiés dans la proposition</li>
                            <li>Formulaires de génération de leads et configuration d'analyse</li>
                            <li>Délai de livraison basé sur la complexité du projet</li>
                        </ul>
                        <p class="mt-3 text-sm italic">*Les tarifs varient selon la taille, la complexité et les exigences spécifiques du projet. Des pages et fonctionnalités supplémentaires peuvent entraîner des coûts supplémentaires. Référez-vous à votre proposition signée pour les tarifs et livrables exacts.</p>
                    </div>
                    <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                        <h4 class="font-semibold text-[#0F0F0F] mb-3">Portée des services</h4>
                        <p>Tous les services sont fournis &quot;en l'état&quot; et sont soumis à l'accord de projet spécifique. Nous nous réservons le droit de refuser le service à quiconque pour quelque raison que ce soit à tout moment.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Responsabilités du client</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>En tant que client, vous acceptez de :</p>
                    <ul class="list-disc pl-6 space-y-3">
                        <li><strong>Fournir des informations en temps voulu :</strong> Fournir tout le contenu, les images, les éléments de marque et les informations nécessaires à la réalisation du projet dans les délais convenus.</li>
                        <li><strong>Répondre rapidement :</strong> Fournir des retours et des approbations dans les 48 heures suivant la soumission des livrables pour éviter les retards de projet.</li>
                        <li><strong>Accorder les accès nécessaires :</strong> Fournir les identifiants de connexion, l'accès à l'hébergement, l'accès au domaine et tout autre accès requis pour mener à bien le projet.</li>
                        <li><strong>Détenir les droits requis :</strong> S'assurer que vous disposez des droits légaux sur tout le contenu, les images et les matériaux que vous nous fournissez.</li>
                        <li><strong>Effectuer les paiements en temps voulu :</strong> Payer toutes les factures dans les délais de paiement convenus.</li>
                        <li><strong>Respecter les lois :</strong> Utiliser nos services en conformité avec toutes les lois et réglementations applicables.</li>
                    </ul>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#EF4444]/20 bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#EF4444]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 text-[#EF4444]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m15 9-6 6"></path>
                                <path d="m9 9 6 6"></path>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F]">Le défaut de fournir les matériaux nécessaires ou des retours en temps voulu peut entraîner des retards de projet. Nous ne sommes pas responsables des retards causés par le manque de réactivité du client.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="payment" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                            <path d="M10 9H8"></path>
                            <path d="M16 13H8"></path>
                            <path d="M16 17H8"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Conditions de paiement</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">1. Tarification et frais</h3>
                        <p class="mb-3">Les tarifs commencent à partir de 1 499 $ et sont personnalisés en fonction de la portée, des exigences et de la complexité de votre projet. La tarification finale est discutée lors de votre appel de découverte et documentée dans une proposition personnalisée. Tous les tarifs sont susceptibles de changer avec un préavis de 30 jours pour les clients en forfait continu, sauf accord écrit contraire.</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Services de forfait mensuel :</strong> À partir de 1 499 $/mois, facturés mensuellement à l'avance tel que décrit dans votre accord de service</li>
                            <li><strong>Forfaits améliorés :</strong> Tarification personnalisée basée sur les fonctionnalités et services sélectionnés (ex. : +forfait réseaux sociaux)</li>
                            <li><strong>Projets ponctuels de site web :</strong> À partir de 1 499 $, avec tarification finale basée sur la portée. Calendrier de paiement généralement réparti entre un acompte initial et un paiement final à l'achèvement</li>
                            <li><strong>Fonctionnalités et pages supplémentaires :</strong> Tarifiées individuellement selon la portée et la complexité</li>
                        </ul>
                        <p class="mt-3 text-sm italic">*Tous les tarifs sont susceptibles de changer. La tarification finale est discutée lors de votre appel de découverte et confirmée dans votre proposition et accord de service signés.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">2. Modes de paiement</h3>
                        <p>Nous acceptons les paiements via :</p>
                        <ul class="list-disc pl-6 space-y-1 mt-2">
                            <li>Cartes de crédit/débit (Visa, Mastercard, American Express)</li>
                            <li>Virement bancaire (pour les factures plus importantes tel que spécifié dans l'accord)</li>
                            <li>Passerelle de paiement Stripe (notre processeur de paiement sécurisé)</li>
                        </ul>
                        <p class="mt-3">Tous les paiements sont traités de manière sécurisée via Stripe. Nous ne stockons pas vos informations de paiement.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">3. Calendrier de paiement</h3>
                        <div class="space-y-3">
                            <div>
                                <h4 class="font-semibold text-[#0F0F0F] mb-1">Services de forfait :</h4>
                                <p>Facturés le 1er de chaque mois. Renouvellement automatique sauf annulation avec un préavis de 7 jours avant le prochain cycle de facturation.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#0F0F0F] mb-1">Projets ponctuels :</h4>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li>Acompte initial généralement requis pour commencer le travail (montant spécifié dans la proposition)</li>
                                    <li>Paiement final dû à l'achèvement du projet avant la livraison finale</li>
                                    <li>Les fichiers finaux ne seront pas remis tant que le paiement complet n'aura pas été reçu</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">4. Retards de paiement</h3>
                        <p class="mb-2">Les factures sont dues dans les 7 jours suivant leur émission, sauf accord contraire.</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Les retards de paiement peuvent entraîner des frais de retard de 5% après 7 jours</li>
                            <li>Le travail peut être suspendu si le paiement est en retard de plus de 14 jours</li>
                            <li>Les comptes impayés peuvent être envoyés en recouvrement après 30 jours</li>
                            <li>Nous nous réservons le droit de suspendre ou résilier les services pour non-paiement</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">5. Remboursements</h3>
                        <p>Veuillez consulter notre <a class="text-[#00AEEF] hover:underline" href="{{ route('refund-policy') }}">Politique de Remboursement</a> pour des informations détaillées sur les remboursements et les annulations.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">6. Taxes</h3>
                        <p>Les prix n'incluent pas les taxes applicables. Vous êtes responsable du paiement de toute taxe de vente, TVA, TPS ou autre taxe pouvant s'appliquer à votre achat en fonction de votre localisation.</p>
                    </div>
                </div>
            </div>
            <div id="intellectual-property" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Droits de propriété intellectuelle</h2>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">1. Propriété des livrables finaux</h3>
                        <p class="mb-3">Après paiement intégral, vous détiendrez les droits sur les livrables finaux approuvés, notamment :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Design et code de site web personnalisé</li>
                            <li>Logos personnalisés et éléments de marque créés spécifiquement pour vous</li>
                            <li>Contenu rédigé créé pour votre projet</li>
                            <li>Graphiques et illustrations personnalisés</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">2. Droits conservés par CodeSommet</h3>
                        <p class="mb-3">Nous conservons les droits de :</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Utilisation en portfolio :</strong> Afficher votre projet dans notre portfolio, études de cas et supports marketing, sauf accord écrit contraire.</li>
                            <li><strong>Composants réutilisables :</strong> Les frameworks, bibliothèques, extraits de code et méthodologies développés par nous restent notre propriété intellectuelle.</li>
                            <li><strong>Matériaux préexistants :</strong> Les photos stock, polices, templates et ressources tierces utilisées dans votre projet restent la propriété de leurs propriétaires respectifs.</li>
                            <li><strong>Processus et méthodologie :</strong> Nos processus de design, flux de travail et méthodes propriétaires restent notre propriété intellectuelle.</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">3. Matériaux tiers</h3>
                        <p>Certains projets peuvent inclure des matériaux tiers tels que :</p>
                        <ul class="list-disc pl-6 space-y-1 mt-2">
                            <li>Photographies stock (avec licences appropriées)</li>
                            <li>Polices premium (des frais de licence peuvent s'appliquer)</li>
                            <li>Plugins et bibliothèques logiciels (soumis à leurs licences)</li>
                            <li>Frameworks open-source (soumis à leurs licences)</li>
                        </ul>
                        <p class="mt-3">Vous êtes responsable du respect de toutes les conditions de licence tiers.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">4. Matériaux fournis par le client</h3>
                        <p>Vous déclarez et garantissez que vous êtes propriétaire ou disposez des droits nécessaires sur tous les matériaux que vous nous fournissez, y compris le contenu, les images, les logos et les marques. Vous nous accordez une licence non exclusive pour utiliser ces matériaux uniquement dans le but de réaliser votre projet.</p>
                    </div>
                    <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                        <h4 class="font-semibold text-[#0F0F0F] mb-2">Note importante sur le transfert de propriété</h4>
                        <p>Les droits de propriété complets ne sont transférés qu'après réception du paiement intégral. Tant que le paiement intégral n'est pas reçu, tout le travail reste la propriété exclusive de CodeSommet.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Calendrier et livraison du projet</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Délais standards</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Tâches de forfait :</strong> Délais de livraison tels que spécifiés dans votre accord de service</li>
                            <li><strong>Développement de site web :</strong> Calendrier basé sur la portée et la complexité du projet (décrit dans la proposition)</li>
                            <li><strong>Révisions :</strong> Délai de traitement spécifié dans votre accord</li>
                        </ul>
                        <p class="mt-3 text-sm italic">*Tous les délais sont des estimations et seront confirmés dans votre proposition de projet.</p>
                    </div>
                    <p>Les délais sont des estimations et peuvent varier en fonction de la complexité du projet, de la rapidité des retours du client et des changements de portée. Nous vous informerons rapidement de tout retard anticipé.</p>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#F59E0B]/20 bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#F59E0B]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-4 h-4 text-[#F59E0B]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F]">Les retards causés par le manque de réactivité du client, la livraison tardive du contenu ou les changements de portée ne sont pas comptabilisés dans nos délais de livraison.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Révisions et modifications</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Révisions incluses</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Services de forfait :</strong> Politique de révision telle que décrite dans votre accord de service</li>
                            <li><strong>Projets ponctuels :</strong> Nombre de tours de révision spécifié dans votre proposition</li>
                        </ul>
                        <p class="mt-3 text-sm italic">*Les allocations de révision spécifiques varient selon le forfait de service et seront détaillées dans votre accord signé.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Ce qui constitue une révision</h3>
                        <p class="mb-2">Une révision est une modification du travail existant dans la portée originale, telle que :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Ajustements de couleur</li>
                            <li>Changements de police</li>
                            <li>Raffinements de mise en page</li>
                            <li>Modifications de contenu</li>
                            <li>Ajustements mineurs de design</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Changements de portée</h3>
                        <p class="mb-2">Les éléments suivants sont considérés comme des changements de portée et peuvent entraîner des frais supplémentaires :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Ajout de nouvelles pages au-delà du nombre convenu</li>
                            <li>Refonte complète de sections approuvées</li>
                            <li>Nouvelles fonctionnalités non prévues dans la portée originale</li>
                            <li>Intégrations supplémentaires ou services tiers</li>
                            <li>Changements dans la direction fondamentale du projet après approbation</li>
                        </ul>
                    </div>
                    <p class="mt-4">Nous vous informerons à l'avance si les modifications demandées constituent un changement de portée et vous fournirons un devis pour le travail supplémentaire.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Garanties et clauses de non-responsabilité</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Nos garanties</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Les services seront exécutés avec compétence et soin professionnels</li>
                            <li>Les livrables seront substantiellement conformes aux spécifications convenues</li>
                            <li>Le travail sera original et ne portera pas atteinte aux droits de tiers</li>
                            <li>Garantie de correction de bugs post-lancement sur les sites web terminés telle que spécifiée dans votre accord (couvre généralement les problèmes techniques pendant une période définie)</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Clauses de non-responsabilité</h3>
                        <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                            <p class="font-semibold text-[#0F0F0F] mb-3 uppercase">SAUF DISPOSITION EXPRESSE CI-DESSUS :</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>LES SERVICES SONT FOURNIS &quot;EN L'ÉTAT&quot; SANS GARANTIE D'AUCUNE SORTE</li>
                                <li>NOUS DÉCLINONS TOUTE GARANTIE, EXPRESSE OU IMPLICITE, Y COMPRIS LA QUALITÉ MARCHANDE ET L'ADÉQUATION À UN USAGE PARTICULIER</li>
                                <li>NOUS NE GARANTISSONS PAS DE RÉSULTATS COMMERCIAUX, DE PROSPECTS OU DE CONVERSIONS SPÉCIFIQUES</li>
                                <li>NOUS NE SOMMES PAS RESPONSABLES DES SERVICES TIERS, PLUGINS OU PROBLÈMES D'HÉBERGEMENT</li>
                                <li>NOUS NE GARANTISSONS PAS UN FONCTIONNEMENT ININTERROMPU OU SANS ERREUR</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Limitation de responsabilité</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <div class="bg-[#F8F8F8] rounded-lg p-6 border-2 border-[#0F0F0F]/20">
                        <p class="font-semibold text-[#0F0F0F] mb-4">DANS LA MESURE MAXIMALE PERMISE PAR LA LOI :</p>
                        <ul class="list-disc pl-6 space-y-3">
                            <li><strong>RESPONSABILITÉ TOTALE :</strong> Notre responsabilité totale pour toute réclamation découlant de nos services ne dépassera pas le montant que vous nous avez payé pour le service spécifique en question, jusqu'à un maximum de 10 000 $.</li>
                            <li><strong>DOMMAGES CONSÉCUTIFS :</strong> Nous ne serons pas responsables des dommages indirects, accessoires, spéciaux, consécutifs ou punitifs, y compris mais sans s'y limiter, la perte de profits, la perte de données, la perte d'opportunités commerciales ou l'interruption d'activité.</li>
                            <li><strong>EXCEPTIONS :</strong> Cette limitation ne s'applique pas aux dommages causés par notre négligence grave, notre faute intentionnelle ou notre fraude.</li>
                        </ul>
                    </div>
                    <p class="text-sm">Certaines juridictions n'autorisent pas l'exclusion ou la limitation des dommages accessoires ou consécutifs, de sorte que les limitations ci-dessus peuvent ne pas s'appliquer à vous.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Indemnisation</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Vous acceptez d'indemniser, de défendre et de dégager de toute responsabilité CodeSommet, ses dirigeants, administrateurs, employés et agents de toute réclamation, responsabilité, dommage, perte et dépense (y compris les frais d'avocat raisonnables) découlant de :</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Votre utilisation de nos services</li>
                        <li>Votre violation de ces Conditions</li>
                        <li>Votre violation des droits de tiers</li>
                        <li>Le contenu ou les matériaux que vous nous fournissez</li>
                        <li>Votre utilisation des livrables finaux</li>
                    </ul>
                    <p class="mt-4">Nous nous réservons le droit d'assumer la défense et le contrôle exclusifs de toute question faisant l'objet d'une indemnisation par vous, et vous acceptez de coopérer avec notre défense de ces réclamations.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Résiliation</h2>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Résiliation par le client</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Services de forfait :</strong> Vous pouvez annuler avec un préavis écrit de 7 jours avant le prochain cycle de facturation. Pas de remboursement pour la période de facturation en cours.</li>
                            <li><strong>Projets ponctuels :</strong> Vous pouvez résilier à tout moment en payant le travail réalisé à ce jour plus des frais de résiliation de 25% du solde restant.</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Nos droits de résiliation</h3>
                        <p class="mb-2">Nous pouvons résilier les services immédiatement si :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Vous ne respectez pas les délais de paiement</li>
                            <li>Vous enfreignez ces Conditions</li>
                            <li>Vous fournissez des informations fausses ou trompeuses</li>
                            <li>La relation de travail devient intenable</li>
                            <li>Vous adoptez un comportement abusif ou harcelant</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Effets de la résiliation</h3>
                        <p>En cas de résiliation :</p>
                        <ul class="list-disc pl-6 space-y-1 mt-2">
                            <li>Vous devez payer pour tout le travail réalisé à ce jour</li>
                            <li>Nous livrerons les fichiers de travail en cours (après paiement intégral)</li>
                            <li>Notre obligation de fournir des services cesse immédiatement</li>
                            <li>Les dispositions relatives au paiement, aux droits de PI et à la responsabilité survivent à la résiliation</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Confidentialité</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Les deux parties s'engagent à maintenir la confidentialité de toute information propriétaire ou sensible partagée au cours de l'engagement.</p>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Nos obligations de confidentialité</h3>
                        <p class="mb-2">Nous protégerons :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Vos stratégies et plans commerciaux</li>
                            <li>Les informations propriétaires et secrets commerciaux</li>
                            <li>Les informations financières</li>
                            <li>Les données clients et listes de contacts</li>
                            <li>Toute information marquée comme confidentielle</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Exceptions</h3>
                        <p class="mb-2">La confidentialité ne s'applique pas aux informations qui :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Sont ou deviennent publiquement disponibles sans violation de cet accord</li>
                            <li>Nous étaient connues avant votre divulgation</li>
                            <li>Sont développées indépendamment par nous</li>
                            <li>Doivent être divulguées par la loi ou une ordonnance du tribunal</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Résolution des litiges</h2>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">1. Résolution informelle</h3>
                        <p>Avant d'engager une procédure formelle, les deux parties s'engagent à tenter de résoudre les litiges par une négociation de bonne foi. Contactez-nous à <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="462e232a2a2906362f2d27353529353233222f296825292b">[email&#160;protected]</span></a> avec vos préoccupations détaillées.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">2. Arbitrage contraignant</h3>
                        <p class="mb-3">Si la résolution informelle échoue, les litiges seront résolus par arbitrage contraignant conformément à :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Les règles de l'American Arbitration Association (AAA)</li>
                            <li>L'arbitrage sera mené en anglais</li>
                            <li>Lieu : Maroc ou arbitrage virtuel mutuellement convenu</li>
                            <li>La décision est finale et contraignante pour les deux parties</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">3. Renonciation aux actions collectives</h3>
                        <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                            <p class="font-semibold text-[#0F0F0F] mb-2">VOUS ACCEPTEZ QUE LES LITIGES SERONT RÉSOLUS SUR UNE BASE INDIVIDUELLE UNIQUEMENT.</p>
                            <p>Vous renoncez à tout droit d'intenter des réclamations en tant que demandeur ou membre d'un groupe dans toute action collective, consolidée ou représentative. L'arbitrage ne peut trancher que vos réclamations individuelles et/ou celles de CodeSommet.</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">4. Exceptions à l'arbitrage</h3>
                        <p>L'une ou l'autre des parties peut demander une mesure injonctive devant un tribunal pour violation de propriété intellectuelle ou violation de confidentialité.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Droit applicable</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Ces Conditions seront régies et interprétées conformément aux lois du Maroc, sans tenir compte de ses dispositions en matière de conflit de lois.</p>
                    <p>Pour les clients situés aux États-Unis, les lois fédérales et étatiques américaines applicables peuvent également s'appliquer lorsque requis.</p>
                    <p>Toute action en justice relative à ces Conditions doit être intentée dans un délai d'un (1) an à compter de la naissance de la réclamation.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Dispositions diverses</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Intégralité de l'accord</h3>
                        <p>Ces Conditions, ainsi que notre Politique de Confidentialité et tout accord de projet signé, constituent l'intégralité de l'accord entre vous et CodeSommet.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Modifications</h3>
                        <p>Nous pouvons modifier ces Conditions à tout moment en publiant des Conditions mises à jour sur notre site web. L'utilisation continue des services après les modifications constitue l'acceptation. Pour les clients en forfait, nous fournirons un préavis de 30 jours pour les changements importants.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Divisibilité</h3>
                        <p>Si une disposition de ces Conditions est jugée inapplicable, les dispositions restantes resteront pleinement en vigueur.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Renonciation</h3>
                        <p>Notre défaut de faire valoir un droit ou une disposition de ces Conditions ne constituera pas une renonciation à ce droit ou cette disposition.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Cession</h3>
                        <p>Vous ne pouvez pas céder ou transférer ces Conditions sans notre consentement écrit. Nous pouvons céder nos droits et obligations en vertu de ces Conditions à toute entité successeur.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Force majeure</h3>
                        <p>Aucune des parties ne sera responsable des retards ou manquements dans l'exécution résultant d'actes échappant à un contrôle raisonnable, y compris les catastrophes naturelles, la guerre, le terrorisme, les pannes d'Internet ou les actions gouvernementales.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#0F0F0F] mb-2">Survie</h3>
                        <p>Les dispositions relatives au paiement, à la propriété intellectuelle, à la confidentialité, aux garanties, à la responsabilité et à la résolution des litiges survivront à la résiliation de ces Conditions.</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#00AEEF]/10 to-[#0071BC]/10 rounded-xl p-8 md:p-10 border border-[#00AEEF]/20">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Des questions sur ces conditions ?</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Si vous avez des questions ou des préoccupations concernant ces Conditions d'Utilisation, veuillez nous contacter :</p>
                    <div class="bg-white rounded-lg p-6 space-y-3">
                        <div>
                            <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                            <p>Agence Premium de Développement Web</p>
                        </div>
                        <div class="space-y-2">
                            <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="c1a9a4adadae81b1a8aaa0b2b2aeb2b5b4a5a8aeefa2aeac">[email&#160;protected]</span></a></p>
                            <p><strong>Téléphone :</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                            <p><strong>Téléphone :</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                        </div>
                        <div>
                            <p><strong>Siège social :</strong> Maroc</p>
                            <p><strong>Opérations :</strong> Monde entier</p>
                        </div>
                        <div class="pt-3 border-t border-[#0F0F0F]/10">
                            <p class="text-sm">Pour les demandes juridiques, veuillez inclure &quot;Juridique - Conditions d'Utilisation&quot; dans l'objet de votre e-mail.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                <p class="text-[#0F0F0F] font-medium mb-3">Reconnaissance</p>
                <p class="text-[#0F0F0F]/70">EN UTILISANT NOS SERVICES, VOUS RECONNAISSEZ AVOIR LU CES CONDITIONS D'UTILISATION, LES COMPRENDRE ET ACCEPTER D'ÊTRE LIÉ PAR ELLES. SI VOUS N'ÊTES PAS D'ACCORD AVEC CES CONDITIONS, VOUS NE DEVEZ PAS UTILISER NOS SERVICES.</p>
            </div>
            <div class="mt-12 text-center">
                <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                <div class="flex flex-wrap justify-center gap-3"><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('privacy-policy') }}">Politique de Confidentialité</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('cookie-policy') }}">Politique de Cookies</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('refund-policy') }}">Politique de Remboursement</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('acceptable-use') }}">Politique d'Utilisation Acceptable</a></div>
            </div>
        </div>
    </div>
</section>
@endsection