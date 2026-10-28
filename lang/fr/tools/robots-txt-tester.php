<?php

return [
    'title' => 'Testeur Robots.txt - URL Bloquée ou Non ? | CodeSommet',
    'meta_description' => 'Testez vos URL contre votre robots.txt pour Googlebot, Bingbot, GPTBot ou tout robot : règle appliquée, groupes, sitemaps, erreurs. Gratuit.',
    'meta_keywords' => 'testeur robots.txt,robots.txt tester,url bloquée googlebot,vérifier robots.txt,disallow allow test,robots txt validator,crawl bloqué',
    'og_title' => 'Testeur Robots.txt - Vérifiez si une URL est Bloquée',
    'og_description' => 'Testez vos URL contre votre robots.txt pour n\'importe quel robot et voyez la règle exacte qui s\'applique.',
    'twitter_description' => 'Testez vos URL contre votre robots.txt pour Googlebot, Bingbot, GPTBot et consorts.',

    'breadcrumb' => 'Testeur Robots.txt',
    'h1' => 'Testeur Robots.txt',
    'intro' => 'Vérifiez, URL par URL et robot par robot, ce que votre fichier robots.txt autorise ou interdit — avec la règle exacte qui l\'emporte, comme le fait Google.',
    'usage' => 'tests effectués',

    'label_site' => 'Site à tester (le robots.txt est récupéré automatiquement)',
    'label_content' => 'Ou collez un robots.txt (prioritaire si rempli)',
    'label_urls' => 'URL à tester (une par ligne, 100 max.)',
    'label_agents' => 'Robots',
    'label_custom_agent' => 'Autre robot (jeton User-agent)',
    'btn_submit' => 'Tester les URL',
    'placeholder_urls' => "https://example.com/\nhttps://example.com/admin/\nhttps://example.com/blog/article?utm_source=x",

    'how' => [
        'Entrez l\'adresse de votre site — nous lisons son robots.txt — ou collez le contenu d\'un fichier que vous préparez.',
        'Listez les URL à vérifier et cochez les robots qui vous intéressent (Googlebot, Bingbot, robots d\'IA, ou un jeton personnalisé).',
        'Lisez la décision par URL et par robot, la règle qui s\'applique, puis corrigez les groupes, les motifs ou la syntaxe signalés.',
    ],
    'faq_intro' => 'Comprendre les décisions d\'un robots.txt',
    'faq' => [
        ['q' => 'Comment un robot choisit-il son groupe de règles ?', 'a' => 'Il cherche le groupe dont le User-agent est le préfixe le plus long de son propre nom : Googlebot-Image utilise le groupe « Googlebot-Image » s\'il existe, sinon « Googlebot », sinon « * ». Un groupe dédié, même vide, remplace entièrement le groupe « * » — il ne s\'y ajoute pas.'],
        ['q' => 'Quelle règle gagne quand plusieurs correspondent ?', 'a' => 'La règle au motif le plus long (le plus spécifique). À longueur égale, Allow l\'emporte sur Disallow. « Disallow: /blog » bloque donc « /blog/article », sauf si « Allow: /blog/article » est présent.'],
        ['q' => 'Que signifient « * » et « $ » dans un motif ?', 'a' => '« * » remplace n\'importe quelle suite de caractères et « $ » marque la fin de l\'URL. « Disallow: /*?sort= » bloque toute URL contenant ce paramètre ; « Disallow: /*.pdf$ » bloque les PDF mais pas « fichier.pdf?v=2 ».'],
        ['q' => 'Un robots.txt empêche-t-il l\'indexation ?', 'a' => 'Non : il empêche l\'exploration. Une URL bloquée peut tout de même apparaître dans Google si d\'autres pages la lient, mais sans extrait. Pour désindexer, laissez le robot accéder à la page et utilisez une balise meta robots noindex.'],
        ['q' => 'Que se passe-t-il si le fichier est absent ou en erreur ?', 'a' => 'Un code 404 est traité comme « tout est permis ». En revanche, une erreur serveur (5xx) répétée peut amener Google à considérer le site entier comme interdit : surveillez la disponibilité du fichier.'],
        ['q' => 'Crawl-delay et Noindex sont-ils pris en compte ?', 'a' => 'Google les ignore. Bing et Yandex respectent Crawl-delay. La directive Noindex dans robots.txt n\'est plus supportée depuis 2019 : utilisez la balise meta ou l\'en-tête X-Robots-Tag.'],
    ],
    'related' => [
        ['slug' => 'robots-validator', 'title' => 'Validateur Robots.txt', 'desc' => 'Vérifiez la syntaxe globale de votre fichier'],
        ['slug' => 'crawl-optimization-checker', 'title' => 'Optimisation du Crawl', 'desc' => 'Ce qui gaspille votre budget de crawl'],
        ['slug' => 'ai-crawler-access-checker', 'title' => 'Accès des Robots d\'IA', 'desc' => 'Qui peut lire votre site : GPTBot, ClaudeBot, Gemini…'],
    ],
    'cta' => [
        'title' => 'Un Problème d\'Exploration Plus Large ?',
        'text' => 'Nous auditons la crawlabilité complète de votre site : robots.txt, sitemaps, redirections, budget d\'exploration',
    ],
    'card_title' => 'Testeur Robots.txt',
    'card_desc' => 'Testez vos URL contre votre robots.txt pour chaque robot et voyez la règle qui s\'applique',
];
