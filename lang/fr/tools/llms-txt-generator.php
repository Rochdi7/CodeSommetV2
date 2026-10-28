<?php

return [
    'title' => 'Générateur de Fichier llms.txt Gratuit | CodeSommet',
    'meta_description' => 'Générez un fichier llms.txt au format llmstxt.org à partir des pages réelles de votre site, pour aider ChatGPT, Claude et Perplexity à le lire.',
    'meta_keywords' => 'llms.txt,générateur llms.txt,fichier llms.txt,GEO,optimisation IA,ChatGPT,Claude,Perplexity,llmstxt',
    'og_title' => 'Générateur LLMs.txt Gratuit',
    'og_description' => 'Créez en un clic le fichier llms.txt de votre site à partir de ses pages réelles, au format llmstxt.org.',
    'twitter_description' => 'Générez le fichier llms.txt de votre site à partir de ses pages réelles.',
    'breadcrumb' => 'Générateur LLMs.txt',
    'h1' => 'Générateur de Fichier llms.txt Gratuit',
    'intro' => 'Créez le fichier llms.txt de votre site : un résumé structuré de vos pages clés, au format llmstxt.org, lisible par les assistants IA.',
    'btn_submit' => 'Générer le llms.txt',
    'fields' => [
        ['name' => 'url', 'label' => 'URL du site', 'type' => 'url', 'placeholder' => 'https://example.com', 'required' => true],
        ['name' => 'siteName', 'label' => 'Nom du site (facultatif)', 'type' => 'text', 'placeholder' => 'Par défaut : le titre de la page d\'accueil'],
        ['name' => 'summary', 'label' => 'Résumé (facultatif)', 'type' => 'textarea', 'rows' => 2,
            'placeholder' => 'Par défaut : la méta description de la page d\'accueil'],
    ],
    'how' => [
        'Entrez l\'adresse de votre site ; ajoutez si vous le souhaitez un nom et un résumé.',
        'L\'outil explore jusqu\'à 40 pages et retient celles qui sont indexables et accessibles.',
        'Copiez ou téléchargez le fichier, relisez-le, puis publiez-le à la racine de votre site (/llms.txt).',
    ],
    'faq_intro' => 'Comprendre le fichier llms.txt et son utilité',
    'faq' => [
        ['q' => 'Qu\'est-ce qu\'un fichier llms.txt ?',
            'a' => 'C\'est une proposition de standard (llmstxt.org) : un fichier Markdown placé à la racine du site qui présente le site et liste ses pages importantes avec une courte description, pour aider les modèles de langage à trouver l\'essentiel.'],
        ['q' => 'Le llms.txt améliore-t-il mon référencement ?',
            'a' => 'Ce n\'est pas un facteur de classement Google. Son intérêt est de donner aux assistants IA une vue claire de vos contenus. Il ne remplace ni le sitemap XML, ni de bonnes pages.'],
        ['q' => 'Quelles pages sont incluses ?',
            'a' => 'Les pages explorées qui répondent correctement (code 2xx), ne sont pas en noindex et ne sont pas bloquées par robots.txt. Les titres et descriptions viennent des pages elles-mêmes : soignez vos balises title et meta description.'],
        ['q' => 'Puis-je modifier le fichier généré ?',
            'a' => 'Oui, et c\'est recommandé : regroupez les sections, retirez les pages secondaires et ajoutez une section « Optional » pour les contenus annexes avant de publier.'],
    ],
    'related' => [
        ['slug' => 'ai-crawler-access-checker', 'title' => 'Accès des Robots IA', 'desc' => 'Vérifiez que GPTBot, ClaudeBot et PerplexityBot peuvent lire vos pages.'],
        ['slug' => 'sitemap-url-extractor', 'title' => 'Extracteur d\'URL de Sitemap', 'desc' => 'Listez toutes les URL déclarées dans votre sitemap.'],
        ['slug' => 'crawl-visualizer', 'title' => 'Visualiseur de Crawl', 'desc' => 'Visualisez l\'architecture de votre site en diagramme.'],
    ],
    'usage' => 'fichiers générés',
    'cta' => [
        'title' => 'Votre Site Est-il Prêt pour la Recherche IA ?',
        'text' => 'Nous structurons contenus, données et fichiers techniques pour que les assistants IA comprennent et citent votre site',
    ],
    'card_title' => 'Générateur LLMs.txt',
    'card_desc' => 'Créez le fichier llms.txt de votre site à partir de ses pages réelles, au format llmstxt.org',
];
