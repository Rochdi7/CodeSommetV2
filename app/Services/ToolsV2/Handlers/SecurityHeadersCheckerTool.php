<?php

namespace App\Services\ToolsV2\Handlers;

use App\Services\SafeHttpFetcher;
use App\Services\ToolsV2\Input;
use App\Services\ToolsV2\InvalidInputException;
use App\Services\ToolsV2\ToolHandler;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;

/**
 * Vérificateur d'en-têtes de sécurité HTTP : une requête, une note A–F.
 *
 * Les points et les conseils suivent les recommandations OWASP (Secure
 * Headers Project) et MDN ; aucun service tiers n'est appelé.
 */
class SecurityHeadersCheckerTool implements ToolHandler
{
    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    public function handle(Request $request): array
    {
        $url = Input::url($request);

        $started = microtime(true);
        $response = $this->fetcher->get($url, 12, ['Accept' => 'text/html,*/*;q=0.5']);
        $timeMs = (int) round((microtime(true) - $started) * 1000);
        $status = $response->status();
        if ($status >= 500 || $status === 0) {
            throw new InvalidInputException("La page a répondu avec le code HTTP {$status}.");
        }

        $headers = $this->flatten($response);
        $https = str_starts_with(strtolower($url), 'https://');
        $checks = [];
        $score = 0;
        $max = 0;

        $add = function (string $id, string $status, int $weight, string $title, string $detail = '', string $fix = '', string $code = '') use (&$checks, &$score, &$max) {
            $max += $weight;
            if ($status === 'pass') {
                $score += $weight;
            } elseif ($status === 'warn') {
                $score += (int) round($weight / 2);
            }
            $checks[] = compact('id', 'status', 'weight', 'title', 'detail', 'fix', 'code');
        };

        // HSTS
        $hsts = $headers['strict-transport-security'] ?? null;
        if (! $https) {
            $add('hsts', 'fail', 15, 'Page servie en HTTP', 'Sans HTTPS, aucun en-tête de sécurité ne protège les visiteurs.', 'Activez HTTPS et redirigez tout le trafic HTTP (301).');
        } elseif ($hsts === null) {
            $add('hsts', 'fail', 15, 'Strict-Transport-Security absent', 'Les navigateurs peuvent encore tenter une connexion HTTP à ce domaine.', 'Ajoutez HSTS avec une durée d\'au moins un an.', 'Strict-Transport-Security: max-age=31536000; includeSubDomains');
        } else {
            preg_match('/max-age=(\d+)/i', $hsts, $m);
            $age = (int) ($m[1] ?? 0);
            if ($age < 31536000) {
                $add('hsts', 'warn', 15, 'HSTS présent mais max-age court (' . $age . ' s)', 'Une durée inférieure à un an est jugée insuffisante par Google et par le preload HSTS.', 'Portez max-age à 31536000 (un an) ou plus.', 'Strict-Transport-Security: max-age=31536000; includeSubDomains');
            } else {
                $add('hsts', 'pass', 15, 'HSTS actif (' . $hsts . ')', stripos($hsts, 'includesubdomains') === false ? 'Pensez à includeSubDomains si tous vos sous-domaines sont en HTTPS.' : '');
            }
        }

        // CSP
        $csp = $headers['content-security-policy'] ?? null;
        $cspRo = $headers['content-security-policy-report-only'] ?? null;
        if ($csp === null && $cspRo === null) {
            $add('csp', 'fail', 20, 'Content-Security-Policy absent', 'Sans CSP, un script injecté (XSS) s\'exécute sans entrave.', 'Déployez d\'abord une politique en mode Report-Only, puis durcissez-la.', "Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'none'; base-uri 'self'; frame-ancestors 'self'");
        } elseif ($csp === null) {
            $add('csp', 'warn', 20, 'CSP en mode Report-Only uniquement', 'La politique est observée mais rien n\'est bloqué.', 'Passez en Content-Security-Policy une fois les rapports propres.');
        } else {
            $weak = [];
            if (preg_match('/unsafe-inline/i', $csp) && ! preg_match('/nonce-|sha256-/i', $csp)) {
                $weak[] = "'unsafe-inline' sans nonce ni hash";
            }
            if (preg_match('/unsafe-eval/i', $csp)) {
                $weak[] = "'unsafe-eval'";
            }
            if (preg_match('/(default-src|script-src)[^;]*\*(?![^;]*\.)/i', $csp)) {
                $weak[] = 'source « * » dans script-src ou default-src';
            }
            if (! preg_match('/object-src/i', $csp) && ! preg_match('/default-src\s+[\'"]?none/i', $csp)) {
                $weak[] = 'object-src non restreint';
            }
            $weak === []
                ? $add('csp', 'pass', 20, 'Content-Security-Policy stricte', mb_substr($csp, 0, 160))
                : $add('csp', 'warn', 20, 'CSP présente mais permissive', 'Points faibles : ' . implode(', ', $weak) . '.', 'Remplacez unsafe-inline par des nonces, supprimez unsafe-eval et ajoutez object-src \'none\'.');
        }

        // X-Content-Type-Options
        $xcto = $headers['x-content-type-options'] ?? null;
        $xcto !== null && strtolower(trim($xcto)) === 'nosniff'
            ? $add('xcto', 'pass', 10, 'X-Content-Type-Options: nosniff')
            : $add('xcto', 'fail', 10, 'X-Content-Type-Options absent', 'Le navigateur peut « deviner » un type MIME et exécuter un fichier comme script.', 'Ajoutez l\'en-tête.', 'X-Content-Type-Options: nosniff');

        // Clickjacking
        $xfo = $headers['x-frame-options'] ?? null;
        $frameAncestors = $csp !== null && preg_match('/frame-ancestors/i', $csp);
        if ($frameAncestors) {
            $add('frame', 'pass', 10, 'Protection contre le clickjacking (CSP frame-ancestors)', $xfo === null ? '' : 'X-Frame-Options est redondant mais utile pour les anciens navigateurs.');
        } elseif ($xfo !== null && preg_match('/^(deny|sameorigin)$/i', trim($xfo))) {
            $add('frame', 'pass', 10, 'X-Frame-Options: ' . strtoupper(trim($xfo)), 'Préférez à terme CSP frame-ancestors, plus souple.');
        } elseif ($xfo !== null) {
            $add('frame', 'warn', 10, 'X-Frame-Options avec une valeur obsolète (' . $xfo . ')', 'ALLOW-FROM n\'est plus supporté.', 'Utilisez CSP frame-ancestors.', "Content-Security-Policy: frame-ancestors 'self'");
        } else {
            $add('frame', 'fail', 10, 'Aucune protection contre le clickjacking', 'La page peut être intégrée dans une iframe sur n\'importe quel site.', 'Ajoutez frame-ancestors à votre CSP (ou X-Frame-Options).', 'X-Frame-Options: SAMEORIGIN');
        }

        // Referrer-Policy
        $rp = $headers['referrer-policy'] ?? null;
        if ($rp === null) {
            $add('referrer', 'fail', 8, 'Referrer-Policy absent', 'Les URL complètes (paramètres compris) sont transmises aux sites tiers.', 'Ajoutez une politique.', 'Referrer-Policy: strict-origin-when-cross-origin');
        } elseif (preg_match('/unsafe-url|^\s*origin-when-cross-origin\s*$|no-referrer-when-downgrade/i', $rp)) {
            $add('referrer', 'warn', 8, 'Referrer-Policy permissive (' . $rp . ')', 'Le chemin complet fuit vers les sites tiers.', 'Préférez strict-origin-when-cross-origin.');
        } else {
            $add('referrer', 'pass', 8, 'Referrer-Policy: ' . $rp);
        }

        // Permissions-Policy
        $pp = $headers['permissions-policy'] ?? null;
        $pp !== null
            ? $add('permissions', 'pass', 7, 'Permissions-Policy présent', mb_substr($pp, 0, 160))
            : $add('permissions', 'warn', 7, 'Permissions-Policy absent', 'Caméra, micro, géolocalisation… restent accessibles aux scripts tiers.', 'Désactivez ce que la page n\'utilise pas.', 'Permissions-Policy: camera=(), microphone=(), geolocation=()');

        // Cross-origin isolation
        $coop = $headers['cross-origin-opener-policy'] ?? null;
        $corp = $headers['cross-origin-resource-policy'] ?? null;
        $coop !== null || $corp !== null
            ? $add('cross-origin', 'pass', 5, 'En-têtes Cross-Origin présents', trim(($coop ? 'COOP: ' . $coop . ' ' : '') . ($corp ? 'CORP: ' . $corp : '')))
            : $add('cross-origin', 'info', 5, 'Cross-Origin-Opener-Policy / Resource-Policy absents', 'Recommandés pour isoler la page des fenêtres et ressources tierces.', '', 'Cross-Origin-Opener-Policy: same-origin');

        // Cookies
        $cookies = $this->setCookies($response);
        if ($cookies !== []) {
            $bad = [];
            foreach ($cookies as $c) {
                $flags = [];
                if (! preg_match('/;\s*secure/i', $c)) {
                    $flags[] = 'Secure';
                }
                if (! preg_match('/;\s*httponly/i', $c)) {
                    $flags[] = 'HttpOnly';
                }
                if (! preg_match('/;\s*samesite=/i', $c)) {
                    $flags[] = 'SameSite';
                }
                if ($flags !== []) {
                    $bad[] = explode('=', $c, 2)[0] . ' (' . implode(', ', $flags) . ' manquant)';
                }
            }
            $bad === []
                ? $add('cookies', 'pass', 10, count($cookies) . ' cookie(s) avec Secure, HttpOnly et SameSite')
                : $add('cookies', 'warn', 10, 'Cookies sans attributs de sécurité', implode(' · ', array_slice($bad, 0, 6)), 'Ajoutez Secure, HttpOnly (sauf accès JS requis) et SameSite=Lax ou Strict.');
        } else {
            $add('cookies', 'pass', 10, 'Aucun cookie déposé par cette réponse');
        }

        // Fuites de version
        $leaks = [];
        foreach (['server', 'x-powered-by', 'x-aspnet-version', 'x-generator'] as $h) {
            if (isset($headers[$h]) && preg_match('/\d/', $headers[$h])) {
                $leaks[] = $h . ': ' . $headers[$h];
            }
        }
        $leaks === []
            ? $add('leaks', 'pass', 5, 'Pas de version logicielle exposée dans les en-têtes')
            : $add('leaks', 'warn', 5, 'Version logicielle exposée', implode(' · ', $leaks), 'Masquez ces en-têtes (server_tokens off, expose_php = Off, Header unset X-Powered-By).');

        // Cache des contenus sensibles — simple information
        if (isset($headers['cache-control']) && preg_match('/no-store/i', $headers['cache-control'])) {
            $add('cache', 'info', 0, 'Cache-Control: no-store', 'Attention aux performances si cette page est publique.');
        }

        $percent = $max === 0 ? 0 : (int) round($score / $max * 100);

        return [
            'url' => $url,
            'status' => $status,
            'timeMs' => $timeMs,
            'score' => $percent,
            'grade' => $this->grade($percent),
            'checks' => $checks,
            'headers' => $headers,
            'cookies' => count($cookies),
        ];
    }

    /** @return array<string, string> en-têtes en minuscules, valeurs jointes */
    private function flatten(Response $response): array
    {
        $out = [];
        foreach ($response->headers() as $name => $values) {
            $out[strtolower($name)] = mb_substr(implode(', ', (array) $values), 0, 2000);
        }

        return $out;
    }

    /** @return list<string> */
    private function setCookies(Response $response): array
    {
        $values = $response->headers()['Set-Cookie'] ?? $response->headers()['set-cookie'] ?? [];

        return array_values(array_filter((array) $values, 'is_string'));
    }

    private function grade(int $score): string
    {
        return match (true) {
            $score >= 90 => 'A',
            $score >= 75 => 'B',
            $score >= 60 => 'C',
            $score >= 40 => 'D',
            default => 'F',
        };
    }
}
