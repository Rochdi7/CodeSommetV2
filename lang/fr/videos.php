<?php

/*
 * Pages vidéo (« watch pages ») — /our-work/{slug}/video.
 * Une entrée par clé de config/videos.php. Textes descriptifs uniquement :
 * ils décrivent ce qui est réellement visible dans chaque vidéo.
 */

return [
    // ─── Libellés partagés ──────────────────────────────────────────────
    'eyebrow' => 'Vidéo',
    'back' => 'Retour au projet',
    'breadcrumb' => 'Vidéo',
    'shown_heading' => 'Ce que montre la vidéo',
    'about_heading' => 'À propos du projet',
    'facts_heading' => 'Informations sur la vidéo',
    'fact_duration' => 'Durée',
    'fact_duration_value' => '10 secondes',
    'fact_format' => 'Format',
    'fact_format_value' => 'HD 1280 × 720',
    'fact_audio' => 'Son',
    'fact_audio_value' => 'Aucun (ni musique ni narration)',
    'fact_published' => 'Publiée le',
    'cta_case' => "Lire l'étude de cas",
    'cta_quote' => 'Demander un devis',
    'watch_link' => 'Regarder la vidéo de présentation',

    // ─── Vidéos ─────────────────────────────────────────────────────────
    'akoubri' => [
        'title' => "Vidéo Akoubri - Site d'Architecte à Marrakech | CodeSommet",
        'name' => "Akoubri : présentation vidéo du site d'architecte à Marrakech",
        'description' => "Vidéo de présentation du site Akoubri, cabinet d'architecture et de design d'intérieur à Marrakech, affiché sur ordinateur et sur mobile.",
        'shown' => "La vidéo présente la page d'accueil « Cabinet d'architecture & design » sur ordinateur portable et sur smartphone : visuel d'en-tête, menu de navigation et bouton de demande de devis, pour montrer le rendu responsive du site.",
        'about' => "Akoubri est un site vitrine premium pour un cabinet d'architecture et de design d'intérieur basé à Marrakech : portfolio de projets, images 3D, journal optimisé pour le référencement et demande de devis en ligne.",
    ],
    'authentic-morocco-adventures' => [
        'title' => 'Vidéo Authentic Morocco Adventures - Voyages | CodeSommet',
        'name' => 'Authentic Morocco Adventures : présentation vidéo du site de circuits privés',
        'description' => "Vidéo de présentation du site Authentic Morocco Adventures, guide privé à Marrakech : circuits et treks dans l'Atlas, sur ordinateur et mobile.",
        'shown' => "La vidéo montre la page d'accueil « Private Morocco Tours & Sahara Desert Adventures » sur ordinateur portable et sur smartphone, avec son visuel de caravane dans le désert et sa version mobile.",
        'about' => "Refonte du site d'un guide privé basé à Marrakech : 62 circuits, activités, treks dans l'Atlas, guides de destinations et réservation via WhatsApp.",
    ],
    'dental-pro' => [
        'title' => 'Vidéo Dental Pro - E-commerce Dentaire | CodeSommet',
        'name' => 'Dental Pro : présentation vidéo de la boutique dentaire en ligne',
        'description' => 'Vidéo de présentation de Dental Pro, plateforme e-commerce et CMS pour le secteur dentaire conçue par CodeSommet, sur ordinateur et mobile.',
        'shown' => "La vidéo montre la page d'accueil « Les pièces de votre cabinet ? Toutes sont ici. » sur ordinateur portable et sur smartphone : barre de recherche, catégories de produits et mises en avant de la boutique.",
        'about' => 'Dental Pro réunit une boutique en ligne pour le secteur dentaire, un catalogue produits, un blog et un backoffice unifié pour gérer l\'ensemble du site.',
    ],
    'glamworlds' => [
        'title' => 'Vidéo GlamWorlds - Boutique Shopify de Luxe | CodeSommet',
        'name' => 'GlamWorlds : présentation vidéo de la boutique Shopify',
        'description' => 'Vidéo de présentation de GlamWorlds, boutique Shopify de lunettes de soleil de luxe conçue par CodeSommet, affichée sur ordinateur et mobile.',
        'shown' => "La vidéo montre la page d'accueil de la boutique, avec sa bannière « Elegance in every detail », sur ordinateur portable et sur smartphone pour illustrer le rendu responsive.",
        'about' => "Création complète d'une boutique Shopify pour une maison de lunettes de soleil haut de gamme, pensée pour le référencement naturel et une expérience d'achat premium.",
    ],
    'gls-sprachenzentrum' => [
        'title' => "Vidéo GLS Sprachenzentrum - École d'Allemand | CodeSommet",
        'name' => "GLS Sprachenzentrum : présentation vidéo du site de l'école d'allemand",
        'description' => "Vidéo de présentation du site de GLS Sprachenzentrum, école de langue allemande : site vitrine multilingue affiché sur ordinateur et mobile.",
        'shown' => "La vidéo montre la page d'accueil « Votre premier pas vers l'Allemagne », avec son titre en français et en arabe, sur ordinateur portable et sur smartphone.",
        'about' => "Application web à double vocation pour une école de langue allemande : un site vitrine orienté conversion et un tableau de bord d'administration à rôles (CRM, paie, certificats).",
    ],
    'hssabek' => [
        'title' => 'Vidéo Hssabek - SaaS de Facturation | CodeSommet',
        'name' => 'Hssabek : présentation vidéo du SaaS de facturation',
        'description' => 'Vidéo de présentation de Hssabek, SaaS de facturation multi-tenant pour TPE, PME et freelances : tableau de bord sur ordinateur et mobile.',
        'shown' => 'La vidéo montre le tableau de bord de Hssabek sur ordinateur portable et sur smartphone : indicateurs des documents, analyse des ventes et graphiques de facturation.',
        'about' => 'Hssabek est un SaaS de facturation multi-tenant en français : devis, factures, avoirs, stock, paiements et rapports TVA réunis dans une seule application.',
    ],
    'mon-asso' => [
        'title' => 'Vidéo Mon Asso - SaaS de Gestion Associative | CodeSommet',
        'name' => 'Mon Asso : présentation vidéo de la plateforme de gestion associative',
        'description' => "Vidéo de présentation de Mon Asso, plateforme SaaS de gestion d'associations : tableau de bord affiché sur ordinateur et sur mobile.",
        'shown' => 'La vidéo montre la vue « Platform Overview » sur ordinateur portable et les statistiques globales sur smartphone : associations, utilisateurs, cotisations et réunions.',
        'about' => "Plateforme SaaS Laravel de gestion d'associations : membres, réunions, cotisations, événements, documents et dépenses réunis dans un seul espace.",
    ],
    'morocco-quest' => [
        'title' => 'Vidéo Morocco Quest - Agence de Voyage de Luxe | CodeSommet',
        'name' => "Morocco Quest : présentation vidéo du site d'agence de voyage de luxe",
        'description' => 'Vidéo de présentation du site Morocco Quest, agence de voyage de luxe au Maroc : circuits privés et désert, sur ordinateur et mobile.',
        'shown' => "La vidéo montre la page d'accueil « Private Morocco Tours & Luxury Desert Journeys Tailored For You » sur ordinateur portable et sur smartphone, avec son moteur de recherche de circuits.",
        'about' => "Site d'une agence de voyage de luxe au Maroc : circuits privés, aventures dans le Sahara et expériences sur mesure, développé avec Laravel et une administration Filament.",
    ],
];
