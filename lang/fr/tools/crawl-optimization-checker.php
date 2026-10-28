<?php

return [
    'title' => 'Test d\'Optimisation du Budget de Crawl | CodeSommet',
    'meta_description' => 'Explorez jusqu\'à 50 pages comme un robot : liens vers erreurs, redirections ou noindex, pages profondes, URL à paramètres, titres dupliqués.',
    'meta_keywords' => 'budget de crawl,optimisation crawl,crawl budget,liens cassés,redirections internes,noindex,profondeur de clic,robots.txt,audit technique seo',
    'og_title' => 'Vérificateur d\'Optimisation du Crawl',
    'og_description' => 'Liens internes vers des erreurs, redirections et pages noindex, profondeur, paramètres : ce qui gaspille l\'exploration de votre site.',
    'twitter_description' => 'Ce qui gaspille l\'exploration de votre site, page par page, avec les liens à corriger.',
    'breadcrumb' => 'Optimisation du Crawl',
    'h1' => 'Vérificateur d\'Optimisation du Crawl',
    'intro' => 'Chaque lien interne vers une erreur, une redirection ou une page exclue de l\'index fait perdre du temps aux robots. Explorez votre site comme eux et obtenez la liste des liens à corriger, avec les pages qui les contiennent.',
    'btn_submit' => 'Explorer le site',
    'fields' => [
        ['name' => 'url', 'label' => 'Page de départ', 'type' => 'url', 'required' => true,
            'placeholder' => 'https://example.com/',
            'help' => 'Généralement la page d\'accueil. Exploration limitée à 50 pages du même domaine.'],
    ],
    'score_note' => 'Résultats sur l\'échantillon exploré (50 pages et 20 secondes maximum), jamais extrapolés au site entier. robots.txt et nofollow sont respectés ; les redirections sont relevées, pas suivies à l\'aveugle.',
    'how' => [
        'Saisissez la page de départ, en général l\'accueil.',
        'L\'outil suit les liens internes comme un robot, en respectant robots.txt, jusqu\'à 50 pages.',
        'Remplacez les liens vers des redirections par l\'URL finale, réparez ou retirez les liens vers des erreurs, et ne liez pas les pages que vous excluez de l\'index.',
    ],
    'faq_intro' => 'Optimiser l\'exploration de votre site',
    'faq' => [
        ['q' => 'Le budget de crawl concerne-t-il les petits sites ?',
            'a' => 'Google précise que le budget de crawl est surtout un sujet pour les grands sites. Mais les liens vers des erreurs ou des redirections ralentissent aussi la découverte des nouvelles pages et diluent les liens internes sur un petit site : ce sont des corrections rapides et toujours utiles.'],
        ['q' => 'Pourquoi corriger les liens qui pointent vers une redirection ?',
            'a' => 'Chaque redirection ajoute une requête avant d\'atteindre la page. Mettre directement l\'URL finale dans vos liens accélère l\'exploration et le chargement pour les visiteurs.'],
        ['q' => 'Quelle différence avec le visualiseur de crawl ?',
            'a' => 'Le visualiseur dessine la structure des liens sous forme de graphe. Cet outil transforme l\'exploration en liste de problèmes à corriger, avec les pages qui contiennent chaque lien fautif.'],
        ['q' => 'Mon site a plus de 50 pages, l\'analyse est-elle complète ?',
            'a' => 'Non : l\'outil s\'arrête à 50 pages ou 20 secondes et l\'indique dans « Couverture de l\'échantillon ». Partez d\'une autre page (rubrique, catégorie) pour explorer une autre partie du site.'],
    ],
    'related' => [
        ['slug' => 'crawl-visualizer', 'title' => 'Visualiseur de Crawl', 'desc' => 'Voyez la structure de liens de votre site sous forme de graphe.'],
        ['slug' => 'broken-link-checker', 'title' => 'Vérificateur de Liens Cassés', 'desc' => 'Testez tous les liens, internes et externes, d\'une page.'],
        ['slug' => 'robots-txt-tester', 'title' => 'Testeur robots.txt', 'desc' => 'Vérifiez si une URL précise est autorisée pour un robot.'],
    ],
    'usage' => 'sites explorés',
    'cta' => [
        'title' => 'Une Structure de Site à Remettre à Plat ?',
        'text' => 'Nous corrigeons maillage interne, redirections et règles d\'indexation pour que les robots trouvent vite vos pages importantes',
    ],
    'card_title' => 'Vérificateur d\'Optimisation du Crawl',
    'card_desc' => 'Liens internes vers des erreurs, redirections et pages noindex, profondeur et paramètres, sur un échantillon de 50 pages',
];
