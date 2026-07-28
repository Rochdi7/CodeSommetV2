@extends('layouts.app')

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
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                    <line x1="12" x2="12" y1="2" y2="22"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg><span class="text-sm font-medium text-[#0F0F0F]">Dernière mise à jour : Janvier 2026</span></div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-[#0F0F0F] leading-tight" style="font-family:var(--font-heading)">Politique de Remboursement et d'Annulation</h1>
            <p class="text-lg md:text-xl text-[#0F0F0F]/70 max-w-2xl mx-auto">Des conditions de remboursement claires et transparentes pour tous nos services. Votre satisfaction est notre priorité.</p>
            <div class="flex flex-wrap justify-center gap-3 pt-4"><a href="#retainer-refunds" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Remboursements Forfait</a><a href="#project-refunds" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Remboursements Projet</a><a href="#how-to-request" class="px-4 py-2 text-sm font-medium text-[#00AEEF] hover:bg-[#00AEEF]/5 rounded-lg transition-colors">Demander un remboursement</a></div>
        </div>
    </div>
</section>
<section class="w-full py-16 md:py-24 bg-[#F8F8F8]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-4" style="font-family:var(--font-heading)">Notre engagement d'équité</h2>
                <div class="prose prose-lg max-w-none text-[#0F0F0F]/70 space-y-4">
                    <p>Chez CodeSommet, nous garantissons la qualité de notre travail. Cette Politique de Remboursement et d'Annulation explique les conditions dans lesquelles les remboursements sont accordés pour nos services.</p>
                    <p>Tous les paiements sont traités de manière sécurisée via <strong>Stripe</strong>, notre passerelle de paiement de confiance. Cette politique est conforme aux conditions de paiement de Stripe et aux lois applicables en matière de protection des consommateurs.</p>
                    <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20 mt-6">
                        <h3 class="font-semibold text-[#0F0F0F] mb-3 flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-5 h-5 text-[#22C55E]" aria-hidden="true">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>Notre philosophie de remboursement</h3>
                        <p class="text-[#0F0F0F]/70">Nous croyons en des pratiques de remboursement justes et transparentes. Bien que nous ne puissions pas offrir de remboursements pour le travail terminé, nous proposons des options d'annulation claires et des remboursements au prorata lorsque c'est approprié. Votre satisfaction nous tient à cœur, et nous travaillerons avec vous pour trouver une solution.</p>
                    </div>
                </div>
            </div>
            <div id="retainer-refunds" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                            <path d="M21 3v5h-5"></path>
                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                            <path d="M8 16H3v5"></path>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Services de forfait mensuel</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Conditions d'annulation</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Délai de préavis :</strong> Vous pouvez annuler votre forfait à tout moment en fournissant un préavis écrit de 7 jours avant le prochain cycle de facturation.</li>
                            <li><strong>Méthode d'annulation :</strong> Envoyez votre demande d'annulation par e-mail à <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="1c74797070735c6c75777d6f6f736f6869787573327f7371">[email&#160;protected]</span></a> avec l'objet &quot;Annulation de forfait.&quot;</li>
                            <li><strong>Date d'effet :</strong> L'annulation prend effet à la fin de votre cycle de facturation en cours.</li>
                            <li><strong>Pas de contrat à long terme :</strong> Nos forfaits sont mensuels sans engagement à long terme requis.</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-4">Éligibilité au remboursement</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#22C55E]/20 shadow-[0_0_20px_rgba(34,197,94,0.08)]
        bg-gradient-to-br from-[#22C55E]/5 to-[#22C55E]/0

      ">
                                <div class="absolute top-0 right-0 w-40 h-40 bg-[#22C55E]/10 rounded-full blur-3xl opacity-20 -mr-20 -mt-20"></div>
                                <div class="relative p-6">
                                    <div class="flex items-center gap-3 mb-5">
                                        <div class="bg-[#22C55E]/10 rounded-xl p-2.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-6 h-6 text-[#22C55E]" aria-hidden="true">
                                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                                <path d="m9 11 3 3L22 4"></path>
                                            </svg></div>
                                        <h4 class="text-xl font-semibold text-[#0F0F0F]">Éligible au remboursement</h4>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex items-start gap-3 group">
                                            <div class="bg-[#22C55E]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                            </div>
                                            <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Erreurs de facturation<!-- -->:</span> <span class="text-[#0F0F0F]/70">Remboursement intégral si vous avez été facturé par erreur</span></div>
                                        </div>
                                        <div class="flex items-start gap-3 group">
                                            <div class="bg-[#22C55E]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                            </div>
                                            <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Service non utilisé<!-- -->:</span> <span class="text-[#0F0F0F]/70">Remboursement au prorata si vous annulez dans les 48 heures suivant le paiement initial et qu'aucun travail n'a commencé</span></div>
                                        </div>
                                        <div class="flex items-start gap-3 group">
                                            <div class="bg-[#22C55E]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                            </div>
                                            <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Doubles facturations<!-- -->:</span> <span class="text-[#0F0F0F]/70">Remboursement immédiat pour toute double facturation</span></div>
                                        </div>
                                        <div class="flex items-start gap-3 group">
                                            <div class="bg-[#22C55E]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></div>
                                            </div>
                                            <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Service non fourni<!-- -->:</span> <span class="text-[#0F0F0F]/70">Remboursement intégral si nous ne fournissons pas les services convenus sans raison valable</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#EF4444]/20 shadow-[0_0_20px_rgba(239,68,68,0.08)]
        bg-gradient-to-br from-[#EF4444]/5 to-[#EF4444]/0

      ">
                                <div class="absolute top-0 right-0 w-40 h-40 bg-[#EF4444]/10 rounded-full blur-3xl opacity-20 -mr-20 -mt-20"></div>
                                <div class="relative p-6">
                                    <div class="flex items-center gap-3 mb-5">
                                        <div class="bg-[#EF4444]/10 rounded-xl p-2.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-6 h-6 text-[#EF4444]" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m15 9-6 6"></path>
                                                <path d="m9 9 6 6"></path>
                                            </svg></div>
                                        <h4 class="text-xl font-semibold text-[#0F0F0F]">Non éligible au remboursement</h4>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex items-start gap-3 group">
                                            <div class="bg-[#EF4444]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></div>
                                            </div>
                                            <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Période de facturation en cours<!-- -->:</span> <span class="text-[#0F0F0F]/70">Pas de remboursement pour le mois actif que vous avez déjà payé</span></div>
                                        </div>
                                        <div class="flex items-start gap-3 group">
                                            <div class="bg-[#EF4444]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></div>
                                            </div>
                                            <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Travail terminé<!-- -->:</span> <span class="text-[#0F0F0F]/70">Pas de remboursement pour les tâches déjà livrées ou en cours</span></div>
                                        </div>
                                        <div class="flex items-start gap-3 group">
                                            <div class="bg-[#EF4444]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></div>
                                            </div>
                                            <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Changement d'avis<!-- -->:</span> <span class="text-[#0F0F0F]/70">Pas de remboursement en raison d'un changement de direction de projet ou de besoins commerciaux</span></div>
                                        </div>
                                        <div class="flex items-start gap-3 group">
                                            <div class="bg-[#EF4444]/10 rounded-md p-1 flex-shrink-0 mt-1 transition-transform group-hover:scale-110">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></div>
                                            </div>
                                            <div class="flex-1"><span class="font-semibold text-[#0F0F0F]">Insatisfaction après révisions<!-- -->:</span> <span class="text-[#0F0F0F]/70">Pas de remboursement après avoir utilisé les révisions illimitées et reçu les livrables finaux</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-4">Mise en pause de votre forfait</h3>
                        <div class="
        relative overflow-hidden rounded-xl border backdrop-blur-sm
        border-[#F59E0B]/20 shadow-[0_0_20px_rgba(245,158,11,0.08)]
        bg-gradient-to-br from-[#F59E0B]/5 to-[#F59E0B]/0
        transition-all duration-300 hover:scale-[1.01]

      ">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F59E0B]/10 rounded-full blur-3xl opacity-30 -mr-16 -mt-16"></div>
                            <div class="relative p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-[#F59E0B]/10 rounded-lg p-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12"></line>
                                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                        </svg></div>
                                    <h4 class="text-lg font-semibold text-[#0F0F0F]">Alternative à l'annulation</h4>
                                </div>
                                <div class="text-[#0F0F0F]/80">
                                    <p>Si vous avez besoin d'une pause temporaire, vous pouvez <strong>mettre en pause votre forfait</strong> pendant une durée maximale de 3 mois sans pénalité. Informez-nous simplement 7 jours avant votre prochain cycle de facturation. Cela vous permet de reprendre les services ultérieurement sans recommencer le processus d'intégration.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Ce qui se passe après l'annulation</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Vous conserverez l'accès aux services jusqu'à la fin de votre période de facturation en cours</li>
                            <li>Tout le travail terminé et les fichiers vous seront livrés</li>
                            <li>Le travail en cours sera fourni dans son état actuel</li>
                            <li>Votre compte restera accessible pendant 30 jours pour le téléchargement des fichiers</li>
                            <li>Pas de renouvellement automatique après votre dernière période de facturation</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="project-refunds" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M12 6v6l4 2"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Développement de site web (Projets ponctuels)</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Structure de paiement</h3>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Acompte initial :</strong> Paiement initial (généralement 50%) requis pour commencer le travail tel que spécifié dans votre proposition</li>
                            <li><strong>Paiement final :</strong> Solde restant dû à l'achèvement du projet avant la livraison finale</li>
                        </ul>
                        <p class="mt-3 text-sm italic">*Les montants exacts de paiement et la structure sont détaillés dans votre proposition signée.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Politique de remboursement par étape du projet</h3>
                        <div class="space-y-4">
                            <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                <h4 class="font-semibold text-[#0F0F0F] mb-3">Étape 1 : Avant le début des travaux</h4>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li><strong>Remboursement intégral disponible :</strong> 100% de remboursement de l'acompte si vous annulez avant que nous commencions le travail (généralement dans les 48 heures suivant le paiement)</li>
                                    <li><strong>Frais de traitement :</strong> Les frais du processeur de paiement peuvent être déduits du remboursement</li>
                                    <li><strong>Délai :</strong> 5-10 jours ouvrables pour que le remboursement apparaisse sur votre compte</li>
                                </ul>
                            </div>
                            <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                <h4 class="font-semibold text-[#0F0F0F] mb-3">Étape 2 : Pendant la phase de conception</h4>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li><strong>Remboursement partiel :</strong> Généralement 75% de l'acompte remboursé</li>
                                    <li><strong>Montant retenu :</strong> Couvre la recherche en design, le wireframing et les concepts initiaux réalisés</li>
                                    <li><strong>Livrables :</strong> Vous recevez tout le travail de design réalisé à ce jour</li>
                                </ul>
                            </div>
                            <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                <h4 class="font-semibold text-[#0F0F0F] mb-3">Étape 3 : Pendant la phase de développement</h4>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li><strong>Remboursement partiel :</strong> Généralement 50% de l'acompte remboursé</li>
                                    <li><strong>Montant retenu :</strong> Couvre le travail de design + développement réalisé</li>
                                    <li><strong>Livrables :</strong> Tous les fichiers de design et le site web partiellement développé fournis</li>
                                </ul>
                            </div>
                            <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                <h4 class="font-semibold text-[#0F0F0F] mb-3">Étape 4 : Révision finale et modifications</h4>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li><strong>Remboursement limité/aucun :</strong> L'acompte est généralement non remboursable à ce stade</li>
                                    <li><strong>Raison :</strong> Un travail substantiel a été réalisé et livré pour votre révision</li>
                                    <li><strong>Alternative :</strong> Nous travaillerons avec vous pour terminer le projet à votre satisfaction en utilisant vos tours de révision inclus</li>
                                </ul>
                            </div>
                            <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                                <h4 class="font-semibold text-[#0F0F0F] mb-3">Étape 5 : Après le paiement final</h4>
                                <ul class="list-disc pl-6 space-y-1">
                                    <li><strong>Pas de remboursement :</strong> Tous les paiements sont définitifs une fois le site web terminé livré</li>
                                    <li><strong>Garantie post-lancement :</strong> Nous fournissons des corrections gratuites pour les problèmes techniques découverts pendant la période de garantie (comme spécifié dans l'accord)</li>
                                    <li><strong>Support continu :</strong> Les modifications supplémentaires sont disponibles à nos tarifs standards tels que décrits dans votre accord de service</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Résiliation par le client</h3>
                        <p class="mb-3">Si vous choisissez de résilier le projet en cours de route :</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Vous payez pour le travail réalisé à ce jour en fonction de l'étape du projet</li>
                            <li>Plus des frais de résiliation de 25% du solde restant</li>
                            <li>Tous les fichiers de travail en cours vous sont livrés</li>
                            <li>Le remboursement partiel est calculé dans les 7 jours ouvrables</li>
                        </ul>
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
                                <p class="font-medium text-[#0F0F0F]"><strong>Exemple :</strong> Si vous résiliez pendant la phase de développement (Étape 3), vous recevriez généralement environ 50% de remboursement de votre acompte, et conserveriez tous les fichiers de design et de développement partiel. Les montants exacts de remboursement sont calculés en fonction du travail réalisé.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Garantie de satisfaction</h3>
                        <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#22C55E]/20 bg-gradient-to-br from-[#22C55E]/5 to-[#22C55E]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                            <div class="bg-[#22C55E]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-4 h-4 text-[#22C55E]" aria-hidden="true">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg></div>
                            <div class="flex-1 text-sm text-[#0F0F0F]/80">
                                <p class="font-medium text-[#0F0F0F] mb-2">Notre promesse :</p>
                                <p>Nous garantissons notre travail. Si le site web final ne correspond pas substantiellement aux spécifications convenues décrites dans votre cahier des charges, et que nous ne parvenons pas à résoudre les problèmes dans vos 2 tours de révision inclus, nous fournirons un remboursement au prorata basé sur le travail ne répondant pas aux spécifications.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Frais et charges supplémentaires</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Services complémentaires</h3>
                        <p class="mb-2">Les services supplémentaires achetés séparément sont soumis à leurs propres conditions de remboursement :</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Pages et fonctionnalités supplémentaires :</strong> Remboursables si le travail n'a pas encore commencé, non remboursables une fois livrées (le prix varie selon la portée)</li>
                            <li><strong>Plugins/Outils premium :</strong> Généralement non remboursables en raison des restrictions de licence tiers</li>
                            <li><strong>Photos/Assets stock :</strong> Non remboursables une fois achetés (licence tiers)</li>
                            <li><strong>Domaine et hébergement :</strong> Soumis aux politiques de remboursement du fournisseur tiers</li>
                        </ul>
                        <p class="mt-3 text-sm italic">*Référez-vous à votre facture et accord de service pour les tarifs spécifiques des compléments et les conditions de remboursement.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Frais de traitement des paiements</h3>
                        <p>Tous les paiements sont traités via Stripe. Lorsque des remboursements sont émis, les frais de traitement des paiements ne sont généralement pas remboursés par le processeur de paiement et peuvent être déduits du montant de votre remboursement. Il s'agit d'une politique du processeur de paiement, et non de frais CodeSommet.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Contestations de paiement</h3>
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
                                <p class="font-medium text-[#0F0F0F] mb-2">Avis important :</p>
                                <p>Si vous initiez une contestation de paiement auprès de votre banque ou de votre société de carte de crédit au lieu de nous contacter directement, nous nous réservons le droit de :</p>
                                <ul class="list-disc pl-6 space-y-1 mt-2">
                                    <li>Suspendre tous les services immédiatement</li>
                                    <li>Retenir tous les fichiers et livrables du projet</li>
                                    <li>Facturer des frais de traitement de contestation si la contestation est jugée invalide (montant spécifié dans l'accord de service)</li>
                                    <li>Engager des poursuites judiciaires pour rupture de contrat</li>
                                </ul>
                                <p class="mt-3 font-medium">Veuillez d'abord nous contacter à <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="a6cec3cacac9e6d6cfcdc7d5d5c9d5d2d3c2cfc988c5c9cb">[email&#160;protected]</span></a> pour résoudre tout litige de paiement.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="how-to-request" class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Comment demander un remboursement</h2>
                </div>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Processus de demande de remboursement</h3>
                        <ol class="list-decimal pl-6 space-y-3">
                            <li><strong>Envoyez-nous un e-mail :</strong> Envoyez une demande de remboursement à <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="caa2afa6a6a58abaa3a1abb9b9a5b9bebfaea3a5e4a9a5a7">[email&#160;protected]</span></a></li>
                            <li><strong>Objet :</strong> Utilisez &quot;Demande de remboursement - [Votre nom/Entreprise]&quot;</li>
                            <li><strong>Incluez les informations :</strong>
                                <ul class="list-disc pl-6 mt-2 space-y-1">
                                    <li>Nom complet et e-mail utilisé pour le paiement</li>
                                    <li>Numéro de facture ou identifiant de transaction</li>
                                    <li>Type de service (Forfait ou Développement de site web)</li>
                                    <li>Raison de la demande de remboursement</li>
                                    <li>Mode de remboursement préféré (mode de paiement original ou alternatif)</li>
                                </ul>
                            </li>
                            <li><strong>Période d'examen :</strong> Nous examinerons votre demande dans un délai de 3 jours ouvrables</li>
                            <li><strong>Décision :</strong> Vous recevrez une réponse écrite avec notre décision et le montant du remboursement (le cas échéant)</li>
                            <li><strong>Traitement :</strong> Les remboursements approuvés sont traités dans un délai de 5-10 jours ouvrables</li>
                            <li><strong>Délai de remboursement :</strong> Comptez 5-10 jours ouvrables pour que les remboursements apparaissent sur votre compte après le traitement</li>
                        </ol>
                    </div>
                    <div class="bg-[#00AEEF]/5 rounded-lg p-6 border border-[#00AEEF]/20">
                        <h4 class="font-semibold text-[#0F0F0F] mb-3">Mode de remboursement</h4>
                        <p class="mb-2">Les remboursements seront émis en utilisant le même mode de paiement que celui utilisé pour l'achat original :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li><strong>Carte de crédit/débit :</strong> Remboursement sur la carte originale (5-10 jours ouvrables)</li>
                            <li><strong>Virement bancaire :</strong> Remboursement sur le compte bancaire original (3-7 jours ouvrables)</li>
                            <li><strong>Mode alternatif :</strong> Disponible sur demande (peut nécessiter un délai de traitement supplémentaire)</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Résolution des litiges</h3>
                        <p class="mb-3">Si vous n'êtes pas d'accord avec notre décision de remboursement :</p>
                        <ol class="list-decimal pl-6 space-y-2">
                            <li>Répondez à notre e-mail de décision avec un contexte ou des preuves supplémentaires</li>
                            <li>Demandez un examen par un membre senior de l'équipe</li>
                            <li>Nous effectuerons un second examen dans les 5 jours ouvrables</li>
                            <li>Si le problème n'est toujours pas résolu, consultez notre processus de <a class="text-[#00AEEF] hover:underline" href="/legal/terms-of-service#dispute-resolution">Résolution des litiges</a> dans nos Conditions d'Utilisation</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Circonstances particulières</h2>
                <div class="space-y-6 text-[#0F0F0F]/70">
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Situations d'urgence</h3>
                        <p class="mb-2">Nous comprenons que les circonstances de la vie peuvent changer. Dans les cas de :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Urgences médicales</li>
                            <li>Fermeture d'entreprise ou faillite</li>
                            <li>Catastrophes naturelles ou événements de force majeure</li>
                            <li>Décès du client ou d'un intervenant clé</li>
                        </ul>
                        <p class="mt-3">Veuillez nous contacter directement. Nous examinerons votre situation au cas par cas et travaillerons avec vous pour trouver une résolution équitable, qui peut inclure des conditions de paiement prolongées, une mise en pause du projet ou une considération spéciale de remboursement.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Défaillances de service</h3>
                        <p class="mb-2">Si nous ne parvenons pas à fournir les services en raison de :</p>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>Retards prolongés au-delà des délais convenus (sans retards causés par le client)</li>
                            <li>Incapacité à respecter les spécifications convenues</li>
                            <li>Problèmes techniques de notre côté empêchant la livraison du service</li>
                            <li>Violation de notre accord de service</li>
                        </ul>
                        <p class="mt-3">Vous avez droit à un remboursement total ou partiel selon l'étendue de la défaillance de service. Nous communiquerons de manière proactive tout problème et travaillerons à le résoudre avant d'envisager des remboursements.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0F0F0F] mb-3">Remboursements de bonne volonté</h3>
                        <p>Dans de rares cas, nous pouvons émettre des remboursements de bonne volonté même lorsque notre politique ne l'exige pas. Ceci est à notre seule discrétion et est généralement réservé aux situations où nous estimons que c'est la bonne chose à faire pour la satisfaction du client et notre réputation.</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#00AEEF]/10 to-[#0071BC]/10 rounded-xl p-8 md:p-10 border border-[#00AEEF]/20">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        </svg></div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F]" style="font-family:var(--font-heading)">Des questions sur les remboursements ?</h2>
                </div>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <p>Si vous avez des questions sur notre politique de remboursement, avez besoin de demander un remboursement ou souhaitez discuter de votre situation spécifique, veuillez nous contacter :</p>
                    <div class="bg-white rounded-lg p-6 space-y-3">
                        <div>
                            <p class="font-semibold text-[#0F0F0F]">CodeSommet</p>
                            <p>Agence Premium de Développement Web</p>
                        </div>
                        <div class="space-y-2">
                            <p><strong>Email :</strong> <a href="mailto:codesommet@gmail.com" class="text-[#00AEEF] hover:underline"><span class="__cf_email__" data-cfemail="cfa7aaa3a3a08fbfa6a4aebcbca0bcbbbaaba6a0e1aca0a2">[email&#160;protected]</span></a></p>
                            <p><strong>Téléphone :</strong> <a href="tel:+212632582096" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                            <p><strong>WhatsApp :</strong> <a href="https://wa.me/212632582096" target="_blank" rel="noopener noreferrer" class="text-[#00AEEF] hover:underline">+212 6 32 58 20 96</a></p>
                        </div>
                        <div>
                            <p><strong>Siège social :</strong> Maroc</p>
                            <p><strong>Opérations :</strong> Monde entier</p>
                        </div>
                        <div class="pt-3 border-t border-[#0F0F0F]/10">
                            <p class="text-sm">Pour les demandes de remboursement, veuillez utiliser l'objet &quot;Demande de remboursement - [Votre nom]&quot; pour un traitement plus rapide.</p>
                        </div>
                    </div>
                    <div class="
        flex items-start gap-3 p-4 rounded-lg border backdrop-blur-sm
        border-[#22C55E]/20 bg-gradient-to-br from-[#22C55E]/5 to-[#22C55E]/0
        transition-all duration-200 hover:scale-[1.01]

      ">
                        <div class="bg-[#22C55E]/10 rounded-lg p-1.5 flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-4 h-4 text-[#22C55E]" aria-hidden="true">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg></div>
                        <div class="flex-1 text-sm text-[#0F0F0F]/80">
                            <p class="font-medium text-[#0F0F0F] mb-2">Notre engagement :</p>
                            <p>Nous nous efforçons de répondre à toutes les demandes de remboursement dans un délai de 3 jours ouvrables. Votre satisfaction est importante pour nous, et nous travaillerons avec vous pour trouver une résolution équitable.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-8 md:p-10 shadow-sm mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0F0F0F] mb-6" style="font-family:var(--font-heading)">Mentions légales importantes</h2>
                <div class="space-y-4 text-[#0F0F0F]/70">
                    <div class="bg-[#F8F8F8] rounded-lg p-6 border border-[#0F0F0F]/10">
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg><span><strong>Modifications de la politique :</strong> Nous nous réservons le droit de modifier cette Politique de Remboursement à tout moment. Les modifications seront publiées sur cette page avec une date de &quot;Dernière mise à jour&quot; actualisée. L'utilisation continue des services après les modifications constitue l'acceptation.</span></li>
                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg><span><strong>Droit applicable :</strong> Cette Politique de Remboursement est régie par les lois du Maroc et est soumise à nos <a class="text-[#00AEEF] hover:underline" href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a> complètes.</span></li>
                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg><span><strong>Conditions Stripe :</strong> Tous les paiements et remboursements sont soumis au Contrat de Services de Stripe. Consultez les <a href="https://stripe.com/legal/consumer" target="_blank" rel="noopener noreferrer" class="text-[#00AEEF] hover:underline">Conditions Consommateur de Stripe</a>.</span></li>
                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg><span><strong>Droits des consommateurs :</strong> Cette politique n'affecte pas vos droits légaux en tant que consommateur en vertu de la loi applicable.</span></li>
                            <li class="flex items-start gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert w-5 h-5 flex-shrink-0 mt-0.5 text-[#00AEEF]" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg><span><strong>Autorité finale :</strong> CodeSommet conserve l'autorité finale sur toutes les décisions de remboursement. Les litiges peuvent être escaladés via notre processus de <a class="text-[#00AEEF] hover:underline" href="/legal/terms-of-service#dispute-resolution">Résolution des litiges</a>.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <p class="text-[#0F0F0F]/70 mb-4">Documents juridiques connexes :</p>
                <div class="flex flex-wrap justify-center gap-3"><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('terms-of-service') }}">Conditions d'Utilisation</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('privacy-policy') }}">Politique de Confidentialité</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('cookie-policy') }}">Politique de Cookies</a><a class="px-6 py-3 text-sm font-medium text-[#00AEEF] border-2 border-[#00AEEF] hover:bg-[#00AEEF] hover:text-white rounded-full transition-colors" href="{{ route('acceptable-use') }}">Politique d'Utilisation Acceptable</a></div>
            </div>
        </div>
    </div>
</section>
@endsection