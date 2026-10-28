<?php

return [
    'title' => 'Test des En-têtes de Sécurité HTTP (A à F) | CodeSommet',
    'meta_description' => 'Analysez les en-têtes de sécurité de votre site (HSTS, CSP, X-Frame-Options, cookies) : note de A à F et corrections à appliquer. Gratuit.',
    'meta_keywords' => 'security headers,en-têtes de sécurité,hsts,content security policy,x-frame-options,referrer-policy,vérifier sécurité site,csp checker,http headers',
    'og_title' => 'Vérificateur d\'En-têtes de Sécurité HTTP - Note A à F',
    'og_description' => 'Testez HSTS, CSP, X-Frame-Options, Referrer-Policy, Permissions-Policy et les attributs de cookies de votre site, avec les corrections prêtes à copier.',
    'twitter_description' => 'Testez les en-têtes de sécurité HTTP de votre site et obtenez une note A–F avec les corrections.',

    'breadcrumb' => 'En-têtes de Sécurité',
    'h1' => 'Vérificateur d\'En-têtes de Sécurité',
    'intro' => 'Une seule requête, une note A–F et la liste des en-têtes HTTP manquants ou mal configurés — avec, pour chacun, la ligne à ajouter à votre serveur.',
    'usage' => 'sites analysés',

    'label_url' => 'URL de la page',
    'btn_submit' => 'Analyser les en-têtes',

    'how' => [
        'Entrez l\'URL de votre page d\'accueil (ou de n\'importe quelle page : les en-têtes peuvent varier).',
        'Nous effectuons une requête et évaluons chaque en-tête de sécurité selon les recommandations OWASP et MDN.',
        'Copiez les directives proposées dans la configuration de votre serveur ou de votre CDN, puis relancez le test.',
    ],
    'faq_intro' => 'Pourquoi ces en-têtes comptent, pour la sécurité comme pour le SEO',
    'faq' => [
        ['q' => 'Les en-têtes de sécurité influencent-ils le référencement ?', 'a' => 'Indirectement. HTTPS est un signal de classement, et HSTS garantit qu\'il est utilisé. Un site compromis par XSS ou clickjacking peut être signalé comme dangereux par Google Safe Browsing, ce qui fait chuter le trafic. Enfin, ces en-têtes font partie des audits de confiance (E-E-A-T) menés par les agences et les acheteurs.'],
        ['q' => 'Qu\'est-ce que Strict-Transport-Security (HSTS) ?', 'a' => 'Il indique au navigateur de n\'utiliser que HTTPS pour ce domaine pendant une durée donnée. Sans lui, la première requête d\'un visiteur peut partir en HTTP et être interceptée. Une durée d\'un an (max-age=31536000) avec includeSubDomains est le standard.'],
        ['q' => 'Comment déployer une Content-Security-Policy sans tout casser ?', 'a' => 'Commencez en mode Content-Security-Policy-Report-Only avec un report-uri ou report-to : le navigateur signale les violations sans rien bloquer. Ajustez la politique jusqu\'à l\'absence de rapports, puis passez à Content-Security-Policy. Remplacez \'unsafe-inline\' par des nonces ou des hashes.'],
        ['q' => 'X-Frame-Options ou frame-ancestors ?', 'a' => 'Les deux protègent du clickjacking. frame-ancestors (dans la CSP) est le standard actuel et permet d\'autoriser des domaines précis ; X-Frame-Options reste utile pour les anciens navigateurs. Les déclarer tous les deux est correct.'],
        ['q' => 'Pourquoi signaler l\'en-tête Server ou X-Powered-By ?', 'a' => 'Ils révèlent le logiciel et sa version (nginx/1.18, PHP/8.1…), ce qui facilite la recherche de failles connues. Les masquer ne corrige rien mais réduit l\'exposition.'],
        ['q' => 'La note s\'applique-t-elle à tout le site ?', 'a' => 'Non, à la page testée. Les en-têtes sont souvent définis globalement, mais un CDN, un sous-dossier ou une application peuvent les modifier. Testez les pages types : accueil, connexion, API, pages servies par un autre service.'],
    ],
    'related' => [
        ['slug' => 'ssl-certificate-checker', 'title' => 'Vérificateur de Certificat SSL', 'desc' => 'Validité, expiration et chaîne de votre certificat'],
        ['slug' => 'domain-health-checker', 'title' => 'Santé du Domaine', 'desc' => 'HTTPS, robots.txt, sitemap et bases techniques'],
        ['slug' => 'website-readiness-checker', 'title' => 'Site Prêt pour le Lancement ?', 'desc' => 'Check-list technique avant mise en ligne'],
    ],
    'cta' => [
        'title' => 'Besoin de Sécuriser Votre Infrastructure ?',
        'text' => 'Nous configurons HTTPS, CSP, en-têtes et CDN pour des sites rapides et protégés',
    ],
    'card_title' => 'En-têtes de Sécurité HTTP',
    'card_desc' => 'Note A–F sur HSTS, CSP, X-Frame-Options, Referrer-Policy et cookies, avec les corrections',
];
