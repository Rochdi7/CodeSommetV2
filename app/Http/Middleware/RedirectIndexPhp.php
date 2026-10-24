<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Normalise les URL du front controller : /index.php, /index.php/, /index.php/about,
 * /index.php?utm_source=x… répondaient 200 (doublons d'URL, canonical déjà propre).
 * Elles sont redirigées en une seule étape (301) vers le chemin propre, chaîne de
 * requête conservée telle quelle.
 *
 * - GET/HEAD uniquement : un POST n'est jamais redirigé (pas de perte de corps).
 * - Seul le préfixe littéral « /index.php » est retiré ; le reste du chemin et la
 *   query string sont recopiés octet pour octet (pas de ré-encodage).
 * - Les « / » de tête sont fusionnés : /index.php//evil.com devient /evil.com
 *   (chemin local), jamais //evil.com (redirection ouverte).
 * - Les URL réécrites par le serveur (/about → index.php) gardent leur REQUEST_URI
 *   d'origine et ne sont donc pas concernées.
 */
class RedirectIndexPhp
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        $uri = (string) $request->server('REQUEST_URI', '');
        [$path] = explode('?', $uri, 2);

        if (! preg_match('#^/index\.php(?=/|$)#i', $path)) {
            return $next($request);
        }

        $rest = substr($path, strlen('/index.php'));
        // Pas de « / » final : le site n'en utilise jamais (.htaccess les retire),
        // on évite ainsi une seconde redirection.
        $target = '/' . trim($rest, '/');

        $query = (string) $request->server('QUERY_STRING', '');
        if ($query !== '') {
            $target .= '?' . $query;
        }

        // Racine = schéma + hôte, SANS le chemin de base : pour une requête /index.php…
        // la racine Laravel inclut « /index.php » (la redirection bouclerait).
        // formatScheme() applique URL::forceScheme('https') en production : une seule étape.
        $root = app('url')->formatScheme() . $request->getHttpHost();

        return redirect()->to($root . $target, 301);
    }
}
