<?php

return [
    'title' => 'Vérificateur de Domaines Expirés (RDAP) | CodeSommet',
    'meta_description' => 'Vérifiez jusqu\'à 25 domaines : disponibilité, registraire, dates de création et d\'expiration, via les registres officiels (RDAP) et le DNS.',
    'meta_keywords' => 'domaine expiré,domaine disponible,vérifier nom de domaine,RDAP,whois,date expiration domaine,registraire,âge du domaine',
    'og_title' => 'Vérificateur de Domaines Expirés et Disponibles',
    'og_description' => 'Disponibilité, registraire, création et expiration de 25 domaines, depuis les registres officiels. Gratuit.',
    'twitter_description' => 'Vérifiez la disponibilité et la date d\'expiration de 25 domaines depuis les registres officiels.',
    'breadcrumb' => 'Vérificateur de Domaines',
    'h1' => 'Vérificateur de Domaines Expirés',
    'intro' => 'Vérifiez en lot si des noms de domaine sont libres, quand ils expirent et chez qui ils sont enregistrés, à partir des registres officiels.',
    'btn_submit' => 'Vérifier les domaines',
    'fields' => [
        ['name' => 'domains', 'label' => 'Noms de domaine', 'type' => 'textarea', 'rows' => 6, 'required' => true,
            'placeholder' => "example.com\nmon-ancienne-marque.ma\nhttps://www.autre-site.fr",
            'help' => 'Un domaine par ligne (ou séparés par des virgules), 25 maximum. Les URL complètes sont acceptées.'],
    ],
    'how' => [
        'Collez vos noms de domaine, un par ligne.',
        'L\'outil interroge le registre officiel de chaque extension (protocole RDAP) et vérifie la résolution DNS.',
        'Filtrez les domaines disponibles, repérez ceux qui expirent bientôt et exportez le résultat.',
    ],
    'faq_intro' => 'Comprendre la disponibilité et l\'expiration des noms de domaine',
    'faq' => [
        ['q' => 'D\'où viennent les informations ?',
            'a' => 'Du protocole RDAP, le successeur officiel du WHOIS, interrogé directement auprès du registre de chaque extension grâce à l\'annuaire de l\'IANA, complété par une vérification DNS. Aucune donnée n\'est estimée.'],
        ['q' => 'Quand un domaine est-il considéré comme disponible ?',
            'a' => 'Uniquement lorsque le registre n\'en a aucune trace ET qu\'il ne résout pas en DNS. Dans tous les cas ambigus, il est classé « à vérifier ». La disponibilité réelle se confirme toujours chez un registraire au moment de l\'achat.'],
        ['q' => 'Pourquoi certaines extensions sont-elles « à vérifier » ?',
            'a' => 'Certaines extensions nationales ne proposent pas encore de service RDAP public, ou limitent le nombre de requêtes. L\'outil l\'indique plutôt que de deviner.'],
        ['q' => 'Un domaine expiré est-il immédiatement disponible ?',
            'a' => 'Non. Après l\'expiration, la plupart des extensions prévoient une période de grâce puis de rédemption (souvent 30 à 75 jours au total) pendant laquelle l\'ancien titulaire peut encore le renouveler.'],
    ],
    'related' => [
        ['slug' => 'domain-health-checker', 'title' => 'Santé du Domaine', 'desc' => 'Contrôlez HTTPS, robots.txt, sitemap et balises d\'un domaine.'],
        ['slug' => 'ssl-certificate-checker', 'title' => 'Vérificateur SSL', 'desc' => 'Vérifiez le certificat et sa date d\'expiration.'],
        ['slug' => 'domain-authority-checker', 'title' => 'Autorité de Domaine', 'desc' => 'Mesurez l\'autorité d\'un domaine avec un fournisseur réel.'],
    ],
    'usage' => 'vérifications',
    'cta' => [
        'title' => 'Un Nouveau Nom de Domaine pour Votre Projet ?',
        'text' => 'Nous vous aidons à choisir, migrer et lancer votre site sans perdre votre référencement',
    ],
    'card_title' => 'Vérificateur de Domaines Expirés',
    'card_desc' => 'Disponibilité, registraire, création et expiration de 25 domaines depuis les registres officiels (RDAP)',
];
