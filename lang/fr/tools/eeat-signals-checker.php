<?php

return [
    'title' => 'Vérificateur de Signaux E-E-A-T Gratuit - Confiance, Auteur, Sources | CodeSommet',
    'meta_description' => 'Contrôlez les signaux E-E-A-T d\'une page : HTTPS, pages légales, contact, organisation schema.org, auteur, dates, profils externes, sources citées et preuves d\'expérience.',
    'meta_keywords' => 'eeat,e-e-a-t,audit eeat,signaux de confiance,expertise,auteur,schema organization,qualité de contenu,google quality rater',
    'og_title' => 'Vérificateur de Signaux E-E-A-T',
    'og_description' => 'Confiance, autorité, expertise, expérience : listez les signaux présents et manquants sur une page, règle par règle.',
    'twitter_description' => 'Les signaux de confiance, d\'expertise et d\'expérience d\'une page, vérifiés règle par règle.',
    'breadcrumb' => 'Signaux E-E-A-T',
    'h1' => 'Vérificateur de Signaux E-E-A-T',
    'intro' => 'Qui est derrière cette page, comment le joindre, sur quoi s\'appuie le contenu ? Vérifiez en une analyse les signaux de confiance, d\'autorité, d\'expertise et d\'expérience visibles dans le HTML.',
    'btn_submit' => 'Vérifier les signaux',
    'fields' => [
        ['name' => 'url', 'label' => 'Page à analyser', 'type' => 'url', 'required' => true,
            'placeholder' => 'https://example.com/blog/article',
            'help' => 'Une page publique : article, page service ou page d\'accueil.'],
    ],
    'score_note' => 'Score de couverture des signaux, pas une note Google : l\'E-E-A-T n\'est pas un facteur de classement unique et la réputation hors du site ne se lit pas sur une page. Les vérifications « non notées » ne s\'appliquent pas à ce type de page.',
    'signals_title' => 'Signaux trouvés sur la page',
    'how' => [
        'Saisissez l\'adresse d\'une page publique.',
        'L\'outil télécharge la page et applique 13 règles documentées : HTTPS, pages légales, contact, organisation, adresse, « À propos », profils, sources, auteur, réalisations, avis, dates, volume de texte.',
        'Corrigez d\'abord les « Problèmes », puis les points « À améliorer » ; exportez la liste en CSV pour la partager.',
    ],
    'faq_intro' => 'Comprendre les signaux E-E-A-T',
    'faq' => [
        ['q' => 'Que signifie E-E-A-T ?',
            'a' => 'Experience, Expertise, Authoritativeness, Trustworthiness : les critères que les évaluateurs de Google utilisent pour juger la qualité d\'une page. La confiance est le plus important : un contenu doit montrer qui l\'a écrit, qui l\'édite et comment les joindre.'],
        ['q' => 'Ce score est-il celui de Google ?',
            'a' => 'Non. Google ne publie aucun score E-E-A-T. Cet outil vérifie des signaux observables dans le HTML d\'une page ; il ne mesure ni la réputation de la marque sur le web ni la qualité réelle du contenu, qui demandent une lecture humaine.'],
        ['q' => 'Pourquoi l\'auteur est-il « non noté » sur ma page ?',
            'a' => 'Un auteur et une date sont attendus sur un article ou un guide. Sur une page d\'accueil ou une page service, l\'outil ne les exige pas et les exclut du score.'],
        ['q' => 'Comment l\'outil repère-t-il les pages « À propos » ou les mentions légales ?',
            'a' => 'D\'après l\'adresse et le texte des liens présents sur la page (« à propos », « qui sommes-nous », « mentions légales », « confidentialité »…). Une page qui existe mais n\'est liée nulle part n\'est pas détectée — et n\'aide pas non plus le visiteur.'],
    ],
    'related' => [
        ['slug' => 'ai-readiness-checker', 'title' => 'Préparation aux Moteurs IA', 'desc' => 'Vérifiez si votre page peut être lue et citée par les moteurs IA.'],
        ['slug' => 'structured-data-extractor', 'title' => 'Extracteur de Données Structurées', 'desc' => 'Inspectez le JSON-LD Organization, Article ou LocalBusiness de la page.'],
        ['slug' => 'local-business-schema', 'title' => 'Générateur Schema LocalBusiness', 'desc' => 'Déclarez votre entreprise, son adresse et ses profils.'],
    ],
    'usage' => 'pages analysées',
    'cta' => [
        'title' => 'Renforcer la Crédibilité de Votre Site ?',
        'text' => 'Nous structurons pages équipe, études de cas, mentions légales et données d\'organisation pour inspirer confiance aux visiteurs comme aux moteurs',
    ],
    'card_title' => 'Vérificateur de Signaux E-E-A-T',
    'card_desc' => 'Confiance, auteur, contact, pages légales, profils, sources et dates : les signaux E-E-A-T d\'une page, règle par règle',
];
