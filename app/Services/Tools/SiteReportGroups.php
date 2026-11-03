<?php

namespace App\Services\Tools;

use App\Services\Analysis\SiteAnalysis;

/**
 * Rapport « grand public » de l'Analyseur de site : 10 points compris par un
 * dirigeant (vitesse, mobile, sécurité, Google…) au lieu de 20 contrôles
 * techniques.
 *
 * Chaque point est dérivé uniquement de faits mesurés dans SiteAnalysis —
 * aucune valeur estimée. La vitesse est ici une mesure statique (réponse du
 * serveur, poids HTML, scripts bloquants) ; le navigateur la remplace par la
 * mesure Google (PageSpeed / CrUX) quand elle est disponible.
 *
 * Clé additive `groups` : n'influence pas le score existant.
 */
final class SiteReportGroups
{
    /** Ordre d'affichage = ordre de priorité pour le « plus gros chantier ». */
    public const KEYS = ['speed', 'mobile', 'secure', 'google', 'indexable', 'address', 'business', 'pages', 'reach', 'hosting'];

    private const BUSINESS_TYPES = [
        'Organization', 'LocalBusiness', 'Corporation', 'ProfessionalService', 'Store', 'Restaurant',
        'MedicalBusiness', 'LegalService', 'FinancialService', 'RealEstateAgent', 'TravelAgency',
        'EducationalOrganization', 'HomeAndConstructionBusiness', 'AutomotiveBusiness', 'FoodEstablishment',
        'HealthAndBeautyBusiness', 'LodgingBusiness', 'SportsActivityLocation', 'OnlineStore', 'Dentist',
        'Physician', 'Hotel', 'Attorney', 'AccountingService', 'EmploymentAgency', 'InsuranceAgency',
    ];

    /** Signatures d'en-têtes de CDN / hébergement edge. */
    private const CDN_HEADERS = [
        'cf-ray' => 'Cloudflare',
        'x-vercel-id' => 'Vercel',
        'x-nf-request-id' => 'Netlify',
        'x-amz-cf-id' => 'Amazon CloudFront',
        'x-fastly-request-id' => 'Fastly',
        'x-akamai-transformed' => 'Akamai',
        'x-azure-ref' => 'Azure Front Door',
        'x-bunny-cache' => 'Bunny CDN',
        'cdn-pullzone' => 'Bunny CDN',
        'x-sucuri-id' => 'Sucuri',
        'x-github-request-id' => 'GitHub Pages',
        'fly-request-id' => 'Fly.io',
        'x-cdn' => 'CDN',
    ];

    /**
     * @return list<array<string, mixed>>
     */
    public static function build(SiteAnalysis $a): array
    {
        return [
            self::speed($a),
            self::mobile($a),
            self::secure($a),
            self::google($a),
            self::indexable($a),
            self::address($a),
            self::business($a),
            self::pages($a),
            self::reach($a),
            self::hosting($a),
        ];
    }

    private static function group(string $key, string $title, bool $good, string $label, string $text, array $extra = []): array
    {
        return [
            'key' => $key,
            'title' => $title,
            'status' => $good ? 'good' : 'work',
            'label' => $label,
            'text' => $text,
        ] + $extra;
    }

    private static function speed(SiteAnalysis $a): array
    {
        $ms = $a->http['responseTimeMs'] ?? null;
        $kb = (int) ($a->http['sizeKb'] ?? 0);
        $blocking = (int) ($a->assets['blockingJs'] ?? 0);

        $slowServer = is_numeric($ms) && $ms > 800;
        $heavy = $kb > 200;
        $tooManyBlocking = $blocking > 2;
        $good = ! $slowServer && ! $heavy && ! $tooManyBlocking;

        $label = is_numeric($ms)
            ? ($ms < 100 ? 'Réponse immédiate' : 'Réponse en ' . self::seconds((int) $ms))
            : ($good ? 'Page légère' : 'Page lourde');

        if ($good) {
            $text = 'Le serveur répond vite et la page reste légère : vos visiteurs n\'attendent pas.';
        } elseif ($slowServer) {
            $text = 'Le serveur met du temps à répondre : chaque seconde d\'attente fait partir des visiteurs.';
        } elseif ($heavy) {
            $text = "La page pèse {$kb} Ko de code avant même les images : elle s'affiche lentement sur mobile.";
        } else {
            $text = "{$blocking} scripts bloquent l'affichage : le contenu apparaît en retard.";
        }

        return self::group('speed', 'Chargement rapide', $good, $label, $text, ['source' => 'static']);
    }

    private static function mobile(SiteAnalysis $a): array
    {
        $viewport = strtolower((string) ($a->meta['viewport'] ?? ''));
        $good = $viewport !== '' && str_contains($viewport, 'width=device-width');

        return $good
            ? self::group('mobile', 'Adapté aux mobiles', true, 'Écran mobile OK', 'Vos pages s\'adaptent à la taille de l\'écran : elles se lisent bien sur téléphone.')
            : self::group('mobile', 'Adapté aux mobiles', false, 'À adapter', 'Vos pages ne s\'adaptent pas à l\'écran d\'un téléphone, alors que la plupart de vos visiteurs y sont.');
    }

    private static function secure(SiteAnalysis $a): array
    {
        $https = (bool) ($a->http['isHttps'] ?? false);
        $mixed = 0;
        if ($https) {
            foreach ($a->images as $img) {
                if (str_starts_with(strtolower((string) ($img['src'] ?? '')), 'http://')) {
                    $mixed++;
                }
            }
        }

        if (! $https) {
            return self::group('secure', 'Connexion sécurisée', false, 'Non sécurisé', 'Votre site n\'utilise pas HTTPS : les navigateurs affichent « Non sécurisé » à vos visiteurs.');
        }
        if ($mixed > 0) {
            return self::group('secure', 'Connexion sécurisée', false, 'Contenu non chiffré', "{$mixed} fichier(s) de la page se chargent sans chiffrement : le navigateur peut avertir vos visiteurs.");
        }

        return self::group('secure', 'Connexion sécurisée', true, 'HTTPS actif', 'La connexion est chiffrée : le cadenas s\'affiche et vos visiteurs sont rassurés.');
    }

    private static function google(SiteAnalysis $a): array
    {
        $title = (int) ($a->meta['titleLength'] ?? 0);
        $desc = (int) ($a->meta['descriptionLength'] ?? 0);

        if ($title === 0) {
            return self::group('google', 'Bien présenté sur Google', false, 'Titre absent', 'La page n\'a pas de titre : Google en invente un, souvent peu engageant.');
        }
        if ($desc === 0) {
            return self::group('google', 'Bien présenté sur Google', false, 'Description absente', 'Aucune description : Google choisit lui-même le texte affiché sous votre lien.');
        }
        if ($title > 65 || $desc > 170) {
            return self::group('google', 'Bien présenté sur Google', false, 'Texte coupé', 'Le titre ou la description est trop long : Google le coupe dans ses résultats.');
        }

        return self::group('google', 'Bien présenté sur Google', true, 'Titres en place', 'La page a un titre et une description clairs : elle s\'affiche proprement dans Google.');
    }

    private static function indexable(SiteAnalysis $a): array
    {
        $noindex = (bool) ($a->meta['isNoindex'] ?? false)
            || str_contains(strtolower((string) ($a->http['xRobotsTag'] ?? '')), 'noindex');
        $blocked = (bool) ($a->crawlability['robots']['blocksEverything'] ?? false);

        if ($noindex || $blocked) {
            return self::group('indexable', 'Google peut lire votre site', false, 'Caché à Google', $blocked
                ? 'Votre robots.txt interdit l\'accès à tout le site : Google ne peut pas l\'explorer.'
                : 'La page demande à Google de ne pas l\'indexer : elle n\'apparaîtra pas dans les résultats.');
        }

        return self::group('indexable', 'Google peut lire votre site', true, 'Ouvert à la recherche', 'Rien ne cache votre site à Google ni aux moteurs de recherche IA.');
    }

    private static function address(SiteAnalysis $a): array
    {
        $count = (int) ($a->meta['canonicalCount'] ?? 0);
        $canonical = (string) ($a->meta['canonical'] ?? '');
        $host = strtolower((string) parse_url($a->finalUrl !== '' ? $a->finalUrl : $a->url, PHP_URL_HOST));
        $canonHost = strtolower((string) parse_url($canonical, PHP_URL_HOST));

        $good = $count === 1 && ($canonHost === '' || $canonHost === $host);

        if ($good) {
            return self::group('address', 'Une seule adresse web', true, 'Adresse unique', 'La page indique à Google son adresse officielle : votre classement n\'est pas dispersé.');
        }
        if ($count > 1) {
            return self::group('address', 'Une seule adresse web', false, 'Adresses en conflit', "La page déclare {$count} adresses officielles différentes : Google risque de toutes les ignorer.");
        }
        if ($count === 1) {
            return self::group('address', 'Une seule adresse web', false, 'Autre domaine', 'L\'adresse officielle déclarée pointe vers un autre domaine : votre classement part ailleurs.');
        }

        return self::group('address', 'Une seule adresse web', false, 'Classement dispersé', 'Aucune adresse officielle déclarée : votre site peut répondre sur plusieurs adresses et diviser son classement Google.');
    }

    private static function business(SiteAnalysis $a): array
    {
        $types = (array) ($a->structuredData['types'] ?? []);
        $found = array_values(array_filter($types, fn ($t) => in_array($t, self::BUSINESS_TYPES, true) || str_ends_with((string) $t, 'Business')));

        return $found !== []
            ? self::group('business', 'Infos entreprise pour Google', true, 'Fiche lisible', 'Google lit clairement le nom de votre entreprise et ses informations (' . implode(', ', array_slice($found, 0, 2)) . ').')
            : self::group('business', 'Infos entreprise pour Google', false, 'Incomplet', 'Google ne peut pas lire proprement le nom, le logo et les coordonnées de votre entreprise.');
    }

    private static function pages(SiteAnalysis $a): array
    {
        $patterns = [
            'À propos' => '#(a-propos|apropos|about|qui-sommes|qui-nous-sommes|notre-histoire|equipe|team|agence|entreprise|societe)#',
            'Contact' => '#(contact|nous-joindre|joindre)#',
            'Offre ou tarifs' => '#(services?|tarif|prix|pricing|offre|produit|product|boutique|shop|store|catalogue|menu|formation|cours|solutions?)#',
            'Confidentialité' => '#(confidentialit|privacy|mentions|legal|cgu|cgv|rgpd|gdpr|politique|conditions|terms)#',
        ];

        $found = [];
        foreach ($a->links as $link) {
            if (! ($link['internal'] ?? false)) {
                continue;
            }
            $hay = strtolower(self::ascii(((string) parse_url((string) ($link['absolute'] ?? $link['href'] ?? ''), PHP_URL_PATH)) . ' ' . ($link['text'] ?? '')));
            foreach ($patterns as $name => $re) {
                if (! isset($found[$name]) && preg_match($re, $hay)) {
                    $found[$name] = true;
                }
            }
        }

        $have = 1 + count($found); // + accueil
        $missing = array_values(array_diff(array_keys($patterns), array_keys($found)));

        return $missing === []
            ? self::group('pages', 'Les pages clés', true, '5 pages clés', 'Accueil, À propos, Contact, offre ou tarifs et Confidentialité : tout est en place pour vos visiteurs.')
            : self::group('pages', 'Les pages clés', false, "{$have} sur 5", 'Introuvable depuis cette page : ' . self::lower(implode(', ', $missing)) . '. Vos visiteurs les cherchent avant de vous contacter.');
    }

    private static function reach(SiteAnalysis $a): array
    {
        $contact = false;
        $social = false;
        $legal = false;

        foreach ($a->links as $link) {
            $href = strtolower((string) ($link['href'] ?? ''));
            $text = strtolower(self::ascii((string) ($link['text'] ?? '')));
            if (preg_match('#^(tel|mailto):|wa\.me|whatsapp\.com|m\.me/#', $href)) {
                $contact = true;
            }
            if (preg_match('#(facebook\.com|instagram\.com|linkedin\.com|twitter\.com|//x\.com|tiktok\.com|youtube\.com|pinterest\.)#', $href)) {
                $social = true;
            }
            if (preg_match('#(mentions|legal|confidentialit|privacy|cgu|cgv|conditions|terms|rgpd)#', $href . ' ' . $text)) {
                $legal = true;
            }
        }

        $missing = [];
        if (! $contact) {
            $missing[] = 'téléphone ou e-mail cliquable';
        }
        if (! $social) {
            $missing[] = 'réseaux sociaux';
        }
        if (! $legal) {
            $missing[] = 'mentions légales';
        }

        if ($missing === []) {
            return self::group('reach', 'Facile à vous joindre', true, 'Joignable', 'Téléphone ou e-mail, réseaux sociaux et mentions légales : vos visiteurs trouvent comment vous joindre.');
        }

        return self::group('reach', 'Facile à vous joindre', false, $contact ? 'Incomplet' : 'Difficile à joindre', 'Il manque : ' . implode(', ', $missing) . '. Les visiteurs les cherchent avant de vous faire confiance.');
    }

    private static function hosting(SiteAnalysis $a): array
    {
        $headers = (array) ($a->http['headers'] ?? []);
        $server = strtolower((string) ($a->http['server'] ?? ''));
        $cdn = null;

        foreach (self::CDN_HEADERS as $header => $name) {
            if (array_key_exists($header, $headers)) {
                $cdn = $name;
                break;
            }
        }
        if ($cdn === null) {
            foreach (['cloudflare' => 'Cloudflare', 'vercel' => 'Vercel', 'netlify' => 'Netlify', 'cloudfront' => 'Amazon CloudFront', 'akamai' => 'Akamai', 'bunnycdn' => 'Bunny CDN', 'fastly' => 'Fastly'] as $needle => $name) {
                if (str_contains($server, $needle)) {
                    $cdn = $name;
                    break;
                }
            }
        }
        if ($cdn === null && preg_match('#(hit|miss).*from|cloudfront|varnish#i', (string) ($headers['x-cache'] ?? '') . ' ' . (string) ($headers['via'] ?? ''))) {
            $cdn = 'CDN';
        }

        return $cdn !== null
            ? self::group('hosting', 'Hébergement moderne', true, $cdn, 'Votre site passe par un réseau de diffusion rapide (' . $cdn . ') : il se charge vite partout.')
            : self::group('hosting', 'Hébergement moderne', false, 'Hébergement classique', 'Votre site n\'utilise pas de réseau de diffusion rapide (CDN) : il est plus lent loin du serveur.');
    }

    private static function seconds(int $ms): string
    {
        return str_replace('.', ',', (string) round($ms / 1000, 1)) . ' s';
    }

    private static function ascii(string $s): string
    {
        $t = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);

        return $t === false ? $s : $t;
    }

    private static function lower(string $s): string
    {
        return mb_strtolower($s, 'UTF-8');
    }
}
