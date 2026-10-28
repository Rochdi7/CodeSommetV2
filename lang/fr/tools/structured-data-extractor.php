<?php

return [
    'title' => 'Extracteur de Données Structurées JSON-LD | CodeSommet',
    'meta_description' => 'Extrayez JSON-LD, microdonnées et RDFa d\'une page et validez chaque entité schema.org pour les résultats enrichis Google. Gratuit.',
    'meta_keywords' => 'données structurées,json-ld validator,schema.org checker,rich results,résultats enrichis,extracteur json-ld,microdata,validateur schema,structured data testing',
    'og_title' => 'Extracteur et Validateur de Données Structurées',
    'og_description' => 'JSON-LD, microdonnées, RDFa : extrayez et validez les données structurées d\'une page pour les résultats enrichis Google.',
    'twitter_description' => 'Extrayez et validez le JSON-LD et les microdonnées d\'une page pour les résultats enrichis Google.',

    'breadcrumb' => 'Données Structurées',
    'h1' => 'Extracteur de Données Structurées',
    'intro' => 'Tout le balisage schema.org d\'une page, bloc par bloc et entité par entité, avec les propriétés qui manquent pour prétendre aux résultats enrichis de Google.',
    'usage' => 'pages analysées',

    'label_url' => 'URL de la page',
    'label_code' => 'Ou collez du JSON-LD (ou un fragment HTML contenant les balises script)',
    'btn_submit' => 'Extraire et valider',

    'how' => [
        'Entrez l\'URL d\'une page, ou collez directement le JSON-LD que vous préparez.',
        'Chaque bloc est vérifié (JSON valide, @context), puis chaque entité est comparée aux propriétés requises et recommandées par Google pour son type.',
        'Corrigez les erreurs (bloquantes pour les résultats enrichis), puis les recommandations, et testez à nouveau.',
    ],
    'faq_intro' => 'Résultats enrichis, types schema.org et erreurs fréquentes',
    'faq' => [
        ['q' => 'Quelle différence entre JSON-LD, microdonnées et RDFa ?', 'a' => 'Ce sont trois syntaxes pour le même vocabulaire schema.org. JSON-LD est un bloc <script> indépendant du HTML, recommandé par Google ; les microdonnées (itemscope, itemprop) et le RDFa (typeof, property) s\'écrivent dans les balises. L\'outil valide le JSON-LD et signale la présence des deux autres.'],
        ['q' => 'Qu\'est-ce qu\'une propriété « requise » ou « recommandée » ?', 'a' => 'Google publie, pour chaque type de résultat enrichi (Article, Produit, FAQ, Événement…), les propriétés sans lesquelles le résultat n\'est pas éligible (requises) et celles qui l\'améliorent (recommandées). Une propriété requise manquante est une erreur ; une recommandée manquante, un avertissement.'],
        ['q' => 'Pourquoi mon bloc est-il « JSON invalide » ?', 'a' => 'Les causes classiques : une virgule après le dernier élément, des guillemets simples au lieu de doubles, un commentaire, ou du HTML non échappé dans une valeur. L\'outil indique si une virgule finale ou un commentaire suffisent à expliquer l\'erreur.'],
        ['q' => 'Un balisage valide garantit-il un résultat enrichi ?', 'a' => 'Non. Il le rend éligible. Google décide ensuite selon la qualité de la page, la cohérence entre le balisage et le contenu visible, et ses règles (les avis auto-attribués, par exemple, ne sont plus affichés).'],
        ['q' => 'Faut-il un seul bloc ou plusieurs ?', 'a' => 'Les deux fonctionnent. Un seul bloc avec @graph permet de relier les entités entre elles (WebSite → Organization → WebPage → Article) grâce aux @id, ce que Google et les moteurs IA exploitent de mieux en mieux.'],
        ['q' => 'Quels types sont vérifiés ?', 'a' => 'Article et ses variantes, Product et Offer, Organization, LocalBusiness et ses sous-types, FAQPage, BreadcrumbList, WebSite, WebPage, Person, Event, Recipe, VideoObject, HowTo, JobPosting, Review, AggregateRating, SoftwareApplication, Service, Course, ImageObject… Les autres types sont extraits mais seulement contrôlés sur la forme.'],
    ],
    'related' => [
        ['slug' => 'schema-generator', 'title' => 'Générateur de Schema', 'desc' => 'Créez un JSON-LD valide pour vos pages'],
        ['slug' => 'faq-schema-generator', 'title' => 'Générateur de Schema FAQ', 'desc' => 'Balisage FAQPage prêt à coller'],
        ['slug' => 'meta-extractor', 'title' => 'Extracteur de Métadonnées', 'desc' => 'Titres, descriptions et canonical en masse'],
    ],
    'cta' => [
        'title' => 'Besoin d\'un Balisage Complet sur Tout le Site ?',
        'text' => 'Nous concevons un graphe schema.org cohérent (organisation, pages, articles, produits) pour les résultats enrichis et les moteurs IA',
    ],
    'card_title' => 'Validateur de Données Structurées',
    'card_desc' => 'Extrayez et validez le JSON-LD d\'une page : propriétés requises et recommandées par type',
];
