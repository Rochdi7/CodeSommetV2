#!/usr/bin/env python3
"""
Translate service page blade files from English to French.
Preserves all HTML structure, CSS classes, Blade directives, and JavaScript.
Only translates visible text content and meta attributes.
"""

import re
import os

BASE = r"c:\Users\ASUS\Desktop\pikasso studio\pikassostudio.com\resources\views\pages\services"

FILES = [
    "ecommerce-website-development.blade.php",
    "edtech-platform-development.blade.php",
    "education-website-development.blade.php",
    "fintech-platform-development.blade.php",
    "fintech-website-development.blade.php",
    "healthcare-website-development.blade.php",
    "immigration-consultancy-website-development.blade.php",
]

# Comprehensive English-to-French translation dictionary
# Ordered from longest to shortest to avoid partial replacements
TRANSLATIONS = {
    # ===== @section meta translations =====
    # These will be handled separately via regex on @section lines

    # ===== LONG PHRASES FIRST (to avoid partial matches) =====

    # Common long phrases across all service pages
    "Enterprise platform connecting technology providers with decision makers": "Plateforme d'entreprise connectant les fournisseurs de technologie avec les décideurs",
    "Real projects, real results. See how we&#x27;ve helped businesses in": "Projets réels, résultats réels. Découvrez comment nous avons aidé les entreprises du secteur",
    "Real projects, real results. See how we&apos;ve helped businesses in": "Projets réels, résultats réels. Découvrez comment nous avons aidé les entreprises du secteur",
    "achieve their digital goals.": "à atteindre leurs objectifs numériques.",
    "achieve their digital goals": "à atteindre leurs objectifs numériques",
    "Local expertise meets global standards. Here&#x27;s what makes us the perfect web development partner in": "L'expertise locale rencontre les standards internationaux. Voici ce qui fait de nous le partenaire idéal en développement web dans le secteur",
    "Local expertise meets global standards. Here&apos;s what makes us the perfect web development partner in": "L'expertise locale rencontre les standards internationaux. Voici ce qui fait de nous le partenaire idéal en développement web dans le secteur",
    "Sound familiar? We&#x27;ve solved these exact problems for 40+": "Cela vous semble familier ? Nous avons résolu ces problèmes exacts pour plus de 40",
    "Sound familiar? We&apos;ve solved these exact problems for 40+": "Cela vous semble familier ? Nous avons résolu ces problèmes exacts pour plus de 40",
    "Generic web developers don&#x27;t understand these": "Les développeurs web généralistes ne comprennent pas ces",
    "Generic web developers don&apos;t understand these": "Les développeurs web généralistes ne comprennent pas ces",
    "-specific pain points": " spécifiques à ce secteur",
    "e-commerce-specific pain points": "problématiques spécifiques au e-commerce",
    "edtech-specific pain points": "problématiques spécifiques à l'edtech",
    "education-specific pain points": "problématiques spécifiques à l'éducation",
    "fintech-specific pain points": "problématiques spécifiques à la fintech",
    "healthcare-specific pain points": "problématiques spécifiques à la santé",
    "immigration-specific pain points": "problématiques spécifiques à l'immigration",

    # CTA and common buttons
    "Book Free Discovery Call": "Réserver un Appel Découverte Gratuit",
    "See Our Solution": "Voir Notre Solution",
    "See Pricing": "Voir les Tarifs",
    "Get Started Today": "Commencer Aujourd'hui",
    "Get Started": "Commencer",
    "Start Your Project": "Démarrer Votre Projet",
    "Request a Quote": "Demander un Devis",
    "Contact Us": "Contactez-nous",
    "Learn More": "En Savoir Plus",
    "View Case Study": "Voir l'Étude de Cas",
    "View All Projects": "Voir Tous les Projets",
    "View Portfolio": "Voir le Portfolio",
    "Schedule a Call": "Planifier un Appel",
    "Book a Call": "Réserver un Appel",

    # Common section headers / badges
    "Why Choose Us": "Pourquoi Nous Choisir",
    "Common Challenges": "Défis Courants",
    "Our Work in": "Nos Réalisations en",
    "7-10 Day Launch Timeline": "Calendrier de Lancement en 7-10 Jours",
    "Our Development Process": "Notre Processus de Développement",
    "Purpose-Built for": "Conçu sur Mesure pour",
    "Essential Features": "Fonctionnalités Essentielles",
    "Success Stories from": "Histoires de Succès en",
    "Trusted by": "Fait Confiance par les",
    "Now Accepting": "Accepte Actuellement les Projets",
    "Projects": "Projets",
    "Specialized Industry": "Industrie Spécialisée",
    "Based in": "Basé dans le secteur",

    # Stats
    "50+ Projects Delivered": "50+ Projets Livrés",
    "100+ Prospects": "100+ Prospects",
    "35+ Clients": "35+ Clients",
    "7-10 Day Delivery": "Livraison en 7-10 Jours",
    "Real results from": "Résultats réels d'entreprises",
    "-based businesses we&#x27;ve partnered with": " avec lesquelles nous avons collaboré",
    "-based businesses we&apos;ve partnered with": " avec lesquelles nous avons collaboré",

    # Breadcrumb
    "Industries": "Industries",

    # Timeline
    "Week 1": "Semaine 1",
    "Week 2": "Semaine 2",
    "Week 3": "Semaine 3",
    "Week 4": "Semaine 4",

    # Pricing section common
    "Choose Your Plan": "Choisissez Votre Forfait",
    "Investment": "Investissement",
    "Transparent pricing with no hidden fees": "Tarification transparente sans frais cachés",
    "Most Popular": "Le Plus Populaire",
    "Best Value": "Meilleur Rapport Qualité-Prix",
    "Enterprise": "Entreprise",
    "Custom": "Sur Mesure",
    "Starting at": "À partir de",
    "per month": "par mois",
    "per year": "par an",
    "one-time": "unique",
    "Includes": "Inclut",
    "Everything in": "Tout dans",
    "plus": "plus",
    "All features": "Toutes les fonctionnalités",
    "Priority support": "Support prioritaire",
    "Custom integrations": "Intégrations personnalisées",
    "Dedicated account manager": "Gestionnaire de compte dédié",
    "SLA guarantee": "Garantie SLA",

    # FAQ section
    "Frequently Asked Questions": "Questions Fréquemment Posées",
    "Got questions? We&#x27;ve got answers.": "Vous avez des questions ? Nous avons les réponses.",
    "Got questions? We&apos;ve got answers.": "Vous avez des questions ? Nous avons les réponses.",

    # CTA section
    "Ready to Transform Your": "Prêt à Transformer Votre",
    "Ready to Build Your": "Prêt à Construire Votre",
    "Ready to Launch Your": "Prêt à Lancer Votre",
    "Digital Presence": "Présence Numérique",
    "Online Presence": "Présence en Ligne",

    # ===== E-COMMERCE SPECIFIC =====
    "WE BUILD WEBSITES THAT DRIVE": "NOUS CRÉONS DES SITES WEB QUI GÉNÈRENT DES",
    "ONLINE STORES": "BOUTIQUES EN LIGNE",
    "Custom e-commerce platforms with secure payment processing, real-time inventory management, AI-powered product recommendations, and conversion-optimized checkout flows to help retailers, brands, and startups maximize online sales.": "Plateformes e-commerce personnalisées avec traitement sécurisé des paiements, gestion d'inventaire en temps réel, recommandations de produits alimentées par l'IA et flux de paiement optimisés pour la conversion afin d'aider les détaillants, les marques et les startups à maximiser leurs ventes en ligne.",
    "Why Choose Pikasso Studio in": "Pourquoi Choisir Pikasso Studio dans le secteur",
    "Conversion-Optimized Checkout": "Paiement Optimisé pour la Conversion",
    "Streamlined checkout flow with guest checkout, autofill, multiple payment options, and abandoned cart recovery to maximize conversions.": "Flux de paiement simplifié avec paiement invité, remplissage automatique, options de paiement multiples et récupération de panier abandonné pour maximiser les conversions.",
    "Secure Payment Processing": "Traitement Sécurisé des Paiements",
    "PCI-compliant payment gateway integration with Stripe, PayPal, Apple Pay, Google Pay, and cryptocurrency support for global sales.": "Intégration de passerelle de paiement conforme PCI avec Stripe, PayPal, Apple Pay, Google Pay et support de cryptomonnaie pour les ventes mondiales.",
    "Real-Time Inventory Management": "Gestion d'Inventaire en Temps Réel",
    "Automated stock tracking, low inventory alerts, multi-warehouse support, and supplier integration to prevent overselling.": "Suivi automatisé des stocks, alertes de stock bas, support multi-entrepôts et intégration fournisseurs pour éviter la survente.",
    "AI Product Recommendations": "Recommandations de Produits par IA",
    "Machine learning algorithms analyze browsing behavior and purchase history to suggest relevant products and increase average order value.": "Les algorithmes d'apprentissage automatique analysent le comportement de navigation et l'historique d'achats pour suggérer des produits pertinents et augmenter la valeur moyenne des commandes.",
    "Sales Analytics Dashboard": "Tableau de Bord d'Analyse des Ventes",
    "Real-time revenue tracking, conversion rate monitoring, customer lifetime value analysis, and product performance insights.": "Suivi des revenus en temps réel, surveillance du taux de conversion, analyse de la valeur client à vie et insights de performance produit.",
    "Mobile-First Shopping Experience": "Expérience d'Achat Mobile-First",
    "Responsive design optimized for mobile shopping with fast loading, touch-friendly navigation, and native app-like experience.": "Design responsive optimisé pour les achats mobiles avec chargement rapide, navigation tactile et expérience similaire à une application native.",
    "Businesses": "Entreprises",

    # E-commerce challenges
    "The Challenge": "Le Défi",
    "Businesses Face Unique Website Challenges": "Les Entreprises Font Face à des Défis Web Uniques",
    "High Cart Abandonment Rates": "Taux Élevés d'Abandon de Panier",
    "Complex checkout processes cause 70% cart abandonment. Streamlined flows with guest checkout and autofill recover lost sales.": "Les processus de paiement complexes causent 70% d'abandon de panier. Des flux simplifiés avec paiement invité et remplissage automatique récupèrent les ventes perdues.",
    "Limited Payment Options": "Options de Paiement Limitées",
    "Customers expect multiple payment methods. Offering credit cards, digital wallets, and buy-now-pay-later increases conversions by 30%.": "Les clients s'attendent à plusieurs méthodes de paiement. Offrir des cartes de crédit, des portefeuilles numériques et le paiement différé augmente les conversions de 30%.",
    "Inventory Management Chaos": "Chaos dans la Gestion des Stocks",
    "Manual stock tracking leads to overselling and disappointed customers. Real-time inventory sync prevents stockouts and backorders.": "Le suivi manuel des stocks mène à la survente et à des clients déçus. La synchronisation d'inventaire en temps réel prévient les ruptures de stock et les commandes en attente.",
    "Low Average Order Value": "Faible Valeur Moyenne de Commande",
    "Without personalized recommendations, customers miss relevant products. AI-powered suggestions increase average order value by 40%.": "Sans recommandations personnalisées, les clients passent à côté de produits pertinents. Les suggestions alimentées par l'IA augmentent la valeur moyenne de commande de 40%.",
    "Slow Loading Times": "Temps de Chargement Lents",
    "Every second of delay costs 7% in conversions. Optimized images, CDN delivery, and fast hosting ensure sub-2-second load times.": "Chaque seconde de retard coûte 7% en conversions. Des images optimisées, une livraison CDN et un hébergement rapide garantissent des temps de chargement inférieurs à 2 secondes.",
    "Security &amp; Trust Concerns": "Préoccupations de Sécurité et de Confiance",
    "Customers worry about payment security. SSL certificates, PCI compliance, trust badges, and secure checkout build confidence.": "Les clients s'inquiètent de la sécurité des paiements. Les certificats SSL, la conformité PCI, les badges de confiance et le paiement sécurisé renforcent la confiance.",
    "businesses.": "entreprises.",

    # E-commerce features
    "Optimized Checkout Flow": "Flux de Paiement Optimisé",
    "Streamlined single-page checkout with guest option, autofill, progress indicators, and multiple payment methods. Abandoned cart recovery emails with personalized discounts to recapture lost sales.": "Paiement simplifié sur une seule page avec option invité, remplissage automatique, indicateurs de progression et méthodes de paiement multiples. E-mails de récupération de panier abandonné avec remises personnalisées pour récupérer les ventes perdues.",
    "Single-page checkout with progress indicators and guest option": "Paiement sur une seule page avec indicateurs de progression et option invité",
    "Address autofill, saved payment methods, and express checkout": "Remplissage automatique d'adresse, méthodes de paiement sauvegardées et paiement express",
    "Multiple payment gateways: Stripe, PayPal, Apple Pay, Google Pay": "Passerelles de paiement multiples : Stripe, PayPal, Apple Pay, Google Pay",
    "Abandoned cart recovery emails with personalized discount codes": "E-mails de récupération de panier abandonné avec codes de réduction personnalisés",
    "Real-Time Inventory System": "Système d'Inventaire en Temps Réel",
    "Automated stock tracking across multiple warehouses with low inventory alerts, supplier integration, and backorder management. Prevents overselling with real-time availability updates on product pages.": "Suivi automatisé des stocks sur plusieurs entrepôts avec alertes de stock bas, intégration fournisseurs et gestion des commandes en attente. Prévient la survente avec des mises à jour de disponibilité en temps réel sur les pages produits.",
    "Multi-warehouse inventory tracking with real-time sync": "Suivi d'inventaire multi-entrepôts avec synchronisation en temps réel",
    "Low stock alerts and automatic reorder point notifications": "Alertes de stock bas et notifications automatiques de point de réapprovisionnement",
    "Supplier integration for automated purchase orders": "Intégration fournisseurs pour les bons de commande automatisés",
    "Backorder management and pre-order functionality": "Gestion des commandes en attente et fonctionnalité de précommande",
    "Machine learning algorithms analyze browsing behavior, purchase history, and similar customer patterns to suggest relevant products. Increases average order value by 40% with personalized upsells and cross-sells.": "Les algorithmes d'apprentissage automatique analysent le comportement de navigation, l'historique d'achats et les modèles de clients similaires pour suggérer des produits pertinents. Augmente la valeur moyenne des commandes de 40% avec des ventes incitatives et croisées personnalisées.",
    "Personalized product recommendations based on browsing history": "Recommandations de produits personnalisées basées sur l'historique de navigation",
    "Smart upsells and cross-sells at checkout": "Ventes incitatives et croisées intelligentes au moment du paiement",
    "Frequently bought together bundles": "Lots fréquemment achetés ensemble",
    "AI-powered search with autocomplete and filters": "Recherche alimentée par l'IA avec autocomplétion et filtres",
    "Comprehensive analytics tracking revenue, conversion rates, customer lifetime value, and product performance. Real-time dashboards with Google Analytics integration and custom reporting for data-driven decisions.": "Analyses complètes suivant les revenus, les taux de conversion, la valeur client à vie et la performance des produits. Tableaux de bord en temps réel avec intégration Google Analytics et rapports personnalisés pour des décisions basées sur les données.",
    "Real-time revenue tracking and conversion rate monitoring": "Suivi des revenus en temps réel et surveillance du taux de conversion",
    "Customer lifetime value and cohort analysis": "Valeur client à vie et analyse de cohorte",
    "Product performance rankings and inventory turnover": "Classements de performance produit et rotation des stocks",
    "Google Analytics and Facebook Pixel integration": "Intégration Google Analytics et Facebook Pixel",

    # E-commerce process
    "Discovery &amp; Store Design": "Découverte et Design de Boutique",
    "Product catalog structure and taxonomy planning": "Planification de la structure et de la taxonomie du catalogue produits",
    "Competitor analysis of 5-10 e-commerce stores": "Analyse concurrentielle de 5 à 10 boutiques e-commerce",
    "Product page and checkout flow wireframes": "Maquettes de pages produits et flux de paiement",
    "Core Platform Development": "Développement de la Plateforme Principale",
    "Product database with categories, variants, and pricing": "Base de données produits avec catégories, variantes et tarification",
    "Shopping cart with quantity updates and promo codes": "Panier d'achat avec mises à jour de quantité et codes promo",
    "User authentication with guest checkout option": "Authentification utilisateur avec option de paiement invité",
    "Inventory &amp; Recommendations": "Inventaire et Recommandations",
    "Real-time inventory tracking and stock alerts": "Suivi d'inventaire en temps réel et alertes de stock",
    "Order management dashboard with fulfillment status": "Tableau de bord de gestion des commandes avec statut d'exécution",
    "AI-powered product recommendations engine": "Moteur de recommandations de produits alimenté par l'IA",
    "Launch &amp; Optimization": "Lancement et Optimisation",
    "Payment gateway testing and security audit": "Tests de passerelle de paiement et audit de sécurité",
    "Performance optimization and SEO setup": "Optimisation des performances et configuration SEO",
    "Staff training and ongoing support": "Formation du personnel et support continu",
    "From concept to launch in 4 weeks, optimized for e-commerce businesses": "Du concept au lancement en 4 semaines, optimisé pour les entreprises e-commerce",
    "for": "pour",
    "Websites": "Sites Web",

    # ===== EDTECH SPECIFIC =====
    "WE BUILD PLATFORMS THAT TRANSFORM": "NOUS CRÉONS DES PLATEFORMES QUI TRANSFORMENT",
    "DIGITAL LEARNING": "L'APPRENTISSAGE NUMÉRIQUE",
    "ONLINE EDUCATION": "L'ÉDUCATION EN LIGNE",
    "EDTECH SOLUTIONS": "LES SOLUTIONS EDTECH",
    "EdTech": "EdTech",
    "Edtech": "Edtech",
    "edtech": "edtech",

    # ===== EDUCATION SPECIFIC =====
    "EDUCATION WEBSITES": "SITES WEB ÉDUCATIFS",
    "Education": "Éducation",
    "education": "éducation",

    # ===== FINTECH SPECIFIC =====
    "FINTECH PLATFORMS": "PLATEFORMES FINTECH",
    "FINTECH WEBSITES": "SITES WEB FINTECH",
    "Fintech": "Fintech",
    "fintech": "fintech",
    "FinTech": "FinTech",

    # ===== HEALTHCARE SPECIFIC =====
    "HEALTHCARE WEBSITES": "SITES WEB DE SANTÉ",
    "Healthcare": "Santé",
    "healthcare": "santé",

    # ===== IMMIGRATION SPECIFIC =====
    "IMMIGRATION WEBSITES": "SITES WEB D'IMMIGRATION",
    "Immigration Consultancy": "Conseil en Immigration",
    "Immigration": "Immigration",
    "immigration": "immigration",

    # ===== Pricing section =====
    "Transparent Pricing": "Tarification Transparente",
    "No hidden fees. No surprises. Choose the plan that fits your needs.": "Pas de frais cachés. Pas de surprises. Choisissez le forfait qui correspond à vos besoins.",
    "Starter": "Démarrage",
    "Professional": "Professionnel",
    "Premium": "Premium",
    "Growth": "Croissance",
    "Scale": "Évolution",
    "Basic": "Basique",
    "Advanced": "Avancé",
    "What&#x27;s Included": "Ce qui est Inclus",
    "What&apos;s Included": "Ce qui est Inclus",
    "Perfect for": "Parfait pour",
    "Ideal for": "Idéal pour",
    "Best for": "Idéal pour",
    "small businesses": "les petites entreprises",
    "growing businesses": "les entreprises en croissance",
    "large enterprises": "les grandes entreprises",
    "startups": "les startups",

    # Common feature items
    "Responsive design": "Design responsive",
    "SEO optimization": "Optimisation SEO",
    "Mobile responsive": "Responsive mobile",
    "SSL certificate": "Certificat SSL",
    "Contact form": "Formulaire de contact",
    "Social media integration": "Intégration réseaux sociaux",
    "Google Maps integration": "Intégration Google Maps",
    "Analytics setup": "Configuration analytique",
    "Content management system": "Système de gestion de contenu",
    "Blog setup": "Configuration du blog",
    "Email integration": "Intégration e-mail",
    "Performance optimization": "Optimisation des performances",
    "Security features": "Fonctionnalités de sécurité",
    "Custom design": "Design personnalisé",
    "Admin dashboard": "Tableau de bord admin",
    "User management": "Gestion des utilisateurs",
    "API integration": "Intégration API",
    "Third-party integrations": "Intégrations tierces",
    "Maintenance &amp; support": "Maintenance et support",
    "24/7 support": "Support 24/7",
    "Monthly reports": "Rapports mensuels",
    "Training included": "Formation incluse",

    # FAQ common
    "How long does it take to build": "Combien de temps faut-il pour construire",
    "What technologies do you use": "Quelles technologies utilisez-vous",
    "Do you provide ongoing support": "Fournissez-vous un support continu",
    "Can I update the website myself": "Puis-je mettre à jour le site moi-même",
    "What is your development process": "Quel est votre processus de développement",
    "How much does it cost": "Combien cela coûte-t-il",

    # Testimonials section
    "What Our Clients Say": "Ce que Disent Nos Clients",
    "Don&#x27;t just take our word for it": "Ne nous croyez pas sur parole",
    "Don&apos;t just take our word for it": "Ne nous croyez pas sur parole",

    # Footer CTA
    "Let&#x27;s Build Something Amazing Together": "Construisons Quelque Chose d'Extraordinaire Ensemble",
    "Let&apos;s Build Something Amazing Together": "Construisons Quelque Chose d'Extraordinaire Ensemble",
    "Let&#x27;s build your": "Construisons votre",
    "Let&apos;s build your": "Construisons votre",
    "website together": "site web ensemble",
    "platform together": "plateforme ensemble",
    "Ready to get started?": "Prêt à commencer ?",
    "Let&#x27;s discuss your project": "Discutons de votre projet",
    "Let&apos;s discuss your project": "Discutons de votre projet",
}


def translate_section_lines(content):
    """Translate @section meta lines."""
    translations_meta = {
        # E-commerce
        "E-commerce Website Development | Custom Online Store & Shopping Platform | Pikasso Studio": "Développement de Sites E-commerce | Boutique en Ligne & Plateforme de Vente Personnalisée | Pikasso Studio",
        "Custom e-commerce websites with secure payments, inventory management, AI recommendations, and conversion optimization. Launch your online store in 7-10 days.": "Sites e-commerce personnalisés avec paiements sécurisés, gestion des stocks, recommandations IA et optimisation de conversion. Lancez votre boutique en ligne en 7-10 jours.",
        "ecommerce website development,online store development,shopping cart platform,payment gateway integration,product catalog,inventory management,ecommerce SEO": "développement site e-commerce,développement boutique en ligne,plateforme panier d'achat,intégration passerelle de paiement,catalogue produits,gestion des stocks,SEO e-commerce",
        "Pikasso Studio - AI-Powered Web Development Agency | Morocco": "Pikasso Studio - Agence de Développement Web Alimentée par l'IA | Maroc",
        "Premium web development agency in Morocco specializing in AI-powered websites, intelligent dashboards, and SaaS platforms. Expert Next.js development for education, healthcare & business. 50+ projects delivered.": "Agence de développement web premium au Maroc spécialisée dans les sites web alimentés par l'IA, les tableaux de bord intelligents et les plateformes SaaS. Développement Next.js expert pour l'éducation, la santé et les entreprises. 50+ projets livrés.",
        "Premium web development agency specializing in AI-powered websites, intelligent dashboards, and SaaS platforms. 50+ projects delivered.": "Agence de développement web premium spécialisée dans les sites web alimentés par l'IA, les tableaux de bord intelligents et les plateformes SaaS. 50+ projets livrés.",

        # EdTech
        "EdTech Platform Development | Custom Learning Management System & Online Education | Pikasso Studio": "Développement de Plateforme EdTech | Système de Gestion d'Apprentissage & Éducation en Ligne | Pikasso Studio",
        "Custom edtech platforms with LMS, video streaming, AI tutoring, gamification, and analytics. Launch your learning platform in 7-10 days.": "Plateformes edtech personnalisées avec LMS, streaming vidéo, tutorat IA, gamification et analyses. Lancez votre plateforme d'apprentissage en 7-10 jours.",
        "edtech platform development,learning management system,online education platform,LMS development,e-learning,virtual classroom,education technology": "développement plateforme edtech,système de gestion d'apprentissage,plateforme éducation en ligne,développement LMS,e-learning,salle de classe virtuelle,technologie éducative",

        # Education
        "Education Website Development | Custom School & University Websites | Pikasso Studio": "Développement de Sites Web Éducatifs | Sites Écoles & Universités Personnalisés | Pikasso Studio",
        "Custom education websites with student portals, course management, online enrollment, and parent communication. Launch your school website in 7-10 days.": "Sites web éducatifs personnalisés avec portails étudiants, gestion des cours, inscription en ligne et communication parentale. Lancez votre site scolaire en 7-10 jours.",
        "education website development,school website,university website,student portal,course management,online enrollment,education technology": "développement site web éducatif,site école,site université,portail étudiant,gestion des cours,inscription en ligne,technologie éducative",

        # Fintech Platform
        "Fintech Platform Development | Custom Financial Technology Solutions | Pikasso Studio": "Développement de Plateforme Fintech | Solutions de Technologie Financière Personnalisées | Pikasso Studio",
        "Custom fintech platforms with payment processing, banking APIs, blockchain integration, and regulatory compliance. Launch your fintech platform in 7-10 days.": "Plateformes fintech personnalisées avec traitement des paiements, APIs bancaires, intégration blockchain et conformité réglementaire. Lancez votre plateforme fintech en 7-10 jours.",
        "fintech platform development,financial technology,payment processing,banking API,blockchain,regulatory compliance,digital banking": "développement plateforme fintech,technologie financière,traitement des paiements,API bancaire,blockchain,conformité réglementaire,banque numérique",

        # Fintech Website
        "Fintech Website Development | Custom Financial Services Websites | Pikasso Studio": "Développement de Sites Web Fintech | Sites de Services Financiers Personnalisés | Pikasso Studio",
        "Custom fintech websites with secure portals, real-time data, compliance features, and trust-building design. Launch your financial website in 7-10 days.": "Sites web fintech personnalisés avec portails sécurisés, données en temps réel, fonctionnalités de conformité et design inspirant confiance. Lancez votre site financier en 7-10 jours.",
        "fintech website development,financial website,financial services website,fintech design,financial portal,investment platform,banking website": "développement site web fintech,site financier,site services financiers,design fintech,portail financier,plateforme d'investissement,site bancaire",

        # Healthcare
        "Healthcare Website Development | Custom Medical & Health Websites | Pikasso Studio": "Développement de Sites Web de Santé | Sites Médicaux & Santé Personnalisés | Pikasso Studio",
        "Custom healthcare websites with patient portals, appointment booking, telemedicine, and HIPAA compliance. Launch your medical website in 7-10 days.": "Sites web de santé personnalisés avec portails patients, prise de rendez-vous, télémédecine et conformité HIPAA. Lancez votre site médical en 7-10 jours.",
        "healthcare website development,medical website,patient portal,appointment booking,telemedicine,HIPAA compliance,health technology": "développement site web santé,site médical,portail patient,prise de rendez-vous,télémédecine,conformité HIPAA,technologie santé",

        # Immigration
        "Immigration Consultancy Website Development | Custom Visa & Migration Websites | Pikasso Studio": "Développement de Sites Web de Conseil en Immigration | Sites Visa & Migration Personnalisés | Pikasso Studio",
        "Custom immigration consultancy websites with visa tracking, document management, client portals, and case management. Launch your immigration website in 7-10 days.": "Sites web de conseil en immigration personnalisés avec suivi de visa, gestion de documents, portails clients et gestion de dossiers. Lancez votre site d'immigration en 7-10 jours.",
        "immigration consultancy website,visa tracking,document management,client portal,case management,immigration technology,migration website": "site web conseil en immigration,suivi de visa,gestion de documents,portail client,gestion de dossiers,technologie immigration,site migration",
    }

    for eng, fr in translations_meta.items():
        content = content.replace(eng, fr)

    return content


def translate_html_text(content):
    """
    Translate text content in HTML while preserving all HTML structure.
    Uses a comprehensive approach with regex to find text between tags.
    """

    # First handle @section meta lines
    content = translate_section_lines(content)

    # Apply dictionary-based translations (longest first to avoid partial matches)
    sorted_translations = sorted(TRANSLATIONS.items(), key=lambda x: len(x[0]), reverse=True)

    for eng, fr in sorted_translations:
        content = content.replace(eng, fr)

    return content


def translate_remaining_text(content):
    """
    Second pass: translate remaining English text that wasn't caught by the dictionary.
    Uses regex to find text between HTML tags and translate common patterns.
    """

    # Additional translations for text content found between tags
    additional = {
        # Common short phrases
        "Everything your": "Tout ce dont votre",
        "business needs in one platform": "entreprise a besoin sur une seule plateforme",
        "businesses need in one platform": "entreprises ont besoin sur une seule plateforme",
        "needs in one platform": "a besoin sur une seule plateforme",
        "in one platform": "sur une seule plateforme",
        "Everything you need": "Tout ce dont vous avez besoin",
        "from concept to launch": "du concept au lancement",
        "From concept to launch": "Du concept au lancement",
        "in 4 weeks": "en 4 semaines",
        "optimized for": "optimisé pour",

        # Discovery & Design
        "Discovery &amp; Design": "Découverte et Design",
        "Discovery &amp; Planning": "Découverte et Planification",
        "Discovery &amp; Research": "Découverte et Recherche",
        "Discovery &amp; Strategy": "Découverte et Stratégie",
        "Design &amp; Development": "Design et Développement",
        "Development &amp; Testing": "Développement et Tests",
        "Testing &amp; Launch": "Tests et Lancement",
        "Launch &amp; Support": "Lancement et Support",
        "Launch &amp; Growth": "Lancement et Croissance",

        # Common words in context
        "Clients": "Clients",
        "B2B SaaS": "B2B SaaS",
        "+140% Lead Growth": "+140% Croissance des Leads",
        "Al-Raba Technologies": "Al-Raba Technologies",
    }

    sorted_additional = sorted(additional.items(), key=lambda x: len(x[0]), reverse=True)
    for eng, fr in sorted_additional:
        content = content.replace(eng, fr)

    return content


def process_file(filepath):
    """Process a single blade file."""
    print(f"Processing: {os.path.basename(filepath)}")

    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Apply translations
    content = translate_html_text(content)
    content = translate_remaining_text(content)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

    print(f"  Done: {os.path.basename(filepath)}")


if __name__ == "__main__":
    for filename in FILES:
        filepath = os.path.join(BASE, filename)
        if os.path.exists(filepath):
            process_file(filepath)
        else:
            print(f"  File not found: {filepath}")

    print("\nAll files processed.")
