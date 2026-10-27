<?php

return [
    'title' => 'Éditeur d\'URL en Masse - Nettoyer, Dédoublonner et Normaliser des Listes d\'URL | CodeSommet',
    'meta_description' => 'Nettoyez des centaines d\'URL en un clic : suppression des paramètres de suivi (utm, gclid), des ancres et des doublons, HTTPS forcé, réduction à la racine. Traitement 100 % local, gratuit.',
    'meta_keywords' => 'éditeur url,nettoyer liste url,supprimer utm,dédoublonner url,normaliser url,supprimer paramètres url,liste url seo',
    'og_title' => 'Éditeur d\'URL en Masse - Nettoyer et Normaliser des Listes d\'URL',
    'og_description' => 'Supprimez paramètres de suivi, ancres et doublons, forcez HTTPS ou réduisez à la racine : des centaines d\'URL nettoyées en un clic.',
    'twitter_description' => 'Nettoyez et normalisez des listes d\'URL en un clic, directement dans votre navigateur.',

    'breadcrumb' => 'Éditeur d\'URL',
    'h1' => 'Éditeur d\'URL en Masse',
    'intro' => 'Collez une liste d\'URL exportée d\'un crawl, de la Search Console ou d\'un tableur, choisissez les nettoyages à appliquer et récupérez une liste propre et dédoublonnée.',
    'usage' => 'listes nettoyées',

    'label_input' => 'URL (une par ligne)',
    'label_params' => 'Paramètres de requête',
    'params_keep' => 'Conserver',
    'params_tracking' => 'Retirer le suivi (utm_*, gclid, fbclid…)',
    'params_all' => 'Tout retirer',
    'label_keep' => 'Garder seulement les URL contenant',
    'label_exclude' => 'Exclure les URL contenant',
    'btn_submit' => 'Nettoyer la liste',

    'how' => [
        'Collez vos URL, une par ligne (jusqu\'à 50 000).',
        'Cochez les nettoyages souhaités : ils sont appliqués dans l\'ordre affiché, puis la liste est dédoublonnée.',
        'Copiez la liste propre ou téléchargez-la en CSV. Rien n\'est envoyé à nos serveurs.',
    ],
    'faq_intro' => 'Normaliser ses URL pour des audits et des imports fiables',
    'faq' => [
        ['q' => 'Pourquoi retirer les paramètres de suivi ?', 'a' => 'Les paramètres utm_*, gclid ou fbclid ne changent pas le contenu de la page mais créent des URL différentes. Les retirer évite de compter plusieurs fois la même page dans un audit ou un fichier de redirections.'],
        ['q' => 'Quelle différence entre « retirer le suivi » et « tout retirer » ?', 'a' => '« Retirer le suivi » ne supprime que les paramètres publicitaires et analytiques connus et conserve ceux qui changent le contenu (pagination, filtres). « Tout retirer » supprime toute la chaîne de requête.'],
        ['q' => 'Les URL sont-elles envoyées quelque part ?', 'a' => 'Non. Tout le traitement se fait dans votre navigateur : la liste ne quitte jamais votre ordinateur.'],
        ['q' => 'Que deviennent les lignes qui ne sont pas des URL ?', 'a' => 'Elles sont mises de côté et listées séparément pour que vous puissiez les corriger, au lieu d\'être silencieusement supprimées.'],
        ['q' => 'La barre oblique finale est-elle importante ?', 'a' => 'Pour un serveur, /page et /page/ sont deux adresses différentes. Choisissez une convention et appliquez-la partout (liens internes, sitemap, canonical) ; l\'option « retirer la barre finale » vous aide à harmoniser une liste.'],
    ],
    'related' => [
        ['slug' => 'domain-extractor', 'title' => 'Extracteur de Domaines', 'desc' => 'Isolez les domaines uniques d\'une liste d\'URL'],
        ['slug' => 'utm-builder', 'title' => 'Générateur UTM', 'desc' => 'Créez des URL de campagne correctement balisées'],
        ['slug' => 'redirect-checker', 'title' => 'Vérificateur de Redirections', 'desc' => 'Suivez la chaîne de redirections d\'une URL'],
    ],
    'cta' => [
        'title' => 'Une Migration d\'URL à Préparer ?',
        'text' => 'Nous cartographions vos URL, préparons les redirections 301 et sécurisons votre référencement pendant la refonte',
    ],
    'card_title' => 'Éditeur d\'URL en Masse',
    'card_desc' => 'Retirez paramètres de suivi, ancres et doublons, forcez HTTPS : des listes d\'URL propres en un clic',
];
