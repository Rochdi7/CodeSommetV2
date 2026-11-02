<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\GoogleConnect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * "Se connecter avec Google" on admin → Intégrations & tags (GA4, GTM,
 * Search Console). See App\Support\GoogleConnect.
 */
class GoogleConnectController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        if (! GoogleConnect::configured()) {
            return $this->back('error', 'Ajoutez GOOGLE_OAUTH_CLIENT_ID et GOOGLE_OAUTH_CLIENT_SECRET dans le .env du serveur (voir l\'encadré « Configurer la connexion Google »).');
        }

        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        return redirect()->away(GoogleConnect::authUrl($state));
    }

    public function callback(Request $request): RedirectResponse
    {
        $expected = $request->session()->pull('google_oauth_state');

        if ($request->filled('error')) {
            return $this->back('error', $request->input('error') === 'access_denied'
                ? 'Connexion Google annulée.'
                : 'Google a refusé la connexion ('.Str::limit((string) $request->input('error'), 60).').');
        }
        if (! $expected || ! hash_equals($expected, (string) $request->input('state')) || ! $request->filled('code')) {
            return $this->back('error', 'Lien de connexion Google expiré — recommencez.');
        }

        try {
            $email = GoogleConnect::connect((string) $request->input('code'));
        } catch (\RuntimeException $e) {
            return $this->back('error', $e->getMessage());
        }

        GoogleConnect::discover(fresh: true);

        return $this->back('success', 'Compte Google connecté'.($email ? " ({$email})" : '').'. Choisissez vos identifiants ci-dessous puis enregistrez.');
    }

    public function refresh(): RedirectResponse
    {
        GoogleConnect::discover(fresh: true);

        return $this->back('success', 'Liste Google actualisée.');
    }

    public function verifySearchConsole(Request $request): RedirectResponse
    {
        $siteHost = parse_url(GoogleConnect::siteUrl(), PHP_URL_HOST);
        if (strcasecmp((string) $siteHost, $request->getHost()) !== 0 && strcasecmp('www.'.$siteHost, $request->getHost()) !== 0) {
            return $this->back('error', "La validation doit être lancée depuis l'admin de production ({$siteHost}) : Google lit la balise sur le site public.");
        }

        try {
            $steps = GoogleConnect::verifySearchConsole();
        } catch (\RuntimeException $e) {
            return $this->back('error', $e->getMessage());
        }

        return $this->back('success', 'Search Console : '.implode(' · ', $steps).'.');
    }

    public function disconnect(): RedirectResponse
    {
        GoogleConnect::disconnect();

        return $this->back('success', 'Compte Google déconnecté. Les identifiants déjà enregistrés restent actifs.');
    }

    private function back(string $type, string $message): RedirectResponse
    {
        return redirect()->route('admin.integrations.index')->with($type, $message);
    }
}
