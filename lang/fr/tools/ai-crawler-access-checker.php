<?php

return [
    'title' => 'Accès des Robots d\'IA - GPTBot, ClaudeBot, Gemini : Qui Peut Lire Votre Site ? | CodeSommet',
    'meta_description' => 'Vérifiez en un clic ce que votre robots.txt, vos balises meta et votre llms.txt autorisent pour GPTBot, ClaudeBot, Google-Extended, PerplexityBot et 15 autres robots d\'IA. Gratuit.',
    'meta_keywords' => 'gptbot robots.txt,claudebot,google-extended,bloquer ia robots.txt,llms.txt,perplexitybot,ai crawler,robots ia,generative engine optimization,geo seo',
    'og_title' => 'Accès des Robots d\'IA - Qui Peut Lire Votre Site ?',
    'og_description' => 'GPTBot, ClaudeBot, Google-Extended, PerplexityBot… Vérifiez ce que votre site autorise aux robots d\'IA et générez le robots.txt adapté à votre stratégie.',
    'twitter_description' => 'Vérifiez ce que votre site autorise aux robots d\'IA (GPTBot, ClaudeBot, Gemini, Perplexity) et ajustez votre robots.txt.',

    'breadcrumb' => 'Accès des Robots d\'IA',
    'h1' => 'Accès des Robots d\'IA',
    'intro' => 'Entraînement, recherche ou navigation : pour vingt robots d\'IA, voyez ce que votre robots.txt, vos balises meta et votre llms.txt autorisent — et décidez en connaissance de cause.',
    'usage' => 'sites vérifiés',

    'label_url' => 'URL du site ou d\'une page',
    'btn_submit' => 'Vérifier les accès',

    'how' => [
        'Entrez l\'adresse de votre site. Nous lisons robots.txt, la page indiquée (meta robots, X-Robots-Tag) et llms.txt.',
        'Chaque robot est classé par usage : entraînement des modèles, index de recherche IA, ou navigation à la demande d\'un utilisateur.',
        'Copiez le bloc robots.txt correspondant à votre choix — bloquer l\'entraînement, tout autoriser — ou ajustez robot par robot.',
    ],
    'faq_intro' => 'Entraînement, recherche, navigation : trois usages, trois décisions',
    'faq' => [
        ['q' => 'Faut-il bloquer les robots d\'IA ?', 'a' => 'Cela dépend de votre objectif. Bloquer les robots d\'entraînement (GPTBot, ClaudeBot, Google-Extended…) protège vos contenus de l\'apprentissage des modèles sans toucher à votre visibilité. Bloquer les robots de recherche (OAI-SearchBot, PerplexityBot, Claude-SearchBot) vous retire des réponses citées par ChatGPT Search, Perplexity ou Claude — une source de trafic croissante. Les robots « utilisateur » n\'agissent que lorsqu\'une personne demande à lire votre page.'],
        ['q' => 'Google-Extended bloque-t-il Google Search ?', 'a' => 'Non. Google-Extended ne contrôle que l\'utilisation de vos contenus pour entraîner Gemini. Googlebot reste responsable de la recherche et des AI Overviews : le bloquer vous retire des résultats classiques.'],
        ['q' => 'Qu\'est-ce que llms.txt ?', 'a' => 'Un fichier texte proposé à la racine du site (/llms.txt) qui résume en Markdown ce que le site propose et liste ses pages essentielles, pour aider les assistants IA à le comprendre. Son adoption par les éditeurs de modèles reste partielle, mais il est peu coûteux à mettre en place.'],
        ['q' => 'À quoi servent noai et max-snippet ?', 'a' => '« noai » et « noimageai » sont des valeurs de meta robots proposées par certains acteurs pour refuser l\'entraînement ; leur respect n\'est pas garanti. « max-snippet » limite la longueur de l\'extrait que Google peut afficher, y compris dans ses AI Overviews.'],
        ['q' => 'Un robot peut-il ignorer mon robots.txt ?', 'a' => 'Oui, techniquement. Les grands éditeurs (OpenAI, Anthropic, Google, Microsoft, Apple, Perplexity pour son robot déclaré) annoncent le respecter. Pour les autres, seuls un blocage au niveau du serveur ou du CDN (par User-agent ou par plage d\'IP) est contraignant.'],
        ['q' => 'Pourquoi le résultat diffère entre la page d\'accueil et une autre page ?', 'a' => 'Les règles robots.txt s\'appliquent par chemin : « Disallow: /blog/ » bloque les articles mais pas l\'accueil. L\'outil évalue l\'URL exacte que vous indiquez ; testez plusieurs sections si vos règles sont fines.'],
    ],
    'related' => [
        ['slug' => 'robots-txt-tester', 'title' => 'Testeur Robots.txt', 'desc' => 'Testez vos URL contre vos règles, robot par robot'],
        ['slug' => 'robots-txt-generator', 'title' => 'Générateur Robots.txt', 'desc' => 'Créez un fichier robots.txt propre'],
        ['slug' => 'canonical-checker', 'title' => 'Vérificateur de Canonique', 'desc' => 'Balises canonical, robots et hreflang d\'une page'],
    ],
    'cta' => [
        'title' => 'Une Stratégie de Visibilité dans les Réponses IA ?',
        'text' => 'Nous optimisons vos contenus pour être compris et cités par ChatGPT, Perplexity et les AI Overviews de Google',
    ],
    'card_title' => 'Accès des Robots d\'IA',
    'card_desc' => 'GPTBot, ClaudeBot, Gemini, Perplexity : qui peut lire votre site, et le robots.txt adapté',
];
