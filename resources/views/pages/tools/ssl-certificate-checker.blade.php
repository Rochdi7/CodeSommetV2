@extends('layouts.app')

@section('title', 'Vérificateur de Certificat SSL - Vérificateur SSL/TLS Gratuit | CodeSommet')
@section('meta_description', "Vérifiez les certificats SSL/TLS et les avertissements de sécurité pour tout domaine. Vérifiez l'''émetteur, la date d'''expiration, la chaîne de certificat et la version du protocole. Outil gratuit de vérification SSL.")
@section('meta_keywords', 'développement web Maroc,agence développement web IA,agence développement Next.js,développement tableaux de bord,développement SaaS,développement site Éducation,développement site sant?,développement React Maroc,développement TypeScript,développement web mondial,intégration chatbot IA,conception tableau de bord personnalisé,agence web Maroc')
@section('og_title', 'Vérificateur de Certificat SSL - Outil de Sécurité Gratuit')
@section('og_description', "Vérifiez les certificats SSL/TLS et les avertissements de sécurité pour tout domaine. Vérifiez l'''émetteur, la date d'''expiration, la chaîne de certificat et la version du protocole. Outil gratuit de vérification SSL.")
@section('twitter_description', 'Vérifiez les certificats SSL/TLS et les avertissements de sécurité pour tout domaine. Outil de vérification SSL gratuit.')

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
        <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span class="text-black font-medium">Vérificateur de Certificat SSL</span></nav>
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">Vérificateur de Certificat SSL</h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">Vérifiez les certificats SSL/TLS et les avertissements de sécurité pour tout domaine</p>
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
                <div class="space-y-2"><label class="block text-sm font-medium text-black">Nom de Domaine<span class="text-[#00AEEF] ml-1">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-5 h-5" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg></div><input type="text" placeholder="https://example.com" required="" class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60 pl-11" value="" />
                    </div>
                    <p class="text-sm text-gray-500">Entrez l'URL complète avec https://</p>
                </div><button class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full w-full" tabindex="0">Vérifier le Certificat SSL</button>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ce que Cet Outil Vérifie</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-900">Détails du Certificat</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Émetteur et confiance de l'autorité</li>
                        <li>• Date d'expiration et validité</li>
                        <li>• Nom commun et SANs</li>
                        <li>• Détection auto-signé</li>
                    </ul>
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-900">Vérifications de Sécurité</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Version du protocole SSL/TLS</li>
                        <li>• Validité de la chaîne de certificat</li>
                        <li>• Avertissements d'expiration</li>
                        <li>• Recommandations de sécurité</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
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
                    <h3 class="text-base md:text-lg font-semibold text-black">Qu'est-ce qu'un certificat SSL et pourquoi est-il important ?</h3>
                </div>
                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg></div>
            </button>
            <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                <p>Un certificat SSL/TLS chiffre les données transmises entre votre site web et les visiteurs, protégeant les informations sensibles comme les mots de passe et les détails de paiement. C'est essentiel pour la sécurité, la confiance des utilisateurs et le SEO - Google marque les sites HTTP comme 'Non sécurisé' et utilise HTTPS comme facteur de classement. Tous les sites web modernes doivent avoir un certificat SSL valide.</p>
            </div>
        </div>
        <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">2</span></div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-black">À quelle fréquence dois-je vérifier mon certificat SSL ?</h3>
                </div>
                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg></div>
            </button>
            <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                <p>Vérifiez votre certificat SSL mensuellement, surtout 60 à 90 jours avant l'expiration. De nombreux certificats sont valides pendant 90 jours (Let's Encrypt) ou 1 an. Configurez un suivi automatisé ou un renouvellement pour éviter l'expiration, qui cause des avertissements de navigateur et brise la confiance des utilisateurs. La plupart des hébergeurs proposent le renouvellement automatique des certificats SSL.</p>
            </div>
        </div>
        <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">3</span></div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-black">Que signifie 'chaîne de certificat invalide' ?</h3>
                </div>
                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg></div>
            </button>
            <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                <p>La validation de la chaîne de certificat garantit que votre certificat SSL est correctement lié à une Autorité de Certification (CA) de confiance. Une chaîne invalide signifie que des certificats intermédiaires sont manquants ou mal configurés. Cela provoque des avertissements de sécurité du navigateur même si votre certificat est valide. Contactez votre fournisseur SSL ou votre hébergeur pour corriger les problèmes de chaîne de certificat.</p>
            </div>
        </div>
        <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">4</span></div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-black">Un certificat SSL auto-signé est-il sûr à utiliser ?</h3>
                </div>
                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg></div>
            </button>
            <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                <p>Les certificats auto-signés fournissent le chiffrement mais ne sont pas approuvés par les navigateurs - les visiteurs voient des avertissements de sécurité effrayants. Ils conviennent pour les tests internes ou les environnements de développement, mais N'utilisez JAMAIS de certificats auto-signés sur des sites web publics. Utilisez des certificats gratuits de Let's Encrypt ou des certificats payants d'autorités de certification de confiance (DigiCert, Sectigo, GlobalSign) pour les sites de production.</p>
            </div>
        </div>
        <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">5</span></div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-black">Quelle version du protocole SSL/TLS dois-je utiliser ?</h3>
                </div>
                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg></div>
            </button>
            <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                <p>Utilisez TLS 1.2 ou TLS 1.3 (la dernière et la plus sécurisée). Les anciens protocoles (SSL 2.0, SSL 3.0, TLS 1.0, TLS 1.1) ont des vulnérabilités connues et sont obsolètes. Les navigateurs et serveurs modernes supportent TLS 1.2+ par défaut. Désactivez les anciens protocoles dans la configuration de votre serveur pour maintenir une sécurité forte.</p>
            </div>
        </div>
        <div class="border-b border-gray-200 last:border-0"><button class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center"><span class="text-sm font-bold text-[#00AEEF]">6</span></div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-black">Mon certificat SSL expire bientôt - que dois-je faire ?</h3>
                </div>
                <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg></div>
            </button>
            <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed" style="padding-left:3.5rem">
                <p>Renouvelez votre certificat immédiatement s'il expire dans moins de 30 jours. La plupart des fournisseurs SSL envoient des rappels de renouvellement 60 à 90 jours avant l'expiration. Si vous utilisez Let's Encrypt, activez le renouvellement automatique via Certbot. Si vous utilisez un certificat payant, renouvelez auprès de votre fournisseur. Après le renouvellement, mettez à jour la configuration de votre serveur et vérifiez que le nouveau certificat est actif.</p>
            </div>
        </div>
    </div>
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 mb-2">Vous avez encore des questions ?</p><a href="/contact" class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">Contactez notre équipe pour obtenir de l'aide<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg></a>
    </div>
</div>
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
                <p class="text-sm text-white/50 pt-2">50+ projets réussis • Livraison en 48h • Sans engagement à long terme</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/tools-common.js') }}" defer></script>
<script src="{{ asset('js/tools/api-tools.js') }}" defer></script>
@endpush