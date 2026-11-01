# CodeSommet — SEO Implementation Plan (Semrush workbook → site)

Source of truth: `CodeSommet_Complete_SEO_Keyword_Research_2026.xlsx` (sheets 02, 05, 06, 07, 09, 11). Baseline: commit `36f29f1` (clean tree, 30 Oct 2026 15:33).
No Semrush calls in this mission. Statuses: NOT_STARTED / IN_PROGRESS / COMPLETED / BLOCKED / VERIFIED. Updated after implementation (30 Oct 2026) from the measured tracker `SEO_IMPLEMENTATION_TRACKER.xlsx`; details in `SEO_IMPLEMENTATION_REPORT.md`.

## Ground rules applied
- Each URL has its own Blade view + lang file; shared partials (`home-sections`, `location-process-steps`, `cta-marquee`, `related-articles`) are NOT edited for page-specific keywords.
- FAQPage JSON-LD is generated from `faq_qN/faq_aN` keys (services + cities), so new visible FAQs = new key pairs + one accordion block: schema stays identical to visible text.
- F-12 (official business location) is pending: no new copy claims an office in any city; only "équipe basée au Maroc".
- F-02 (27 non-francophone city pages) is pending: only grammar fixes, no targeting/language/URL change.
- No published prices exist on the site ("Tarification sur mesure"): price content explains factors + free quote, never invents amounts.
- Verified facts reused: site vitrine 2–5 days (express 2 days), unlimited revisions, free quote, pause/cancel anytime, payment by transfer/card/PayPal with milestone schedule, team based in Morocco, 8+ years.

## Execution order
1. P1 quick wins (home title, "du Morocco" FAQ bug, H1 grammar, titles > 580 px, 11 P1 FAQs).
2. Moroccan commercial pages (home, get-quote, seo-maroc, e-commerce, Casablanca, Marrakech, Tanger, Rabat, Agadir).
3. Other service pages (titles/H1/meta per sheet 05, healthcare vs telemedicine differentiation, P2 FAQs).
4. /worldwide + approved international (Brussels, Paris) within F-02 limits.
5. Tools (high-demand titles, 5 short FAQ answers, tool FAQs), blog guides (new seeder), remaining pages review.

## Page checklist (146)

### /  —  P1  —  VERIFIED
- Type / country / lang: Homepage · Morocco · fr
- Source: `resources/views/frontoffice/pages/home.blade.php + partials/home-sections.blade.php` · `lang/fr/home.php`
- Current title: Création Site Web Maroc — Agence Web & SaaS | CodeSommet (582 px) · H1: Création Site Web au Maroc : Agence Web & SaaS qui génère DES RÉSULTATS
- Current mapped primary: création site web maroc [ma] → researched primary: **création site web maroc** [ma 1000/KD 22]
- Secondary: creation site web maroc [ma 1000]; agence web maroc [ma 480]; agence digitale maroc [ma 320]
- Do NOT target here: nom de domaine maroc; agence marketing digital maroc; agence de communication maroc
- Sections: 13 · keyword gaps (Partly): 4 → #2 “Un Design Pixel-Perfect Allié à une Technologie Pu” ⇢ agence web maroc; #8 “Le Choix d'Investissement Intelligent” ⇢ création site web prix maroc; #9 “6 Problèmes Courants de Sites Web que Nous Résolvo” ⇢ agence digitale maroc; #10 “Solutions Personnalisées, Conçues pour Vous” ⇢ création site web prix maroc
- FAQs: 0 existing (none) · new: [P1] Combien coûte la création d'un site web au Maroc ?; [P1] Comment créer un site web professionnel pour mon entreprise ?; [P2] Pourquoi ne pas utiliser un créateur de site web gratuit ?; [P2] Quelle est la différence entre un site vitrine et un site e-commerce ?; [P2] Combien de temps faut-il pour créer un site internet ?; [P2] Comment choisir une agence web au Maroc ?
- On-page: Title (P1): Création Site Web Maroc – Agence Web & SaaS | CodeSommet (573 px) || Création Site Web Maroc : Agence Web & Sa | Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep  | Internal link (P2): Contextual link to /web-development-company/marrakech with anchor "création de site web à Marrakech" | Internal link (P2): Contextual link to /services/seo-maroc with anchor "agence SEO au Maroc"
- Cannibalisation: MEDIUM vs /locations: agence web maroc -> Keep /locations as a hub ("nos villes / zones d'intervention"); internal links with "agence web maroc" anchor point only to / | LOW vs /our-work: agence web maroc -> Optional: portfolio title around "Réalisations & études de cas" - not urgent | LOW vs /contact: agence web maroc -> No change needed; contact pages rarely compete

### /about  —  P3  —  COMPLETED
- Type / country / lang: Core - About · Morocco · fr
- Source: `resources/views/frontoffice/pages/about.blade.php` · `lang/fr/about.php`
- Current title: À Propos - Agence Digitale au Maroc depuis 2018 | CodeSommet (582 px) · H1: À Propos : Agence Digitale au Maroc Depuis 2018
- Current mapped primary: codesommet [ma] → researched primary: **codesommet** [ma NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: agence web marrakech; agence digitale maroc
- Sections: 6 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- On-page: Title (P3): À Propos de CodeSommet – Agence Digitale depuis 2018 (513 px)
- Cannibalisation: LOW vs /: agence digitale maroc -> Keep About brand-focused; do not add more "agence digitale maroc" copy there

### /contact  —  P3  —  COMPLETED
- Type / country / lang: Core - Contact · Morocco · fr
- Source: `resources/views/frontoffice/pages/contact.blade.php` · `lang/fr/contact.php`
- Current title: Contact — Agence Web au Maroc, Réponse sous 24h | CodeSommet (622 px) · H1: Contact : Agence Web au Maroc, Réponse sous 24h
- Current mapped primary: contact agence web [ma] → researched primary: **contact agence web** [ma NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: agence web maroc
- Sections: 8 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- On-page: Title (P3): Contact – Agence Web au Maroc | CodeSommet (435 px) || Contactez CodeSommet – Réponse sous 24h (407 px)
- Cannibalisation: LOW vs /: agence web maroc -> No change needed; contact pages rarely compete

### /get-quote  —  P1  —  VERIFIED
- Type / country / lang: Core - Conversion · Morocco · fr
- Source: `resources/views/frontoffice/pages/get-quote.blade.php` · `lang/fr/get-quote.php`
- Current title: Obtenir un Devis Gratuit | CodeSommet (355 px) · H1: Obtenir un Devis Gratuit pour Votre Site Web
- Current mapped primary: devis site web [ma] → researched primary: **devis site web** [ma 30/KD NOT AVAILABLE]
- Secondary: devis création site internet [fr 880]; devis site web [fr 590]; création site web prix maroc [ma 30]; prix création site web [ma 30]; devis création site web [ma 20]; prix site web maroc [ma 20]; prix creation site web maroc [ma 20]; devis site internet [ma 20]
- Sections: 2 · keyword gaps (Partly): 1 → #2 “Demande de devis envoyée !” ⇢ création site web prix maroc
- FAQs: 0 existing (none) · new: [P1] Que contient un devis de création de site internet ?; [P2] Quel est le prix d'un site internet ?
- On-page: Title (P3): Devis Site Web Gratuit – Prix Site Maroc | CodeSommet (501 px)

### /our-work  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Core - Portfolio hub · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work.blade.php` · `lang/fr/our-work.php`
- Current title: Portfolio & Études de Cas — Agence Web Maroc | CodeSommet (576 px) · H1: Portfolio & Études de Cas, Agence Web Maroc : Nos Projets Génèrent de Vrais Résultats
- Current mapped primary: exemple de site web [ma] → researched primary: **exemple de site web** [ma 20/KD NOT AVAILABLE]
- Secondary: exemple site web [ma 20]
- Do NOT target here: agence web maroc
- Sections: 11 · keyword gaps (Partly): 6 → #1 “Portfolio & Études de Cas, Agence Web Maroc : Nos ” ⇢ exemple de site web; #2 “GLS Sprachenzentrum” ⇢ exemple site web; #4 “Authentic Morocco Adventures” ⇢ exemple site web; #6 “Mon Asso” ⇢ exemple site web; #8 “Dental Pro” ⇢ exemple site web; #10 “Vous vous demandez comment se positionne votre sit” ⇢ exemple site web
- FAQs: 0 existing (none)
- Cannibalisation: LOW vs /: agence web maroc -> Optional: portfolio title around "Réalisations & études de cas" - not urgent

### /industries  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Core - Industry hub · Morocco · fr
- Source: `resources/views/frontoffice/pages/industries.blade.php` · `lang/fr/industries.php`
- Current title: Sites Web par Secteur : E-commerce, Santé | CodeSommet (536 px) · H1: Sites Web par Secteur : E-commerce, Santé et Sites Spécialisés Chaque Secteur
- Current mapped primary: création site web par secteur [ma] → researched primary: **création site web par secteur** [ma NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 7 · keyword gaps (Partly): 1 → #1 “Sites Web par Secteur : E-commerce, Santé et Sites” ⇢ création site web par secteur
- FAQs: 0 existing (none)

### /locations  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Core - Locations hub · Morocco · fr
- Source: `resources/views/frontoffice/pages/locations.blade.php` · `lang/fr/locations.php`
- Current title: Agence Web au Maroc et à l'International | CodeSommet (507 px) · H1: Agence Web au Maroc et à l'International : des Sites Pour les Entreprises Internationales
- Current mapped primary: agence web au maroc [ma] → researched primary: **agence web au maroc** [ma 30/KD NOT AVAILABLE]
- Do NOT target here: agence web maroc
- Sections: 9 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- Cannibalisation: MEDIUM vs /: agence web maroc -> Keep /locations as a hub ("nos villes / zones d'intervention"); internal links with "agence web maroc" anchor point only to /

### /tools  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Core - Tools hub · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools.blade.php` · `lang/fr/tools.php`
- Current title: 40+ Outils SEO & IA Gratuits en Ligne | CodeSommet (481 px) · H1: 40+ Outils SEO & IA Gratuits en Ligne Pour Votre Site Web
- Current mapped primary: outil seo gratuit [fr] → researched primary: **outil seo gratuit** [fr 720/KD 43]
- Secondary: outils seo en ligne [fr 320]; outils seo gratuits [fr 170]; outil seo gratuit [ma 20]
- Sections: 3 · keyword gaps (Partly): 1 → #2 “Aucun outil trouvé” ⇢ outils seo en ligne
- FAQs: 0 existing (none)

### /blog  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Core - Blog hub · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/blog/index (BlogController@index)` · `lang/fr.json / blog views`
- Current title: Blog Développement Web, SEO & Design | CodeSommet (510 px) · H1: Blog Développement Web, SEO & Design
- Current mapped primary: blog développement web [fr] → researched primary: **blog développement web** [fr 10/KD NOT AVAILABLE]
- Sections: 2 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)

### /legal/privacy-policy  —  P5 (review only)  —  VERIFIED – NO CHANGE (legal, no keyword target)
- Type / country / lang: Legal · Morocco · fr
- Source: `resources/views/frontoffice/pages/legal/privacy-policy.blade.php` · `lang/fr/legal/privacy-policy.php`
- Current title: Politique de Confidentialité | CodeSommet (373 px) · H1: Politique de Confidentialité
- Current mapped primary: n/a → researched primary: none (legal)
- Do NOT target here: mentions légales codesommet
- Sections: 13 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)

### /legal/terms-of-service  —  P5 (review only)  —  VERIFIED – NO CHANGE (legal, no keyword target)
- Type / country / lang: Legal · Morocco · fr
- Source: `resources/views/frontoffice/pages/legal/terms-of-service.blade.php` · `lang/fr/legal/terms-of-service.php`
- Current title: Conditions d'Utilisation | CodeSommet (338 px) · H1: Conditions d'Utilisation
- Current mapped primary: n/a → researched primary: none (legal)
- Do NOT target here: mentions légales codesommet
- Sections: 18 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /legal/refund-policy  —  P5 (review only)  —  VERIFIED – NO CHANGE (legal, no keyword target)
- Type / country / lang: Legal · Morocco · fr
- Source: `resources/views/frontoffice/pages/legal/refund-policy.blade.php` · `lang/fr/legal/refund-policy.php`
- Current title: Politique de Remboursement et d'Annulation | CodeSommet (533 px) · H1: Politique de Remboursement et d'Annulation
- Current mapped primary: n/a → researched primary: none (legal)
- Do NOT target here: mentions légales codesommet
- Sections: 9 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /legal/cookie-policy  —  P5 (review only)  —  VERIFIED – NO CHANGE (legal, no keyword target)
- Type / country / lang: Legal · Morocco · fr
- Source: `resources/views/frontoffice/pages/legal/cookie-policy.blade.php` · `lang/fr/legal/cookie-policy.php`
- Current title: Politique de Cookies | CodeSommet (319 px) · H1: Politique de Cookies
- Current mapped primary: n/a → researched primary: none (legal)
- Do NOT target here: mentions légales codesommet
- Sections: 10 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)

### /legal/acceptable-use  —  P5 (review only)  —  VERIFIED – NO CHANGE (legal, no keyword target)
- Type / country / lang: Legal · Morocco · fr
- Source: `resources/views/frontoffice/pages/legal/acceptable-use.blade.php` · `lang/fr/legal/acceptable-use.php`
- Current title: Politique d'Utilisation Acceptable | CodeSommet (424 px) · H1: Politique d'Utilisation Acceptable
- Current mapped primary: n/a → researched primary: none (legal)
- Do NOT target here: mentions légales codesommet
- Sections: 9 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)

### /services/ecommerce-website-development  —  P1  —  VERIFIED
- Type / country / lang: Service landing page · Morocco · fr
- Source: `resources/views/frontoffice/pages/services/ecommerce-website-development.blade.php` · `lang/fr/services/ecommerce-website-development-agency.php`
- Current title: Création Site E-commerce Maroc — Boutique | CodeSommet (546 px) · H1: Création Site E-commerce au Maroc : une Boutique qui génère des VENTES EN LIGNE
- Current mapped primary: création site e-commerce maroc [ma] → researched primary: **création site e-commerce maroc** [ma 20/KD NOT AVAILABLE]
- Secondary: agence e-commerce [fr 1900]; création site e-commerce [fr 1300]; boutique en ligne maroc [ma 140]; site de vente en ligne maroc [ma 140]; création site e-commerce sur mesure [fr 140]; site e-commerce maroc [ma 30]; développement site e-commerce [ma 30]; agence e-commerce maroc [ma 20]
- Do NOT target here: shopify maroc
- Sections: 16 · keyword gaps (Partly): 4 → #4 “Le Défi : E-commerce Les Entreprises Font Face à d” ⇢ boutique en ligne maroc; #5 “Fonctionnalités Essentielles for E-commerce Sites ” ⇢ site de vente en ligne maroc; #8 “Solutions Personnalisées, Tarification Transparent” ⇢ prix site e-commerce; #12 “Questions Fréquemment Posées sur le Développement ” ⇢ cmi paiement en ligne
- FAQs: 8 existing (KEEP 8) · new: [P1] Combien coûte un site e-commerce au Maroc ?; [P1] Comment intégrer le paiement en ligne CMI sur un site e-commerce ?; [P2] Comment créer un site de vente en ligne au Maroc ?; [P2] Faut-il choisir WooCommerce, Shopify ou un site e-commerce sur mesure ?
- On-page: Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /services/saas-platform-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/saas-platform-development.blade.php` · `lang/fr/services/saas-platform-development-agency.php`
- Current title: Développement de Plateformes SaaS & B2B | CodeSommet (535 px) · H1: Développement de Plateformes SaaS & B2B qui génèrent des TABLEAUX DE BORD UTILISATEURS
- Current mapped primary: développement saas [fr] → researched primary: **développement saas** [fr 170/KD 11]
- Secondary: application web sur mesure [fr 480]; agence saas [fr 320]; logiciel saas sur mesure [fr 170]; développement application saas [fr 110]
- Do NOT target here: créer un saas; mvp saas
- Sections: 17 · keyword gaps (Partly): 3 → #4 “Le Défi : SaaS & Logiciels B2B Les Entreprises Fon” ⇢ application web sur mesure; #5 “Fonctionnalités Essentielles pour SaaS & Logiciels” ⇢ agence saas; #13 “Au Service de Clients dans le Monde Entier” ⇢ logiciel saas sur mesure
- FAQs: 8 existing (KEEP 8) · new: [P2] Combien coûte le développement d'une plateforme SaaS ?; [P2] Développez-vous aussi des applications web sur mesure (hors SaaS) ?
- On-page: H1 (P2): Fix grammar of the rotating-word construction (e.g. "qui génèrent de la croissance financière") - keep keyword | Title (P3): Développement SaaS & Applications Web B2B | CodeSommet (553 px) | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: LOW vs /blog/creer-une-plateforme-saas-mvp-multi-tenant-facturation-par-ou-commencer: plateforme saas -> Blog = how-to ("créer un saas", "mvp saas"); service = "développement saas" | LOW vs /our-work/hssabek: saas facturation -> Case study links to service

### /services/fintech-platform-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/fintech-platform-development.blade.php` · `lang/fr/services/fintech-platform-development-agency.php`
- Current title: Développement de Plateformes FinTech & Paiement | CodeSommet (605 px) · H1: Développement de Plateformes FinTech qui génèrent des PASSERELLES DE PAIEMENT
- Current mapped primary: développement fintech [fr] → researched primary: **développement fintech** [fr 0/KD NOT AVAILABLE]
- Secondary: plateforme de paiement [fr 260]
- Sections: 17 · keyword gaps (Partly): 1 → #14 “Au Service de Clients dans le Monde Entier” ⇢ plateforme de paiement
- FAQs: 8 existing (KEEP 8)
- On-page: Title (P3): Plateformes FinTech & Paiement sur Mesure | CodeSommet (539 px) | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: MEDIUM vs /services/fintech-website-development: fintech -> Platform = "développement fintech/plateforme de paiement"; website = "site web fintech"

### /services/fintech-website-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/fintech-website-development.blade.php` · `lang/fr/services/fintech-website-development-agency.php`
- Current title: Création de Sites Web FinTech & Finance | CodeSommet (511 px) · H1: Création de Sites Web FinTech & Finance qui génèrent des CROISSANCE FINANCIÈRE
- Current mapped primary: site web fintech [fr] → researched primary: **site web fintech** [fr 30/KD NOT AVAILABLE]
- Secondary: site fintech [fr 20]
- Sections: 17 · keyword gaps (Partly): 0
- FAQs: 8 existing (KEEP 8)
- On-page: H1 (P2): Fix grammar of the rotating-word construction (e.g. "qui génèrent de la croissance financière") - keep keyword | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: MEDIUM vs /services/fintech-platform-development: fintech -> Platform = "développement fintech/plateforme de paiement"; website = "site web fintech" | MEDIUM vs /blog/site-web-fintech-7-elements-qui-rassurent-un-visiteur: site web fintech -> Blog = "éléments de réassurance site web"; keep "site web fintech" commercial on the service page

### /services/healthcare-website-development  —  P2  —  VERIFIED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/healthcare-website-development.blade.php` · `lang/fr/services/healthcare-website-development-agency.php`
- Current title: Développement de Sites Web Santé & Télésanté | CodeSommet (573 px) · H1: Développement de Sites Web Santé & Télésanté qui génèrent des PORTAILS PATIENTS
- Current mapped primary: agence web santé [fr] → researched primary: **agence web santé** [fr 590/KD 28]
- Secondary: création site internet médecin [fr 90]; site web médical [fr 30]; site web santé [fr 30]
- Do NOT target here: site web cabinet médical
- Sections: 17 · keyword gaps (Partly): 2 → #1 “Développement de Sites Web Santé & Télésanté qui g” ⇢ agence web santé; #4 “Le Défi : Santé et Médical Les Entreprises Font Fa” ⇢ création site internet médecin
- FAQs: 8 existing (KEEP 8) · new: [P3] Combien coûte un site internet pour un médecin ou une clinique ?
- On-page: Title (P2): Agence Web Santé – Sites Médicaux | CodeSommet (469 px) | H1 (P2): Consider including "agence web santé" naturally (keep single H1) | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep  | Internal link (P4): Contextual link to /services/telemedicine-website-development with anchor "site pour cabinet médical"
- Cannibalisation: HIGH vs /services/telemedicine-website-development: site web médical / site web cabinet médical -> Differentiate: healthcare = clinics, hospitals, health organisations, patient portals ("agence web santé"); telemedicine-website = private practice + booking/téléconsultation ("site web cabinet médical")

### /services/education-website-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/education-website-development.blade.php` · `lang/fr/services/education-website-development-agency.php`
- Current title: Création de Sites Web Éducatifs & E-Learning | CodeSommet (549 px) · H1: Création de Sites Web Éducatifs & E-Learning qui génèrent des PORTAILS DE CANDIDATURE ÉTUDIANTS
- Current mapped primary: site internet école [fr] → researched primary: **site internet école** [fr 10/KD NOT AVAILABLE]
- Secondary: site web centre de formation [fr 20]
- Do NOT target here: plateforme e-learning
- Sections: 16 · keyword gaps (Partly): 2 → #1 “Création de Sites Web Éducatifs & E-Learning qui g” ⇢ site internet école; #4 “Le Défi : Éducation et EdTech Les Entreprises Font” ⇢ site web centre de formation
- FAQs: 8 existing (KEEP 8)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: LOW vs /services/university-website-development: site web école / université -> Education = schools/training centres; university = higher education portals | MEDIUM vs /services/elearning-platform-development: e-learning -> Drop e-learning focus from education page copy over time; link to e-learning page

### /services/edtech-platform-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/edtech-platform-development.blade.php` · `lang/fr/services/edtech-platform-development-agency.php`
- Current title: Développement de Plateformes EdTech B2B | CodeSommet (536 px) · H1: Développement de Plateformes EdTech qui génèrent des PLATEFORMES EDTECH B2B
- Current mapped primary: plateforme edtech [fr] → researched primary: **plateforme edtech** [fr 10/KD NOT AVAILABLE]
- Sections: 17 · keyword gaps (Partly): 0
- FAQs: 8 existing (KEEP 8)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: MEDIUM vs /services/elearning-platform-development: plateforme edtech / e-learning -> EdTech = startups building a product; e-learning = institutions deploying an LMS (state it in intros)

### /services/elearning-platform-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/elearning-platform-development.blade.php` · `lang/fr/services/elearning-platform-development-agency.php`
- Current title: Développement de Plateformes E-Learning (LMS) | CodeSommet (583 px) · H1: Développement de Plateformes E-Learning qui génèrent des LMS POUR ÉCOLES, CENTRES DE FORMATION ET ENTREPRISES
- Current mapped primary: plateforme e-learning [fr] → researched primary: **plateforme e-learning** [fr 2400/KD 31]
- Secondary: plateforme lms [fr 1000]; plateforme de formation en ligne [fr 1000]; logiciel lms [fr 170]
- Do NOT target here: lms
- Sections: 17 · keyword gaps (Partly): 3 → #5 “Fonctionnalités Essentielles for E-Learning Platfo” ⇢ plateforme de formation en ligne; #12 “Questions Fréquemment Posées sur le Développement ” ⇢ comment créer une plateforme e-learning; #13 “Au Service de Clients dans le Monde Entier” ⇢ logiciel lms
- FAQs: 8 existing (KEEP 8) · new: [P2] Combien coûte une plateforme e-learning sur mesure ?; [P3] Comment créer une plateforme e-learning ?
- On-page: Title (P3): Plateforme E-Learning & LMS sur Mesure | CodeSommet (512 px) | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: MEDIUM vs /services/online-course-platform-development: plateforme de formation en ligne -> E-learning = LMS/organisations ("plateforme e-learning", "plateforme lms"); online-course = creators ("vendre des formations en ligne") | MEDIUM vs /services/edtech-platform-development: plateforme edtech / e-learning -> EdTech = startups building a product; e-learning = institutions deploying an LMS (state it in intros) | LOW vs /blog/lms-sur-mesure-ou-produit-edtech-quelle-plateforme-e-learning: plateforme lms / lms -> Blog = "lms sur mesure" (comparison); service = "plateforme lms" (commercial)

### /services/online-course-platform-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/online-course-platform-development.blade.php` · `lang/fr/services/online-course-platform-development-agency.php`
- Current title: Développement de Plateformes de Cours en Ligne | CodeSommet (588 px) · H1: Développement de Plateformes de Cours en Ligne qui génèrent des SITES WEB DE COURS PERSONNALISÉS
- Current mapped primary: vendre des formations en ligne [fr] → researched primary: **vendre des formations en ligne** [fr 260/KD 10]
- Secondary: plateforme de cours en ligne [fr 480]; créer un site de formation en ligne [fr 70]
- Do NOT target here: plateforme de formation en ligne
- Sections: 16 · keyword gaps (Partly): 3 → #1 “Développement de Plateformes de Cours en Ligne qui” ⇢ vendre des formations en ligne; #5 “Fonctionnalités Essentielles pour Plateformes de C” ⇢ créer un site de formation en ligne; #12 “Questions Fréquemment Posées sur le Développement ” ⇢ comment créer un site de formation en ligne
- FAQs: 8 existing (KEEP 8) · new: [P2] Comment créer un site de formation en ligne pour vendre mes cours ?
- On-page: H1 (P2): Consider including "vendre des formations en ligne" naturally (keep single H1) | Title (P3): Plateforme pour Vendre des Formations en Ligne | CodeSommet (578 px) | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: MEDIUM vs /services/elearning-platform-development: plateforme de formation en ligne -> E-learning = LMS/organisations ("plateforme e-learning", "plateforme lms"); online-course = creators ("vendre des formations en ligne")

### /services/university-website-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/university-website-development.blade.php` · `lang/fr/services/university-website-development-agency.php`
- Current title: Développement de Sites Web Universitaires | CodeSommet (529 px) · H1: Développement de Sites Web Universitaires qui génèrent des PORTAILS D'ADMISSION ÉTUDIANTE
- Current mapped primary: site web université [fr] → researched primary: **site web université** [fr 20/KD NOT AVAILABLE]
- Do NOT target here: portail étudiant; portail étudiant; site universitaire
- Sections: 16 · keyword gaps (Partly): 0
- FAQs: 8 existing (KEEP 8)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: LOW vs /services/education-website-development: site web école / université -> Education = schools/training centres; university = higher education portals

### /services/language-school-website-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/language-school-website-development.blade.php` · `lang/fr/services/language-school-website-development-agency.php`
- Current title: Création de Sites Web pour Écoles de Langues | CodeSommet (560 px) · H1: Création de Sites Web pour Écoles de Langues qui génèrent des Écoles de Langues
- Current mapped primary: site web école de langues [fr] → researched primary: **site web école de langues** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 16 · keyword gaps (Partly): 0
- FAQs: 8 existing (KEEP 8)
- On-page: H1 (P2): Fix grammar of the rotating-word construction (e.g. "qui génèrent de la croissance financière") - keep keyword | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /services/study-abroad-website-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/study-abroad-website-development.blade.php` · `lang/fr/services/study-abroad-website-development-agency.php`
- Current title: Création de Sites Web Études à l'Étranger | CodeSommet (515 px) · H1: Création de Sites Web Études à l'Étranger qui génèrent des PORTAILS DE CANDIDATURE ÉTUDIANTS
- Current mapped primary: site web agence études à l'étranger [fr] → researched primary: **site web agence études à l'étranger** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: agence étude à l'étranger
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 8 existing (KEEP 8)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: LOW vs /services/immigration-consultancy-website-development: portail de candidature -> Study-abroad = agencies placing students; immigration = visa consultancies

### /services/immigration-consultancy-website-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/immigration-consultancy-website-development.blade.php` · `lang/fr/services/immigration-consultancy-website-development-agency.php`
- Current title: Sites Web pour Cabinets d'Immigration | CodeSommet (486 px) · H1: Sites Web pour Cabinets d'Immigration qui génèrent des PORTAILS DE DEMANDE DE VISA
- Current mapped primary: site web cabinet immigration [fr] → researched primary: **site web cabinet immigration** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: cabinet immigration canada maroc
- Sections: 16 · keyword gaps (Partly): 0
- FAQs: 8 existing (KEEP 8)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: LOW vs /services/study-abroad-website-development: portail de candidature -> Study-abroad = agencies placing students; immigration = visa consultancies

### /services/real-estate-website-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/real-estate-website-development.blade.php` · `lang/fr/services/real-estate-website-development-agency.php`
- Current title: Sites Web Immobiliers & Portails Sur Mesure | CodeSommet (539 px) · H1: Sites Web Immobiliers & Portails Sur Mesure qui génèrent des ANNONCES IMMOBILIÈRES
- Current mapped primary: création site immobilier [fr] → researched primary: **création site immobilier** [fr 390/KD 19]
- Secondary: agence web immobilier [fr 260]; site internet agence immobilière [fr 110]; création site web agence immobilière [fr 90]
- Do NOT target here: site immobilier; seo immobilier; site immobilier maroc
- Sections: 17 · keyword gaps (Partly): 4 → #1 “Sites Web Immobiliers & Portails Sur Mesure qui gé” ⇢ création site immobilier; #4 “Le Défi : Immobilier Les Entreprises Font Face à d” ⇢ agence web immobilier; #5 “Fonctionnalités Essentielles pour Immobilier Sites” ⇢ site internet agence immobilière; #13 “Au Service de Clients dans le Monde Entier” ⇢ création site web agence immobilière
- FAQs: 8 existing (KEEP 8) · new: [P2] Combien coûte un site internet pour une agence immobilière ?
- On-page: Title (P2): Création Site Immobilier sur Mesure | CodeSommet (459 px) | H1 (P2): Consider including "création site immobilier" naturally (keep single H1) | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: LOW vs /blog/site-immobilier-structurer-les-annonces-pour-le-seo-et-la-conversion: site immobilier -> Blog = "seo immobilier"; service = "création site immobilier"

### /services/telemedicine-platform-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/telemedicine-platform-development.blade.php` · `lang/fr/services/telemedicine-platform-development-agency.php`
- Current title: Développement de Plateformes de Télémédecine | CodeSommet (577 px) · H1: Développement de PLATEFORMES DE TÉLÉMÉDECINE
- Current mapped primary: logiciel téléconsultation [fr] → researched primary: **logiciel téléconsultation** [fr 210/KD 29]
- Secondary: logiciel télémédecine [fr 140]; plateforme téléconsultation [fr 70]; plateforme de télémédecine [fr 20]
- Sections: 17 · keyword gaps (Partly): 3 → #1 “Développement de PLATEFORMES DE TÉLÉMÉDECINE” ⇢ logiciel téléconsultation; #5 “Le Défi : Télémédecine & Virtual Care Les Entrepri” ⇢ logiciel télémédecine; #6 “Fonctionnalités Essentielles pour Télémédecine & V” ⇢ plateforme téléconsultation
- FAQs: 8 existing (KEEP 8)
- On-page: Title (P2): Logiciel de Téléconsultation sur Mesure | CodeSommet (490 px) | H1 (P2): Consider including "logiciel téléconsultation" naturally (keep single H1) | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- Cannibalisation: MEDIUM vs /services/telemedicine-website-development: télémédecine -> Platform page = "logiciel téléconsultation"; website page = "site web cabinet médical"

### /services/telemedicine-website-development  —  P2  —  COMPLETED
- Type / country / lang: Service landing page · Francophone (FR) + Morocco · fr
- Source: `resources/views/frontoffice/pages/services/telemedicine-website-development.blade.php` · `lang/fr/services/telemedicine-website-development-agency.php`
- Current title: Site Web Cabinet Médical & Télémédecine | CodeSommet (517 px) · H1: Site Web Cabinet Médical & Télémédecine : nous créons des SITES WEB MÉDICAUX
- Current mapped primary: site web cabinet médical [fr] → researched primary: **site web cabinet médical** [fr 20/KD NOT AVAILABLE]
- Secondary: site médecin [ma 20]; site médecin [fr 10]
- Do NOT target here: agence web santé
- Sections: 17 · keyword gaps (Partly): 0
- FAQs: 8 existing (KEEP 8)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep  | Internal link (P4): Contextual link to /services/healthcare-website-development with anchor "agence web santé"
- Cannibalisation: HIGH vs /services/healthcare-website-development: site web médical / site web cabinet médical -> Differentiate: healthcare = clinics, hospitals, health organisations, patient portals ("agence web santé"); telemedicine-website = private practice + booking/téléconsultation ("site web cabinet médical") | MEDIUM vs /services/telemedicine-platform-development: télémédecine -> Platform page = "logiciel téléconsultation"; website page = "site web cabinet médical" | LOW vs /blog/site-web-telemedecine-cabinet-clinique-que-doit-il-contenir: site web cabinet médical / télémédecine -> Blog links to service with commercial anchor; keep blog informational

### /services/seo-maroc  —  P1  —  VERIFIED
- Type / country / lang: Service landing page · Morocco · fr
- Source: `resources/views/frontoffice/pages/services/seo-maroc.blade.php` · `lang/fr/services/seo-maroc-agency.php`
- Current title: Agence SEO Maroc — Référencement Naturel Google | CodeSommet (625 px) · H1: Agence SEO Maroc : un Référencement Naturel Google qui génère des DEMANDES DE DEVIS
- Current mapped primary: agence seo maroc [ma] → researched primary: **agence seo maroc** [ma 880/KD 44]
- Secondary: seo maroc [ma 320]; agence seo marrakech [ma 320]; agence seo casablanca [ma 170]; agence seo maroc [fr 90]; consultant seo maroc [ma 70]
- Do NOT target here: agence seo
- Sections: 16 · keyword gaps (Partly): 4 → #4 “Le Défi : Les Entreprises Marocaines Font Face à d” ⇢ seo maroc; #5 “Ce que Comprend Notre Accompagnement” ⇢ agence seo marrakech; #8 “Offres SEO Claires, Tarification Transparente” ⇢ prix seo maroc; #13 “Référencement Local dans Tout le Maroc” ⇢ agence seo casablanca
- FAQs: 8 existing (KEEP 8) · new: [P1] Combien coûte une prestation SEO au Maroc ?; [P1] Proposez-vous un audit SEO gratuit ?; [P3] Qu'est-ce que le SEO et pourquoi est-il important pour une entreprise marocaine ?; [P3] Combien de temps faut-il pour être référencé sur Google ?
- On-page: Title (P1): Agence SEO Maroc : Référencement Naturel | CodeSommet (541 px) || Agence SEO Maroc – Référencement Google | Co | Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep  | Internal link (P4): Contextual link to /tools/website-analyzer with anchor "audit SEO gratuit"
- Cannibalisation: MEDIUM vs /web-development-company/marrakech: agence seo marrakech -> Assign to /services/seo-maroc; Marrakech page links to it with this anchor | LOW vs /web-development-company/casablanca: agence seo casablanca -> Assign to /services/seo-maroc

### /web-development-company/worldwide  —  P1  —  VERIFIED
- Type / country / lang: Location page · International (FR/BE/CH/CA) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-worldwide.blade.php` · `lang/fr/locations/web-development-company-worldwide.php`
- Current title: Agence Web Offshore au Maroc — À Distance | CodeSommet (555 px) · H1: Agence Web Offshore au Maroc : nous travaillons à distance, où que vous soyez PARTOUT OÙ QUE VOUS SOYEZ
- Current mapped primary: agence web offshore maroc [ma] → researched primary: **agence web offshore maroc** [ma 140/KD NOT AVAILABLE]
- Secondary: agence de développement web [fr 1300]; agence web offshore [fr 480]; développement web offshore [fr 210]; développeur offshore [fr 110]
- Do NOT target here: agence web maroc
- Sections: 8 · keyword gaps (Partly): 1 → #4 “Secteurs que Nous Servons dans le Monde” ⇢ agence de développement web
- FAQs: 6 existing (KEEP 6) · new: [P1] Pourquoi externaliser le développement web au Maroc ?; [P2] Quels sont les avantages et les risques du développement web offshore ?
- Cannibalisation: LOW vs /: agence web offshore maroc / agence de développement web -> Keep separation: FR-market terms on /worldwide only | HIGH (doorway/thin-content risk) vs /web-development-company/{30 international cities}: développement web {ville} -> Owner decision (already pending as F-02): keep the 5-6 pages with genuine francophone value (Paris, Brussels, Tunis, Montréal-equivalent) and differentiate them; consolidate the rest into /worldwide with 301s - do not change before approval

### /web-development-company/casablanca  —  P1  —  VERIFIED
- Type / country / lang: Location page · Morocco · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-casablanca.blade.php` · `lang/fr/locations/web-development-company-casablanca.php`
- Current title: Agence Web Casablanca — Création de Sites | CodeSommet (548 px) · H1: Agence Web Casablanca : Création de Sites qui génèrent LA CROISSANCE DES ENTREPRISES À CASABLANCA
- Current mapped primary: agence web casablanca [ma] → researched primary: **agence web casablanca** [ma 1000/KD 52]
- Secondary: agence digitale casablanca [ma 260]; création site web casablanca [ma 210]; agence création site web casablanca [ma 30]
- Do NOT target here: agence de communication casablanca; agence marketing digital casablanca; agence seo casablanca
- Sections: 15 · keyword gaps (Partly): 6 → #3 “Approuvé par Casablanca Entreprises” ⇢ agence digitale casablanca; #4 “Casablanca Nos Secteurs de Spécialisation” ⇢ création site web casablanca; #6 “Des Plateformes Immobilières Pensées pour le March” ⇢ agence création site web casablanca; #7 “Solutions Personnalisées, Tarification Transparent” ⇢ prix création site web casablanca; #13 “Nous Servons Également” ⇢ agence digitale casablanca; #14 “En Savoir Plus” ⇢ création site web casablanca
- FAQs: 6 existing (KEEP 5, IMPROVE 1) · new: [P1] Combien coûte la création d'un site web à Casablanca ?
- On-page: Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep  | Internal link (P2): Contextual link to /services/seo-maroc with anchor "référencement naturel à Casablanca"
- Cannibalisation: LOW vs /services/seo-maroc: agence seo casablanca -> Assign to /services/seo-maroc

### /web-development-company/marrakech  —  P1  —  VERIFIED
- Type / country / lang: Location page · Morocco · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-marrakech.blade.php` · `lang/fr/locations/web-development-company-marrakech.php`
- Current title: Création Site Web Marrakech — Agence Web | CodeSommet (548 px) · H1: Création Site Web Marrakech : votre Agence Web pour des sites qui génèrent LA CROISSANCE COMMERCIALE À MARRAKECH
- Current mapped primary: création site web marrakech [ma] → researched primary: **création site web marrakech** [ma 590/KD 19]
- Secondary: creation site web marrakech [ma 590]; agence web marrakech [ma 320]; création site internet marrakech [ma 170]; agence digitale marrakech [ma 140]; site web marrakech [ma 90]
- Do NOT target here: agence de communication marrakech; agence seo marrakech; agence marketing digital marrakech
- Sections: 15 · keyword gaps (Partly): 4 → #3 “Approuvé par les Entreprises de Marrakech” ⇢ agence web marrakech; #4 “Marrakech Nos Secteurs de Spécialisation” ⇢ création site internet marrakech; #6 “Des Plateformes Immobilières Pensées pour le March” ⇢ agence digitale marrakech; #7 “Solutions Sur Mesure, Tarification Transparente” ⇢ prix création site web marrakech
- FAQs: 6 existing (KEEP 4, REWRITE 1, IMPROVE 1) · new: [P1] Combien coûte la création d'un site web à Marrakech ?; [P2] Pouvez-vous créer un site pour un riad, un hôtel ou une agence de voyage à Marrakech ?
- On-page: Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep  | Internal link (P2): Contextual link to /services/seo-maroc with anchor "agence SEO à Marrakech"
- Cannibalisation: MEDIUM vs /services/seo-maroc: agence seo marrakech -> Assign to /services/seo-maroc; Marrakech page links to it with this anchor

### /web-development-company/rabat  —  P1  —  COMPLETED
- Type / country / lang: Location page · Morocco · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-rabat.blade.php` · `lang/fr/locations/web-development-company-rabat.php`
- Current title: Agence Web Rabat — Création de Sites | CodeSommet (497 px) · H1: Agence Web Rabat : Création de Sites qui génèrent LA CROISSANCE COMMERCIALE À RABAT
- Current mapped primary: agence web rabat [ma] → researched primary: **agence web rabat** [ma 260/KD NOT AVAILABLE]
- Secondary: agence digitale rabat [ma 170]; création site web rabat [ma 140]
- Do NOT target here: agence de communication rabat; agence marketing digital rabat
- Sections: 15 · keyword gaps (Partly): 2 → #3 “Approuvé par les Entreprises de Rabat” ⇢ agence digitale rabat; #4 “Rabat Nos Secteurs de Spécialisation” ⇢ création site web rabat
- FAQs: 6 existing (KEEP 4, REWRITE 1, IMPROVE 1) · new: [P3] Travaillez-vous avec les administrations et institutions à Rabat ?
- On-page: Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /web-development-company/tangier  —  P1  —  COMPLETED
- Type / country / lang: Location page · Morocco · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-tangier.blade.php` · `lang/fr/locations/web-development-company-tangier.php`
- Current title: Création Site Web Tanger — Agence Web | CodeSommet (516 px) · H1: Création Site Web Tanger : votre Agence Web pour des sites qui génèrent LA CROISSANCE COMMERCIALE À TANGER
- Current mapped primary: creation site web tanger [ma] → researched primary: **creation site web tanger** [ma 320/KD 11]
- Secondary: création site web tanger [ma 260]; agence web tanger [ma 40]
- Do NOT target here: agence marketing digital tanger; agence de communication tanger
- Sections: 15 · keyword gaps (Partly): 1 → #3 “Approuvé par Tanger Entreprises” ⇢ agence web tanger
- FAQs: 6 existing (KEEP 6) · new: [P2] Combien coûte la création d'un site web à Tanger ?
- On-page: Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /web-development-company/agadir  —  P1  —  COMPLETED
- Type / country / lang: Location page · Morocco · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-agadir.blade.php` · `lang/fr/locations/web-development-company-agadir.php`
- Current title: Agence Web Agadir — Création de Sites | CodeSommet (501 px) · H1: Agence Web Agadir : Création de Sites qui génèrent LA CROISSANCE DES ENTREPRISES À AGADIR
- Current mapped primary: agence web agadir [ma] → researched primary: **agence web agadir** [ma 140/KD NOT AVAILABLE]
- Secondary: création site web agadir [ma 90]
- Do NOT target here: agence de communication agadir; agence seo agadir
- Sections: 15 · keyword gaps (Partly): 2 → #3 “Approuvé par les Entreprises Marocaines” ⇢ création site web agadir; #14 “En Savoir Plus” ⇢ création site web agadir
- FAQs: 6 existing (KEEP 5, IMPROVE 1) · new: [P3] Accompagnez-vous les entreprises touristiques et agricoles d'Agadir ?
- On-page: Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /web-development-company/dubai  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United Arab Emirates (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-dubai.blade.php` · `lang/fr/locations/web-development-company-dubai.php`
- Current title: Développement Web à Dubaï, EAU | CodeSommet (453 px) · H1: Développement Web à Dubaï, EAU : des sites web qui génèrent CROISSANCE COMMERCIALE À DUBAÏ
- Current mapped primary: développement web dubai [ae] → researched primary: **développement web dubai** [ae NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company dubai
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/abudhabi  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United Arab Emirates (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-abudhabi.blade.php` · `lang/fr/locations/web-development-company-abudhabi.php`
- Current title: Développement Web à Abu Dhabi, EAU | CodeSommet (492 px) · H1: Développement Web à Abu Dhabi, EAU : des sites web qui génèrent Portails Immobiliers
- Current mapped primary: développement web abu dhabi [ae] → researched primary: **développement web abu dhabi** [ae NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company abu dhabi
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/riyadh  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Saudi Arabia (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-riyadh.blade.php` · `lang/fr/locations/web-development-company-riyadh.php`
- Current title: Développement Web à Riyad, Arabie Saoudite | CodeSommet (551 px) · H1: Développement Web à Riyad, Arabie Saoudite : des sites web qui génèrent CROISSANCE COMMERCIALE À RIYAD
- Current mapped primary: développement web riyad [sa] → researched primary: **développement web riyad** [sa NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company riyadh
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/london  —  P4 (F-02 restricted)  —  VERIFIED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United Kingdom (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-london.blade.php` · `lang/fr/locations/web-development-company-london.php`
- Current title: Développement Web à Londres, Royaume-Uni | CodeSommet (553 px) · H1: Développement Web à Londres, Royaume-Uni : des sites web qui génèrent Plateformes FinTech
- Current mapped primary: développement web londres [uk] → researched primary: **développement web londres** [uk NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company london
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/amsterdam  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Netherlands (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-amsterdam.blade.php` · `lang/fr/locations/web-development-company-amsterdam.php`
- Current title: Développement Web à Amsterdam, Pays-Bas | CodeSommet (548 px) · H1: Développement Web à Amsterdam, Pays-Bas : des sites web qui génèrent Plateformes FinTech
- Current mapped primary: développement web amsterdam [nl] → researched primary: **développement web amsterdam** [nl NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development amsterdam
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/berlin  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Germany (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-berlin.blade.php` · `lang/fr/locations/web-development-company-berlin.php`
- Current title: Développement Web à Berlin, Allemagne | CodeSommet (503 px) · H1: Développement Web à Berlin, Allemagne : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web berlin [de] → researched primary: **développement web berlin** [de NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: webentwicklung berlin
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/paris  —  P2  —  COMPLETED
- Type / country / lang: Location page · France (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-paris.blade.php` · `lang/fr/locations/web-development-company-paris.php`
- Current title: Développement Web à Paris, France | CodeSommet (467 px) · H1: Développement Web à Paris, France : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web paris [fr] → researched primary: **développement web paris** [fr 260/KD 31]
- Secondary: création site web paris [fr 320]
- Sections: 15 · keyword gaps (Partly): 2 → #3 “Approuvé par les Entreprises de Paris” ⇢ création site web paris; #4 “Paris Nos Secteurs de Spécialisation” ⇢ création site web paris
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /web-development-company/copenhagen  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Denmark (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-copenhagen.blade.php` · `lang/fr/locations/web-development-company-copenhagen.php`
- Current title: Développement Web à Copenhague, Danemark | CodeSommet (565 px) · H1: Développement Web à Copenhague, Danemark : des sites web qui génèrent Plateformes SaaS
- Current mapped primary: développement web copenhague [dk] → researched primary: **développement web copenhague** [dk NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development copenhagen
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/dublin  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Ireland (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-dublin.blade.php` · `lang/fr/locations/web-development-company-dublin.php`
- Current title: Développement Web à Dublin, Irlande | CodeSommet (476 px) · H1: Développement Web à Dublin, Irlande : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web dublin [ie] → researched primary: **développement web dublin** [ie NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company dublin
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/brussels  —  P2  —  COMPLETED
- Type / country / lang: Location page · Belgium (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-brussels.blade.php` · `lang/fr/locations/web-development-company-brussels.php`
- Current title: Développement Web à Bruxelles, Belgique | CodeSommet (517 px) · H1: Développement Web à Bruxelles, Belgique : des sites web qui génèrent Plateformes FinTech
- Current mapped primary: création site web bruxelles [be] → researched primary: **création site web bruxelles** [be 140/KD 5]
- Secondary: agence web bruxelles [be 1300]
- Sections: 15 · keyword gaps (Partly): 3 → #3 “Ce que nous apportons aux entreprises de Bruxelles” ⇢ agence web bruxelles; #5 “Ce que nous construisons pour Bruxelles” ⇢ agence web bruxelles; #14 “En Savoir Plus” ⇢ agence web bruxelles
- FAQs: 6 existing (KEEP 6)
- On-page: H1 (P2): Consider including "création site web bruxelles" naturally (keep single H1) | Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /web-development-company/zurich  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Switzerland (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-zurich.blade.php` · `lang/fr/locations/web-development-company-zurich.php`
- Current title: Développement Web à Zurich, Suisse | CodeSommet (474 px) · H1: Développement Web à Zurich, Suisse : des sites web qui génèrent Plateformes FinTech
- Current mapped primary: développement web zurich [ch] → researched primary: **développement web zurich** [ch NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: webagentur zürich
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/stockholm  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Sweden (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-stockholm.blade.php` · `lang/fr/locations/web-development-company-stockholm.php`
- Current title: Développement Web à Stockholm, Suède | CodeSommet (510 px) · H1: Développement Web à Stockholm, Suède : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web stockholm [se] → researched primary: **développement web stockholm** [se NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: webbyrå stockholm
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/madrid  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Spain (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-madrid.blade.php` · `lang/fr/locations/web-development-company-madrid.php`
- Current title: Développement Web à Madrid, Espagne | CodeSommet (499 px) · H1: Développement Web à Madrid, Espagne : des sites web qui génèrent CROISSANCE COMMERCIALE À MADRID
- Current mapped primary: développement web madrid [es] → researched primary: **développement web madrid** [es NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: desarrollo web madrid
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/barcelona  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Spain (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-barcelona.blade.php` · `lang/fr/locations/web-development-company-barcelona.php`
- Current title: Développement Web à Barcelone, Espagne | CodeSommet (527 px) · H1: Développement Web à Barcelone, Espagne : des sites web qui génèrent CROISSANCE DES ENTREPRISES À BARCELONE
- Current mapped primary: développement web barcelone [es] → researched primary: **développement web barcelone** [es NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: desarrollo web barcelona
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/lisbon  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Portugal (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-lisbon.blade.php` · `lang/fr/locations/web-development-company-lisbon.php`
- Current title: Développement Web à Lisbonne, Portugal | CodeSommet (514 px) · H1: Développement Web à Lisbonne, Portugal : des sites web qui génèrent CROISSANCE COMMERCIALE À LISBONNE
- Current mapped primary: développement web lisbonne [pt] → researched primary: **développement web lisbonne** [pt NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: desenvolvimento web lisboa
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/rome  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Italy (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-rome.blade.php` · `lang/fr/locations/web-development-company-rome.php`
- Current title: Développement Web à Rome, Italie | CodeSommet (455 px) · H1: Développement Web à Rome, Italie : des sites web qui génèrent CROISSANCE COMMERCIALE À ROME
- Current mapped primary: développement web rome [it] → researched primary: **développement web rome** [it NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: sviluppo siti web roma
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/milan  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Italy (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-milan.blade.php` · `lang/fr/locations/web-development-company-milan.php`
- Current title: Développement Web à Milan, Italie | CodeSommet (449 px) · H1: Développement Web à Milan, Italie : des sites web qui génèrent CROISSANCE COMMERCIALE À MILAN
- Current mapped primary: développement web milan [it] → researched primary: **développement web milan** [it NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: sviluppo siti web milano
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/new-york  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United States (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-new-york.blade.php` · `lang/fr/locations/web-development-company-new-york.php`
- Current title: Développement Web à New York, États-Unis | CodeSommet (538 px) · H1: Développement Web à New York, États-Unis : des sites web qui génèrent Plateformes FinTech
- Current mapped primary: développement web new york [us] → researched primary: **développement web new york** [us NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company new york
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/san-francisco  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United States (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-san-francisco.blade.php` · `lang/fr/locations/web-development-company-san-francisco.php`
- Current title: Développement Web à San Francisco, États-Unis | CodeSommet (579 px) · H1: Développement Web à San Francisco, États-Unis : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web san francisco [us] → researched primary: **développement web san francisco** [us NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company san francisco
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/los-angeles  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United States (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-los-angeles.blade.php` · `lang/fr/locations/web-development-company-los-angeles.php`
- Current title: Développement Web à Los Angeles, États-Unis | CodeSommet (561 px) · H1: Développement Web à Los Angeles, États-Unis : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web los angeles [us] → researched primary: **développement web los angeles** [us NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company los angeles
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/austin  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United States (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-austin.blade.php` · `lang/fr/locations/web-development-company-austin.php`
- Current title: Développement Web à Austin, États-Unis | CodeSommet (507 px) · H1: Développement Web à Austin, États-Unis : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web austin [us] → researched primary: **développement web austin** [us NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company austin
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/seattle  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United States (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-seattle.blade.php` · `lang/fr/locations/web-development-company-seattle.php`
- Current title: Développement Web à Seattle, États-Unis | CodeSommet (514 px) · H1: Développement Web à Seattle, États-Unis : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web seattle [us] → researched primary: **développement web seattle** [us NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company seattle
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/boston  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United States (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-boston.blade.php` · `lang/fr/locations/web-development-company-boston.php`
- Current title: Développement Web à Boston, États-Unis | CodeSommet (514 px) · H1: Développement Web à Boston, États-Unis : des sites web qui génèrent Plateformes EdTech
- Current mapped primary: développement web boston [us] → researched primary: **développement web boston** [us NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company boston
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/chicago  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United States (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-chicago.blade.php` · `lang/fr/locations/web-development-company-chicago.php`
- Current title: Développement Web à Chicago, États-Unis | CodeSommet (524 px) · H1: Développement Web à Chicago, États-Unis : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web chicago [us] → researched primary: **développement web chicago** [us NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company chicago
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/denver  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · United States (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-denver.blade.php` · `lang/fr/locations/web-development-company-denver.php`
- Current title: Développement Web à Denver, États-Unis | CodeSommet (516 px) · H1: Développement Web à Denver, États-Unis : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web denver [us] → researched primary: **développement web denver** [us NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company denver
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/toronto  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Canada (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-toronto.blade.php` · `lang/fr/locations/web-development-company-toronto.php`
- Current title: Développement Web à Toronto, Canada | CodeSommet (498 px) · H1: Développement Web à Toronto, Canada : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web toronto [ca] → researched primary: **développement web toronto** [ca NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company toronto
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/vancouver  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Canada (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-vancouver.blade.php` · `lang/fr/locations/web-development-company-vancouver.php`
- Current title: Développement Web à Vancouver, Canada | CodeSommet (524 px) · H1: Développement Web à Vancouver, Canada : des sites web qui génèrent Tableaux de Bord SaaS
- Current mapped primary: développement web vancouver [ca] → researched primary: **développement web vancouver** [ca NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company vancouver
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/tunis  —  P2  —  COMPLETED
- Type / country / lang: Location page · Tunisia (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-tunis.blade.php` · `lang/fr/locations/web-development-company-tunis.php`
- Current title: Développement Web à Tunis, Tunisie | CodeSommet (471 px) · H1: Développement Web à Tunis, Tunisie : des sites web qui génèrent CROISSANCE COMMERCIALE À TUNIS
- Current mapped primary: développement web tunis [tn] → researched primary: **développement web tunis** [tn 20/KD NOT AVAILABLE]
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 

### /web-development-company/cairo  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Egypt (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-cairo.blade.php` · `lang/fr/locations/web-development-company-cairo.php`
- Current title: Développement Web au Caire, Égypte | CodeSommet (480 px) · H1: Développement Web au Caire, Égypte : des sites web qui génèrent CROISSANCE DES ENTREPRISES AU CAIRE
- Current mapped primary: développement web le caire [eg] → researched primary: **développement web le caire** [eg NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company cairo
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /web-development-company/lagos  —  P4 (F-02 restricted)  —  COMPLETED (F-02 limits: grammar/fact fixes only)
- Type / country / lang: Location page · Nigeria (city page) · fr
- Source: `resources/views/frontoffice/pages/locations/web-development-company-lagos.blade.php` · `lang/fr/locations/web-development-company-lagos.php`
- Current title: Développement Web à Lagos, Nigeria | CodeSommet (476 px) · H1: Développement Web à Lagos, Nigeria : des sites web qui génèrent CROISSANCE COMMERCIALE À LAGOS
- Current mapped primary: développement web lagos [ng] → researched primary: **développement web lagos** [ng NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: web development company lagos
- Sections: 15 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)
- On-page: Heading count (P4): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep 
- F-02 restriction: grammar/quality fixes only; targeting, language, URL and structure unchanged → strategic items BLOCKED FOR APPROVAL.

### /tools/ai-crawler-access-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/ai-crawler-access-checker.blade.php` · `lang/fr/tools/ai-crawler-access-checker.php`
- Current title: Accès des Robots d'IA - GPTBot, ClaudeBot | CodeSommet (534 px) · H1: Accès des Robots d'IA : GPTBot, ClaudeBot
- Current mapped primary: robots ia [fr] → researched primary: **robots ia** [fr 320/KD 33]
- Secondary: robots ia [ma 20]
- Sections: 8 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)

### /tools/ai-readiness-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/ai-readiness-checker.blade.php` · `lang/fr/tools/ai-readiness-checker.php`
- Current title: Test de Préparation aux Moteurs IA (GEO) | CodeSommet (522 px) · H1: Test de Préparation aux Moteurs IA (GEO)
- Current mapped primary: geo seo [fr] → researched primary: **geo seo** [fr 1900/KD 34]
- Secondary: generative engine optimization [fr 1300]; référencement ia [fr 480]
- Sections: 6 · keyword gaps (Partly): 3 → #1 “Test de Préparation aux Moteurs IA (GEO)” ⇢ geo seo; #2 “Robots de recherche et d'assistants IA” ⇢ generative engine optimization; #3 “Comment Utiliser Cet Outil” ⇢ référencement ia
- FAQs: 4 existing (KEEP 4)
- On-page: Title (P2): Lead with "geo seo"

### /tools/base64-encoder  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/base64-encoder.blade.php` · `lang/fr/tools/base64-encoder.php`
- Current title: Encodeur/Décodeur Base64 en Ligne Gratuit | CodeSommet (538 px) · H1: Encodeur/Décodeur Base64 en Ligne Gratuit
- Current mapped primary: base64 decode [fr] → researched primary: **base64 decode** [fr 9900/KD 60]
- Secondary: base64 encode [fr 1900]; base64 decode [ma 1300]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/blog-title-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/blog-title-generator.blade.php` · `lang/fr/tools/blog-title-generator.php`
- Current title: Générateur de Titres de Blog IA Gratuit | CodeSommet (490 px) · H1: Générateur de Titres de Blog IA Gratuit
- Current mapped primary: générateur de titre [fr] → researched primary: **générateur de titre** [fr 140/KD 21]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/bot-viewer  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/bot-viewer.blade.php` · `lang/fr/tools/bot-viewer.php`
- Current title: Bot Viewer - Votre Page Vue par Googlebot | CodeSommet (528 px) · H1: Bot Viewer : Votre Page Vue par Googlebot
- Current mapped primary: googlebot [fr] → researched primary: **googlebot** [fr 390/KD 22]
- Secondary: googlebot [ma 20]
- Sections: 7 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)

### /tools/broken-link-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/broken-link-checker.blade.php` · `lang/fr/tools/broken-link-checker.php`
- Current title: Vérificateur de Liens Brisés Gratuit | CodeSommet (449 px) · H1: Vérificateur de Liens Brisés Gratuit
- Current mapped primary: broken link checker [fr] → researched primary: **broken link checker** [fr 720/KD 78]
- Secondary: broken link checker [ma 110]
- Sections: 5 · keyword gaps (Partly): 1 → #1 “Vérificateur de Liens Brisés Gratuit” ⇢ broken link checker
- FAQs: 7 existing (KEEP 7)
- On-page: Title (P2): Lead with "broken link checker"

### /tools/canonical-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/canonical-checker.blade.php` · `lang/fr/tools/canonical-checker.php`
- Current title: Vérificateur de Balise Canonical Gratuit | CodeSommet (487 px) · H1: Vérificateur de Balise Canonical Gratuit
- Current mapped primary: url canonique [fr] → researched primary: **url canonique** [fr 390/KD 30]
- Secondary: canonical seo [fr 170]; url canonique [ma 30]
- Sections: 5 · keyword gaps (Partly): 2 → #1 “Vérificateur de Balise Canonical Gratuit” ⇢ url canonique; #2 “Comment utiliser cet outil” ⇢ canonical seo
- FAQs: 7 existing (KEEP 7)

### /tools/chatbot-script-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/chatbot-script-generator.blade.php` · `lang/fr/tools/chatbot-script-generator.php`
- Current title: Générateur de Script Chatbot IA Gratuit | CodeSommet (494 px) · H1: Générateur de Script Chatbot IA Gratuit
- Current mapped primary: créer un chatbot [fr] → researched primary: **créer un chatbot** [fr 480/KD 39]
- Secondary: créer un chatbot [ma 20]
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Générateur de Script Chatbot IA Gratuit” ⇢ créer un chatbot
- FAQs: 7 existing (KEEP 7)

### /tools/color-palette-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/color-palette-generator.blade.php` · `lang/fr/tools/color-palette-generator.php`
- Current title: Générateur de Palette de Couleurs Gratuit | CodeSommet (517 px) · H1: Générateur de Palette de Couleurs Gratuit
- Current mapped primary: palette de couleurs [fr] → researched primary: **palette de couleurs** [fr 1600/KD 48]
- Secondary: palette de couleurs [ma 1300]; palette couleur site web [fr 140]; générateur couleur [fr 110]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/core-web-vitals-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/core-web-vitals-checker.blade.php` · `lang/fr/tools/core-web-vitals-checker.php`
- Current title: Test Core Web Vitals Gratuit - LCP, INP, CLS | CodeSommet (547 px) · H1: Test Core Web Vitals Gratuit : LCP, INP, CLS
- Current mapped primary: test core web vitals [fr] → researched primary: **test core web vitals** [fr 110/KD 27]
- Secondary: core web vitals [fr 1900]; core web vitals test [fr 140]
- Sections: 3 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: MEDIUM vs /tools/page-speed-analyzer: vitesse / core web vitals -> Speed analyzer = "test vitesse site web"; CWV = "test core web vitals"; cross-link

### /tools/crawl-optimization-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/crawl-optimization-checker.blade.php` · `lang/fr/tools/crawl-optimization-checker.php`
- Current title: Test d'Optimisation du Budget de Crawl | CodeSommet (491 px) · H1: Test d'Optimisation du Budget de Crawl
- Current mapped primary: crawl budget [fr] → researched primary: **crawl budget** [fr 210/KD 25]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 4 existing (KEEP 4)

### /tools/crawl-visualizer  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/crawl-visualizer.blade.php` · `lang/fr/tools/crawl-visualizer.php`
- Current title: Visualiseur de Crawl - Carte des Liens Internes | CodeSommet (557 px) · H1: Visualiseur de Crawl : Carte des Liens Internes
- Current mapped primary: visualisation crawl [fr] → researched primary: **visualisation crawl** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 6 · keyword gaps (Partly): 1 → #1 “Visualiseur de Crawl : Carte des Liens Internes” ⇢ visualisation crawl
- FAQs: 6 existing (KEEP 6)
- Cannibalisation: MEDIUM vs /tools/internal-link-analyzer: maillage interne -> Analyzer owns "maillage interne"; visualizer uses "visualisation crawl / carte des liens"

### /tools/css-minifier  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/css-minifier.blade.php` · `lang/fr/tools/css-minifier.php`
- Current title: Minificateur CSS - Compression de Code Gratuite | CodeSommet (582 px) · H1: Minificateur CSS : Compression de Code Gratuite
- Current mapped primary: minify css [fr] → researched primary: **minify css** [fr 320/KD 29]
- Secondary: minifier css [fr 260]; css minifier [fr 260]; minify css [ma 170]
- Sections: 6 · keyword gaps (Partly): 1 → #1 “Minificateur CSS : Compression de Code Gratuite” ⇢ minify css
- FAQs: 7 existing (KEEP 7)
- On-page: Title (P3): Minify CSS : Minificateur CSS Gratuit | CodeSommet (470 px)
- Cannibalisation: LOW vs /tools/html-minifier: minifier -> CSS minifier owns "minify css"

### /tools/domain-authority-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/domain-authority-checker.blade.php` · `lang/fr/tools/domain-authority-checker.php`
- Current title: Score de Fondations SEO Techniques Gratuit | CodeSommet (546 px) · H1: Score de Fondations SEO Techniques Gratuit
- Current mapped primary: audit seo technique [fr] → researched primary: **audit seo technique** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: domain authority; autorité de domaine
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Score de Fondations SEO Techniques Gratuit” ⇢ audit seo technique
- FAQs: 7 existing (KEEP 7)

### /tools/domain-extractor  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/domain-extractor.blade.php` · `lang/fr/tools/domain-extractor.php`
- Current title: Extracteur de Domaines d'une Liste d'URL | CodeSommet (516 px) · H1: Extracteur de Domaines d'une Liste d'URL
- Current mapped primary: extraire domaine url [fr] → researched primary: **extraire domaine url** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 6 · keyword gaps (Partly): 0
- FAQs: 4 existing (KEEP 3, IMPROVE 1)

### /tools/domain-health-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/domain-health-checker.blade.php` · `lang/fr/tools/domain-health-checker.php`
- Current title: Santé de Domaine - Testeur DNS & SSL Gratuit | CodeSommet (567 px) · H1: Santé de Domaine : Testeur DNS & SSL Gratuit
- Current mapped primary: test dns [fr] → researched primary: **test dns** [fr 1000/KD 56]
- Secondary: test dns [ma 110]
- Do NOT target here: test ssl
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: LOW vs /tools/ssl-certificate-checker: test ssl -> SSL checker owns "test ssl"; domain health owns "test dns"

### /tools/duplicate-content-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/duplicate-content-checker.blade.php` · `lang/fr/tools/duplicate-content-checker.php`
- Current title: Vérificateur de Contenu Dupliqué Gratuit | CodeSommet (499 px) · H1: Vérificateur de Contenu Dupliqué Gratuit
- Current mapped primary: duplicate content [fr] → researched primary: **duplicate content** [fr 720/KD 32]
- Secondary: contenu dupliqué [fr 480]; duplicate content [ma 30]
- Do NOT target here: détecteur de plagiat
- Sections: 6 · keyword gaps (Partly): 2 → #1 “Vérificateur de Contenu Dupliqué Gratuit” ⇢ duplicate content; #2 “Comparer toutes les pages de votre site” ⇢ contenu dupliqué
- FAQs: 6 existing (KEEP 6)
- On-page: Title (P2): Lead with "duplicate content"

### /tools/eeat-signals-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/eeat-signals-checker.blade.php` · `lang/fr/tools/eeat-signals-checker.php`
- Current title: Vérificateur de Signaux E-E-A-T Gratuit | CodeSommet (490 px) · H1: Vérificateur de Signaux E-E-A-T Gratuit
- Current mapped primary: e-e-a-t [fr] → researched primary: **e-e-a-t** [fr 2400/KD 36]
- Secondary: eeat [fr 1600]; eeat seo [fr 260]
- Sections: 6 · keyword gaps (Partly): 3 → #2 “Signaux trouvés sur la page” ⇢ eeat; #3 “Comment Utiliser Cet Outil” ⇢ eeat seo; #6 “Renforcer la Crédibilité de Votre Site ?” ⇢ eeat
- FAQs: 4 existing (KEEP 4)

### /tools/expired-domain-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/expired-domain-checker.blade.php` · `lang/fr/tools/expired-domain-checker.php`
- Current title: Vérificateur de Domaines Expirés (RDAP) | CodeSommet (509 px) · H1: Vérificateur de Domaines Expirés (RDAP)
- Current mapped primary: nom de domaine expiré [fr] → researched primary: **nom de domaine expiré** [fr 170/KD 19]
- Secondary: nom de domaine expiré [ma 20]
- Sections: 6 · keyword gaps (Partly): 0
- FAQs: 4 existing (KEEP 4)

### /tools/faq-schema-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/faq-schema-generator.blade.php` · `lang/fr/tools/faq-schema-generator.php`
- Current title: Générateur de Schéma FAQ JSON-LD Gratuit | CodeSommet (553 px) · H1: Générateur de Schéma FAQ JSON-LD Gratuit
- Current mapped primary: faq schema [fr] → researched primary: **faq schema** [fr 50/KD NOT AVAILABLE]
- Secondary: faq schema [ma 20]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: LOW vs /tools/schema-generator: schema -> Keep - specific variants

### /tools/heading-analyzer  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/heading-analyzer.blade.php` · `lang/fr/tools/heading-analyzer.php`
- Current title: Analyseur de Titres H1-H6 - Outil SEO | CodeSommet (482 px) · H1: Analyseur de Titres H1-H6 : Outil SEO
- Current mapped primary: balise h1 [fr] → researched primary: **balise h1** [fr 390/KD 18]
- Secondary: balise h1 [ma 20]
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Analyseur de Titres H1-H6 : Outil SEO” ⇢ balise h1
- FAQs: 7 existing (KEEP 7)

### /tools/hreflang-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/hreflang-generator.blade.php` · `lang/fr/tools/hreflang-generator.php`
- Current title: Générateur de Balises Hreflang Gratuit | CodeSommet (486 px) · H1: Générateur de Balises Hreflang Gratuit
- Current mapped primary: hreflang [fr] → researched primary: **hreflang** [fr 880/KD 29]
- Secondary: balise hreflang [fr 140]; hreflang [ma 20]
- Sections: 6 · keyword gaps (Partly): 1 → #3 “Comment utiliser cet outil” ⇢ balise hreflang
- FAQs: 7 existing (KEEP 7)

### /tools/html-minifier  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/html-minifier.blade.php` · `lang/fr/tools/html-minifier.php`
- Current title: Minificateur HTML/CSS/JS Gratuit | CodeSommet (443 px) · H1: Minificateur HTML/CSS/JS Gratuit
- Current mapped primary: html minifier [fr] → researched primary: **html minifier** [fr 260/KD 29]
- Secondary: minifier html [fr 260]; minify html [fr 260]; html minifier [ma 70]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: LOW vs /tools/css-minifier: minifier -> CSS minifier owns "minify css"

### /tools/html-to-text  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/html-to-text.blade.php` · `lang/fr/tools/html-to-text.php`
- Current title: Convertisseur HTML en Texte Brut Gratuit | CodeSommet (516 px) · H1: Convertisseur HTML en Texte Brut Gratuit
- Current mapped primary: html to text [fr] → researched primary: **html to text** [fr 320/KD 68]
- Secondary: html to text [ma 140]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/image-alt-analyzer  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/image-alt-analyzer.blade.php` · `lang/fr/tools/image-alt-analyzer.php`
- Current title: Analyseur de Texte Alt d'Image - SEO | CodeSommet (478 px) · H1: Analyseur de Texte Alt d'Image : SEO
- Current mapped primary: balise alt [fr] → researched primary: **balise alt** [fr 260/KD 21]
- Secondary: balise alt [ma 10]
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Analyseur de Texte Alt d'Image : SEO” ⇢ balise alt
- FAQs: 7 existing (KEEP 7)

### /tools/image-compression-analyzer  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/image-compression-analyzer.blade.php` · `lang/fr/tools/image-compression-analyzer.php`
- Current title: Analyseur de Compression d'Images Gratuit | CodeSommet (532 px) · H1: Analyseur de Compression d'Images Gratuit
- Current mapped primary: optimisation image seo [fr] → researched primary: **optimisation image seo** [fr 20/KD NOT AVAILABLE]
- Sections: 5 · keyword gaps (Partly): 1 → #1 “Analyseur de Compression d'Images Gratuit” ⇢ optimisation image seo
- FAQs: 6 existing (KEEP 6)
- Cannibalisation: LOW vs /tools/image-compressor: compresser image -> Compressor = "compresser image"; analyzer = "optimisation image seo"

### /tools/image-compressor  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/image-compressor.blade.php` · `lang/fr/tools/image-compressor.php`
- Current title: Compresseur d'Images Gratuit - WebP, JPEG | CodeSommet (550 px) · H1: Compresseur d'Images Gratuit : WebP, JPEG
- Current mapped primary: compresser image [fr] → researched primary: **compresser image** [fr 22200/KD 28]
- Secondary: compresser photo [fr 9900]; réduire taille image [fr 8100]; compresser image [ma 5400]; compression image [fr 5400]; compresser image en ligne [fr 590]
- Sections: 6 · keyword gaps (Partly): 3 → #2 “Images optimisées” ⇢ compresser photo; #3 “Comment Utiliser Cet Outil” ⇢ réduire taille image; #6 “Un Site Trop Lent ?” ⇢ compression image
- FAQs: 5 existing (IMPROVE 1, KEEP 4) · new: [P2] Comment compresser une image sans perte de qualité ?
- On-page: Title (P2): Compresser Image Gratuit – WebP, JPEG, PNG | CodeSommet (573 px) | Title (P2): Compresser Image Gratuit – WebP, JPEG, PNG | CodeSommet (573 px)
- Cannibalisation: LOW vs /tools/image-compression-analyzer: compresser image -> Compressor = "compresser image"; analyzer = "optimisation image seo"

### /tools/internal-link-analyzer  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/internal-link-analyzer.blade.php` · `lang/fr/tools/internal-link-analyzer.php`
- Current title: Analyseur de Liens Internes Gratuit | CodeSommet (454 px) · H1: Analyseur de Liens Internes Gratuit
- Current mapped primary: maillage interne [fr] → researched primary: **maillage interne** [fr 1900/KD 25]
- Secondary: analyse maillage interne [fr 140]; maillage interne [ma 20]
- Sections: 5 · keyword gaps (Partly): 2 → #1 “Analyseur de Liens Internes Gratuit” ⇢ maillage interne; #2 “Comment Utiliser Cet Outil” ⇢ analyse maillage interne
- FAQs: 6 existing (KEEP 6)
- On-page: Title (P2): Lead with "maillage interne"
- Cannibalisation: MEDIUM vs /tools/crawl-visualizer: maillage interne -> Analyzer owns "maillage interne"; visualizer uses "visualisation crawl / carte des liens"

### /tools/invisible-character-cleaner  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/invisible-character-cleaner.blade.php` · `lang/fr/tools/invisible-character-cleaner.php`
- Current title: Nettoyeur de Caractères Invisibles Gratuit | CodeSommet (512 px) · H1: Nettoyeur de Caractères Invisibles Gratuit
- Current mapped primary: caractère invisible [fr] → researched primary: **caractère invisible** [fr 6600/KD 16]
- Secondary: caractère invisible [ma 260]
- Do NOT target here: détecter texte ia
- Sections: 7 · keyword gaps (Partly): 0
- FAQs: 4 existing (KEEP 4) · new: [P2] Qu'est-ce qu'un caractère invisible et pourquoi le supprimer ?
- On-page: Title (P3): Caractère Invisible : Détecter et Supprimer | CodeSommet (519 px)

### /tools/json-formatter  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/json-formatter.blade.php` · `lang/fr/tools/json-formatter.php`
- Current title: Formateur et Validateur JSON Gratuit | CodeSommet (476 px) · H1: Formateur et Validateur JSON Gratuit
- Current mapped primary: json formatter [fr] → researched primary: **json formatter** [fr 12100/KD 74]
- Secondary: json viewer [fr 3600]; json validator [fr 3600]; json formatter [ma 1600]; formater json [fr 110]; json en ligne [fr 110]
- Sections: 5 · keyword gaps (Partly): 2 → #1 “Formateur et Validateur JSON Gratuit” ⇢ json formatter; #2 “Comment Utiliser le Formateur JSON” ⇢ json viewer
- FAQs: 7 existing (KEEP 7)
- On-page: Title (P2): Lead with "json formatter"

### /tools/keyword-density-analyzer  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/keyword-density-analyzer.blade.php` · `lang/fr/tools/keyword-density-analyzer.php`
- Current title: Analyseur de Densité de Mots-Clés Gratuit | CodeSommet (519 px) · H1: Analyseur de Densité de Mots-Clés Gratuit
- Current mapped primary: densité mot clé [fr] → researched primary: **densité mot clé** [fr 170/KD 21]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/keyword-modifier-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/keyword-modifier-generator.blade.php` · `lang/fr/tools/keyword-modifier-generator.php`
- Current title: Générateur de Variantes de Mots-Clés | CodeSommet (483 px) · H1: Générateur de Variantes de Mots-Clés
- Current mapped primary: générateur de mots clés [fr] → researched primary: **générateur de mots clés** [fr 590/KD 38]
- Secondary: trouver mots clés [fr 260]; générateur mots clés [fr 170]; générateur de mots clés [ma 10]
- Sections: 5 · keyword gaps (Partly): 2 → #2 “Comment Utiliser Cet Outil” ⇢ trouver mots clés; #5 “Un Plan de Contenus à Bâtir ?” ⇢ générateur mots clés
- FAQs: 4 existing (KEEP 4)

### /tools/landing-page-generator  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/landing-page-generator.blade.php` · `lang/fr/tools/landing-page-generator.php`
- Current title: Générateur de Landing Page IA Gratuit | CodeSommet (489 px) · H1: Générateur de Landing Page IA Gratuit
- Current mapped primary: créer une landing page [fr] → researched primary: **créer une landing page** [fr 590/KD 31]
- Secondary: landing page [fr 8100]; landing page gratuite [fr 320]; créer une landing page [ma 20]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 5 existing (KEEP 5)
- On-page: Title (P2): Lead with "créer une landing page"

### /tools/llms-txt-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/llms-txt-generator.blade.php` · `lang/fr/tools/llms-txt-generator.php`
- Current title: Générateur de Fichier llms.txt Gratuit | CodeSommet (470 px) · H1: Générateur de Fichier llms.txt Gratuit
- Current mapped primary: llms.txt [fr] → researched primary: **llms.txt** [fr 1900/KD 31]
- Secondary: llms txt [fr 720]; fichier llms.txt [fr 320]
- Sections: 6 · keyword gaps (Partly): 1 → #6 “Votre Site Est-il Prêt pour la Recherche IA ?” ⇢ llms txt
- FAQs: 4 existing (KEEP 4) · new: [P2] Qu'est-ce qu'un fichier llms.txt et faut-il en avoir un ?

### /tools/local-business-schema  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/local-business-schema.blade.php` · `lang/fr/tools/local-business-schema.php`
- Current title: Générateur de Schéma LocalBusiness Gratuit | CodeSommet (548 px) · H1: Générateur de Schéma LocalBusiness Gratuit
- Current mapped primary: local business schema [fr] → researched primary: **local business schema** [fr 20/KD NOT AVAILABLE]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/lorem-ipsum-generator  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/lorem-ipsum-generator.blade.php` · `lang/fr/tools/lorem-ipsum-generator.php`
- Current title: Générateur Lorem Ipsum Gratuit | CodeSommet (432 px) · H1: Générateur Lorem Ipsum Gratuit
- Current mapped primary: lorem ipsum [fr] → researched primary: **lorem ipsum** [fr 40500/KD 45]
- Secondary: lorem ipsum [ma 1900]; faux texte [fr 1600]; texte lorem ipsum [fr 1000]; générateur lorem ipsum [fr 260]
- Sections: 5 · keyword gaps (Partly): 1 → #2 “Qu'est-ce que Lorem Ipsum ?” ⇢ faux texte
- FAQs: 7 existing (KEEP 7)

### /tools/meta-extractor  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/meta-extractor.blade.php` · `lang/fr/tools/meta-extractor.php`
- Current title: Extracteur de Métadonnées en Masse | CodeSommet (479 px) · H1: Extracteur de Métadonnées en Masse
- Current mapped primary: extraire meta title [fr] → researched primary: **extraire meta title** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 6 · keyword gaps (Partly): 1 → #1 “Extracteur de Métadonnées en Masse” ⇢ extraire meta title
- FAQs: 4 existing (KEEP 4)

### /tools/meta-refresh-generator  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/meta-refresh-generator.blade.php` · `lang/fr/tools/meta-refresh-generator.php`
- Current title: Générateur de Balise Meta Refresh Gratuit | CodeSommet (522 px) · H1: Générateur de Balise Meta Refresh Gratuit
- Current mapped primary: meta refresh [fr] → researched primary: **meta refresh** [fr 30/KD NOT AVAILABLE]
- Secondary: meta refresh [ma 20]
- Sections: 7 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/meta-tag-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/meta-tag-generator.blade.php` · `lang/fr/tools/meta-tag-generator.php`
- Current title: Générateur de Balises Méta IA Gratuit | CodeSommet (481 px) · H1: Générateur de Balises Méta IA Gratuit
- Current mapped primary: balise meta [fr] → researched primary: **balise meta** [fr 320/KD 37]
- Secondary: meta description [fr 1000]; balise meta [ma 20]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/mobile-friendly-test  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/mobile-friendly-test.blade.php` · `lang/fr/tools/mobile-friendly-test.php`
- Current title: Test de Compatibilité Mobile Gratuit | CodeSommet (457 px) · H1: Test de Compatibilité Mobile Gratuit
- Current mapped primary: mobile friendly test [fr] → researched primary: **mobile friendly test** [fr 210/KD 22]
- Secondary: test mobile friendly [fr 140]; mobile friendly test [ma 10]
- Sections: 3 · keyword gaps (Partly): 1 → #1 “Test de Compatibilité Mobile Gratuit” ⇢ mobile friendly test
- FAQs: 6 existing (KEEP 6)

### /tools/ngram-extractor  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/ngram-extractor.blade.php` · `lang/fr/tools/ngram-extractor.php`
- Current title: Extracteur de N-grammes - Mots Fréquents | CodeSommet (529 px) · H1: Extracteur de N-grammes : Mots Fréquents
- Current mapped primary: n-gram [fr] → researched primary: **n-gram** [fr 90/KD 19]
- Secondary: n-gram [ma 20]
- Do NOT target here: ngram
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6)

### /tools/nofollow-link-checker  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/nofollow-link-checker.blade.php` · `lang/fr/tools/nofollow-link-checker.php`
- Current title: Vérificateur de Liens Nofollow Gratuit | CodeSommet (469 px) · H1: Vérificateur de Liens Nofollow Gratuit
- Current mapped primary: nofollow [fr] → researched primary: **nofollow** [fr 260/KD 23]
- Secondary: nofollow [ma 20]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/og-preview-generator  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/og-preview-generator.blade.php` · `lang/fr/tools/og-preview-generator.php`
- Current title: Aperçu Open Graph - Testeur Image OG | CodeSommet (506 px) · H1: Aperçu Open Graph : Testeur Image OG
- Current mapped primary: open graph [fr] → researched primary: **open graph** [fr 480/KD 41]
- Secondary: og image [fr 320]; open graph [ma 20]
- Do NOT target here: facebook debugger
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)

### /tools/page-speed-analyzer  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/page-speed-analyzer.blade.php` · `lang/fr/tools/page-speed-analyzer.php`
- Current title: Analyseur de Vitesse de Page Gratuit | CodeSommet (473 px) · H1: Analyseur de Vitesse de Page Gratuit
- Current mapped primary: test vitesse site web [fr] → researched primary: **test vitesse site web** [fr 260/KD 36]
- Secondary: test vitesse site [fr 260]; vitesse site web [fr 210]; tester vitesse site web [fr 170]; test vitesse site web [ma 20]
- Do NOT target here: pagespeed
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Analyseur de Vitesse de Page Gratuit” ⇢ test vitesse site web
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: MEDIUM vs /tools/core-web-vitals-checker: vitesse / core web vitals -> Speed analyzer = "test vitesse site web"; CWV = "test core web vitals"; cross-link

### /tools/qr-code-generator  —  P3  —  VERIFIED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/qr-code-generator.blade.php` · `lang/fr/tools/qr-code-generator.php`
- Current title: Générateur de QR Code Gratuit | CodeSommet (425 px) · H1: Générateur de QR Code Gratuit
- Current mapped primary: générateur qr code [fr] → researched primary: **générateur qr code** [fr 4400/KD 44]
- Secondary: qr code gratuit [fr 40500]; générer qr code [fr 5400]; créer qr code [fr 3600]; générateur qr code [ma 210]
- Sections: 5 · keyword gaps (Partly): 1 → #2 “Cas d'Utilisation” ⇢ qr code gratuit
- FAQs: 7 existing (KEEP 7) · new: [P2] Un QR code généré ici est-il gratuit et sans date d'expiration ?
- On-page: Title (P3): Générateur QR Code Gratuit et Sans Expiration | CodeSommet (565 px)

### /tools/readability-analyzer  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/readability-analyzer.blade.php` · `lang/fr/tools/readability-analyzer.php`
- Current title: Analyseur de Lisibilité de Contenu Gratuit | CodeSommet (506 px) · H1: Analyseur de Lisibilité de Contenu Gratuit
- Current mapped primary: test lisibilité [fr] → researched primary: **test lisibilité** [fr 20/KD NOT AVAILABLE]
- Secondary: flesch [fr 110]
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Analyseur de Lisibilité de Contenu Gratuit” ⇢ test lisibilité
- FAQs: 5 existing (KEEP 5)

### /tools/redirect-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/redirect-checker.blade.php` · `lang/fr/tools/redirect-checker.php`
- Current title: Vérificateur de Redirections 301 et 302 | CodeSommet (485 px) · H1: Vérificateur de Redirections 301 et 302
- Current mapped primary: redirect checker [fr] → researched primary: **redirect checker** [fr 480/KD 55]
- Secondary: redirection 301 [fr 1000]; test redirection [fr 260]; redirect checker [ma 170]
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Vérificateur de Redirections 301 et 302” ⇢ redirect checker
- FAQs: 7 existing (KEEP 7)

### /tools/robots-txt-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/robots-txt-generator.blade.php` · `lang/fr/tools/robots-txt-generator.php`
- Current title: Générateur de Fichier Robots.txt Gratuit | CodeSommet (498 px) · H1: Générateur de Fichier Robots.txt Gratuit
- Current mapped primary: robots.txt [fr] → researched primary: **robots.txt** [fr 1900/KD 36]
- Secondary: robots.txt [ma 260]
- Sections: 6 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: MEDIUM vs /tools/robots-txt-tester: robots.txt -> Generator = "robots.txt / créer robots.txt"; tester = "test robots.txt"; see next row

### /tools/robots-txt-tester  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/robots-txt-tester.blade.php` · `lang/fr/tools/robots-txt-tester.php`
- Current title: Testeur Robots.txt - URL Bloquée ou Non ? | CodeSommet (527 px) · H1: Testeur Robots.txt : URL Bloquée ou Non ?
- Current mapped primary: test robots.txt [fr] → researched primary: **test robots.txt** [fr 260/KD 20]
- Secondary: robots.txt tester [fr 320]; test robots.txt [ma 20]
- Sections: 8 · keyword gaps (Partly): 2 → #3 “Groupes et règles” ⇢ robots.txt tester; #5 “Comment Utiliser Cet Outil” ⇢ robots.txt tester
- FAQs: 6 existing (KEEP 6)
- Cannibalisation: MEDIUM vs /tools/robots-txt-generator: robots.txt -> Generator = "robots.txt / créer robots.txt"; tester = "test robots.txt"; see next row | HIGH vs /tools/robots-validator: test / valider robots.txt -> Owner decision: merge validator into tester (301) or differentiate validator as syntax linting; no measurable demand for "valider robots.txt"

### /tools/robots-validator  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/robots-validator.blade.php` · `lang/fr/tools/robots-validator.php`
- Current title: Validateur Robots.txt Gratuit | CodeSommet (392 px) · H1: Validateur Robots.txt Gratuit
- Current mapped primary: valider robots.txt [fr] → researched primary: **valider robots.txt** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: HIGH vs /tools/robots-txt-tester: test / valider robots.txt -> Owner decision: merge validator into tester (301) or differentiate validator as syntax linting; no measurable demand for "valider robots.txt"

### /tools/schema-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/schema-generator.blade.php` · `lang/fr/tools/schema-generator.php`
- Current title: Générateur de Schema Markup JSON-LD | CodeSommet (512 px) · H1: Générateur de Schema Markup JSON-LD
- Current mapped primary: schema markup [fr] → researched primary: **schema markup** [fr 210/KD 12]
- Secondary: json-ld [fr 1000]; données structurées [fr 880]; schema markup [ma 50]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 5 existing (KEEP 5)
- Cannibalisation: LOW vs /tools/structured-data-extractor: données structurées -> Generator = "schema markup / données structurées"; extractor = "test données structurées" | LOW vs /tools/faq-schema-generator: schema -> Keep - specific variants

### /tools/security-headers-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/security-headers-checker.blade.php` · `lang/fr/tools/security-headers-checker.php`
- Current title: Test des En-têtes de Sécurité HTTP (A à F) | CodeSommet (529 px) · H1: Test des En-têtes de Sécurité HTTP (A à F)
- Current mapped primary: security headers [fr] → researched primary: **security headers** [fr 480/KD 52]
- Secondary: security headers [ma 50]
- Sections: 7 · keyword gaps (Partly): 1 → #1 “Test des En-têtes de Sécurité HTTP (A à F)” ⇢ security headers
- FAQs: 6 existing (KEEP 6)

### /tools/serp-snippet-preview  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/serp-snippet-preview.blade.php` · `lang/fr/tools/serp-snippet-preview.php`
- Current title: Aperçu SERP Google - Titre et Meta | CodeSommet (464 px) · H1: Aperçu SERP Google : Titre et Meta
- Current mapped primary: simulateur serp [fr] → researched primary: **simulateur serp** [fr 260/KD 11]
- Sections: 6 · keyword gaps (Partly): 1 → #1 “Aperçu SERP Google : Titre et Meta” ⇢ simulateur serp
- FAQs: 6 existing (KEEP 6)

### /tools/sitemap-url-extractor  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/sitemap-url-extractor.blade.php` · `lang/fr/tools/sitemap-url-extractor.php`
- Current title: Extracteur d'URL de Sitemap XML Gratuit | CodeSommet (512 px) · H1: Extracteur d'URL de Sitemap XML Gratuit
- Current mapped primary: sitemap url extractor [fr] → researched primary: **sitemap url extractor** [fr 10/KD NOT AVAILABLE]
- Sections: 9 · keyword gaps (Partly): 1 → #1 “Extracteur d'URL de Sitemap XML Gratuit” ⇢ sitemap url extractor
- FAQs: 6 existing (KEEP 6)

### /tools/sitemap-validator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/sitemap-validator.blade.php` · `lang/fr/tools/sitemap-validator.php`
- Current title: Validateur de Sitemap XML Gratuit | CodeSommet (449 px) · H1: Validateur de Sitemap XML Gratuit
- Current mapped primary: sitemap validator [fr] → researched primary: **sitemap validator** [fr 70/KD 31]
- Secondary: sitemap validator [ma 10]
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Validateur de Sitemap XML Gratuit” ⇢ sitemap validator
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: LOW vs /tools/xml-sitemap-generator: sitemap xml -> Distinct tasks - keep; cross-link

### /tools/ssl-certificate-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/ssl-certificate-checker.blade.php` · `lang/fr/tools/ssl-certificate-checker.php`
- Current title: Vérificateur de Certificat SSL/TLS Gratuit | CodeSommet (505 px) · H1: Vérificateur de Certificat SSL/TLS Gratuit
- Current mapped primary: test ssl [fr] → researched primary: **test ssl** [fr 320/KD 37]
- Secondary: ssl checker [fr 1900]; test ssl [ma 20]
- Do NOT target here: certificat ssl
- Sections: 4 · keyword gaps (Partly): 2 → #1 “Vérificateur de Certificat SSL/TLS Gratuit” ⇢ test ssl; #2 “Ce que Cet Outil Vérifie” ⇢ ssl checker
- FAQs: 6 existing (KEEP 6)
- Cannibalisation: LOW vs /tools/domain-health-checker: test ssl -> SSL checker owns "test ssl"; domain health owns "test dns"

### /tools/structured-data-extractor  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/structured-data-extractor.blade.php` · `lang/fr/tools/structured-data-extractor.php`
- Current title: Extracteur de Données Structurées JSON-LD | CodeSommet (544 px) · H1: Extracteur de Données Structurées JSON-LD
- Current mapped primary: test données structurées [fr] → researched primary: **test données structurées** [fr 720/KD 37]
- Secondary: tester données structurées [fr 480]
- Sections: 7 · keyword gaps (Partly): 4 → #1 “Extracteur de Données Structurées JSON-LD” ⇢ test données structurées; #2 “Entités détectées” ⇢ tester données structurées; #3 “Blocs JSON-LD” ⇢ tester données structurées; #4 “Comment Utiliser Cet Outil” ⇢ tester données structurées
- FAQs: 6 existing (KEEP 6)
- On-page: Title (P2): Lead with "test données structurées"
- Cannibalisation: LOW vs /tools/schema-generator: données structurées -> Generator = "schema markup / données structurées"; extractor = "test données structurées"

### /tools/text-case-converter  —  P3  —  VERIFIED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/text-case-converter.blade.php` · `lang/fr/tools/text-case-converter.php`
- Current title: Convertisseur de Casse de Texte Gratuit | CodeSommet (503 px) · H1: Convertisseur de Casse de Texte Gratuit
- Current mapped primary: majuscule en minuscule [fr] → researched primary: **majuscule en minuscule** [fr 3600/KD 25]
- Secondary: mettre en majuscule [fr 390]; majuscule en minuscule [ma 20]
- Sections: 5 · keyword gaps (Partly): 1 → #2 “Ce que Cet Outil Fait” ⇢ mettre en majuscule
- FAQs: 6 existing (KEEP 6) · new: [P3] Comment transformer un texte en majuscules ou minuscules ?
- On-page: Title (P2): Majuscule en Minuscule : Convertisseur Gratuit | CodeSommet (559 px) | Title (P2): Majuscule en Minuscule : Convertisseur Gratuit | CodeSommet (559 px)

### /tools/text-editor  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/text-editor.blade.php` · `lang/fr/tools/text-editor.php`
- Current title: Éditeur de Texte Ligne par Ligne Gratuit | CodeSommet (496 px) · H1: Éditeur de Texte Ligne par Ligne Gratuit
- Current mapped primary: éditeur de texte en ligne [fr] → researched primary: **éditeur de texte en ligne** [fr 260/KD 57]
- Secondary: éditeur de texte en ligne [ma 10]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 4 existing (KEEP 2, IMPROVE 2)

### /tools/url-editor  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/url-editor.blade.php` · `lang/fr/tools/url-editor.php`
- Current title: Éditeur d'URL en Masse - Nettoyer les URL | CodeSommet (526 px) · H1: Éditeur d'URL en Masse : Nettoyer les URL
- Current mapped primary: nettoyer url [fr] → researched primary: **nettoyer url** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 5 existing (KEEP 4, IMPROVE 1)

### /tools/url-slug-generator  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/url-slug-generator.blade.php` · `lang/fr/tools/url-slug-generator.php`
- Current title: Générateur de Slug d'URL SEO Gratuit | CodeSommet (489 px) · H1: Générateur de Slug d'URL SEO Gratuit
- Current mapped primary: slug seo [fr] → researched primary: **slug seo** [fr 170/KD 13]
- Secondary: slug seo [ma 10]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 3 existing (KEEP 3)

### /tools/utm-builder  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/utm-builder.blade.php` · `lang/fr/tools/utm-builder.php`
- Current title: Générateur d'URL UTM Gratuit | CodeSommet (417 px) · H1: Générateur d'URL UTM Gratuit
- Current mapped primary: utm builder [fr] → researched primary: **utm builder** [fr 1600/KD 51]
- Secondary: utm [fr 5400]; lien utm [fr 260]; utm builder [ma 210]
- Sections: 6 · keyword gaps (Partly): 2 → #1 “Générateur d'URL UTM Gratuit” ⇢ utm builder; #2 “Générateur d'URL de Campagne” ⇢ utm
- FAQs: 7 existing (KEEP 7)
- On-page: Title (P2): Lead with "utm builder"

### /tools/website-analyzer  —  P1  —  VERIFIED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/website-analyzer.blade.php` · `lang/fr/tools/website-analyzer.php`
- Current title: Analyseur de Site Web - Audit SEO Gratuit | CodeSommet (521 px) · H1: Analyseur de Site Web : Audit SEO Gratuit
- Current mapped primary: audit seo gratuit [fr] → researched primary: **audit seo gratuit** [fr 1900/KD 31]
- Secondary: audit seo [fr 6600]; audit site web [fr 1600]; analyse site web gratuit [fr 880]; analyse seo gratuit [fr 590]; audit site web gratuit [fr 480]; analyser mon site web [fr 260]; analyseur site web [fr 260]; test site web gratuit [fr 170]
- Sections: 8 · keyword gaps (Partly): 0
- FAQs: 8 existing (KEEP 8) · new: [P1] L'audit SEO de ce site est-il vraiment gratuit et sans inscription ?
- On-page: Heading count (P2): Demote decorative headings (card labels, step titles) to styled <div class="hd-3"> per existing pattern; keep  | Internal link (P2): Contextual link to /services/seo-maroc with anchor "accompagnement SEO au Maroc" | Title (P3): Audit SEO Gratuit – Analyseur de Site Web | CodeSommet (525 px)
- Cannibalisation: LOW vs /tools/website-readiness-checker: analyse site web -> Readiness = pre-launch checklist; analyzer = SEO audit

### /tools/website-readiness-checker  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/website-readiness-checker.blade.php` · `lang/fr/tools/website-readiness-checker.php`
- Current title: Vérificateur de Préparation de Site Web Gratuit | CodeSommet (559 px) · H1: Vérificateur de Préparation de Site Web Gratuit
- Current mapped primary: checklist mise en ligne site [fr] → researched primary: **checklist mise en ligne site** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 4 · keyword gaps (Partly): 1 → #1 “Vérificateur de Préparation de Site Web Gratuit” ⇢ checklist mise en ligne site
- FAQs: 10 existing (KEEP 10)
- Cannibalisation: LOW vs /tools/website-analyzer: analyse site web -> Readiness = pre-launch checklist; analyzer = SEO audit

### /tools/word-counter  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/word-counter.blade.php` · `lang/fr/tools/word-counter.php`
- Current title: Compteur de Mots et de Caractères Gratuit | CodeSommet (527 px) · H1: Compteur de Mots et de Caractères Gratuit
- Current mapped primary: compteur de mots [fr] → researched primary: **compteur de mots** [fr 18100/KD 32]
- Secondary: compteur de caractères [fr 9900]; nombre de mots [fr 2900]; compter les mots [fr 2900]; compteur de mot [fr 2900]; compteur de mots [ma 480]
- Sections: 4 · keyword gaps (Partly): 0
- FAQs: 6 existing (KEEP 6) · new: [P3] Combien de mots faut-il pour un article SEO ?

### /tools/xml-sitemap-generator  —  P3  —  COMPLETED
- Type / country / lang: Free tool · Francophone (FR proxy) + Morocco · fr
- Source: `resources/views/frontoffice/pages/tools/xml-sitemap-generator.blade.php` · `lang/fr/tools/xml-sitemap-generator.php`
- Current title: Générateur de Sitemap XML Gratuit | CodeSommet (462 px) · H1: Générateur de Sitemap XML Gratuit
- Current mapped primary: sitemap xml [fr] → researched primary: **sitemap xml** [fr 720/KD 39]
- Secondary: sitemap generator [fr 480]; sitemap xml [ma 210]
- Sections: 8 · keyword gaps (Partly): 2 → #2 “Trouver les URL en explorant votre site” ⇢ sitemap generator; #5 “Comprendre les Paramètres du Sitemap” ⇢ sitemap generator
- FAQs: 7 existing (KEEP 7)
- Cannibalisation: LOW vs /tools/sitemap-validator: sitemap xml -> Distinct tasks - keep; cross-link

### /our-work/akoubri  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Case study · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work/akoubri.blade.php` · `lang/fr/our-work/akoubri.php`
- Current title: Akoubri - Site d'Architecte à Marrakech | CodeSommet (487 px) · H1: Akoubri Site d'Architecte à Marrakech
- Current mapped primary: création site web architecte [fr] → researched primary: **création site web architecte** [fr 70/KD 6]
- Secondary: site web architecte [fr 70]
- Do NOT target here: architecte marrakech
- Sections: 5 · keyword gaps (Partly): 1 → #1 “Akoubri Site d'Architecte à Marrakech” ⇢ création site web architecte
- FAQs: 0 existing (none)
- On-page: H1 (P2): Consider including "création site web architecte" naturally (keep single H1) | Internal link (P4): Contextual link to /web-development-company/marrakech with anchor "création de site web à Marrakech"

### /our-work/authentic-morocco-adventures  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Case study · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work/authentic-morocco-adventures.blade.php` · `lang/fr/our-work/authentic-morocco-adventures.php`
- Current title: Authentic Morocco Adventures - Circuits Privés | CodeSommet (558 px) · H1: Authentic Morocco Adventures Circuits Privés
- Current mapped primary: site web agence de voyage [fr] → researched primary: **site web agence de voyage** [fr 70/KD 10]
- Sections: 5 · keyword gaps (Partly): 1 → #1 “Authentic Morocco Adventures Circuits Privés” ⇢ site web agence de voyage
- FAQs: 0 existing (none)
- On-page: H1 (P2): Consider including "site web agence de voyage" naturally (keep single H1)
- Cannibalisation: LOW vs /our-work/morocco-quest: site agence de voyage -> Different angles: luxury agency vs private tours; distinct titles already

### /our-work/dental-pro  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Case study · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work/dental-pro.blade.php` · `lang/fr/our-work/dental-pro.php`
- Current title: Dental Pro - E-commerce & CMS Dentaire | CodeSommet (516 px) · H1: Dental Pro E-commerce & CMS Dentaire
- Current mapped primary: site e-commerce dentaire [fr] → researched primary: **site e-commerce dentaire** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)

### /our-work/glamworlds  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Case study · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work/glamworlds.blade.php` · `lang/fr/our-work/glamworlds.php`
- Current title: GlamWorlds - Boutique Shopify de Lunettes | CodeSommet (529 px) · H1: GlamWorlds Boutique Shopify de Lunettes
- Current mapped primary: création boutique shopify [fr] → researched primary: **création boutique shopify** [fr 50/KD NOT AVAILABLE]
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- On-page: H1 (P2): Consider including "création boutique shopify" naturally (keep single H1)

### /our-work/gls-sprachenzentrum  —  P3  —  COMPLETED
- Type / country / lang: Case study · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work/gls-sprachenzentrum.blade.php` · `lang/fr/our-work/gls-sprachenzentrum.php`
- Current title: GLS Sprachenzentrum - École de Langue Allemande | CodeSommet (610 px) · H1: GLS Sprachenzentrum École de Langue Allemande
- Current mapped primary: site web école de langues [ma] → researched primary: **site web école de langues** [ma NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: cours allemand casablanca
- Sections: 5 · keyword gaps (Partly): 1 → #1 “GLS Sprachenzentrum École de Langue Allemande” ⇢ site web école de langues
- FAQs: 0 existing (none)
- On-page: Title (P3): GLS Sprachenzentrum – École d'Allemand | CodeSommet (518 px) | Internal link (P4): Contextual link to /services/language-school-website-development with anchor "site web pour école de langues"

### /our-work/hssabek  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Case study · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work/hssabek.blade.php` · `lang/fr/our-work/hssabek.php`
- Current title: Hssabek - SaaS de Facturation Multi-Tenant | CodeSommet (534 px) · H1: Hssabek SaaS de Facturation Multi-Tenant
- Current mapped primary: saas facturation [fr] → researched primary: **saas facturation** [fr 20/KD NOT AVAILABLE]
- Do NOT target here: logiciel de facturation; logiciel facturation maroc
- Sections: 5 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- Cannibalisation: LOW vs /services/saas-platform-development: saas facturation -> Case study links to service

### /our-work/mon-asso  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Case study · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work/mon-asso.blade.php` · `lang/fr/our-work/mon-asso.php`
- Current title: Mon Asso - SaaS de Gestion Associative | CodeSommet (504 px) · H1: Mon Asso SaaS de Gestion Associative
- Current mapped primary: développement saas association [fr] → researched primary: **développement saas association** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: logiciel gestion association
- Sections: 5 · keyword gaps (Partly): 1 → #1 “Mon Asso SaaS de Gestion Associative” ⇢ développement saas association
- FAQs: 0 existing (none)

### /our-work/morocco-quest  —  P3  —  REVIEWED – NO CHANGE NEEDED
- Type / country / lang: Case study · Morocco · fr
- Source: `resources/views/frontoffice/pages/our-work/morocco-quest.blade.php` · `lang/fr/our-work/morocco-quest.php`
- Current title: Morocco Quest - Agence de Voyage de Luxe | CodeSommet (540 px) · H1: Morocco Quest Agence de Voyage de Luxe
- Current mapped primary: création site agence de voyage [fr] → researched primary: **création site agence de voyage** [fr 70/KD NOT AVAILABLE]
- Do NOT target here: site agence de voyage
- Sections: 5 · keyword gaps (Partly): 1 → #1 “Morocco Quest Agence de Voyage de Luxe” ⇢ création site agence de voyage
- FAQs: 0 existing (none)
- On-page: H1 (P2): Consider including "création site agence de voyage" naturally (keep single H1) | Internal link (P2): Contextual link to /web-development-company/marrakech with anchor "agence web à Marrakech"
- Cannibalisation: LOW vs /our-work/authentic-morocco-adventures: site agence de voyage -> Different angles: luxury agency vs private tours; distinct titles already

### /blog/creer-une-plateforme-saas-mvp-multi-tenant-facturation-par-ou-commencer  —  P3  —  REVIEWED – NO CHANGE (DB content; links to services already present)
- Type / country / lang: Blog article · Francophone (FR proxy) + Morocco · fr
- Source: `DB (blog_posts) - seeded by database/seeders/SeoArticlesSeeder.php` · `n/a (DB content)`
- Current title: Créer une plateforme SaaS : MVP et multi-tenant | CodeSommet (578 px) · H1: Créer une plateforme SaaS : MVP, multi-tenant, facturation — par où commencer ?
- Current mapped primary: créer un saas [fr] → researched primary: **créer un saas** [fr 170/KD 10]
- Secondary: mvp saas [fr 110]; créer un logiciel saas [fr 70]
- Do NOT target here: développement saas
- Sections: 11 · keyword gaps (Partly): 1 → #9 “Par où commencer, concrètement” ⇢ mvp saas
- FAQs: 0 existing (none) · new: [P3] Comment créer un SaaS sans équipe technique ?
- On-page: Internal link (P4): Contextual link to /services/saas-platform-development with anchor "développement SaaS sur mesure"
- Cannibalisation: LOW vs /services/saas-platform-development: plateforme saas -> Blog = how-to ("créer un saas", "mvp saas"); service = "développement saas"

### /blog/site-immobilier-structurer-les-annonces-pour-le-seo-et-la-conversion  —  P3  —  REVIEWED – NO CHANGE (DB content; links to services already present)
- Type / country / lang: Blog article · Francophone (FR proxy) + Morocco · fr
- Source: `DB (blog_posts) - seeded by database/seeders/SeoArticlesSeeder.php` · `n/a (DB content)`
- Current title: Site immobilier : des annonces qui convertissent (428 px) · H1: Site immobilier : comment structurer les annonces pour le SEO et la conversion
- Current mapped primary: seo immobilier [fr] → researched primary: **seo immobilier** [fr 480/KD 24]
- Secondary: référencement site immobilier [fr 320]
- Do NOT target here: création site immobilier
- Sections: 13 · keyword gaps (Partly): 5 → #2 “Penser l'annonce comme une page à part entière” ⇢ référencement site immobilier; #4 “Le contenu descriptif : ce que la fiche technique ” ⇢ référencement site immobilier; #6 “Les photos : le premier facteur de conversion” ⇢ référencement site immobilier; #9 “Le maillage entre les annonces et les pages de sec” ⇢ référencement site immobilier; #11 “En résumé” ⇢ référencement site immobilier
- FAQs: 0 existing (none)
- On-page: Internal link (P4): Contextual link to /services/real-estate-website-development with anchor "création de site immobilier"
- Cannibalisation: LOW vs /services/real-estate-website-development: site immobilier -> Blog = "seo immobilier"; service = "création site immobilier"

### /blog/lms-sur-mesure-ou-produit-edtech-quelle-plateforme-e-learning  —  P3  —  REVIEWED – NO CHANGE (DB content; links to services already present)
- Type / country / lang: Blog article · Francophone (FR proxy) + Morocco · fr
- Source: `DB (blog_posts) - seeded by database/seeders/SeoArticlesSeeder.php` · `n/a (DB content)`
- Current title: LMS sur mesure ou EdTech : que choisir ? | CodeSommet (520 px) · H1: LMS sur mesure ou produit EdTech : quelle plateforme e-learning pour votre organisation ?
- Current mapped primary: lms sur mesure [fr] → researched primary: **lms sur mesure** [fr NOT AVAILABLE/KD NOT AVAILABLE]
- Do NOT target here: plateforme lms
- Sections: 10 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- On-page: Internal link (P4): Contextual link to /services/elearning-platform-development with anchor "plateforme e-learning sur mesure"
- Cannibalisation: LOW vs /services/elearning-platform-development: plateforme lms / lms -> Blog = "lms sur mesure" (comparison); service = "plateforme lms" (commercial)

### /blog/site-web-telemedecine-cabinet-clinique-que-doit-il-contenir  —  P3  —  REVIEWED – NO CHANGE (DB content; links to services already present)
- Type / country / lang: Blog article · Francophone (FR proxy) + Morocco · fr
- Source: `DB (blog_posts) - seeded by database/seeders/SeoArticlesSeeder.php` · `n/a (DB content)`
- Current title: Site de télémédecine : le contenu essentiel | CodeSommet (519 px) · H1: Site web de télémédecine pour cabinet ou clinique : que doit-il contenir ?
- Current mapped primary: site de télémédecine [fr] → researched primary: **site de télémédecine** [fr 20/KD NOT AVAILABLE]
- Do NOT target here: site web cabinet médical
- Sections: 13 · keyword gaps (Partly): 0
- FAQs: 0 existing (none)
- On-page: Internal link (P4): Contextual link to /services/telemedicine-website-development with anchor "site web pour cabinet médical"
- Cannibalisation: LOW vs /services/telemedicine-website-development: site web cabinet médical / télémédecine -> Blog links to service with commercial anchor; keep blog informational

### /blog/site-web-fintech-7-elements-qui-rassurent-un-visiteur  —  P3  —  REVIEWED – NO CHANGE (DB content; links to services already present)
- Type / country / lang: Blog article · Francophone (FR proxy) + Morocco · fr
- Source: `DB (blog_posts) - seeded by database/seeders/SeoArticlesSeeder.php` · `n/a (DB content)`
- Current title: Site fintech : 7 éléments qui rassurent | CodeSommet (476 px) · H1: Site web fintech : les 7 éléments qui rassurent un visiteur avant qu'il ne vous contacte
- Current mapped primary: éléments de réassurance site web [fr] → researched primary: **éléments de réassurance site web** [fr 70/KD 17]
- Do NOT target here: site web fintech
- Sections: 12 · keyword gaps (Partly): 1 → #1 “Site web fintech : les 7 éléments qui rassurent un” ⇢ éléments de réassurance site web
- FAQs: 0 existing (none)
- On-page: H1 (P2): Consider including "éléments de réassurance site web" naturally (keep single H1) | Internal link (P4): Contextual link to /services/fintech-website-development with anchor "création de site fintech"
- Cannibalisation: MEDIUM vs /services/fintech-website-development: site web fintech -> Blog = "éléments de réassurance site web"; keep "site web fintech" commercial on the service page
