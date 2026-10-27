<?php

return [
    'title' => 'Compresseur d\'Images Gratuit - WebP, JPEG, PNG et Redimensionnement | CodeSommet',
    'meta_description' => 'Compressez et convertissez jusqu\'à 30 images en WebP, JPEG ou PNG, avec redimensionnement et contrôle de qualité. Traitement dans votre navigateur : aucune image n\'est envoyée.',
    'meta_keywords' => 'compresser image,convertir webp,réduire poids image,compression jpeg,redimensionner image,optimiser images seo,images légères',
    'og_title' => 'Compresseur d\'Images Gratuit - WebP, JPEG, PNG',
    'og_description' => 'Réduisez le poids de vos images et convertissez-les en WebP, sans les envoyer sur un serveur.',
    'twitter_description' => 'Compressez et convertissez vos images en WebP, JPEG ou PNG, dans votre navigateur.',

    'breadcrumb' => 'Compresseur d\'Images',
    'h1' => 'Compresseur d\'Images',
    'intro' => 'Des images trop lourdes ralentissent vos pages et pèsent sur les Core Web Vitals. Compressez-les, convertissez-les en WebP et redimensionnez-les en quelques secondes — sans les envoyer nulle part.',
    'usage' => 'lots compressés',

    'label_files' => 'Images (JPEG, PNG, WebP — 30 maximum, 25 Mo chacune)',
    'label_format' => 'Format de sortie',
    'label_quality' => 'Qualité',
    'label_width' => 'Largeur maximale (px)',
    'btn_submit' => 'Compresser les images',

    'how' => [
        'Sélectionnez jusqu\'à 30 images.',
        'Choisissez le format (WebP recommandé), la qualité et, si besoin, une largeur maximale.',
        'Comparez les poids avant et après, puis téléchargez chaque image optimisée.',
    ],
    'faq_intro' => 'Optimiser ses images pour la vitesse et le SEO',
    'faq' => [
        ['q' => 'Mes images sont-elles envoyées sur un serveur ?', 'a' => 'Non. La compression utilise le moteur graphique de votre navigateur : les fichiers ne quittent jamais votre appareil.'],
        ['q' => 'Quel format choisir ?', 'a' => 'WebP offre généralement le meilleur rapport poids/qualité et est lu par tous les navigateurs récents. JPEG reste universel pour les photos ; PNG est sans perte et conserve la transparence, mais il est souvent plus lourd.'],
        ['q' => 'Quelle qualité utiliser ?', 'a' => '80 % est un bon équilibre pour les photos ; descendez à 60 % pour des vignettes. La qualité ne s\'applique pas au PNG, qui est sans perte.'],
        ['q' => 'Les métadonnées sont-elles conservées ?', 'a' => 'Non : la réencodage supprime les métadonnées EXIF (appareil, coordonnées GPS), ce qui allège aussi le fichier. Conservez vos originaux si vous en avez besoin.'],
        ['q' => 'Et si l\'image compressée est plus lourde ?', 'a' => 'Cela arrive avec des fichiers déjà très optimisés ou une conversion en PNG. L\'outil l\'indique clairement : gardez alors l\'original.'],
    ],
    'related' => [
        ['slug' => 'image-compression-analyzer', 'title' => 'Analyseur de Compression d\'Images', 'desc' => 'Repérez les images trop lourdes d\'une page'],
        ['slug' => 'image-alt-analyzer', 'title' => 'Analyseur de Texte Alt', 'desc' => 'Vérifiez les textes alternatifs de vos images'],
        ['slug' => 'page-speed-analyzer', 'title' => 'Analyseur de Vitesse', 'desc' => 'Mesurez la performance réelle de vos pages'],
    ],
    'cta' => [
        'title' => 'Un Site Trop Lent ?',
        'text' => 'Nous optimisons images, code et hébergement pour des pages qui s\'affichent en moins de deux secondes',
    ],
    'card_title' => 'Compresseur d\'Images',
    'card_desc' => 'Compressez et convertissez vos images en WebP, JPEG ou PNG, sans les envoyer sur un serveur',
];
