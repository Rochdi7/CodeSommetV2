<?php

namespace App\Services\Seo;

use App\Services\SafeHttpFetcher;
use Illuminate\Support\Facades\Cache;

/**
 * Free, public domain data: RDAP (the registries' official successor to
 * WHOIS, discovered through the IANA bootstrap file) and DNS. No API key.
 *
 * RDAP servers come only from the IANA bootstrap — never from user input —
 * and every request goes through SafeHttpFetcher.
 */
class DomainRegistryClient
{
    public const BOOTSTRAP_URL = 'https://data.iana.org/rdap/dns.json';

    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    /**
     * @return array{found: bool|null, registrar: string|null, created: string|null,
     *               expires: string|null, statuses: list<string>, server: string|null, error: string|null}
     */
    public function rdap(string $domain): array
    {
        $tld = strtolower(substr(strrchr($domain, '.') ?: '', 1));
        $server = $this->bootstrap()[$tld] ?? null;
        $empty = ['found' => null, 'registrar' => null, 'created' => null, 'expires' => null, 'statuses' => [], 'server' => $server, 'error' => null];

        if ($server === null) {
            return ['error' => 'Extension sans service RDAP public.'] + $empty;
        }

        try {
            $response = $this->fetcher->get(rtrim($server, '/') . '/domain/' . rawurlencode($domain), 10, [
                'Accept' => 'application/rdap+json, application/json',
            ]);
        } catch (\Throwable) {
            return ['error' => 'Registre injoignable.'] + $empty;
        }

        if ($response->status() === 404) {
            return ['found' => false] + $empty;
        }
        if ($response->status() === 429) {
            return ['error' => 'Registre saturé (trop de requêtes), réessayez plus tard.'] + $empty;
        }
        if (! $response->successful()) {
            return ['error' => 'Réponse du registre : HTTP ' . $response->status() . '.'] + $empty;
        }

        $data = json_decode($this->fetcher->cappedBody($response), true) ?: [];
        $events = [];
        foreach ($data['events'] ?? [] as $event) {
            if (isset($event['eventAction'], $event['eventDate'])) {
                $events[$event['eventAction']] = substr((string) $event['eventDate'], 0, 10);
            }
        }

        $registrar = null;
        foreach ($data['entities'] ?? [] as $entity) {
            if (in_array('registrar', $entity['roles'] ?? [], true)) {
                foreach ($entity['vcardArray'][1] ?? [] as $field) {
                    if (($field[0] ?? '') === 'fn') {
                        $registrar = (string) ($field[3] ?? '');
                    }
                }
            }
        }

        return [
            'found' => true,
            'registrar' => $registrar ?: null,
            'created' => $events['registration'] ?? null,
            'expires' => $events['expiration'] ?? null,
            'statuses' => array_values(array_map('strval', $data['status'] ?? [])),
            'server' => $server,
            'error' => null,
        ];
    }

    /** True when the domain has NS or A/AAAA records. */
    public function resolves(string $domain): bool
    {
        foreach ([DNS_NS, DNS_A, DNS_AAAA] as $type) {
            $records = @dns_get_record($domain, $type);
            if (is_array($records) && $records !== []) {
                return true;
            }
        }

        return false;
    }

    /**
     * TLD => RDAP base URL, from the IANA bootstrap (cached 24 h).
     *
     * @return array<string, string>
     */
    private function bootstrap(): array
    {
        return Cache::remember('rdap-bootstrap-v1', now()->addDay(), function () {
            try {
                $json = json_decode($this->fetcher->getBody(self::BOOTSTRAP_URL, 10), true);
            } catch (\Throwable) {
                return [];
            }
            $map = [];
            foreach ($json['services'] ?? [] as $service) {
                $url = $service[1][0] ?? null;
                foreach ($service[0] ?? [] as $tld) {
                    if ($url) {
                        $map[strtolower($tld)] = $url;
                    }
                }
            }

            return $map;
        });
    }
}
