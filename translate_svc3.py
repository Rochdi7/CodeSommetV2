#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""Second pass: translate remaining English text and fix mixed Fr/En text."""
import os

BASE = os.path.join("c:", os.sep, "Users", "ASUS", "Desktop", "CodeSommetstudio",
                     "pikassostudio.com", "resources", "views", "pages", "services")

files = [
    "language-school-website-development.blade.php",
    "online-course-platform-development.blade.php",
    "real-estate-website-development.blade.php",
    "saas-platform-development.blade.php",
    "study-abroad-website-development.blade.php",
    "telemedicine-website-development.blade.php",
    "university-website-development.blade.php",
]

# These are direct string replacements (old -> new)
# sorted by length descending when applied
replacements = {
    # Fix "pour" that was incorrectly placed (for->pour in English context)
    # and translate remaining full English sentences

    # --- Mixed/corrupted texts that need full replacement ---
    ">Limit\u00e9 API access means you can&#x27;t connect your CRM, email tools, or custom automations. You&#x27;re pourced into their ecosystem with expensive add-ons.<":
        ">L'acc\u00e8s API limit\u00e9 signifie que vous ne pouvez pas connecter votre CRM, outils e-mail ou automatisations personnalis\u00e9es. Vous \u00eates forc\u00e9 dans leur \u00e9cosyst\u00e8me avec des modules compl\u00e9mentaires co\u00fbteux.<",

    ">Managing student inquiries across WhatsApp, email, phone, Instagram, and walk-ins is overwhelming. Counselors pourget follow-ups and students fall through the cracks. Unified communication inbox with automated tracking.<":
        ">G\u00e9rer les demandes \u00e9tudiantes sur WhatsApp, e-mail, t\u00e9l\u00e9phone, Instagram et visites est accablant. Les conseillers oublient les suivis et les \u00e9tudiants passent entre les mailles du filet. Bo\u00eete de r\u00e9ception unifi\u00e9e avec suivi automatis\u00e9.<",

    ">No multilingual support, confusing visa documentation processes, and lack of international payment options deter poureign students who bring higher tuition revenue.<":
        ">L'absence de support multilingue, les processus de documentation de visa confus et le manque d'options de paiement internationales dissuadent les \u00e9tudiants \u00e9trangers qui apportent des revenus de scolarit\u00e9 plus \u00e9lev\u00e9s.<",

    ">Lots de cours, memberships, and drip content scheduling pour student retention.<":
        ">Packs de cours, adh\u00e9sions et planification de contenu progressif pour la r\u00e9tention des \u00e9tudiants.<",

    ">Course comments, Q&amp;A pourums, and direct messaging pour student support.<":
        ">Commentaires de cours, forums Q&amp;R et messagerie directe pour le support \u00e9tudiant.<",

    ">Barres de progression visuelles, completion certificates, and engagement analytics.<":
        ">Barres de progression visuelles, certificats de compl\u00e9tion et analytiques d'engagement.<",

    ">Le Support Multilingue est Co\u00fbteux and Inconsistent<":
        ">Le Support Multilingue est Co\u00fbteux et Incoh\u00e9rent<",

    ">Communication \u00c9tudiante Chaotique Across Channels<":
        ">Communication \u00c9tudiante Chaotique \u00e0 Travers les Canaux<",

    ">Mauvais Classements SEO - Losing Students to Competitors<":
        ">Mauvais Classement SEO - Perte d'\u00c9tudiants au Profit des Concurrents<",

    ">Pas de Qualification de Leads - Time Wasted on Unqualified Students<":
        ">Aucune Qualification de Prospects - Temps Perdu sur des \u00c9tudiants Non Qualifi\u00e9s<",

    ">AI-Powered Health Fonctionnalit\u00e9s<":
        ">Fonctionnalit\u00e9s Sant\u00e9 Aliment\u00e9es par l'IA<",

    ">AI-Powered SaaS Fonctionnalit\u00e9s<":
        ">Fonctionnalit\u00e9s SaaS Aliment\u00e9es par l'IA<",

    ">Chatbot IA pour Student Queries<":
        ">Chatbot IA pour les Questions \u00c9tudiantes<",

    ">50% of Our Clients Are T\u00e9l\u00e9m\u00e9decine Providers<":
        ">50% de Nos Clients sont des Prestataires de T\u00e9l\u00e9m\u00e9decine<",

    ">Limit\u00e9 Customization<":
        ">Personnalisation Limit\u00e9e<",

    ">T\u00e9l\u00e9m\u00e9decine workflow analysis and use case definition<":
        ">Analyse du flux de travail de t\u00e9l\u00e9m\u00e9decine et d\u00e9finition des cas d'utilisation<",

    ">Ready to Transform Your Plateformees de Cours en Ligne Website?<":
        ">Pr\u00eat \u00e0 Transformer Votre Site Web de Plateformes de Cours en Ligne ?<",

    ">Ready to Transform Your Real Estate Website?<":
        ">Pr\u00eat \u00e0 Transformer Votre Site Web Immobilier ?<",

    ">Ready to Transform Your SaaS &amp; B2B Software Website?<":
        ">Pr\u00eat \u00e0 Transformer Votre Site Web SaaS &amp; Logiciels B2B ?<",

    ">Ready to Transform Your Study Abroad &amp; Visa Consultancy Website?<":
        ">Pr\u00eat \u00e0 Transformer Votre Site Web d'\u00c9tudes \u00e0 l'\u00c9tranger &amp; Conseil en Visa ?<",

    ">Ready to Transform Your T\u00e9l\u00e9m\u00e9decine &amp; Virtual Care Website?<":
        ">Pr\u00eat \u00e0 Transformer Votre Site Web de T\u00e9l\u00e9m\u00e9decine &amp; Soins Virtuels ?<",

    ">Ready to Transform Your Universities &amp; Higher Education Website?<":
        ">Pr\u00eat \u00e0 Transformer Votre Site Web d'Universit\u00e9s &amp; Enseignement Sup\u00e9rieur ?<",

    ">Ready to Transform Your \u00c9coles de Langues Website?<":
        ">Pr\u00eat \u00e0 Transformer Votre Site Web d'\u00c9coles de Langues ?<",

    ">Messagerie directe with counselor<":
        ">Messagerie directe avec le conseiller<",

    ">Maquettes haute fid\u00e9lit\u00e9 with country-specific branding<":
        ">Maquettes haute fid\u00e9lit\u00e9 avec marque sp\u00e9cifique au pays<",

    ">Formation du chatbot IA on visa requirements and courses<":
        ">Formation du chatbot IA sur les exigences de visa et les cours<",

    ">Tests cross-device and QA across browsers<":
        ">Tests multi-appareils et QA sur tous les navigateurs<",

    ">Design responsive mobile pour on-the-go students<":
        ">Design responsive mobile pour les \u00e9tudiants en d\u00e9placement<",

    ">Wireframes pour student application workflow<":
        ">Maquettes fil de fer pour le flux de candidature \u00e9tudiant<",

    ">Processing paper applications, manual document verification, and email-based communication is time-consuming. Admissions \u00e9quipes waste 30+ hours per week on repetitive tasks.<":
        ">Le traitement des candidatures papier, la v\u00e9rification manuelle des documents et la communication par e-mail prennent du temps. Les \u00e9quipes d'admission perdent plus de 30 heures par semaine sur des t\u00e2ches r\u00e9p\u00e9titives.<",

    ">7-10 jours pour MVP, 2-3 weeks pour full platform<":
        ">7-10 jours pour le MVP, 2-3 semaines pour la plateforme compl\u00e8te<",

    # --- Full English sentences/paragraphs remaining ---
    ">Build engaging language learning platforms with AI-powered pronunciation feedback, interactive lessons, live tutoring integration, cultural immersion content, and gamified learning experiences that keep students motivated.<":
        ">Cr\u00e9ez des plateformes d'apprentissage des langues engageantes avec retour de prononciation aliment\u00e9 par l'IA, cours interactifs, int\u00e9gration de tutorat en direct, contenu d'immersion culturelle et exp\u00e9riences d'apprentissage ludiques qui maintiennent la motivation des \u00e9tudiants.<",

    ">Expert in building platforms pour language schools with multi-language support, pronunciation tools, grammar checkers, and immersive cultural content that makes language learning engaging and effective.<":
        ">Expert dans la cr\u00e9ation de plateformes pour \u00e9coles de langues avec support multi-langues, outils de prononciation, correcteurs grammaticaux et contenu d'immersion culturelle qui rend l'apprentissage des langues engageant et efficace.<",

    ">Custom AI chatbots that answer student queries 24/7 in multiple languages. Automated lead qualification, instant course recommendations, and personalized follow-ups.<":
        ">Chatbots IA personnalis\u00e9s qui r\u00e9pondent aux questions des \u00e9tudiants 24h/24 et 7j/7 en plusieurs langues. Qualification automatis\u00e9e des prospects, recommandations de cours instantan\u00e9es et suivis personnalis\u00e9s.<",

    ">From inquiry to enrollment - we build the entire ecosystem: landing pages, application portals, document upload systems, payment gateways, student dashboards, and counselor CRM.<":
        ">De la demande \u00e0 l'inscription - nous construisons l'\u00e9cosyst\u00e8me complet : pages d'atterrissage, portails de candidature, syst\u00e8mes de t\u00e9l\u00e9chargement de documents, passerelles de paiement, tableaux de bord \u00e9tudiants et CRM pour conseillers.<",

    # Generic web developers don't understand...
    ">Generic web developers don&#x27;t understand these language schools-specific pain points<":
        ">Les d\u00e9veloppeurs web g\u00e9n\u00e9ralistes ne comprennent pas ces probl\u00e8mes sp\u00e9cifiques aux \u00e9coles de langues<",
    ">Generic web developers don&#x27;t understand these online course platforms-specific pain points<":
        ">Les d\u00e9veloppeurs web g\u00e9n\u00e9ralistes ne comprennent pas ces probl\u00e8mes sp\u00e9cifiques aux plateformes de cours en ligne<",
    ">Generic web developers don&#x27;t understand these real estate-specific pain points<":
        ">Les d\u00e9veloppeurs web g\u00e9n\u00e9ralistes ne comprennent pas ces probl\u00e8mes sp\u00e9cifiques \u00e0 l'immobilier<",
    ">Generic web developers don&#x27;t understand these saas &amp; b2b software-specific pain points<":
        ">Les d\u00e9veloppeurs web g\u00e9n\u00e9ralistes ne comprennent pas ces probl\u00e8mes sp\u00e9cifiques au SaaS &amp; logiciels B2B<",
    ">Generic web developers don&#x27;t understand these study abroad &amp; visa consultancy-specific pain points<":
        ">Les d\u00e9veloppeurs web g\u00e9n\u00e9ralistes ne comprennent pas ces probl\u00e8mes sp\u00e9cifiques aux \u00e9tudes \u00e0 l'\u00e9tranger &amp; conseil en visa<",
    ">Generic web developers don&#x27;t understand these telemedicine &amp; virtual care-specific pain points<":
        ">Les d\u00e9veloppeurs web g\u00e9n\u00e9ralistes ne comprennent pas ces probl\u00e8mes sp\u00e9cifiques \u00e0 la t\u00e9l\u00e9m\u00e9decine &amp; soins virtuels<",
    ">Generic web developers don&#x27;t understand these universities &amp; higher education-specific pain points<":
        ">Les d\u00e9veloppeurs web g\u00e9n\u00e9ralistes ne comprennent pas ces probl\u00e8mes sp\u00e9cifiques aux universit\u00e9s &amp; enseignement sup\u00e9rieur<",

    # Everything your X business needs
    ">Everything your language schools business needs in one platform<":
        ">Tout ce dont votre entreprise d'\u00e9cole de langues a besoin en une seule plateforme<",
    ">Everything your online course platforms business needs in one platform<":
        ">Tout ce dont votre entreprise de cours en ligne a besoin en une seule plateforme<",
    ">Everything your real estate business needs in one platform<":
        ">Tout ce dont votre entreprise immobili\u00e8re a besoin en une seule plateforme<",
    ">Everything your saas &amp; b2b software business needs in one platform<":
        ">Tout ce dont votre entreprise SaaS &amp; logiciels B2B a besoin en une seule plateforme<",
    ">Everything your study abroad &amp; visa consultancy business needs in one platform<":
        ">Tout ce dont votre entreprise de conseil en \u00e9tudes \u00e0 l'\u00e9tranger &amp; visa a besoin en une seule plateforme<",
    ">Everything your telemedicine &amp; virtual care business needs in one platform<":
        ">Tout ce dont votre entreprise de t\u00e9l\u00e9m\u00e9decine &amp; soins virtuels a besoin en une seule plateforme<",
    ">Everything your universities &amp; higher education business needs in one platform<":
        ">Tout ce dont votre entreprise d'universit\u00e9s &amp; enseignement sup\u00e9rieur a besoin en une seule plateforme<",

    # From concept to launch...
    ">From concept to launch in 4 weeks, optimized pour language schools businesses<":
        ">Du concept au lancement en 4 semaines, optimis\u00e9 pour les entreprises d'\u00e9coles de langues<",
    ">From concept to launch in 4 weeks, optimized pour online course platforms businesses<":
        ">Du concept au lancement en 4 semaines, optimis\u00e9 pour les entreprises de cours en ligne<",
    ">From concept to launch in 4 weeks, optimized pour real estate businesses<":
        ">Du concept au lancement en 4 semaines, optimis\u00e9 pour les entreprises immobili\u00e8res<",
    ">From concept to launch in 4 weeks, optimized pour saas &amp; b2b software businesses<":
        ">Du concept au lancement en 4 semaines, optimis\u00e9 pour les entreprises SaaS &amp; logiciels B2B<",
    ">From concept to launch in 4 weeks, optimized pour study abroad &amp; visa consultancy businesses<":
        ">Du concept au lancement en 4 semaines, optimis\u00e9 pour les entreprises de conseil en \u00e9tudes \u00e0 l'\u00e9tranger &amp; visa<",
    ">From concept to launch in 4 weeks, optimized pour telemedicine &amp; virtual care businesses<":
        ">Du concept au lancement en 4 semaines, optimis\u00e9 pour les entreprises de t\u00e9l\u00e9m\u00e9decine &amp; soins virtuels<",
    ">From concept to launch in 4 weeks, optimized pour universities &amp; higher education businesses<":
        ">Du concept au lancement en 4 semaines, optimis\u00e9 pour les entreprises d'universit\u00e9s &amp; enseignement sup\u00e9rieur<",

    # We've built X websites...
    ">We&#x27;ve built language schools websites pour clients across the globe. Whether you&#x27;re in Morocco or anywhere else, we deliver world-class solutions.<":
        ">Nous avons cr\u00e9\u00e9 des sites web pour \u00e9coles de langues pour des clients du monde entier. Que vous soyez au Maroc ou ailleurs, nous livrons des solutions de classe mondiale.<",
    ">We&#x27;ve built online course platforms websites pour clients across the globe. Whether you&#x27;re in Morocco or anywhere else, we deliver world-class solutions.<":
        ">Nous avons cr\u00e9\u00e9 des sites web de plateformes de cours en ligne pour des clients du monde entier. Que vous soyez au Maroc ou ailleurs, nous livrons des solutions de classe mondiale.<",
    ">We&#x27;ve built real estate websites pour clients across the globe. Whether you&#x27;re in Morocco or anywhere else, we deliver world-class solutions.<":
        ">Nous avons cr\u00e9\u00e9 des sites web immobiliers pour des clients du monde entier. Que vous soyez au Maroc ou ailleurs, nous livrons des solutions de classe mondiale.<",
    ">We&#x27;ve built saas &amp; b2b software websites pour clients across the globe. Whether you&#x27;re in Morocco or anywhere else, we deliver world-class solutions.<":
        ">Nous avons cr\u00e9\u00e9 des sites web SaaS &amp; logiciels B2B pour des clients du monde entier. Que vous soyez au Maroc ou ailleurs, nous livrons des solutions de classe mondiale.<",
    ">We&#x27;ve built study abroad &amp; visa consultancy websites pour clients across the globe. Whether you&#x27;re in Morocco or anywhere else, we deliver world-class solutions.<":
        ">Nous avons cr\u00e9\u00e9 des sites web d'\u00e9tudes \u00e0 l'\u00e9tranger &amp; conseil en visa pour des clients du monde entier. Que vous soyez au Maroc ou ailleurs, nous livrons des solutions de classe mondiale.<",
    ">We&#x27;ve built telemedicine &amp; virtual care websites pour clients across the globe. Whether you&#x27;re in Morocco or anywhere else, we deliver world-class solutions.<":
        ">Nous avons cr\u00e9\u00e9 des sites web de t\u00e9l\u00e9m\u00e9decine &amp; soins virtuels pour des clients du monde entier. Que vous soyez au Maroc ou ailleurs, nous livrons des solutions de classe mondiale.<",
    ">We&#x27;ve built universities &amp; higher education websites pour clients across the globe. Whether you&#x27;re in Morocco or anywhere else, we deliver world-class solutions.<":
        ">Nous avons cr\u00e9\u00e9 des sites web d'universit\u00e9s &amp; enseignement sup\u00e9rieur pour des clients du monde entier. Que vous soyez au Maroc ou ailleurs, nous livrons des solutions de classe mondiale.<",

    # Testimonials
    ">&quot;CodeSommetStudio transformed our B2B platform and generated 250% more qualified leads in just 6 months. Their understanding of the market and tech expertise is unmatched.&quot;<":
        ">&quot;CodeSommetStudio a transform\u00e9 notre plateforme B2B et g\u00e9n\u00e9r\u00e9 250% de prospects qualifi\u00e9s en plus en seulement 6 mois. Leur compr\u00e9hension du march\u00e9 et leur expertise technologique sont in\u00e9gal\u00e9es.&quot;<",
    ">&quot;Working remotely with CodeSommetStudio was seamless. They delivered our healthcare booking platform in 10 days with full DHA compliance. The patient portal is loved by our clients.&quot;<":
        ">&quot;Travailler \u00e0 distance avec CodeSommetStudio a \u00e9t\u00e9 fluide. Ils ont livr\u00e9 notre plateforme de r\u00e9servation de soins en 10 jours avec une conformit\u00e9 DHA compl\u00e8te. Le portail patient est ador\u00e9 par nos clients.&quot;<",
    ">&quot;We needed a complex e-learning platform with live video, progress tracking, and payment integration. CodeSommetStudio delivered everything in 3 weeks at a fraction of what UK agencies quoted.&quot;<":
        ">&quot;Nous avions besoin d'une plateforme e-learning complexe avec vid\u00e9o en direct, suivi des progr\u00e8s et int\u00e9gration de paiement. CodeSommetStudio a tout livr\u00e9 en 3 semaines pour une fraction du prix propos\u00e9 par les agences britanniques.&quot;<",
    ">&quot;Our real estate website went from basic listings to a full booking platform with virtual tours and CRM integration. Online inquiries jumped 400% in the first quarter.&quot;<":
        ">&quot;Notre site web immobilier est pass\u00e9 de simples annonces \u00e0 une plateforme de r\u00e9servation compl\u00e8te avec visites virtuelles et int\u00e9gration CRM. Les demandes en ligne ont bondi de 400% au premier trimestre.&quot;<",

    # FAQ questions
    ">How long does it take to build a language school website?<":
        ">Combien de temps faut-il pour cr\u00e9er un site web d'\u00e9cole de langues ?<",
    ">Can the AI chatbot handle student queries in multiple languages?<":
        ">Le chatbot IA peut-il g\u00e9rer les questions des \u00e9tudiants en plusieurs langues ?<",
    ">What CRM systems do you integrate with?<":
        ">Avec quels syst\u00e8mes CRM vous int\u00e9grez-vous ?<",
    ">Can you build a student application portal with document uploads?<":
        ">Pouvez-vous cr\u00e9er un portail de candidature \u00e9tudiant avec t\u00e9l\u00e9chargement de documents ?<",
    ">Do you support multiple currencies and payment gateways?<":
        ">Supportez-vous plusieurs devises et passerelles de paiement ?<",
    ">What makes you different from other web developers?<":
        ">Qu'est-ce qui vous diff\u00e9rencie des autres d\u00e9veloppeurs web ?<",
    ">How long does it take to migrate from Teachable or Kajabi?<":
        ">Combien de temps faut-il pour migrer depuis Teachable ou Kajabi ?<",
    ">Can I offer subscriptions and payment plans?<":
        ">Puis-je proposer des abonnements et des plans de paiement ?<",
    ">What video hosting do you use?<":
        ">Quel h\u00e9bergement vid\u00e9o utilisez-vous ?<",
    ">What if I need features that Teachable doesn&#x27;t have?<":
        ">Et si j'ai besoin de fonctionnalit\u00e9s que Teachable n'offre pas ?<",
    ">Do you support drip content and course scheduling?<":
        ">Supportez-vous le contenu progressif et la planification de cours ?<",
    ">Will I lose students during the migration?<":
        ">Vais-je perdre des \u00e9tudiants pendant la migration ?<",
    ">Will my custom platform have better SEO than Teachable?<":
        ">Ma plateforme personnalis\u00e9e aura-t-elle un meilleur SEO que Teachable ?<",
    ">How much can I save by switching to my own platform?<":
        ">Combien puis-je \u00e9conomiser en passant \u00e0 ma propre plateforme ?<",
    ">How long does it take to build a real estate website?<":
        ">Combien de temps faut-il pour cr\u00e9er un site web immobilier ?<",
    ">Do you include virtual tour and 360\u00b0 viewing features?<":
        ">Incluez-vous les visites virtuelles et les fonctionnalit\u00e9s de vue \u00e0 360\u00b0 ?<",
    ">Do you include advanced search filters and map integration?<":
        ">Incluez-vous des filtres de recherche avanc\u00e9s et l'int\u00e9gration de carte ?<",
    ">How does the lead management CRM work?<":
        ">Comment fonctionne le CRM de gestion de prospects ?<",
    ">Can agents manage their own listings on the platform?<":
        ">Les agents peuvent-ils g\u00e9rer leurs propres annonces sur la plateforme ?<",
    ">Can buyers save favorite properties and create accounts?<":
        ">Les acheteurs peuvent-ils sauvegarder leurs biens favoris et cr\u00e9er des comptes ?<",
    ">Can you integrate MLS data into our property portal?<":
        ">Pouvez-vous int\u00e9grer les donn\u00e9es MLS dans notre portail immobilier ?<",
    ">Do you help with real estate SEO and Google Ads?<":
        ">Aidez-vous avec le SEO immobilier et Google Ads ?<",
    ">How long does it take to build a SaaS platform?<":
        ">Combien de temps faut-il pour cr\u00e9er une plateforme SaaS ?<",
    ">Can you build a white-label SaaS platform?<":
        ">Pouvez-vous cr\u00e9er une plateforme SaaS en marque blanche ?<",
    ">Do you support API development and documentation?<":
        ">Supportez-vous le d\u00e9veloppement et la documentation d'API ?<",
    ">What billing systems do you integrate with?<":
        ">Avec quels syst\u00e8mes de facturation vous int\u00e9grez-vous ?<",
    ">Can the platform scale to 10,000+ users?<":
        ">La plateforme peut-elle passer \u00e0 l'\u00e9chelle pour plus de 10 000 utilisateurs ?<",
    ">Do you provide content writing pour SaaS platforms?<":
        ">Fournissez-vous la r\u00e9daction de contenu pour les plateformes SaaS ?<",
    ">Can you help with SEO and paid ads pour SaaS platforms?<":
        ">Pouvez-vous aider avec le SEO et la publicit\u00e9 payante pour les plateformes SaaS ?<",
    ">What makes you different from other SaaS developers?<":
        ">Qu'est-ce qui vous diff\u00e9rencie des autres d\u00e9veloppeurs SaaS ?<",
    ">How long does it take to build a study abroad website?<":
        ">Combien de temps faut-il pour cr\u00e9er un site web d'\u00e9tudes \u00e0 l'\u00e9tranger ?<",
    ">Can you build a visa document tracking system?<":
        ">Pouvez-vous cr\u00e9er un syst\u00e8me de suivi de documents de visa ?<",
    ">Can the AI chatbot handle visa queries in multiple languages?<":
        ">Le chatbot IA peut-il g\u00e9rer les questions de visa en plusieurs langues ?<",
    ">Can students track their application status online?<":
        ">Les \u00e9tudiants peuvent-ils suivre le statut de leur candidature en ligne ?<",
    ">Do you provide content writing pour study abroad websites?<":
        ">Fournissez-vous la r\u00e9daction de contenu pour les sites web d'\u00e9tudes \u00e0 l'\u00e9tranger ?<",
    ">Can you help with Google Ads and SEO pour study abroad keywords?<":
        ">Pouvez-vous aider avec Google Ads et le SEO pour les mots-cl\u00e9s \u00e9tudes \u00e0 l'\u00e9tranger ?<",
    ">How long does it take to build a telemedicine platform?<":
        ">Combien de temps faut-il pour cr\u00e9er une plateforme de t\u00e9l\u00e9m\u00e9decine ?<",
    ">Is your telemedicine platform HIPAA compliant?<":
        ">Votre plateforme de t\u00e9l\u00e9m\u00e9decine est-elle conforme HIPAA ?<",
    ">What video platform do you use pour consultations?<":
        ">Quelle plateforme vid\u00e9o utilisez-vous pour les consultations ?<",
    ">Can you integrate with our existing EMR system?<":
        ">Pouvez-vous vous int\u00e9grer \u00e0 notre syst\u00e8me DME existant ?<",
    ">How do you handle prescription management?<":
        ">Comment g\u00e9rez-vous la gestion des prescriptions ?<",
    ">Do you support international telemedicine services?<":
        ">Supportez-vous les services de t\u00e9l\u00e9m\u00e9decine internationaux ?<",
    ">Can you help with marketing our telemedicine platform?<":
        ">Pouvez-vous aider \u00e0 commercialiser notre plateforme de t\u00e9l\u00e9m\u00e9decine ?<",
    ">Can the AI symptom checker handle medical triage?<":
        ">Le v\u00e9rificateur de sympt\u00f4mes IA peut-il g\u00e9rer le triage m\u00e9dical ?<",
    ">How long does it take to build a university website with student portal?<":
        ">Combien de temps faut-il pour cr\u00e9er un site web universitaire avec portail \u00e9tudiant ?<",
    ">Can we manage multiple campuses from one system?<":
        ">Pouvons-nous g\u00e9rer plusieurs campus depuis un seul syst\u00e8me ?<",
    ">Can you integrate with our existing LMS (Moodle, Canvas, Blackboard)?<":
        ">Pouvez-vous vous int\u00e9grer \u00e0 notre LMS existant (Moodle, Canvas, Blackboard) ?<",
    ">Is the system FERPA compliant pour student data protection?<":
        ">Le syst\u00e8me est-il conforme FERPA pour la protection des donn\u00e9es \u00e9tudiantes ?<",
    ">Do you provide training pour admissions staff and faculty?<":
        ">Fournissez-vous une formation pour le personnel d'admission et les enseignants ?<",
    ">Can international students apply and pay in their local currency?<":
        ">Les \u00e9tudiants internationaux peuvent-ils postuler et payer dans leur devise locale ?<",
    ">How do you handle document verification pour admissions?<":
        ">Comment g\u00e9rez-vous la v\u00e9rification des documents pour les admissions ?<",

    # Long description texts
    ">Custom online course platform development pour coaches, course creators, and educators. We&#x27;ve built 30+ course platforms with video hosting, membership management, and payment optimization.<":
        ">D\u00e9veloppement de plateformes de cours en ligne sur mesure pour coachs, cr\u00e9ateurs de cours et \u00e9ducateurs. Nous avons cr\u00e9\u00e9 plus de 30 plateformes de cours avec h\u00e9bergement vid\u00e9o, gestion des adh\u00e9sions et optimisation des paiements.<",

    ">We&#x27;ve built 40+ online learning platforms. We understand course delivery, student engagement, and creator monetization.<":
        ">Nous avons cr\u00e9\u00e9 plus de 40 plateformes d'apprentissage en ligne. Nous comprenons la diffusion de cours, l'engagement \u00e9tudiant et la mon\u00e9tisation des cr\u00e9ateurs.<",

    ">We&#x27;ve built 40+ university websites and portals. We understand admissions funnels, student lifecycle management, and alumni engagement.<":
        ">Nous avons cr\u00e9\u00e9 plus de 40 sites web et portails universitaires. Nous comprenons les entonnoirs d'admission, la gestion du cycle de vie \u00e9tudiant et l'engagement des anciens.<",

    ">Teachable takes 5% + Stripe fees. Kajabi and similar platforms charge hefty monthly fees. The more you earn, the more you pay just to host your courses.<":
        ">Teachable prend 5% + frais Stripe. Kajabi et les plateformes similaires facturent des frais mensuels \u00e9lev\u00e9s. Plus vous gagnez, plus vous payez juste pour h\u00e9berger vos cours.<",

    ">Template-based platforms restrict your branding, design, and user experience. You can&#x27;t match your brand identity or create unique course experiences.<":
        ">Les plateformes bas\u00e9es sur des mod\u00e8les restreignent votre marque, design et exp\u00e9rience utilisateur. Vous ne pouvez pas correspondre \u00e0 votre identit\u00e9 de marque ou cr\u00e9er des exp\u00e9riences de cours uniques.<",

    ">Generic course players, limited engagement features, and competitor branding hurt your authority. Students see you as &quot;just another course on Teachable&quot;.<":
        ">Les lecteurs de cours g\u00e9n\u00e9riques, les fonctionnalit\u00e9s d'engagement limit\u00e9es et la marque des concurrents nuisent \u00e0 votre autorit\u00e9. Les \u00e9tudiants vous voient comme &quot;juste un autre cours sur Teachable&quot;.<",

    ">If Teachable/Kajabi changes pricing, shuts down, or modifies features, you&#x27;re stuck. You don&#x27;t own your platform or student relationships.<":
        ">Si Teachable/Kajabi change ses tarifs, ferme ou modifie ses fonctionnalit\u00e9s, vous \u00eates bloqu\u00e9. Vous ne poss\u00e9dez ni votre plateforme ni vos relations \u00e9tudiantes.<",

    ">Course platforms give you a subdomain (yourname.teachable.com) which hurts SEO. Custom domains with proper SEO rank 10x better on Google.<":
        ">Les plateformes de cours vous donnent un sous-domaine (votrenom.teachable.com) qui nuit au SEO. Les domaines personnalis\u00e9s avec un bon SEO se classent 10x mieux sur Google.<",

    # Real estate long texts
    ">Custom property portals with advanced search, virtual tours, agent dashboards, and MLS integration to help real estate agencies, brokers, and property management companies generate more leads and close deals faster.<":
        ">Portails immobiliers sur mesure avec recherche avanc\u00e9e, visites virtuelles, tableaux de bord agents et int\u00e9gration MLS pour aider les agences immobili\u00e8res, courtiers et soci\u00e9t\u00e9s de gestion immobili\u00e8re \u00e0 g\u00e9n\u00e9rer plus de prospects et conclure des affaires plus rapidement.<",

    ">Traditional search is limited and frustrating. Buyers need powerful filters, map views, and saved searches to discover their perfect property quickly.<":
        ">La recherche traditionnelle est limit\u00e9e et frustrante. Les acheteurs ont besoin de filtres puissants, de vues carte et de recherches sauvegard\u00e9es pour d\u00e9couvrir rapidement leur bien id\u00e9al.<",

    ">In-person showings are time-consuming and inconvenient. Virtual tours allow buyers to explore properties remotely beforee committing to visits.<":
        ">Les visites en personne sont chronophages et peu pratiques. Les visites virtuelles permettent aux acheteurs d'explorer les biens \u00e0 distance avant de s'engager \u00e0 visiter.<",

    ">Manual lead follow-up means lost opportunities. Automated CRM workflows ensure every inquiry gets timely responses and nurturing.<":
        ">Le suivi manuel des prospects signifie des opportunit\u00e9s perdues. Les workflows CRM automatis\u00e9s garantissent que chaque demande re\u00e7oit des r\u00e9ponses et un suivi en temps opportun.<",

    ">Agents juggle spreadsheets, emails, and calendars. A unified dashboard streamlines listing management, lead tracking, and scheduling.<":
        ">Les agents jonglent entre tableurs, e-mails et calendriers. Un tableau de bord unifi\u00e9 simplifie la gestion des annonces, le suivi des prospects et la planification.<",

    ">Buyers and sellers lack pricing transparency. Real-time market analytics, neighborhood data, and comparable property insights enable informed decisions.<":
        ">Les acheteurs et vendeurs manquent de transparence sur les prix. Les analytiques de march\u00e9 en temps r\u00e9el, les donn\u00e9es de quartier et les informations sur les biens comparables permettent des d\u00e9cisions \u00e9clair\u00e9es.<",

    ">Manual listing updates lead to inaccuracies. MLS integration ensures properties are always current, avoiding buyer disappointment and wasted time.<":
        ">Les mises \u00e0 jour manuelles des annonces entra\u00eenent des inexactitudes. L'int\u00e9gration MLS garantit que les biens sont toujours \u00e0 jour, \u00e9vitant la d\u00e9ception des acheteurs et le temps perdu.<",

    # SaaS long texts
    ">Specialized SaaS platform development pour B2B software companies, cloud service providers, and tech startups. We&#x27;ve built 50+ SaaS platforms with scalable architecture, real-time features, and subscription billing.<":
        ">D\u00e9veloppement sp\u00e9cialis\u00e9 de plateformes SaaS pour les entreprises de logiciels B2B, fournisseurs de services cloud et startups tech. Nous avons cr\u00e9\u00e9 plus de 50 plateformes SaaS avec architecture \u00e9volutive, fonctionnalit\u00e9s en temps r\u00e9el et facturation par abonnement.<",

    ">Deep expertise in B2B software, cloud platforms, and subscription services. We understand user onboarding, churn reduction, and product-led growth strategies.<":
        ">Expertise approfondie en logiciels B2B, plateformes cloud et services par abonnement. Nous comprenons l'onboarding utilisateur, la r\u00e9duction du churn et les strat\u00e9gies de croissance orient\u00e9es produit.<",

    ">Custom AI analytics, recommendation engines, and intelligent automation tailored pour SaaS. Predictive insights, usage pattern analysis, and smart notifications.<":
        ">Analytiques IA personnalis\u00e9es, moteurs de recommandation et automatisation intelligente adapt\u00e9s au SaaS. Insights pr\u00e9dictifs, analyse des patterns d'utilisation et notifications intelligentes.<",

    ">SaaS platforms optimized pour PLG (Product-Led Growth) and viral loops. Our SaaS clients see average 400% increase in trial-to-paid conversions.<":
        ">Plateformes SaaS optimis\u00e9es pour le PLG (Product-Led Growth) et les boucles virales. Nos clients SaaS voient une augmentation moyenne de 400% des conversions essai-payant.<",

    ">Launch your SaaS MVP in 7-10 jours to validate product-market fit. Agile development process designed pour rapid iteration and investor demos.<":
        ">Lancez votre MVP SaaS en 7-10 jours pour valider l'ad\u00e9quation produit-march\u00e9. Processus de d\u00e9veloppement agile con\u00e7u pour l'it\u00e9ration rapide et les d\u00e9mos investisseurs.<",

    ">From signup to paid conversion - we build the entire ecosystem: onboarding flows, feature discovery, upgrade prompts, retention campaigns, and billing portals.<":
        ">De l'inscription \u00e0 la conversion payante - nous construisons l'\u00e9cosyst\u00e8me complet : flux d'onboarding, d\u00e9couverte de fonctionnalit\u00e9s, invitations de mise \u00e0 niveau, campagnes de r\u00e9tention et portails de facturation.<",

    ">Users sign up but abandon your SaaS within days. Confusing onboarding flows and unclear value propositions kill retention. You need guided tours, progress tracking, and activation emails.<":
        ">Les utilisateurs s'inscrivent mais abandonnent votre SaaS en quelques jours. Des flux d'onboarding confus et des propositions de valeur peu claires tuent la r\u00e9tention. Vous avez besoin de visites guid\u00e9es, de suivis de progression et d'e-mails d'activation.<",

    ">Customers demand Zapier, Slack, and CRM integrations but building each one takes months. You need a unified API strategy and pre-built connectors pour common tools.<":
        ">Les clients demandent des int\u00e9grations Zapier, Slack et CRM mais en construire chacune prend des mois. Vous avez besoin d'une strat\u00e9gie API unifi\u00e9e et de connecteurs pr\u00e9-construits pour les outils courants.<",

    ">Your prototype works pour 10 users but crashes with 100. You need enterprise-grade infrastructure with load balancing, caching, and database optimization from day one.<":
        ">Votre prototype fonctionne pour 10 utilisateurs mais plante avec 100. Vous avez besoin d'une infrastructure de niveau entreprise avec \u00e9quilibrage de charge, mise en cache et optimisation de base de donn\u00e9es d\u00e8s le premier jour.<",

    ">Spending hours managing subscriptions, upgrades, and failed payments manually. You need automated recurring billing, proration, dunning management, and self-service portals.<":
        ">Passer des heures \u00e0 g\u00e9rer manuellement les abonnements, les mises \u00e0 niveau et les paiements \u00e9chou\u00e9s. Vous avez besoin de facturation r\u00e9currente automatis\u00e9e, de prorata, de gestion des relances et de portails en libre-service.<",

    ">Developers struggle to integrate with your SaaS because docs are incomplete or wrong. You need auto-generated API docs, interactive sandboxes, and webhook testing tools.<":
        ">Les d\u00e9veloppeurs peinent \u00e0 s'int\u00e9grer \u00e0 votre SaaS car la documentation est incompl\u00e8te ou erron\u00e9e. Vous avez besoin de documentation API auto-g\u00e9n\u00e9r\u00e9e, de bacs \u00e0 sable interactifs et d'outils de test de webhooks.<",

    ">Flying blind without knowing which features users love or ignore. You need event tracking, funnel analytics, cohort analysis, and user session recordings to make data-driven decisions.<":
        ">Naviguer \u00e0 l'aveugle sans savoir quelles fonctionnalit\u00e9s les utilisateurs adorent ou ignorent. Vous avez besoin de suivi d'\u00e9v\u00e9nements, d'analytiques d'entonnoir, d'analyse de cohortes et d'enregistrements de sessions utilisateurs pour prendre des d\u00e9cisions bas\u00e9es sur les donn\u00e9es.<",

    # Study abroad long texts
    ">Specialized study abroad website development pour overseas education consultancies, visa agencies, and university placement services. We&#x27;ve built 40+ study abroad platforms with student portals, document tracking, and multilingual support.<":
        ">D\u00e9veloppement sp\u00e9cialis\u00e9 de sites web d'\u00e9tudes \u00e0 l'\u00e9tranger pour les cabinets de conseil en \u00e9ducation internationale, agences de visa et services de placement universitaire. Nous avons cr\u00e9\u00e9 plus de 40 plateformes avec portails \u00e9tudiants, suivi de documents et support multilingue.<",

    ">Deep expertise in overseas education, visa processing, university applications, and student recruitment. We understand country-specific requirements pour USA, UK, Canada, Germany, and more.<":
        ">Expertise approfondie en \u00e9ducation internationale, traitement de visa, candidatures universitaires et recrutement \u00e9tudiant. Nous comprenons les exigences sp\u00e9cifiques par pays pour les USA, le Royaume-Uni, le Canada, l'Allemagne et plus.<",

    ">Custom AI chatbots trained on visa requirements, university eligibility, and country-specific queries. Answer 1000+ student questions instantly in 50+ languages.<":
        ">Chatbots IA personnalis\u00e9s form\u00e9s sur les exigences de visa, l'\u00e9ligibilit\u00e9 universitaire et les requ\u00eates sp\u00e9cifiques par pays. R\u00e9pondez instantan\u00e9ment \u00e0 plus de 1000 questions d'\u00e9tudiants en 50+ langues.<",

    ">From inquiry to visa approval - we build the entire ecosystem: landing pages, application portals, document upload, visa tracking, payment gateways, and counselor CRM.<":
        ">De la demande \u00e0 l'approbation du visa - nous construisons l'\u00e9cosyst\u00e8me complet : pages d'atterrissage, portails de candidature, t\u00e9l\u00e9chargement de documents, suivi de visa, passerelles de paiement et CRM pour conseillers.<",

    ">Study abroad websites optimized pour Google Ads (Study in USA, MS in Germany). Our clients see average 300% increase in qualified student leads.<":
        ">Sites web d'\u00e9tudes \u00e0 l'\u00e9tranger optimis\u00e9s pour Google Ads (\u00c9tudier aux USA, MS en Allemagne). Nos clients voient une augmentation moyenne de 300% des prospects \u00e9tudiants qualifi\u00e9s.<",

    ">Support pour 50+ languages and 20+ currencies. Essential pour recruiting students from India, Bangladesh, Pakistan, Nepal, Nigeria, and Moyen-Orient.<":
        ">Support de plus de 50 langues et 20+ devises. Essentiel pour recruter des \u00e9tudiants d'Inde, du Bangladesh, du Pakistan, du N\u00e9pal, du Nigeria et du Moyen-Orient.<",

    ">Multi-language support, country-specific content, and global payment gateways built-in.<":
        ">Support multi-langues, contenu sp\u00e9cifique par pays et passerelles de paiement mondiales int\u00e9gr\u00e9s.<",

    ">From discovery call to live website in 7-10 jours. Start attracting and enrolling students within 2 weeks.<":
        ">De l'appel d\u00e9couverte au site web en ligne en 7-10 jours. Commencez \u00e0 attirer et inscrire des \u00e9tudiants en 2 semaines.<",

    ">From discovery call to live course platform in 7-10 jours. Start selling courses and enrolling students within 2 weeks.<":
        ">De l'appel d\u00e9couverte \u00e0 la plateforme de cours en ligne en 7-10 jours. Commencez \u00e0 vendre des cours et inscrire des \u00e9tudiants en 2 semaines.<",

    ">Wix and WordPress can&#x27;t handle complex student application workflows, visa document requirements, or country-specific processes needed pour international education consultancies.<":
        ">Wix et WordPress ne peuvent pas g\u00e9rer les flux de candidature \u00e9tudiante complexes, les exigences de documents de visa ou les processus sp\u00e9cifiques par pays n\u00e9cessaires pour l'\u00e9ducation internationale.<",

    ">Counselors spend 20+ hours per week answering basic questions from students who don&#x27;t meet eligibility criteria or can&#x27;t afford programs. AI-powered eligibility checkers, chatbots, and pre-qualification forms reduce counselor workload by 70%.<":
        ">Les conseillers passent plus de 20 heures par semaine \u00e0 r\u00e9pondre \u00e0 des questions basiques d'\u00e9tudiants qui ne remplissent pas les crit\u00e8res d'\u00e9ligibilit\u00e9 ou ne peuvent pas se permettre les programmes. Les v\u00e9rificateurs d'\u00e9ligibilit\u00e9 et chatbots aliment\u00e9s par l'IA r\u00e9duisent la charge de travail des conseillers de 70%.<",

    ">Tracking student documents (passports, transcripts, financial statements, recommendation letters) via email and Google Drive leads to missed deadlines and visa rejections. Secure document upload portals with automated checklists and deadline reminders.<":
        ">Suivre les documents \u00e9tudiants (passeports, relev\u00e9s de notes, \u00e9tats financiers, lettres de recommandation) par e-mail et Google Drive entra\u00eene des dates limites manqu\u00e9es et des refus de visa. Portails de t\u00e9l\u00e9chargement s\u00e9curis\u00e9s avec listes de v\u00e9rification automatis\u00e9es et rappels de dates limites.<",

    ">Hiring translators or agencies pour Hindi, Arabic, Spanish content is costly (costly per language). Inconsistent terminology confuses students. Built-in multilingual CMS with AI-assisted translation.<":
        ">Engager des traducteurs ou agences pour du contenu en hindi, arabe, espagnol est co\u00fbteux (co\u00fbteux par langue). La terminologie incoh\u00e9rente embrouille les \u00e9tudiants. CMS multilingue int\u00e9gr\u00e9 avec traduction assist\u00e9e par l'IA.<",

    ">Complex application forms, slow response times, and poor mobile experience cause 60% of started applications to be abandoned. You&#x27;re losing qualified students to competitors.<":
        ">Les formulaires de candidature complexes, les temps de r\u00e9ponse lents et la mauvaise exp\u00e9rience mobile font abandonner 60% des candidatures commenc\u00e9es. Vous perdez des \u00e9tudiants qualifi\u00e9s au profit des concurrents.<",

    ">Your website doesn&#x27;t rank pour &#x27;study in [country]&#x27; keywords. Competitors with better SEO capture 70% of organic traffic and you rely on expensive Google Ads. Technical SEO, content strategies, and local optimization included.<":
        ">Votre site web n'est pas class\u00e9 pour les mots-cl\u00e9s '\u00e9tudier dans [pays]'. Les concurrents avec un meilleur SEO captent 70% du trafic organique et vous comptez sur des publicit\u00e9s payantes co\u00fbteuses. SEO technique, strat\u00e9gies de contenu et optimisation locale inclus.<",

    # Telemedicine long texts
    ">Specialized telemedicine platform development pour virtual clinics, online doctors, and remote care providers. We&#x27;ve built 20+ telehealth platforms with secure video consultation, patient portals, and HIPAA compliance.<":
        ">D\u00e9veloppement sp\u00e9cialis\u00e9 de plateformes de t\u00e9l\u00e9m\u00e9decine pour les cliniques virtuelles, m\u00e9decins en ligne et prestataires de soins \u00e0 distance. Nous avons cr\u00e9\u00e9 plus de 20 plateformes de t\u00e9l\u00e9sant\u00e9 avec consultation vid\u00e9o s\u00e9curis\u00e9e, portails patients et conformit\u00e9 HIPAA.<",

    ">Deep expertise in virtual care platforms, online consultation systems, and remote patient monitoring. We understand HIPAA compliance, video quality requirements, and patient engagement.<":
        ">Expertise approfondie en plateformes de soins virtuels, syst\u00e8mes de consultation en ligne et surveillance \u00e0 distance des patients. Nous comprenons la conformit\u00e9 HIPAA, les exigences de qualit\u00e9 vid\u00e9o et l'engagement des patients.<",

    ">Custom AI symptom checkers and chatbots pour patient triage. Pre-consultation screening reduces doctor time by 40% while improving diagnostic accuracy.<":
        ">V\u00e9rificateurs de sympt\u00f4mes IA personnalis\u00e9s et chatbots pour le triage des patients. Le d\u00e9pistage pr\u00e9-consultation r\u00e9duit le temps du m\u00e9decin de 40% tout en am\u00e9liorant la pr\u00e9cision diagnostique.<",

    ">From symptom checking to video consultation to prescription delivery - we build the entire ecosystem: patient portals, doctor dashboards, pharmacy integrations, and billing systems.<":
        ">De la v\u00e9rification des sympt\u00f4mes \u00e0 la consultation vid\u00e9o en passant par la livraison de prescriptions - nous construisons l'\u00e9cosyst\u00e8me complet : portails patients, tableaux de bord m\u00e9decins, int\u00e9grations pharmacies et syst\u00e8mes de facturation.<",

    ">Support pour 50+ languages and 20+ currencies. Essential pour international telemedicine services and medical tourism platforms.<":
        ">Support de plus de 50 langues et 20+ devises. Essentiel pour les services de t\u00e9l\u00e9m\u00e9decine internationaux et les plateformes de tourisme m\u00e9dical.<",

    ">Launch your telemedicine platform in 10-14 jours. Agile process designed pour healthcare compliance timelines and urgent patient needs.<":
        ">Lancez votre plateforme de t\u00e9l\u00e9m\u00e9decine en 10-14 jours. Processus agile con\u00e7u pour les d\u00e9lais de conformit\u00e9 sant\u00e9 et les besoins urgents des patients.<",

    ">All telemedicine platforms include encrypted video, secure messaging, audit logs, and BAA agreements. We handle compliance so you can focus on patient care.<":
        ">Toutes les plateformes de t\u00e9l\u00e9m\u00e9decine incluent vid\u00e9o chiffr\u00e9e, messagerie s\u00e9curis\u00e9e, journaux d'audit et accords BAA. Nous g\u00e9rons la conformit\u00e9 pour que vous puissiez vous concentrer sur les soins aux patients.<",

    ">HIPAA-compliant HD video calls with screen sharing, file uploads, and consultation recording.<":
        ">Appels vid\u00e9o HD conformes HIPAA avec partage d'\u00e9cran, t\u00e9l\u00e9chargement de fichiers et enregistrement de consultation.<",

    ">HIPAA-compliant telemedicine platform<":
        ">Plateforme de t\u00e9l\u00e9m\u00e9decine conforme HIPAA<",

    ">Personalized dashboard pour booking appointments, viewing medical records, and managing prescriptions.<":
        ">Tableau de bord personnalis\u00e9 pour la prise de rendez-vous, la consultation des dossiers m\u00e9dicaux et la gestion des prescriptions.<",

    ">Pre-consultation triage system that recommends specialist and urgency level.<":
        ">Syst\u00e8me de triage pr\u00e9-consultation qui recommande le sp\u00e9cialiste et le niveau d'urgence.<",

    ">Doctor dashboard pour managing schedules, patient records, and revenue analytics.<":
        ">Tableau de bord m\u00e9decin pour la gestion des emplois du temps, dossiers patients et analytiques de revenus.<",

    ">Managing patient inquiries across WhatsApp, email, phone calls, and clinic visits is overwhelming. Patients ask the same questions repeatedly. AI chatbots trained on your medical specialties provide instant, accurate responses 24/7.<":
        ">G\u00e9rer les demandes des patients sur WhatsApp, e-mail, appels t\u00e9l\u00e9phoniques et visites en clinique est accablant. Les patients posent les m\u00eames questions de mani\u00e8re r\u00e9p\u00e9titive. Les chatbots IA form\u00e9s sur vos sp\u00e9cialit\u00e9s m\u00e9dicales fournissent des r\u00e9ponses instantan\u00e9es et pr\u00e9cises 24h/24 et 7j/7.<",

    ">30-40% no-show rates cost virtual clinics thousands in lost revenue. Manual appointment reminders don&#x27;t work. Our platforms include automated SMS/email reminders, pre-consultation payment collection, and waitlist management.<":
        ">Les taux d'absence de 30-40% co\u00fbtent aux cliniques virtuelles des milliers en revenus perdus. Les rappels manuels de rendez-vous ne fonctionnent pas. Nos plateformes incluent des rappels automatis\u00e9s par SMS/e-mail, la collecte de paiement pr\u00e9-consultation et la gestion des listes d'attente.<",

    ">Doctors manually copy consultation notes from video calls to EMR systems. Patients can&#x27;t access their records or prescriptions easily. Built-in consultation note templates, auto-synced with your EMR, and patient-facing records portal.<":
        ">Les m\u00e9decins copient manuellement les notes de consultation des appels vid\u00e9o vers les syst\u00e8mes DME. Les patients ne peuvent pas acc\u00e9der facilement \u00e0 leurs dossiers ou prescriptions. Mod\u00e8les de notes de consultation int\u00e9gr\u00e9s, synchronis\u00e9s automatiquement avec votre DME, et portail de dossiers orient\u00e9 patient.<",

    ">Collecting payments post-consultation leads to 20-30% unpaid invoices. Insurance claim processing takes weeks and requires dedicated staff. Pre-consultation payment collection, automated insurance claims, and transparent pricing display.<":
        ">La collecte des paiements apr\u00e8s consultation entra\u00eene 20-30% de factures impay\u00e9es. Le traitement des r\u00e9clamations d'assurance prend des semaines et n\u00e9cessite du personnel d\u00e9di\u00e9. Collecte de paiement pr\u00e9-consultation, r\u00e9clamations d'assurance automatis\u00e9es et affichage transparent des prix.<",

    ">Patients use telemedicine once and never return. No system to track patient health outcomes or encourage follow-up consultations. Patient engagement tools including health reminders, medication tracking, and chronic care management.<":
        ">Les patients utilisent la t\u00e9l\u00e9m\u00e9decine une fois et ne reviennent jamais. Aucun syst\u00e8me pour suivre les r\u00e9sultats de sant\u00e9 des patients ou encourager les consultations de suivi. Outils d'engagement patient incluant rappels de sant\u00e9, suivi des m\u00e9dicaments et gestion des soins chroniques.<",

    ">Generic Platforms Aren&#x27;t HIPAA Compliant<":
        ">Les Plateformes G\u00e9n\u00e9riques ne sont pas Conformes HIPAA<",

    ">Zoom and Google Meet don&#x27;t meet HIPAA requirements pour protected health information. You need BAA-signed video platforms with encrypted storage. We build HIPAA-compliant video from scratch with audit trails.<":
        ">Zoom et Google Meet ne r\u00e9pondent pas aux exigences HIPAA pour les informations de sant\u00e9 prot\u00e9g\u00e9es. Vous avez besoin de plateformes vid\u00e9o avec BAA sign\u00e9 et stockage chiffr\u00e9. Nous construisons de la vid\u00e9o conforme HIPAA de z\u00e9ro avec des pistes d'audit.<",

    # University long texts
    ">Custom university website development pour higher education institutions. We&#x27;ve built 15+ university websites with student admissions systems, course catalogs, faculty portals, and LMS integrations.<":
        ">D\u00e9veloppement de sites web universitaires sur mesure pour les \u00e9tablissements d'enseignement sup\u00e9rieur. Nous avons cr\u00e9\u00e9 plus de 15 sites web universitaires avec syst\u00e8mes d'admission, catalogues de cours, portails enseignants et int\u00e9grations LMS.<",

    ">Most university websites are 10+ years old with poor UX, slow loading, and non-mobile responsive. This hurts enrollment as 70% of prospective students research on mobile devices.<":
        ">La plupart des sites web universitaires ont plus de 10 ans avec une mauvaise UX, un chargement lent et ne sont pas responsive mobile. Cela nuit \u00e0 l'inscription car 70% des \u00e9tudiants potentiels recherchent sur appareils mobiles.<",

    ">Students calling/emailing pour transcripts, enrollment status, fee receipts, and course schedules overwhelms staff. You need a self-service portal pour 80% of common queries.<":
        ">Les \u00e9tudiants qui appellent/envoient des e-mails pour les relev\u00e9s de notes, le statut d'inscription, les re\u00e7us de frais et les emplois du temps surchargent le personnel. Vous avez besoin d'un portail en libre-service pour 80% des demandes courantes.<",

    ">Separate systems pour admissions, LMS, finance, and student records create data silos. Staff waste hours on duplicate data entry and students face fragmented experiences.<":
        ">Des syst\u00e8mes s\u00e9par\u00e9s pour les admissions, le LMS, les finances et les dossiers \u00e9tudiants cr\u00e9ent des silos de donn\u00e9es. Le personnel perd des heures en saisie de donn\u00e9es en double et les \u00e9tudiants font face \u00e0 des exp\u00e9riences fragment\u00e9es.<",

    ">Connect with your SIS, LMS, and CRM. One unified digital experience pour students and faculty.<":
        ">Connectez-vous \u00e0 votre SIS, LMS et CRM. Une exp\u00e9rience num\u00e9rique unifi\u00e9e pour les \u00e9tudiants et les enseignants.<",

    ">Every page optimizes pour prospective student conversion, application completion, and enrollment rates.<":
        ">Chaque page est optimis\u00e9e pour la conversion des \u00e9tudiants potentiels, la compl\u00e9tion des candidatures et les taux d'inscription.<",

    ">WCAG 2.1 AA compliant, FERPA secure, and ADA accessible by default.<":
        ">Conforme WCAG 2.1 AA, s\u00e9curis\u00e9 FERPA et accessible ADA par d\u00e9faut.<",

    ">Interactive course catalog with search, prerequisites, seat availability, and online registration.<":
        ">Catalogue de cours interactif avec recherche, pr\u00e9requis, disponibilit\u00e9 des places et inscription en ligne.<",

    ">Personalized portal pour grades, schedules, transcripts, fee payments, and announcements.<":
        ">Portail personnalis\u00e9 pour les notes, emplois du temps, relev\u00e9s de notes, paiement des frais et annonces.<",

    ">Faculty dashboard pour attendance, grading, course materials, and student communication.<":
        ">Tableau de bord enseignant pour la pr\u00e9sence, la notation, les supports de cours et la communication avec les \u00e9tudiants.<",

    ">Online application system with document uploads, application tracking, and automated communications.<":
        ">Syst\u00e8me de candidature en ligne avec t\u00e9l\u00e9chargement de documents, suivi des candidatures et communications automatis\u00e9es.<",

    # Remaining misc texts
    ">Comprehensive analytics dashboard with real-time metrics, activity feeds, and personalized insights.<":
        ">Tableau de bord analytique complet avec m\u00e9triques en temps r\u00e9el, flux d'activit\u00e9 et insights personnalis\u00e9s.<",

    ">Powerful admin interface pour user management, permissions, monitoring, and system configuration.<":
        ">Interface d'administration puissante pour la gestion des utilisateurs, les permissions, la surveillance et la configuration syst\u00e8me.<",

    ">Automated recurring billing with Stripe integration, proration, invoicing, and dunning management.<":
        ">Facturation r\u00e9currente automatis\u00e9e avec int\u00e9gration Stripe, prorata, facturation et gestion des relances.<",

    ">RESTful APIs with webhooks, authentication, rate limiting, and auto-generated documentation.<":
        ">APIs RESTful avec webhooks, authentification, limitation de d\u00e9bit et documentation auto-g\u00e9n\u00e9r\u00e9e.<",

    ">Scalable infrastructure supporting 10,000+ concurrent users. White-label ready with custom domains, branding, and isolated data pour each client.<":
        ">Infrastructure \u00e9volutive supportant plus de 10 000 utilisateurs simultan\u00e9s. Pr\u00eat pour la marque blanche avec domaines personnalis\u00e9s, marque et donn\u00e9es isol\u00e9es pour chaque client.<",

    ">Beautiful video player with chapters, speed control, notes, and progress saving.<":
        ">Lecteur vid\u00e9o \u00e9l\u00e9gant avec chapitres, contr\u00f4le de vitesse, notes et sauvegarde de progression.<",

    ">Adaptive bitrate streaming, CDN delivery, and playback analytics pour seamless video learning.<":
        ">Streaming \u00e0 d\u00e9bit adaptatif, livraison CDN et analytiques de lecture pour un apprentissage vid\u00e9o fluide.<",

    ">Gamification, progress tracking, and engagement triggers proven to increase course completion rates.<":
        ">Ludification, suivi des progr\u00e8s et d\u00e9clencheurs d'engagement prouv\u00e9s pour augmenter les taux de compl\u00e9tion de cours.<",

    ">Subscription models, course bundles, upsells, and affiliate systems built-in. Maximize your revenue per student.<":
        ">Mod\u00e8les d'abonnement, packs de cours, ventes additionnelles et syst\u00e8mes d'affiliation int\u00e9gr\u00e9s. Maximisez vos revenus par \u00e9tudiant.<",

    ">Empower your instructors with analytics, content management, and student communication tools.<":
        ">Donnez \u00e0 vos instructeurs les moyens d'agir avec des analytiques, la gestion de contenu et des outils de communication avec les \u00e9tudiants.<",

    ">Smart application forms with country-specific document checklists and real-time tracking.<":
        ">Formulaires de candidature intelligents avec listes de v\u00e9rification de documents sp\u00e9cifiques au pays et suivi en temps r\u00e9el.<",

    ">Smart application forms with document uploads, real-time tracking, and automated notifications.<":
        ">Formulaires de candidature intelligents avec t\u00e9l\u00e9chargement de documents, suivi en temps r\u00e9el et notifications automatis\u00e9es.<",

    ">Personalized portal pour tracking applications, documents, and payments.<":
        ">Portail personnalis\u00e9 pour le suivi des candidatures, documents et paiements.<",

    ">Lead management system with scoring, follow-ups, and conversion analytics pour counselors.<":
        ">Syst\u00e8me de gestion de prospects avec notation, suivis et analytiques de conversion pour les conseillers.<",

    ">Lead management with auto-scoring, follow-ups, and conversion analytics.<":
        ">Gestion de prospects avec notation automatique, suivis et analytiques de conversion.<",

    ">Lead management with status tracking and automated follow-ups<":
        ">Gestion de prospects avec suivi de statut et suivis automatis\u00e9s<",

    ">Lead management CRM with status tracking<":
        ">CRM de gestion de prospects avec suivi de statut<",

    ">24/7 multilingual chatbot trained on visa requirements and university eligibility.<":
        ">Chatbot multilingue 24h/24 et 7j/7 form\u00e9 sur les exigences de visa et l'\u00e9ligibilit\u00e9 universitaire.<",

    ">Multi-filter search engine with location, price, bedrooms, amenities, and custom criteria. Map view with clustering, saved searches, and instant email alerts when new properties match buyer criteria.<":
        ">Moteur de recherche multi-filtres avec localisation, prix, chambres, \u00e9quipements et crit\u00e8res personnalis\u00e9s. Vue carte avec regroupement, recherches sauvegard\u00e9es et alertes e-mail instantan\u00e9es lors de la mise en ligne de biens correspondants.<",

    ">Multi-filter search with map view, saved searches, and instant notifications when properties match buyer criteria.<":
        ">Recherche multi-filtres avec vue carte, recherches sauvegard\u00e9es et notifications instantan\u00e9es lorsque les biens correspondent aux crit\u00e8res de l'acheteur.<",

    ">Multi-filter search engine with map integration<":
        ">Moteur de recherche multi-filtres avec int\u00e9gration de carte<",

    ">Advanced search with map, saved searches, instant alerts<":
        ">Recherche avanc\u00e9e avec carte, recherches sauvegard\u00e9es, alertes instantan\u00e9es<",

    ">Immersive property viewing with 360\u00b0 panoramas, video walkthroughs, interactive floor plans, and drone footage. Mobile-optimized pour on-the-go viewing with VR headset support pour immersive experience.<":
        ">Visite immersive de biens avec panoramas 360\u00b0, visites vid\u00e9o guid\u00e9es, plans interactifs et images de drone. Optimis\u00e9 mobile pour la visualisation en d\u00e9placement avec support de casque VR pour une exp\u00e9rience immersive.<",

    ">Immersive property viewing with 360\u00b0 panoramas, video walkthroughs, and interactive floor plans to engage remote buyers.<":
        ">Visite immersive de biens avec panoramas 360\u00b0, visites vid\u00e9o guid\u00e9es et plans interactifs pour engager les acheteurs \u00e0 distance.<",

    ">Centralized agent portal to manage listings, track leads, schedule showings, and view performance analytics. Automated lead assignment, follow-up reminders, and email campaign integration.<":
        ">Portail centralis\u00e9 pour les agents pour g\u00e9rer les annonces, suivre les prospects, planifier les visites et consulter les analytiques de performance. Attribution automatis\u00e9e des prospects, rappels de suivi et int\u00e9gration de campagnes e-mail.<",

    ">Centralized platform pour agents to manage listings, track leads, schedule showings, and monitor performance metrics in real-time.<":
        ">Plateforme centralis\u00e9e pour les agents pour g\u00e9rer les annonces, suivre les prospects, planifier les visites et surveiller les m\u00e9triques de performance en temps r\u00e9el.<",

    ">Real-time pricing trends, neighborhood insights, comparable property analysis, and investment ROI calculators pour informed decisions.<":
        ">Tendances de prix en temps r\u00e9el, informations sur le quartier, analyse de biens comparables et calculateurs de ROI d'investissement pour des d\u00e9cisions \u00e9clair\u00e9es.<",

    ">Real-time pricing trends, neighborhood insights, school ratings, crime statistics, and comparable property analysis. Investment ROI calculators, rental yield estimators, and mortgage calculators.<":
        ">Tendances de prix en temps r\u00e9el, informations sur le quartier, \u00e9valuations scolaires, statistiques de criminalit\u00e9 et analyse de biens comparables. Calculateurs de ROI d'investissement, estimateurs de rendement locatif et calculateurs hypoth\u00e9caires.<",

    ">Direct MLS data synchronization to display up-to-date property listings, avoid duplicate entries, and ensure accurate availability.<":
        ">Synchronisation directe des donn\u00e9es MLS pour afficher des annonces immobili\u00e8res \u00e0 jour, \u00e9viter les doublons et garantir une disponibilit\u00e9 pr\u00e9cise.<",

    ">Automated lead capture from property inquiries with follow-up workflows, email campaigns, and conversion tracking pour agents.<":
        ">Capture automatis\u00e9e de prospects \u00e0 partir des demandes immobili\u00e8res avec workflows de suivi, campagnes e-mail et suivi des conversions pour les agents.<",

    ">Competitor analysis of 5-10 real estate platforms<":
        ">Analyse de 5 \u00e0 10 plateformes immobili\u00e8res concurrentes<",

    ">Platform design mockups<":
        ">Maquettes de design de plateforme<",

    ">Platform Transaction Fees<":
        ">Frais de Transaction de Plateforme<",

    ">Platform Fees Are Killing Your Profits<":
        ">Les Frais de Plateforme Tuent Vos Profits<",

    ">Platform Lock-In Risk<":
        ">Risque de Verrouillage de Plateforme<",

    ">Platform commission (10-20%)<":
        ">Commission de plateforme (10-20%)<",

    ">Platform owns it<":
        ">La plateforme en est propri\u00e9taire<",

    ">Video Consultation Platform<":
        ">Plateforme de Consultation Vid\u00e9o<",

    ">Course Platform Development<":
        ">D\u00e9veloppement de Plateforme de Cours<",

    ">Course Platform Experience<":
        ">Exp\u00e9rience en Plateformes de Cours<",

    ">Course Platform Specialists<":
        ">Sp\u00e9cialistes en Plateformes de Cours<",

    ">View Course Platform Portfolio<":
        ">Voir le Portfolio Plateformes de Cours<",

    ">Annual Platform Fees<":
        ">Frais Annuels de Plateforme<",

    ">+300% Platform Usage<":
        ">+300% d'Utilisation de la Plateforme<",

    ">360\u00b0 Virtual Tour Platform<":
        ">Plateforme de Visite Virtuelle 360\u00b0<",

    ">360\u00b0 panoramic property tours with hotspot navigation<":
        ">Visites panoramiques 360\u00b0 de biens avec navigation par points d'int\u00e9r\u00eat<",

    ">Unified dashboard pour all languages<":
        ">Tableau de bord unifi\u00e9 pour toutes les langues<",

    ">Saved searches with instant email alerts pour new listings<":
        ">Recherches sauvegard\u00e9es avec alertes e-mail instantan\u00e9es pour les nouvelles annonces<",

    ">Espa\u00f1ol Vivo Language School<":
        ">\u00c9cole de Langues Espa\u00f1ol Vivo<",

    ">Provider training on telehealth platform features<":
        ">Formation des prestataires sur les fonctionnalit\u00e9s de la plateforme de t\u00e9l\u00e9sant\u00e9<",

    ">No credit card required \u00b7 Results in 30 seconds \u00b7 Personalized improvement plan<":
        ">Aucune carte de cr\u00e9dit requise \u00b7 R\u00e9sultats en 30 secondes \u00b7 Plan d'am\u00e9lioration personnalis\u00e9<",

    ">* Comparison based on average pricing and service offerings from top 10 agencies in<":
        ">* Comparaison bas\u00e9e sur les prix moyens et les offres de services des 10 meilleures agences dans<",

    ">Don&#x27;t just take our word for it. Hear from businesses in<":
        ">Ne nous croyez pas sur parole. \u00c9coutez les entreprises dans<",

    ">who&#x27;ve achieved remarkable results with CodeSommetStudio.<":
        ">qui ont obtenu des r\u00e9sultats remarquables avec CodeSommetStudio.<",

    ">-based businesses we&#x27;ve partnered with<":
        "> - entreprises partenaires avec lesquelles nous avons collabor\u00e9<",

    ">Real projects, real results. See how we&#x27;ve helped businesses in<":
        ">Projets r\u00e9els, r\u00e9sultats r\u00e9els. D\u00e9couvrez comment nous avons aid\u00e9 des entreprises dans<",

    ">achieve their digital goals.<":
        ">\u00e0 atteindre leurs objectifs num\u00e9riques.<",

    ">Sound familiar? We&#x27;ve solved these exact problems for 40+<":
        ">Cela vous parle ? Nous avons r\u00e9solu ces probl\u00e8mes exacts pour plus de 40<",

    ">Frequently Asked Questions About Web Development in<":
        ">Questions Fr\u00e9quemment Pos\u00e9es sur le D\u00e9veloppement Web dans<",

    ">Have questions? We&#x27;ve got answers. Here are the most common questions from<":
        ">Vous avez des questions ? Nous avons les r\u00e9ponses. Voici les questions les plus courantes de<",

    ">Local expertise meets global standards. Here&#x27;s what makes us the perfect web development partner in<":
        ">L'expertise locale rencontre les standards mondiaux. Voici ce qui fait de nous le partenaire id\u00e9al en d\u00e9veloppement web dans<",

    ">Let&#x27;s discuss how AI and modern design can elevate your business<":
        ">Discutons de la fa\u00e7on dont l'IA et le design moderne peuvent \u00e9lever votre entreprise<",

    ">Secure video consultation platforms with patient management and prescription systems.<":
        ">Plateformes de consultation vid\u00e9o s\u00e9curis\u00e9es avec gestion des patients et syst\u00e8mes de prescription.<",

    ">Complete SaaS applications with authentication, billing, and real-time features.<":
        ">Applications SaaS compl\u00e8tes avec authentification, facturation et fonctionnalit\u00e9s en temps r\u00e9el.<",

    ">Secure financial platforms with payment processing, compliance, and regulatory features.<":
        ">Plateformes financi\u00e8res s\u00e9curis\u00e9es avec traitement des paiements, conformit\u00e9 et fonctionnalit\u00e9s r\u00e9glementaires.<",

    ">online course platforms<":
        ">plateformes de cours en ligne<",

    ">language schools<":
        ">\u00e9coles de langues<",
}

# Process each file
for fname in files:
    fpath = os.path.join(BASE, fname)
    with open(fpath, 'r', encoding='utf-8') as f:
        content = f.read()

    orig_len = len(content)

    # Sort by key length descending to avoid partial replacements
    sorted_replacements = sorted(replacements.items(), key=lambda x: len(x[0]), reverse=True)
    for old, new in sorted_replacements:
        if old != new:
            content = content.replace(old, new)

    with open(fpath, 'w', encoding='utf-8') as f:
        f.write(content)

    print(f"Pass 2: {fname} ({orig_len} -> {len(content)} chars)")

print("\nDone!")
