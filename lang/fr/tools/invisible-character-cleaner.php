<?php

return [
    'title' => 'Nettoyeur de Caractères Invisibles - Espaces Insécables, Zéro-Largeur, Contrôles | CodeSommet',
    'meta_description' => 'Détectez et supprimez les caractères invisibles d\'un texte : espaces de largeur nulle, marques de direction, caractères de balise, espaces insécables. Rapport détaillé, 100 % local.',
    'meta_keywords' => 'caractères invisibles,zero width space,espace insécable,nettoyer texte,caractères cachés,u+200b,texte copié coller',
    'og_title' => 'Nettoyeur de Caractères Invisibles',
    'og_description' => 'Trouvez et supprimez les caractères invisibles qui perturbent vos titres, balises et contenus copiés-collés.',
    'twitter_description' => 'Détectez et supprimez les caractères invisibles d\'un texte, dans votre navigateur.',

    'breadcrumb' => 'Caractères Invisibles',
    'h1' => 'Nettoyeur de Caractères Invisibles',
    'intro' => 'Un texte copié depuis un traitement de texte, une messagerie ou un outil en ligne peut contenir des caractères invisibles qui cassent les recherches, les balises title ou la mise en page. Repérez-les et nettoyez-les.',
    'usage' => 'textes nettoyés',

    'label_input' => 'Texte à vérifier',
    'opt_spaces' => 'Remplacer les espaces spéciaux (insécables, fines…) par des espaces normaux',
    'opt_collapse' => 'Réduire les espaces multiples',
    'opt_quotes' => 'Redresser les guillemets et apostrophes typographiques',
    'opt_ellipsis' => 'Remplacer « … » par « ... »',
    'btn_submit' => 'Analyser et nettoyer',

    'how' => [
        'Collez votre texte : titres, méta descriptions, articles, listes.',
        'Choisissez les normalisations facultatives (espaces, guillemets, points de suspension).',
        'Consultez le rapport par type de caractère, puis copiez le texte nettoyé.',
    ],
    'faq_intro' => 'Comprendre les caractères invisibles',
    'faq' => [
        ['q' => 'Quels caractères sont toujours supprimés ?', 'a' => 'Les espaces de largeur nulle (U+200B à U+200D, U+2060, U+FEFF), les marques et contrôles de direction (U+200E, U+200F, U+202A à U+202E, U+2066 à U+2069), le trait d\'union conditionnel (U+00AD) et les caractères de balise Unicode (U+E0000 à U+E007F). Ils ne s\'affichent pas mais modifient le texte.'],
        ['q' => 'Pourquoi c\'est un problème pour le SEO ?', 'a' => 'Un caractère invisible dans une balise title, une URL ou un mot-clé crée une chaîne différente de celle attendue : recherches internes qui échouent, doublons apparents, affichage inattendu dans les résultats.'],
        ['q' => 'Les emojis sont-ils conservés ?', 'a' => 'Oui. Le joint de largeur nulle (U+200D) qui compose certains emojis est conservé lorsqu\'il se trouve entre deux emojis, et les sélecteurs de variante ne sont pas touchés.'],
        ['q' => 'Cet outil rend-il un texte « indétectable » ?', 'a' => 'Non. Il nettoie des caractères techniques ; il ne modifie ni le style ni le vocabulaire d\'un texte et ne prétend pas masquer son origine.'],
    ],
    'related' => [
        ['slug' => 'word-counter', 'title' => 'Compteur de Mots', 'desc' => 'Mots, caractères et temps de lecture'],
        ['slug' => 'text-editor', 'title' => 'Éditeur de Texte Ligne par Ligne', 'desc' => 'Dédoublonnez, triez et filtrez vos listes'],
        ['slug' => 'serp-snippet-preview', 'title' => 'Aperçu SERP', 'desc' => 'Prévisualisez titre et description dans Google'],
    ],
    'cta' => [
        'title' => 'Des Contenus à Fiabiliser à Grande Échelle ?',
        'text' => 'Nous mettons en place des chaînes de publication propres, du rédactionnel jusqu\'aux balises SEO',
    ],
    'card_title' => 'Nettoyeur de Caractères Invisibles',
    'card_desc' => 'Repérez et supprimez espaces de largeur nulle, contrôles de direction et espaces insécables',
];
