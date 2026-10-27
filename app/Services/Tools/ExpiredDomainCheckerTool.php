<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\Seo\DomainRegistryClient;
use Illuminate\Validation\ValidationException;

/**
 * Expired Domain Checker — registration status, registrar, creation and
 * expiry dates from the official registries (RDAP) plus DNS resolution, for
 * up to 25 domains. "Available" is only claimed when the registry has no
 * record AND the name does not resolve; anything ambiguous is "unknown".
 */
class ExpiredDomainCheckerTool implements AnalysisTool
{
    public const MAX_DOMAINS = 25;

    public function __construct(private DomainRegistryClient $registry)
    {
    }

    public function slug(): string
    {
        return 'expired-domain-checker';
    }

    public function mode(): string
    {
        return AnalysisRun::MODE_SYNC;
    }

    public function allowsInlineFallback(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['domains' => ['required', 'string', 'max:10000']];
    }

    public function normalizeInput(array $validated): array
    {
        $domains = [];
        $invalid = [];
        foreach (preg_split('/[\s,;]+/', (string) $validated['domains'], -1, PREG_SPLIT_NO_EMPTY) as $token) {
            $host = strtolower(trim($token));
            if (preg_match('#^[a-z][a-z0-9+.-]*://#', $host)) {
                $host = (string) parse_url($host, PHP_URL_HOST);
            }
            $host = rtrim(preg_replace('~[/?#].*$~', '', $host), '.');
            $host = preg_replace('/^www\./', '', $host);
            if (function_exists('idn_to_ascii') && preg_match('/[^\x20-\x7e]/', $host)) {
                $host = (string) idn_to_ascii($host, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
            }
            if (preg_match('/^(?=.{4,253}$)([a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z][a-z0-9-]{1,62}$/', $host)) {
                $domains[$host] = true;
            } else {
                $invalid[] = mb_substr($token, 0, 80);
            }
        }

        if ($domains === []) {
            throw ValidationException::withMessages(['domains' => 'Aucun nom de domaine valide.']);
        }
        if (count($domains) > self::MAX_DOMAINS) {
            throw ValidationException::withMessages(['domains' => 'Maximum ' . self::MAX_DOMAINS . ' domaines par analyse.']);
        }

        return ['domains' => array_keys($domains), 'invalid' => array_slice($invalid, 0, 50)];
    }

    public function run(array $input, callable $progress): array
    {
        $started = microtime(true);
        $rows = [];
        foreach ($input['domains'] as $i => $domain) {
            if (microtime(true) - $started > 22) {
                $rows[] = ['domain' => $domain, 'status' => 'unknown', 'reason' => 'Non vérifié : budget de temps atteint.'];

                continue;
            }
            $progress((int) floor($i / count($input['domains']) * 100), $domain);

            $rdap = $this->registry->rdap($domain);
            $dns = $this->registry->resolves($domain);

            $status = match (true) {
                $rdap['found'] === true => 'registered',
                $rdap['found'] === false && ! $dns => 'available',
                default => 'unknown',
            };
            $reason = match (true) {
                $status === 'available' => 'Aucun enregistrement au registre et aucune résolution DNS.',
                $rdap['found'] === false && $dns => 'Le registre ne connaît pas ce nom mais il résout en DNS : à vérifier.',
                $rdap['error'] !== null => $rdap['error'],
                default => null,
            };

            $daysLeft = $rdap['expires'] ? (int) now()->startOfDay()->diffInDays(\Illuminate\Support\Carbon::parse($rdap['expires']), false) : null;

            $rows[] = [
                'domain' => $domain,
                'status' => $status,
                'dns' => $dns,
                'registrar' => $rdap['registrar'],
                'created' => $rdap['created'],
                'expires' => $rdap['expires'],
                'daysUntilExpiry' => $daysLeft,
                'ageYears' => $rdap['created'] ? (int) \Illuminate\Support\Carbon::parse($rdap['created'])->diffInYears(now()) : null,
                'registryStatuses' => $rdap['statuses'],
                'reason' => $reason,
            ];
        }

        $count = fn (string $s) => count(array_filter($rows, fn ($r) => $r['status'] === $s));

        return [
            'rows' => $rows,
            'summary' => [
                'total' => count($rows),
                'available' => $count('available'),
                'registered' => $count('registered'),
                'unknown' => $count('unknown'),
                'expiringWithin30Days' => count(array_filter($rows, fn ($r) => isset($r['daysUntilExpiry']) && $r['daysUntilExpiry'] !== null && $r['daysUntilExpiry'] >= 0 && $r['daysUntilExpiry'] <= 30)),
            ],
            'invalid' => $input['invalid'],
            'source' => 'Registres officiels (RDAP via IANA) + DNS',
            'analyzedAt' => now()->toIso8601String(),
        ];
    }
}
