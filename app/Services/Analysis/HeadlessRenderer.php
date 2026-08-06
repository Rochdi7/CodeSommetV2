<?php

namespace App\Services\Analysis;

use App\Services\SafeUrlValidator;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

/**
 * Couche 4 — Rendu navigateur (Chromium via Playwright).
 *
 * Une application React/Vue/Angular renvoie un HTML serveur quasi vide : sans
 * exécution du JavaScript, nos analyseurs ne voient ni titres, ni contenu, ni
 * images, et notent la page bien en dessous de ce que Google indexe réellement.
 *
 * Le rendu étant coûteux (~2-6 s et un processus Chromium), il n'est déclenché
 * que lorsque le HTML serveur paraît insuffisant — jamais systématiquement.
 *
 * SÉCURITÉ — l'URL est validée (SSRF, DNS, plages privées) avant tout
 * lancement. Le navigateur ne reçoit qu'une URL déjà autorisée, les
 * téléchargements sont refusés et le processus est tué au-delà du délai.
 */
class HeadlessRenderer
{
    /** Délai global du processus Node, marge comprise. */
    public const PROCESS_TIMEOUT = 60;

    public const RENDER_TIMEOUT_MS = 25000;

    /** @var array{available: bool, reason: string, checks: array<string, bool>}|null */
    private ?array $availabilityCache = null;

    public function __construct(private SafeUrlValidator $validator)
    {
    }

    /**
     * Le rendu est-il possible dans cet environnement ?
     *
     * Conçu pour un hébergement mutualisé, où la réponse est presque toujours
     * « non » : Chromium pèse ~2,8 Go (au-delà du quota disque habituel), Node
     * n'est pas installé, et `proc_open` est très souvent désactivé par
     * `disable_functions`. Chaque condition est donc vérifiée séparément, de
     * façon à ne jamais provoquer d'erreur fatale : l'application reste
     * pleinement fonctionnelle sans rendu, en signalant simplement la limite.
     *
     * Le résultat est mémoïsé par requête — inutile de refaire ces tests à
     * chaque page analysée.
     */
    public function isAvailable(): bool
    {
        return $this->availability()['available'];
    }

    /**
     * Diagnostic détaillé : indique *pourquoi* le rendu est indisponible, afin
     * que l'exploitant sache quoi corriger plutôt que de constater une absence
     * silencieuse.
     *
     * @return array{available: bool, reason: string, checks: array<string, bool>}
     */
    public function availability(): array
    {
        if ($this->availabilityCache !== null) {
            return $this->availabilityCache;
        }

        $checks = [];

        // 1. Le rendu peut être coupé explicitement par configuration.
        $checks['enabled'] = (bool) config('services.headless.enabled', true);

        // 2. Symfony Process requiert proc_open, que les hébergements mutualisés
        //    désactivent fréquemment. Sans lui, instancier Process lèverait une
        //    LogicException — d'où la vérification préalable.
        $checks['proc_open'] = function_exists('proc_open');
        $disabled = array_map('trim', explode(',', (string) ini_get('disable_functions')));
        $checks['proc_open_not_disabled'] = ! in_array('proc_open', $disabled, true);

        // 3. Le script de rendu doit être déployé.
        $checks['script'] = is_file(base_path('resources/js/render-page.cjs'));

        // 4. node_modules/playwright est souvent exclu du déploiement.
        $checks['playwright'] = is_dir(base_path('node_modules/playwright'));

        // 5. Un binaire Chromium doit être présent. C'est le point de blocage
        //    principal en mutualisé : ~2,8 Go.
        $checks['browser'] = $this->browserBinaryExists();

        $available = ! in_array(false, $checks, true);

        $reason = match (true) {
            ! $checks['enabled'] => 'Le rendu navigateur est désactivé par configuration (HEADLESS_RENDERING=false).',
            ! $checks['proc_open'] || ! $checks['proc_open_not_disabled'] => 'La fonction PHP proc_open est désactivée sur cet hébergement : aucun processus externe ne peut être lancé. Configuration courante en mutualisé.',
            ! $checks['script'] => 'Le script de rendu resources/js/render-page.cjs est absent du déploiement.',
            ! $checks['playwright'] => 'Playwright n\'est pas installé (node_modules absent du déploiement).',
            ! $checks['browser'] => 'Aucun binaire Chromium trouvé. Il pèse environ 2,8 Go, ce qui dépasse le quota disque de la plupart des hébergements mutualisés.',
            default => 'Le rendu navigateur est disponible.',
        };

        return $this->availabilityCache = [
            'available' => $available,
            'reason' => $reason,
            'checks' => $checks,
        ];
    }

    /**
     * Cherche un Chromium installé aux emplacements habituels de Playwright.
     */
    private function browserBinaryExists(): bool
    {
        // Emplacement explicite, prioritaire.
        if (($custom = config('services.headless.browser_path')) && is_file($custom)) {
            return true;
        }

        $candidates = [];

        // PLAYWRIGHT_BROWSERS_PATH prime lorsqu'il est défini.
        if ($env = getenv('PLAYWRIGHT_BROWSERS_PATH')) {
            $candidates[] = $env;
        }

        $home = getenv('USERPROFILE') ?: getenv('HOME') ?: '';
        if ($home !== '') {
            $candidates[] = $home . '/AppData/Local/ms-playwright';  // Windows
            $candidates[] = $home . '/.cache/ms-playwright';          // Linux
            $candidates[] = $home . '/Library/Caches/ms-playwright';  // macOS
        }

        foreach ($candidates as $dir) {
            if (! is_dir($dir)) {
                continue;
            }
            // Un dossier chromium-* suffit : la version exacte importe peu.
            $matches = glob(rtrim($dir, '/\\') . '/chromium*', GLOB_ONLYDIR) ?: [];
            if ($matches !== []) {
                return true;
            }
        }

        return false;
    }

    /**
     * Rend une page et renvoie le DOM final avec ses métriques.
     *
     * @return array<string, mixed>|null  null si le rendu est indisponible ou a échoué
     *
     * @throws \App\Services\UnsafeUrlException
     */
    public function render(string $url): ?array
    {
        // Validation SSRF avant de lancer quoi que ce soit.
        $validated = $this->validator->validate($url);

        if (! $this->isAvailable()) {
            return null;
        }

        $payload = json_encode([
            'url' => $validated['url'],
            'timeout' => self::RENDER_TIMEOUT_MS,
        ], JSON_UNESCAPED_SLASHES);

        // Chemin de l'exécutable Node : rarement dans le PATH en mutualisé,
        // d'où la possibilité de le renseigner explicitement.
        $node = (string) config('services.headless.node_path', 'node');

        try {
            $process = new Process(
                [$node, base_path('resources/js/render-page.cjs'), $payload],
                base_path(),
                // Neutralise tout proxy d'environnement, qui contournerait
                // l'IP validée et rouvrirait une voie SSRF.
                ['HTTP_PROXY' => '', 'HTTPS_PROXY' => '', 'NO_PROXY' => '*'],
                null,
                self::PROCESS_TIMEOUT
            );
        } catch (\Throwable $e) {
            // Symfony\Process lève une LogicException si proc_open manque.
            // availability() l'anticipe, mais on ne prend pas le risque d'une
            // erreur fatale en production.
            Log::info('Headless rendering unavailable: ' . $e->getMessage());

            return null;
        }

        try {
            $process->run();
        } catch (ProcessTimedOutException $e) {
            Log::warning("Headless render timed out for {$url}");

            return null;
        } catch (\Throwable $e) {
            Log::warning('Headless render failed to start: ' . $e->getMessage());

            return null;
        }

        $output = trim($process->getOutput());
        if ($output === '') {
            Log::warning('Headless render produced no output: ' . substr($process->getErrorOutput(), 0, 300));

            return null;
        }

        $decoded = json_decode($output, true);
        if (! is_array($decoded) || ($decoded['ok'] ?? false) !== true) {
            Log::info('Headless render unsuccessful: ' . ($decoded['error'] ?? 'unknown'));

            return null;
        }

        return $decoded;
    }
}
