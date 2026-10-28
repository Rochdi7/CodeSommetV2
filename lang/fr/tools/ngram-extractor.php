<?php

return [
    'title' => 'Extracteur de N-grammes - Mots Fréquents | CodeSommet',
    'meta_description' => 'Extrayez les expressions de 1 à 4 mots les plus fréquentes d\'un texte ou d\'une URL, avec densité et présence dans les titres. Gratuit.',
    'meta_keywords' => 'n-grammes,ngram extractor,expressions fréquentes,analyse sémantique,densité mots-clés,bigrammes trigrammes,vocabulaire page,analyse concurrent seo',
    'og_title' => 'Extracteur de N-grammes - Expressions les Plus Fréquentes',
    'og_description' => 'Mots et expressions de 1 à 4 mots les plus fréquents d\'un texte ou d\'une page, avec densité et présence dans les titres.',
    'twitter_description' => 'Extrayez les expressions de 1 à 4 mots les plus fréquentes d\'un texte ou d\'une URL.',

    'breadcrumb' => 'Extracteur de N-grammes',
    'h1' => 'Extracteur de N-grammes : Mots Fréquents',
    'intro' => 'Quelles expressions reviennent le plus dans une page qui se classe ? Extrayez les mots, bigrammes, trigrammes et quadrigrammes d\'un texte ou d\'une URL, avec leur fréquence et leur présence dans les titres.',
    'usage' => 'textes analysés',

    'label_url' => 'URL de la page (le texte visible sera extrait)',
    'btn_fetch' => 'Charger le texte',
    'label_text' => 'Texte à analyser',
    'label_min' => 'Fréquence minimale',
    'label_stopwords' => 'Ignorer les mots-outils (le, de, and, the…)',
    'btn_submit' => 'Extraire les n-grammes',

    'how' => [
        'Collez un texte, ou entrez l\'URL d\'une page (la vôtre ou celle d\'un concurrent) pour en charger le texte visible.',
        'Choisissez la fréquence minimale et si les mots-outils doivent être ignorés, puis lancez l\'extraction.',
        'Parcourez les onglets 1 à 4 mots : fréquence, densité, et présence dans les titres H1–H6. Exportez en CSV pour comparer plusieurs pages.',
    ],
    'faq_intro' => 'Lire et utiliser une analyse de n-grammes',
    'faq' => [
        ['q' => 'Qu\'est-ce qu\'un n-gramme ?', 'a' => 'Une suite de n mots consécutifs. « agence web » est un bigramme, « agence web casablanca » un trigramme. Les n-grammes fréquents d\'une page révèlent son sujet, ses entités et ses expressions clés bien mieux qu\'un mot isolé.'],
        ['q' => 'À quoi cela sert-il en SEO ?', 'a' => 'À comprendre le vocabulaire que Google associe à une intention : analysez les pages qui se classent sur votre requête, repérez les expressions qu\'elles partagent et que votre page n\'emploie pas, et enrichissez votre contenu sans bourrage.'],
        ['q' => 'Quelle densité viser ?', 'a' => 'Aucune valeur magique. Une expression principale entre 0,5 et 2 % est courante dans les pages bien classées ; au-delà de 3 %, le texte devient répétitif. La couverture du champ lexical (variété des n-grammes liés) compte plus que la répétition.'],
        ['q' => 'Pourquoi ignorer les mots-outils ?', 'a' => 'Articles, prépositions et conjonctions dominent toute liste de fréquences sans porter de sens. Les ignorer fait remonter les expressions utiles ; les conserver est utile pour retrouver des formulations exactes (« comment créer un site »).'],
        ['q' => 'Le texte est-il envoyé à un serveur ?', 'a' => 'Le calcul des n-grammes se fait dans votre navigateur. Seul le chargement depuis une URL passe par nos serveurs, qui ne conservent pas le texte.'],
        ['q' => 'Pourquoi le texte chargé diffère-t-il de la page ?', 'a' => 'Nous lisons le HTML envoyé par le serveur, sans exécuter le JavaScript, et retirons scripts et styles. Les menus et pieds de page restent inclus : collez le corps de l\'article pour une analyse plus fine.'],
    ],
    'related' => [
        ['slug' => 'keyword-density-analyzer', 'title' => 'Densité de Mots-clés', 'desc' => 'Densité d\'un mot-clé précis dans une page'],
        ['slug' => 'readability-analyzer', 'title' => 'Analyseur de Lisibilité', 'desc' => 'Score de lisibilité de vos textes'],
        ['slug' => 'word-counter', 'title' => 'Compteur de Mots', 'desc' => 'Mots, caractères, phrases, temps de lecture'],
    ],
    'cta' => [
        'title' => 'Besoin de Contenus Qui Se Classent ?',
        'text' => 'Nous rédigeons et optimisons vos pages à partir de l\'analyse sémantique des résultats qui gagnent',
    ],
    'card_title' => 'Extracteur de N-grammes',
    'card_desc' => 'Expressions de 1 à 4 mots les plus fréquentes d\'un texte ou d\'une page, avec densité',
];
