<?php

return [
    'title' => 'Extracteur de Métadonnées en Masse - Titres, Descriptions, Canonical | CodeSommet',
    'meta_description' => 'Récupérez en une fois le titre, la meta description, la canonical, la balise robots, le H1 et le nombre de mots de 20 pages. Doublons signalés, export CSV.',
    'meta_keywords' => 'extracteur meta,meta description en masse,balise title,canonical,audit SEO en masse,export CSV,balises meta',
    'og_title' => 'Extracteur de Métadonnées en Masse',
    'og_description' => 'Titre, description, canonical, robots, H1 et nombre de mots de 20 URL en un clic, avec export CSV.',
    'twitter_description' => 'Extrayez les balises SEO de 20 URL en un clic, doublons signalés et export CSV.',
    'breadcrumb' => 'Extracteur de Métadonnées',
    'h1' => 'Extracteur de Métadonnées en Masse',
    'intro' => 'Comparez d\'un coup d\'œil les balises SEO de plusieurs pages : titres, descriptions, canonical, robots, H1 et volume de texte.',
    'btn_submit' => 'Extraire les métadonnées',
    'fields' => [
        ['name' => 'urls', 'label' => 'URL à analyser', 'type' => 'textarea', 'rows' => 6, 'required' => true,
            'placeholder' => "https://example.com/\nhttps://example.com/services\nhttps://example.com/contact",
            'help' => 'Une URL par ligne, 20 maximum.'],
    ],
    'how' => [
        'Collez jusqu\'à 20 adresses, une par ligne.',
        'L\'outil télécharge chaque page et lit ses balises dans le HTML.',
        'Repérez les titres trop longs, les descriptions manquantes ou dupliquées, puis exportez le tableau en CSV.',
    ],
    'faq_intro' => 'Bien lire les résultats de l\'extraction',
    'faq' => [
        ['q' => 'Quelle longueur pour le titre et la description ?',
            'a' => 'Visez environ 30 à 60 caractères pour la balise title et 120 à 160 pour la meta description : au-delà, Google risque de les tronquer dans les résultats.'],
        ['q' => 'Pourquoi signaler les doublons ?',
            'a' => 'Deux pages avec le même titre ou la même description se distinguent mal dans les résultats de recherche et peuvent se concurrencer. Chaque page devrait avoir des balises uniques.'],
        ['q' => 'Une page est affichée en erreur, pourquoi ?',
            'a' => 'La page a répondu par un code d\'erreur (404, 500…), n\'a pas répondu à temps, ou pointe vers une adresse non publique. Les autres pages de la liste sont analysées normalement.'],
        ['q' => 'Les pages construites en JavaScript sont-elles analysées ?',
            'a' => 'L\'outil lit le HTML renvoyé par le serveur. Sur un site entièrement rendu en JavaScript, certaines balises peuvent n\'apparaître qu\'après exécution du script.'],
    ],
    'related' => [
        ['slug' => 'meta-tag-generator', 'title' => 'Générateur de Balises Meta', 'desc' => 'Rédigez des balises title et description optimisées.'],
        ['slug' => 'canonical-checker', 'title' => 'Vérificateur de Canonical', 'desc' => 'Contrôlez la balise canonical et les hreflang d\'une page.'],
        ['slug' => 'sitemap-url-extractor', 'title' => 'Extracteur d\'URL de Sitemap', 'desc' => 'Récupérez la liste des URL à auditer depuis votre sitemap.'],
    ],
    'usage' => 'pages analysées',
    'cta' => [
        'title' => 'Des Balises SEO à Reprendre sur Tout le Site ?',
        'text' => 'Nous auditons et réécrivons titres, descriptions et balises techniques page par page',
    ],
    'card_title' => 'Extracteur de Métadonnées',
    'card_desc' => 'Titre, description, canonical, robots, H1 et mots de 20 URL en un clic, doublons signalés, export CSV',
];
