<?php

return [
    'title' => 'Bot Viewer - Votre Page Vue par Googlebot | CodeSommet',
    'meta_description' => 'Chargez une page comme Googlebot, Bingbot, GPTBot ou ClaudeBot et comparez avec un navigateur : statut, redirections, contenu, cloaking. Gratuit.',
    'meta_keywords' => 'bot viewer,voir comme googlebot,fetch as google,user-agent googlebot,cloaking checker,gptbot test,page vue par les robots,waf bloque googlebot',
    'og_title' => 'Bot Viewer - Votre Page Vue par Googlebot, Bingbot et les Robots d\'IA',
    'og_description' => 'Comparez ce que reçoivent Googlebot, Bingbot, GPTBot ou Facebook avec ce que reçoit un navigateur : statut, redirections, titre, mots, liens. Détectez cloaking et blocages.',
    'twitter_description' => 'Votre page vue par Googlebot, Bingbot, GPTBot : comparez avec un navigateur et détectez cloaking et blocages.',

    'breadcrumb' => 'Bot Viewer',
    'h1' => 'Bot Viewer',
    'intro' => 'Votre serveur répond-il la même chose à Googlebot qu\'à un visiteur ? Chargez la page avec le User-Agent de chaque robot et comparez statut, redirections, titre, contenu et liens.',
    'usage' => 'pages comparées',

    'label_url' => 'URL de la page',
    'label_bots' => 'Robots à comparer au navigateur (4 max.)',
    'btn_submit' => 'Comparer les rendus',

    'how' => [
        'Entrez l\'URL à tester et cochez jusqu\'à quatre robots : Googlebot smartphone et ordinateur, Bingbot, GPTBot, ClaudeBot, PerplexityBot, Facebook ou curl.',
        'Nous chargeons la page une fois par User-Agent (en suivant les redirections) et une fois avec un navigateur de référence.',
        'Chaque différence est signalée : statut, URL finale, titre, canonique, directives robots, volume de texte, liens. Les écarts importants sont marqués comme suspects.',
    ],
    'faq_intro' => 'Cloaking, pare-feux et rendu différencié',
    'faq' => [
        ['q' => 'Qu\'est-ce que le cloaking ?', 'a' => 'Servir aux moteurs un contenu différent de celui servi aux visiteurs. C\'est une violation des règles de Google, sanctionnée par une action manuelle. Il est souvent involontaire : un pare-feu qui bloque les robots, une redirection géographique, un A/B test ou une page de consentement servie selon le User-Agent.'],
        ['q' => 'Mon site renvoie 403 ou 503 à Googlebot : est-ce grave ?', 'a' => 'Oui : Google ne peut plus explorer la page et finit par la désindexer. C\'est typique d\'une protection anti-bot (Cloudflare, Imperva, règles WAF) mal configurée. Autorisez explicitement les robots des moteurs, qui se vérifient par DNS inversé, pas seulement par User-Agent.'],
        ['q' => 'Les robots exécutent-ils le JavaScript ?', 'a' => 'Googlebot et Bingbot rendent les pages dans un navigateur sans interface, mais après un délai et avec des limites. Les robots d\'IA (GPTBot, ClaudeBot, PerplexityBot) lisent en général le HTML brut. Cet outil compare le HTML brut : si le contenu n\'y figure pas, les robots d\'IA ne le voient pas.'],
        ['q' => 'Pourquoi le navigateur de référence est-il Chrome sur Windows ?', 'a' => 'C\'est le profil le plus courant. Les différences avec les versions mobiles de Googlebot peuvent être légitimes (site adaptatif), mais le titre, la canonique et les directives robots doivent rester identiques.'],
        ['q' => 'Que signifie « texte légèrement différent » ?', 'a' => 'Le texte visible diffère de moins de 10 % : généralement une date, un compteur, un identifiant de session ou un bandeau de cookies. Sans autre écart, ce n\'est pas un signe de cloaking.'],
        ['q' => 'L\'outil se fait-il passer pour Google ?', 'a' => 'Il envoie seulement la chaîne User-Agent ; il n\'usurpe ni les adresses IP de Google ni sa vérification DNS. Un site qui vérifie l\'IP peut donc répondre différemment au vrai Googlebot. Les résultats reflètent les règles basées sur le User-Agent, la cause la plus fréquente de différence.'],
    ],
    'related' => [
        ['slug' => 'redirect-checker', 'title' => 'Vérificateur de Redirections', 'desc' => 'Suivez la chaîne complète de redirections'],
        ['slug' => 'security-headers-checker', 'title' => 'En-têtes de Sécurité HTTP', 'desc' => 'Note de A à F et corrections à appliquer'],
        ['slug' => 'ai-crawler-access-checker', 'title' => 'Accès des Robots d\'IA', 'desc' => 'Ce que robots.txt autorise aux robots d\'IA'],
    ],
    'cta' => [
        'title' => 'Un Pare-feu Qui Bloque les Moteurs ?',
        'text' => 'Nous configurons CDN, WAF et rendu serveur pour que chaque robot utile voie exactement votre contenu',
    ],
    'card_title' => 'Bot Viewer',
    'card_desc' => 'Votre page vue par Googlebot, Bingbot, GPTBot… comparée au navigateur : cloaking et blocages',
];
