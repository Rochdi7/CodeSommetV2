<?php

return [
    'title' => 'Extracteur de Domaines - Domaines Uniques d\'une Liste d\'URL | CodeSommet',
    'meta_description' => 'Extrayez les noms de domaine uniques d\'une liste d\'URL ou de backlinks, avec le nombre d\'URL par domaine et la gestion des suffixes comme .co.ma ou .co.uk. Gratuit, 100 % local.',
    'meta_keywords' => 'extraire domaines,domaines uniques,liste url en domaines,domain extractor,backlinks domaines référents,nom de domaine racine',
    'og_title' => 'Extracteur de Domaines Uniques',
    'og_description' => 'Transformez une liste d\'URL ou de backlinks en liste de domaines uniques, avec le nombre d\'URL par domaine.',
    'twitter_description' => 'Extrayez les domaines uniques d\'une liste d\'URL, directement dans votre navigateur.',

    'breadcrumb' => 'Extracteur de Domaines',
    'h1' => 'Extracteur de Domaines',
    'intro' => 'Transformez une liste d\'URL — export de backlinks, crawl, liste de prospects — en domaines uniques, avec le nombre d\'URL pour chacun.',
    'usage' => 'listes analysées',

    'label_input' => 'URL ou noms d\'hôte (un par ligne)',
    'label_mode' => 'Niveau',
    'mode_root' => 'Domaine racine (blog.exemple.co.ma → exemple.co.ma)',
    'mode_host' => 'Nom d\'hôte complet (sans www.)',
    'btn_submit' => 'Extraire les domaines',

    'how' => [
        'Collez vos URL ou noms d\'hôte, un par ligne.',
        'Choisissez le domaine racine ou le nom d\'hôte complet.',
        'Copiez la liste des domaines uniques ou exportez le tableau en CSV.',
    ],
    'faq_intro' => 'Domaines, sous-domaines et suffixes publics',
    'faq' => [
        ['q' => 'Qu\'est-ce que le domaine racine ?', 'a' => 'C\'est le nom enregistré auprès d\'un registraire, sans les sous-domaines : blog.exemple.com devient exemple.com. Pour les extensions à deux niveaux comme .co.ma, .co.uk ou .com.br, l\'outil conserve le niveau supplémentaire (exemple.co.ma).'],
        ['q' => 'Quelles extensions à plusieurs niveaux sont reconnues ?', 'a' => 'Une liste des suffixes publics les plus courants (Maroc, France, Royaume-Uni, Brésil, Australie, Japon, Inde, Afrique…), intégrée à la page. Pour un suffixe rare non listé, utilisez le mode « nom d\'hôte complet ».'],
        ['q' => 'À quoi cela sert-il en SEO ?', 'a' => 'À compter les domaines référents d\'un export de backlinks, à préparer un fichier de désaveu au niveau domaine, ou à dédoublonner une liste de prospection.'],
        ['q' => 'Mes données sont-elles envoyées ?', 'a' => 'Non, l\'extraction se fait entièrement dans votre navigateur.'],
    ],
    'related' => [
        ['slug' => 'url-editor', 'title' => 'Éditeur d\'URL en Masse', 'desc' => 'Nettoyez et dédoublonnez vos listes d\'URL'],
        ['slug' => 'expired-domain-checker', 'title' => 'Vérificateur de Domaines Expirés', 'desc' => 'Disponibilité et expiration depuis les registres'],
        ['slug' => 'domain-health-checker', 'title' => 'Santé du Domaine', 'desc' => 'HTTPS, robots.txt, sitemap et balises essentielles'],
    ],
    'cta' => [
        'title' => 'Besoin d\'un Audit de Votre Profil de Liens ?',
        'text' => 'Nous analysons vos domaines référents et construisons une stratégie de liens durable',
    ],
    'card_title' => 'Extracteur de Domaines',
    'card_desc' => 'Domaines uniques d\'une liste d\'URL ou de backlinks, avec le nombre d\'URL par domaine',
];
