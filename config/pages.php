<?php

/*
|--------------------------------------------------------------------------
| Pages publiques statiques (whitelists)
|--------------------------------------------------------------------------
| Source unique de vérité pour les slugs des pages services et villes.
| Utilisée par routes/web.php (validation) et par le sitemap dynamique.
| Ajouter une page = créer la vue Blade + ajouter le slug ici.
*/

return [

    'services' => [
        'ecommerce-website-development',
        'saas-platform-development',
        'fintech-platform-development',
        'fintech-website-development',
        'healthcare-website-development',
        'education-website-development',
        'edtech-platform-development',
        'elearning-platform-development',
        'online-course-platform-development',
        'university-website-development',
        'language-school-website-development',
        'study-abroad-website-development',
        'immigration-consultancy-website-development',
        'real-estate-website-development',
        'telemedicine-platform-development',
        'telemedicine-website-development',
    ],

    // NOTE : « doha » et « kuwait-city » ont été retirés — aucune vue n'existe
    // pour ces villes, la route renvoyait systématiquement un 404.
    'cities' => [
        'worldwide',
        'casablanca', 'marrakech', 'rabat', 'tangier',
        'dubai', 'abudhabi', 'riyadh',
        'london', 'amsterdam', 'berlin', 'paris', 'copenhagen',
        'dublin', 'brussels', 'zurich', 'stockholm',
        'madrid', 'barcelona', 'lisbon', 'rome', 'milan',
        'new-york', 'san-francisco', 'los-angeles', 'austin',
        'seattle', 'boston', 'chicago', 'denver', 'toronto', 'vancouver',
        'tunis', 'cairo', 'lagos',
    ],

    'legal' => [
        'privacy-policy',
        'terms-of-service',
        'refund-policy',
        'cookie-policy',
        'acceptable-use',
    ],

];
