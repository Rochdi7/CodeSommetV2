@extends('layouts.app')

@section('title', 'Étude de Cas GLS Sprachenzentrum - École de Langue Allemande | CodeSommet')
@section('meta_description', 'Étude de cas GLS Sprachenzentrum : site bilingue FR/EN et tableau de bord de gestion pour école de langue allemande (CRM, paie, certificats).')
@section('meta_keywords', 'plateforme école de langue,site bilingue FR EN,tableau de bord de gestion scolaire,CRM étudiant,automatisation de la paie,vérification de certificats QR code,cours d\'allemand A1 C1')
@section('og_title', 'Étude de Cas GLS Sprachenzentrum - École de Langue Allemande')
@section('og_description', 'Application web à double vocation pour une école de langue allemande : site vitrine bilingue FR/EN orienté conversion et tableau de bord d\'administration à rôles couvrant cours, inscriptions, CRM, paie, encaissement et contrôle d\'accès.')
@section('twitter_description', 'Application web à double vocation pour une école de langue allemande : site vitrine bilingue FR/EN orienté conversion et tableau de bord d\'administration à rôles couvrant cours, inscriptions, CRM, paie, encaissement et contrôle d\'accès.')

@section('content')
<section class="relative pt-24 md:pt-28 lg:pt-32 pb-12 md:pb-16 lg:pb-24 overflow-hidden">
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
        <div class="mb-6 md:mb-8"><a href="/our-work"><button class="inline-flex items-center justify-center font-medium cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] border border-[var(--border-default)] text-[var(--text-primary)] bg-transparent hover:border-[var(--color-primary-orange)] hover:text-[var(--color-primary-orange)] hover:bg-[var(--hover-primary)] h-10 px-6 rounded-full group hover:shadow-lg transition-all duration-300 text-sm md:text-base" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-3.5 h-3.5 md:w-4 md:h-4 mr-2 group-hover:-translate-x-1 transition-transform" aria-hidden="true">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>Retour aux Nos Projets</button></a></div>
        <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-center mb-12 md:mb-16">
            <div class="space-y-4 md:space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-[#00AEEF]/10 to-[#0071BC]/10 rounded-full border border-[#00AEEF]/20" style="transform:scale(0.9)">
                    <div class="w-2 h-2 rounded-full bg-[#00AEEF] animate-pulse"></div><span class="text-sm font-semibold text-[#00AEEF]">Éducation</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight" style="font-family:var(--font-heading)">GLS Sprachenzentrum</h1>
                <p class="text-xl md:text-2xl text-[var(--text-secondary)] font-medium">Deutsch Sprachenzentrum</p>
                <p class="text-base md:text-lg text-[var(--text-secondary)] leading-relaxed">Application web à double vocation pour une école de langue allemande : un site vitrine bilingue FR/EN orienté conversion et un tableau de bord d'administration à rôles qui pilote tout le quotidien du centre, du premier clic publicitaire jusqu'au certificat de l'étudiant</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                    <div class="group relative p-4 bg-white rounded-2xl border border-gray-100 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#00AEEF]/10 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                    <path d="M8 2v4"></path>
                                    <path d="M16 2v4"></path>
                                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                    <path d="M3 10h18"></path>
                                </svg></div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Délai</p>
                                <p class="text-sm font-bold text-gray-900 truncate">6 semaines</p>
                            </div>
                        </div>
                    </div>
                    <div class="group relative p-4 bg-white rounded-2xl border border-gray-100 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#10B981]/10 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-5 h-5 text-[#10B981]" aria-hidden="true">
                                    <path d="M16 7h6v6"></path>
                                    <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                                </svg></div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Croissance des Prospects</p>
                                <p class="text-sm font-bold text-gray-900 truncate">2000+</p>
                            </div>
                        </div>
                    </div>
                    <div class="group relative p-4 bg-white rounded-2xl border border-gray-100 hover:border-[#00AEEF]/30 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#8B5CF6]/10 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5 text-[#8B5CF6]" aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </svg></div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Trafic Mensuel</p>
                                <p class="text-sm font-bold text-gray-900 truncate">45,000+</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-2 md:pt-4"><a href="https://gls-sprachzentrum.ma/" target="_blank" rel="noopener noreferrer" class="block w-full"><button class="inline-flex items-center justify-center cursor-pointer disabled:pointer-events-none disabled:opacity-50 overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] rounded-full group relative w-full bg-gradient-to-r from-[#00AEEF] to-[#0071BC] text-white hover:shadow-[0_8px_30px_rgba(0,174,239,0.4)] transition-all duration-300 text-base md:text-lg px-6 py-3.5 md:py-4 h-auto font-semibold" tabindex="0"><span>Visiter le Site</span><svg class="w-5 h-5 md:w-5 md:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg></button></a></div>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-[#00AEEF]/20 via-transparent to-[#0071BC]/20 blur-3xl -z-10 animate-pulse"></div>
                <div class="relative aspect-[16/9] rounded-2xl md:rounded-3xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 md:border-2 shadow-xl md:shadow-2xl"><video src="{{ asset('videos/gls-sprachenzentrum-language-school-showcase.mp4') }}" autoplay loop muted playsinline webkit-playsinline class="w-full h-full object-cover"></video></div>
            </div>
        </div>
    </div>
</section>
<section class="relative py-12 md:py-16 lg:py-20 bg-[#F5F5F5] overflow-hidden">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-2 md:mb-3" style="font-family:var(--font-heading)">Le Parcours</h2>
            <p class="text-gray-600 text-base md:text-lg">Du défi à la solution</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4 md:gap-6 mb-8 md:mb-12 max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg></div>
                    <h3 class="text-xl font-bold text-gray-900" style="font-family:var(--font-heading)">Le Défi</h3>
                </div>
                <p class="text-gray-700 leading-relaxed text-[15px]">GLS Sprachenzentrum pilotait ses centres avec des outils dispersés : fichiers de présence, plannings papier, calculs de paie manuels, suivi des paiements et des impayés sur tableur, et un site vitrine incapable de capter et de qualifier les demandes d&#x27;inscription. Il fallait réunir deux mondes dans une seule application : d&#x27;un côté un site public bilingue FR/EN, rapide et optimisé pour la conversion, présentant les niveaux A1 à C1, les cours intensifs et en ligne, les centres et le programme Studienkolleg ; de l&#x27;autre un back-office à permissions capable de gérer groupes, professeurs, plannings, rapports pédagogiques, CRM étudiant, paie, encaissement et contrôle d&#x27;accès physique, avec des données cloisonnées par centre et un suivi fiable à l&#x27;heure de Casablanca.</p>
            </div>
            <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                            <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg></div>
                    <h3 class="text-xl font-bold text-gray-900" style="font-family:var(--font-heading)">Notre Solution</h3>
                </div>
                <p class="text-gray-700 leading-relaxed text-[15px]">Nous avons livré une plateforme unique articulée en deux espaces. Le frontoffice bilingue FR/EN gère le routage automatique de la locale et un contenu multilingue de bout en bout (noms de cours, niveaux, blog) : pages de niveaux CEFR A1&rarr;C1, cours intensifs et en ligne, pages de centres affichant les groupes ouverts et leurs disponibilités en temps réel, programme Studienkolleg, tarifs transparents, blog catégorisé, témoignages d&#x27;étudiants et pôles d&#x27;information examens (GLS, &Ouml;SD, Goethe). La captation de prospects s&#x27;appuie sur l&#x27;inscription en ligne et les formulaires GLS avec confirmation e-mail instantanée, la candidature à un groupe ouvert, la réservation de consultation gratuite, la newsletter et des landing pages publicitaires (Meta, Google, TikTok) volontairement non mises en cache pour que le tracking de conversion se déclenche toujours. Des outils interactifs complètent le parcours : quiz &laquo; Découvrez votre niveau &raquo;, vérification publique de l&#x27;authenticité des certificats, demandes d&#x27;attestation en ligne et suivi de traduction par référence. Côté backoffice, un système de rôles et permissions avec vérification e-mail, réinitialisation de mot de passe, protection contre les conflits de session et cloisonnement des données par centre encadre l&#x27;ensemble : gestion des groupes, professeurs et centres, plannings exportables en PDF, rapports pédagogiques hebdomadaires avec grille par compétence (Lesen &middot; H&ouml;ren &middot; Grammatik &middot; Schreiben &middot; Sprechen) et pièces jointes, suivi de niveau, génération de certificats avec lien public à jeton et QR code, CMS de blog, gestion du quiz, de la newsletter, des campagnes WhatsApp et des commandes de traduction. Le CRM synchronise étudiants, classes, inscriptions et présences depuis les systèmes de l&#x27;école, suit les paiements, allocations et recouvrements, calcule un score de churn pour repérer les étudiants à risque et alimente les tableaux de bord agents, relances et rapports quotidiens. La paie est automatisée par import des présences (professeurs, périodes horaires, personnel CRM) avec journal de statuts, piste d&#x27;audit et gestion des primes, l&#x27;encaissement couvre recettes, dépenses par site, impayés et recouvrement, et l&#x27;intégration native Hikvision assure le contrôle d&#x27;accès et la présence physique (appareils, personnes, alarmes, webhooks, journaux). Le tout est complété par la mise en cache des réponses, la génération automatique du sitemap, les balises SEO et données structurées Schema.org, une limitation anti-spam sur les formulaires publics et des rapports automatisés récurrents avec suivi des envois.</p>
            </div>
        </div>
        <div class="mb-8 md:mb-12 max-w-6xl mx-auto">
            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 text-center" style="font-family:var(--font-heading)">Fonctionnalités Clés</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Site public bilingue FR/EN avec routage automatique de la locale et contenu multilingue (cours, niveaux, blog)</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Pages de niveaux CEFR A1&rarr;C1, cours intensifs et en ligne, pages de centres avec groupes ouverts et disponibilités en direct</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Inscription en ligne et candidature à un groupe avec confirmation e-mail instantanée, réservation de consultation et landing pages publicitaires non mises en cache</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Quiz interactif &laquo; Découvrez votre niveau &raquo; orientant chaque visiteur vers son niveau CEFR</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Vérification publique des certificats par QR code et lien à jeton unique, plus demandes d'attestation en ligne</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">CRM étudiant complet : classes, inscriptions et présences synchronisées, paiements, recouvrement, score de churn et relances</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Automatisation de la paie par import des présences (professeurs, périodes horaires, personnel CRM) avec primes et piste d'audit</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Module financier d'encaissement : recettes, dépenses par site, impayés, recouvrement et tableau de bord consolidé</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Intégration native Hikvision pour la présence et le contrôle d'accès physique (appareils, alarmes, webhooks, journaux d'activité)</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.06)] hover:shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 border border-gray-100" style="transform:scale(0.95)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <p class="text-sm text-gray-700 leading-relaxed">Rapports pédagogiques hebdomadaires par compétence (Lesen &middot; H&ouml;ren &middot; Grammatik &middot; Schreiben &middot; Sprechen), plannings exportables en PDF et rapports automatisés récurrents</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)] max-w-6xl mx-auto">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code-xml w-6 h-6 text-[#00AEEF]" aria-hidden="true">
                        <path d="m18 16 4-4-4-4"></path>
                        <path d="m6 8-4 4 4 4"></path>
                        <path d="m14.5 4-5 16"></path>
                    </svg></div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900" style="font-family:var(--font-heading)">Stack Technologique</h3>
            </div>
            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 capitalize text-sm flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div>frontend
                    </h4>
                    <div class="flex flex-wrap gap-2"><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Next.js 15.3.2</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">React 19</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">TypeScript 5.8.2</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Tailwind CSS 3.3.0</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">shadcn/ui</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Framer Motion</span></div>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 capitalize text-sm flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div>backend
                    </h4>
                    <div class="flex flex-wrap gap-2"><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Supabase</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">PostgreSQL</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Cloud Functions</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">ISR with Force-Static Generation</span></div>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 capitalize text-sm flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#00AEEF]"></div>intégrations
                    </h4>
                    <div class="flex flex-wrap gap-2"><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">OpenAI GPT-4</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Resend API</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Google Cloud Storage</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Vercel Analytics</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Upstash Redis</span><span class="px-4 py-2 bg-gray-50 rounded-full text-sm font-medium text-gray-700 border border-gray-200 hover:border-[#00AEEF]/30 hover:bg-white transition-all duration-200" style="transform:scale(0.9)">Recharts</span></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-12 md:py-16 lg:py-20 bg-white">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3" style="font-family:var(--font-heading)">Aperçu de l'Interface</h2>
            <p class="text-gray-600 text-base md:text-lg">Captures d'écran à venir</p>
        </div>
        <div class="flex justify-center gap-2 mb-8 flex-wrap"><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-[#00AEEF] text-white shadow-md" style="transform:scale(0.95)">Accueil</button><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200" style="transform:scale(0.95)">Détail Niveau</button><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200" style="transform:scale(0.95)">Recherche de Cours</button><button class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200" style="transform:scale(0.95)">Tableau de Bord Admin</button></div>
        <div class="relative mb-8 md:mb-12 max-w-5xl mx-auto">
            <div class="relative aspect-[3/2] rounded-2xl md:rounded-3xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 shadow-[0_4px_20px_rgba(0,0,0,0.08)]"><img src="{{ asset('images/our-work/gls-sprachenzentrum/homepage.webp') }}" alt="Accueil" class="w-full h-full object-cover" /></div>
        </div>
        <div class="grid sm:grid-cols-2 gap-4 md:gap-6 max-w-3xl mx-auto">
            <div class="bg-[#F5F5F5] rounded-2xl md:rounded-3xl p-6 md:p-8 text-center">
                <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-white flex items-center justify-center mx-auto mb-3 md:mb-4 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor w-6 h-6 md:w-8 md:h-8 text-[#00AEEF]" aria-hidden="true">
                        <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                        <line x1="8" x2="16" y1="21" y2="21"></line>
                        <line x1="12" x2="12" y1="17" y2="21"></line>
                    </svg></div>
                <h3 class="text-base md:text-lg font-bold text-gray-900 mb-1 md:mb-2" style="font-family:var(--font-heading)">Optimisé Bureau</h3>
                <p class="text-xs md:text-sm text-gray-600">Expérience époustouflante sur grands écrans</p>
            </div>
            <div class="bg-[#F5F5F5] rounded-2xl md:rounded-3xl p-6 md:p-8 text-center">
                <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl bg-white flex items-center justify-center mx-auto mb-3 md:mb-4 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-smartphone w-6 h-6 md:w-8 md:h-8 text-[#00AEEF]" aria-hidden="true">
                        <rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect>
                        <path d="M12 18h.01"></path>
                    </svg></div>
                <h3 class="text-base md:text-lg font-bold text-gray-900 mb-1 md:mb-2" style="font-family:var(--font-heading)">Adapté Mobile</h3>
                <p class="text-xs md:text-sm text-gray-600">Parfait sur téléphones et tablettes</p>
            </div>
        </div>
    </div>
</section>
<section class="relative py-16 md:py-20 lg:py-24 overflow-hidden" style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
    <div class="absolute inset-0" style="background-image:linear-gradient(rgba(255,255,255,0.15) 1px, transparent 1px),
                             linear-gradient(90deg, rgba(255,255,255,0.15) 1px, transparent 1px);background-size:50px 50px"></div>
    <div class="absolute inset-0" style="background:radial-gradient(
              ellipse 70% 70% at center,
              transparent 0%,
              transparent 10%,
              rgba(10, 10, 10, 0.15) 25%,
              rgba(10, 10, 10, 0.35) 40%,
              rgba(10, 10, 10, 0.6) 60%,
              rgba(10, 10, 10, 0.85) 80%,
              rgba(10, 10, 10, 0.95) 100%
            )"></div>
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div>
            <div class="text-center mb-10 md:mb-12 lg:mb-16">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-white" style="font-family:var(--font-heading)">Impact Mesurable</h2>
                <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto">Des chiffres réels. Une croissance réelle. Des résultats réels.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-12 md:mb-16 max-w-4xl mx-auto">
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                                <path d="M16 7h6v6"></path>
                                <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">2000+</p>
                            <p class="text-xs text-gray-600 font-medium">Augmentation des Prospects</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#10B981]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target w-5 h-5 text-[#10B981]" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">15.5%</p>
                            <p class="text-xs text-gray-600 font-medium">Taux de Conversion</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#8B5CF6]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5 text-[#8B5CF6]" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">45,000+</p>
                            <p class="text-xs text-gray-600 font-medium">Visiteurs Mensuels</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#F59E0B]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-5 h-5 text-[#F59E0B]" aria-hidden="true">
                                <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">&lt; 1.8s</p>
                            <p class="text-xs text-gray-600 font-medium">Temps de Chargement</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#EC4899]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-5 h-5 text-[#EC4899]" aria-hidden="true">
                                <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                                <path d="M20 2v4"></path>
                                <path d="M22 4h-4"></path>
                                <circle cx="4" cy="20" r="2"></circle>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">2000+</p>
                            <p class="text-xs text-gray-600 font-medium">Étudiants Suivis</p>
                        </div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-lg p-3 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#06B6D4]/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor w-5 h-5 text-[#06B6D4]" aria-hidden="true">
                                <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                                <line x1="8" x2="16" y1="21" y2="21"></line>
                                <line x1="12" x2="12" y1="17" y2="21"></line>
                            </svg></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg md:text-xl font-bold text-gray-900 leading-tight">88%</p>
                            <p class="text-xs text-gray-600 font-medium">Processus Automatisés</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-4xl mx-auto mt-16 mb-12">
                <div class="bg-gradient-to-br from-[#00AEEF]/5 to-orange-50 rounded-3xl p-8 md:p-10 border-2 border-[#00AEEF]/20 text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#00AEEF]/10 mb-5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column w-7 h-7 text-[#00AEEF]" aria-hidden="true">
                            <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                            <path d="M18 17V9"></path>
                            <path d="M13 17V5"></path>
                            <path d="M8 17v-3"></path>
                        </svg></div>
                    <h3 class="text-2xl md:text-3xl font-bold mb-3 text-[var(--text-primary)]" style="font-family:var(--font-heading)">Comparez les Performances de Votre Site Web</h3>
                    <p class="text-base md:text-lg text-[var(--text-secondary)] mb-6 max-w-2xl mx-auto">Nous avons obtenu ces résultats pour <!-- -->GLS Sprachenzentrum<!-- -->. Vous voulez des résultats similaires ? Obtenez une analyse gratuite alimentée par l'IA avec plus de 40 vérifications, puis demandez votre devis gratuit.</p><a class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-[#00AEEF] hover:bg-[#0071BC] text-white font-medium transition-all shadow-[0_4px_20px_rgba(0,174,239,0.25)] hover:shadow-[0_6px_24px_rgba(0,174,239,0.35)] hover:scale-105 text-sm md:text-base" href="/tools/website-analyzer"><span>Analyser Mon Site Web</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></a>
                </div>
            </div>
            <div class="max-w-3xl mx-auto px-2 md:px-0">
                <div class="bg-[#FEFEFE] rounded-2xl md:rounded-3xl overflow-hidden p-1.5 md:p-2 transition-all duration-300 hover:-translate-y-2" style="box-shadow:0 10px 40px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.06)">
                    <div class="relative rounded-lg md:rounded-[16px] overflow-hidden" style="background:linear-gradient(to top, #00AEEF 0%, #0071BC 100%);box-shadow:0 8px 20px rgba(0, 0, 0, 0.08), 0 3px 6px rgba(0, 0, 0, 0.04)">
                        <div class="px-5 md:px-6 py-6 md:py-7"><svg class="w-8 h-8 md:w-10 md:h-10 text-white/30 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path>
                            </svg>
                            <blockquote class="text-base md:text-lg text-white leading-relaxed mb-6 font-normal italic">&quot;<!-- -->CodeSommet a réuni notre site public et toute notre gestion interne dans une seule plateforme. Les inscriptions arrivent directement en ligne, les plannings et les rapports hebdomadaires de nos professeurs sont centralisés, la paie se calcule automatiquement à partir des présences et nos certificats sont vérifiables par QR code. Nos équipes ont enfin une vision claire de chaque centre, du premier contact jusqu&#x27;au certificat.<!-- -->&quot;</blockquote>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0"><span class="text-white font-bold text-base md:text-lg">R</span></div>
                                <div>
                                    <p class="font-bold text-white text-sm md:text-base">Rafiq</p>
                                    <p class="text-white/90 text-xs md:text-sm">Administration, GLS Sprachenzentrum</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-12 md:pt-16 lg:pt-20 pb-3 md:pb-4 bg-[#F5F5F5] border-t border-gray-200">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="grid grid-cols-3 md:grid-cols-3 gap-3 md:gap-4 max-w-4xl mx-auto"><a class="group" href="/our-work/morocco-quest">
                <div class="bg-white rounded-2xl p-4 md:p-6 text-center hover:shadow-md transition-all duration-200 border border-gray-100"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-6 h-6 md:w-5 md:h-5 text-gray-400 mx-auto mb-0 md:mb-2 group-hover:text-[#00AEEF] group-hover:-translate-x-1 transition-all" aria-hidden="true">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-700 hidden md:block">Précédent Project</p>
                </div>
            </a><a class="group" href="/our-work">
                <div class="bg-[#00AEEF] rounded-2xl p-4 md:p-6 text-center hover:bg-[#0071BC] transition-all duration-200 shadow-md hover:shadow-lg">
                    <div class="w-6 h-6 md:w-5 md:h-5 mx-auto mb-0 md:mb-2 flex items-center justify-center">
                        <div class="grid grid-cols-2 gap-0.5">
                            <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                            <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                            <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                            <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                        </div>
                    </div>
                    <p class="text-sm font-semibold text-white hidden md:block">Voir Tout</p>
                </div>
            </a><a class="group" href="/our-work/dental-pro">
                <div class="bg-white rounded-2xl p-4 md:p-6 text-center hover:shadow-md transition-all duration-200 border border-gray-100"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-6 h-6 md:w-5 md:h-5 text-gray-400 mx-auto mb-0 md:mb-2 group-hover:text-[#00AEEF] group-hover:translate-x-1 transition-all" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-700 hidden md:block">Suivant Project</p>
                </div>
            </a></div>
    </div>
</section>
<div class="relative w-full px-4 py-12 md:py-16 lg:py-20 bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto">
        <div class="relative overflow-hidden rounded-[24px] md:rounded-[32px] px-6 py-6 md:py-8" style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
            <div class="absolute inset-0 z-0" style="background-image:linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
                               linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);background-size:50px 50px"></div>
            <div class="absolute inset-0 z-[1]" style="background:radial-gradient(
                ellipse 70% 70% at center,
                transparent 0%,
                transparent 10%,
                rgba(10, 10, 10, 0.15) 25%,
                rgba(10, 10, 10, 0.35) 40%,
                rgba(10, 10, 10, 0.6) 60%,
                rgba(10, 10, 10, 0.85) 80%,
                rgba(10, 10, 10, 0.95) 100%
              )"></div>
            <div class="relative z-10 text-center space-y-3 md:space-y-4">
                <h2 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-tight text-white px-4 pb-6 md:pb-8" style="font-family:var(--font-display)">Prêt à Créer Quelque Chose d'Extraordinaire ?</h2>
                <div class="flex flex-col items-center gap-4 md:gap-6">
                    <div class="flex flex-col sm:flex-row items-center gap-4 md:hidden"><a target="_blank" rel="noopener noreferrer" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto" style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px,
                rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                rgba(0, 0, 0, 0.055) 0px 47.8699px 47.8699px -2.8125px,
                rgba(0, 0, 0, 0.043) 0px 82.4287px 82.4287px -3.28125px,
                rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px" data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' href="#">
                            <div class="shine-wrapper">
                                <div class="shine-element"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel Découverte</span>
                        </a><a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden w-full sm:w-auto border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" style="border-radius:118px" href="/tools/website-analyzer">
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Analyser Votre Site Web</span>
                        </a></div>
                    <div class="hidden md:flex flex-row items-center gap-4"><button data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting" data-cal-config="{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden" style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px,
                rgba(0, 0, 0, 0.06) 0px 29.2442px 29.2442px -2.34375px,
                rgba(0, 0, 0, 0.055) 0px 47.8699px 47.8699px -2.8125px,
                rgba(0, 0, 0, 0.043) 0px 82.4287px 82.4287px -3.28125px,
                rgba(0, 0, 0, 0.024) 0px 150px 150px -3.75px">
                            <div class="shine-wrapper">
                                <div class="shine-element"></div>
                            </div>
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div>
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-black" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Réserver un Appel Découverte</span>
                        </button><a class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden border-2 border-white/30 bg-transparent hover:bg-white/10 transition-colors" style="border-radius:118px" href="/tools/website-analyzer">
                            <div class="relative z-10 flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket w-5 h-5 text-white" aria-hidden="true">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                                    <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                                </svg></div><span class="relative z-10 text-base md:text-lg font-medium tracking-tight text-white" style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">Analyser Votre Site Web</span>
                        </a></div>
                    <div class="relative mt-2 h-16">
                        <div class="absolute pointer-events-none animate-cursor-stops" style="left:50%;top:50%">
                            <div class="absolute left-0 -top-6 -translate-x-1/2"><svg width="20" height="19" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg">
                                    <path d="M 8.065 7.445 C 7.971 6.231 9.325 5.449 10.33 6.137 L 20.112 12.846 C 21.187 13.583 20.819 15.252 19.535 15.47 L 15.214 16.201 C 14.871 16.259 14.56 16.439 14.339 16.706 L 11.545 20.083 C 10.714 21.087 9.084 20.57 8.983 19.271 Z" fill="rgb(0, 0, 0)" stroke="rgb(255, 255, 255)" stroke-width="2" stroke-miterlimit="10"></path>
                                </svg></div>
                            <div class="absolute left-0 top-0 -translate-x-1/2 px-3 py-1 rounded-full border border-white/80 bg-black/90" style="font-size:10px"><span class="text-white font-medium whitespace-nowrap">Cliquez ici</span></div>
                        </div>
                    </div>
                </div>
                <p class="text-base md:text-lg text-white/70 font-medium">Vous voulez des résultats similaires ? Obtenez votre devis gratuit aujourd'hui</p>
                <p class="text-sm md:text-base text-white/50">Planifiez une consultation gratuite et laissez-nous vous montrer ce qui est possible pour votre entreprise</p>
                <div class="mt-6">
                    <div class="relative w-full py-8">
                        <div class="flex items-center justify-center gap-0">
                            <section class="flex items-center overflow-hidden" style="width:100%;max-width:100%;mask-image:linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%)">
                                <ul class="flex items-center gap-3 list-none m-0 p-0" style="position:relative;flex-direction:row;will-change:transform">
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-dashed border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full border-2 border-white/30"></div>
                                            </div><span class="text-[10px] font-medium text-white/40">CMS</span>
                                        </div>
                                    </li>
                                </ul>
                            </section>
                            <div style="margin-top:5px" class="jsx-19a8fa7e477c8109 relative z-10 flex-shrink-0">
                                <div style="background:linear-gradient(135deg, #00AEEF, #0071BC, #0088D4);animation:subtle-pulse 2s ease-in-out infinite" class="jsx-19a8fa7e477c8109 relative p-[2px] rounded-[12px]">
                                    <div class="jsx-19a8fa7e477c8109 relative px-8 py-4 bg-[#1a1a1a] rounded-[10px] flex items-center justify-center"><img src="{{ asset('logo-white.svg') }}" alt="CodeSommet" class="jsx-19a8fa7e477c8109 h-8 w-auto" /></div>
                                </div>
                            </div>
                            <section class="flex items-center overflow-hidden" style="width:100%;max-width:100%;mask-image:linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgb(0, 0, 0) 12.5%, rgb(0, 0, 0) 87.5%, rgba(0, 0, 0, 0) 100%)">
                                <ul class="flex items-center gap-3 list-none m-0 p-0" style="position:relative;flex-direction:row;will-change:transform">
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">CMS</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">CMS</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Chatbots IA</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Tableaux de Bord</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Automatisation</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">SEO</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Analytique</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Authentification</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">Paiements</span>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0">
                                        <div class="flex items-center gap-3 whitespace-nowrap px-5 py-2.5 rounded-full border border-solid border-white/20 bg-transparent">
                                            <div class="relative w-5 h-5">
                                                <div class="absolute inset-0 rounded-full bg-white flex items-center justify-center"><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 5L4.5 8.5L11 1.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg></div>
                                            </div><span class="text-[10px] font-medium text-white/90">CMS</span>
                                        </div>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection