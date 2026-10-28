<?php

return [
    'title' => 'Extracteur d\'URL de Sitemap XML Gratuit | CodeSommet',
    'meta_description' => 'Extrayez toutes les URL des sitemaps XML d\'un site (index, gzip) avec lastmod et images, et repérez doublons et hôtes mixtes. Export CSV gratuit.',
    'meta_keywords' => 'extracteur sitemap,sitemap url extractor,lister urls sitemap,sitemap xml to csv,sitemap index,lastmod,toutes les pages d\'un site',
    'og_title' => 'Extracteur d\'URL de Sitemap XML',
    'og_description' => 'Toutes les URL des sitemaps d\'un site en un clic, avec lastmod et statistiques par dossier. Export CSV / JSON.',
    'twitter_description' => 'Listez toutes les URL des sitemaps XML d\'un site, index compris, et exportez en CSV.',

    'breadcrumb' => 'Extracteur de Sitemap',
    'h1' => 'Extracteur d\'URL de Sitemap XML Gratuit',
    'intro' => 'Indiquez un site ou un sitemap : nous suivons les index, lisons les fichiers (même compressés) et vous rendons la liste complète des URL avec leurs dates, prêtes à exporter.',
    'usage' => 'sitemaps lus',

    'label_url' => 'Site ou URL de sitemap',
    'btn_submit' => 'Extraire les URL',

    'how' => [
        'Entrez l\'adresse du site (nous cherchons les sitemaps déclarés dans robots.txt et aux emplacements habituels) ou directement l\'URL d\'un sitemap ou d\'un index.',
        'Les index sont suivis, les fichiers .gz décompressés, et chaque URL est relevée avec son lastmod, sa priorité et ses images.',
        'Filtrez la liste, lisez les anomalies détectées, puis exportez en CSV ou JSON pour la croiser avec un crawl ou la Search Console.',
    ],
    'faq_intro' => 'Bien construire et exploiter un sitemap XML',
    'faq' => [
        ['q' => 'À quoi sert d\'extraire les URL d\'un sitemap ?', 'a' => 'À confronter ce que vous déclarez à Google avec ce qui existe vraiment : pages orphelines (dans le sitemap mais sans lien interne), pages absentes du sitemap, URL non canoniques, sections oubliées. C\'est aussi la façon la plus rapide d\'obtenir la liste des pages d\'un concurrent.'],
        ['q' => 'Quelles sont les limites d\'un sitemap ?', 'a' => '50 000 URL et 50 Mo (non compressé) par fichier. Au-delà, utilisez un index de sitemaps qui pointe vers plusieurs fichiers. L\'outil lit jusqu\'à 25 fichiers et 10 000 URL par analyse.'],
        ['q' => 'Le lastmod est-il important ?', 'a' => 'Google l\'utilise pour prioriser l\'exploration, à condition qu\'il soit fiable : s\'il est identique sur toutes les pages ou mis à jour sans changement réel, il est ignoré. Changefreq et priority ne sont plus pris en compte.'],
        ['q' => 'Pourquoi signaler les URL d\'un autre hôte ?', 'a' => 'Un sitemap ne peut lister que les URL de l\'hôte qui le sert (www.example.com et example.com sont deux hôtes). Les autres sont ignorées, sauf validation croisée dans la Search Console.'],
        ['q' => 'Un sitemap suffit-il à faire indexer mes pages ?', 'a' => 'Non. Il aide à la découverte, mais l\'indexation dépend de la qualité de la page, de son maillage interne et de ses directives (canonical, noindex). Une page présente seulement dans le sitemap et sans lien interne est souvent explorée mais peu indexée.'],
        ['q' => 'L\'outil lit-il les sitemaps d\'images, de vidéos et d\'actualités ?', 'a' => 'Il compte les images déclarées par URL (balises image:image). Les extensions vidéo et actualités sont tolérées mais leurs champs spécifiques ne sont pas extraits.'],
    ],
    'related' => [
        ['slug' => 'sitemap-validator', 'title' => 'Validateur de Sitemap', 'desc' => 'Vérifiez la validité XML de votre sitemap'],
        ['slug' => 'crawl-optimization-checker', 'title' => 'Optimisation du Crawl', 'desc' => 'Liens, redirections et pages qui gaspillent le crawl'],
        ['slug' => 'crawl-visualizer', 'title' => 'Visualiseur d\'Exploration', 'desc' => 'Croisez sitemap et maillage pour trouver les orphelines'],
    ],
    'cta' => [
        'title' => 'Des Milliers de Pages à Mettre en Ordre ?',
        'text' => 'Nous structurons sitemaps, canoniques et maillage pour que Google explore et indexe ce qui compte',
    ],
    'card_title' => 'Extracteur d\'URL de Sitemap',
    'card_desc' => 'Toutes les URL des sitemaps d\'un site, index suivis, avec lastmod et anomalies, export CSV',
];
