<?php

namespace App\Http\Controllers;

use App\Mail\ToolReportMail;
use App\Mail\ToolReportReceived;
use App\Models\AnalyticsSession;
use App\Models\ToolReportRequest;
use App\Services\ToolReports\ToolReportStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

/**
 * POST /tools/report-email — « Recevez ce rapport par e-mail » (pages outils).
 *
 * Le contenu de l'e-mail vient uniquement du résumé mis en cache par
 * RememberToolReport lors de l'analyse (même IP, même outil) : le navigateur
 * ne fournit que l'adresse. Chaque demande est enregistrée comme lead.
 */
class ToolReportController extends Controller
{
    /** Même adresse + même outil + même site : un seul envoi par fenêtre. */
    private const DEDUPE_MINUTES = 10;

    /** Plafond d'envois par adresse destinataire et par jour (anti-bombardement). */
    private const MAX_PER_EMAIL_PER_DAY = 5;

    public function send(Request $request): JsonResponse
    {
        try {
            $v = $request->validate([
                'email' => 'required|email:rfc|max:255',
                'name' => 'nullable|string|max:100',
                'slug' => ['required', 'string', 'regex:/^[a-z0-9-]{2,80}$/'],
                'url' => 'nullable|string|max:2048',
                'website' => 'nullable|size:0', // honeypot
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?? 'Adresse e-mail invalide.',
            ], 422);
        }

        $ip = (string) $request->ip();
        $summary = ToolReportStore::get($ip, $v['slug']);
        if ($summary === null || ! $this->sameSite($summary['url'] ?? null, $v['url'] ?? null)) {
            return response()->json([
                'success' => false,
                'message' => 'Ce rapport a expiré. Relancez l\'analyse, puis demandez-le à nouveau.',
            ], 422);
        }

        if ($summary['score'] === null && ($summary['items'] ?? []) === [] && ($summary['fixes'] ?? []) === []) {
            return response()->json(['success' => false, 'message' => 'Cet outil ne produit pas de rapport à envoyer.'], 422);
        }

        if ($v['slug'] === 'website-analyzer') {
            $summary = $this->withGoogleSpeed($summary, ToolReportStore::get($ip, 'core-web-vitals-checker'));
        }

        $email = mb_strtolower(trim($v['email']));

        $recent = ToolReportRequest::where('email', $email)
            ->where('tool_slug', $v['slug'])
            ->where('target_url', $summary['url'])
            ->where('created_at', '>=', now()->subMinutes(self::DEDUPE_MINUTES))
            ->exists();
        if ($recent) {
            return response()->json(['success' => true, 'message' => 'Rapport déjà envoyé : vérifiez votre boîte de réception (et les indésirables).']);
        }

        $rateKey = 'tool-report-recipient:' . sha1($email);
        if (RateLimiter::tooManyAttempts($rateKey, self::MAX_PER_EMAIL_PER_DAY)) {
            return response()->json(['success' => false, 'message' => 'Trop de rapports envoyés à cette adresse aujourd\'hui. Réessayez demain.'], 429);
        }
        RateLimiter::hit($rateKey, 86400);

        $lead = ToolReportRequest::create([
            'email' => $email,
            'name' => isset($v['name']) ? trim(strip_tags($v['name'])) ?: null : null,
            'tool_slug' => $v['slug'],
            'target_url' => $summary['url'],
            'score' => $summary['score'],
            'report' => $summary,
            'ip_address' => $ip,
            'visitor_id' => AnalyticsSession::isValidId($request->input('cs_vid')) ? $request->input('cs_vid') : null,
            'analytics_session_id' => AnalyticsSession::isValidId($request->input('cs_sid')) ? $request->input('cs_sid') : null,
        ]);

        try {
            AnalyticsSession::attachLead($request->input('cs_sid'), $request->input('cs_vid'), 'tool_report', $lead->id, '/tools/' . $v['slug']);
        } catch (\Throwable $e) {
            Log::warning('Tool report lead #' . $lead->id . ' could not be linked to its analytics session: ' . $e->getMessage());
        }

        try {
            Mail::to($lead->email)->send(new ToolReportMail($lead));
            $lead->forceFill(['emailed_at' => now()])->save();
        } catch (\Throwable $e) {
            Log::error('Tool report lead #' . $lead->id . ' email failed: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'L\'envoi a échoué. Réessayez dans un instant.'], 502);
        }

        try {
            Mail::to(config('mail.from.address'))->send(new ToolReportReceived($lead));
        } catch (\Throwable $e) {
            Log::error('Tool report lead #' . $lead->id . ' admin notification failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'C\'est envoyé ! Le rapport arrive dans votre boîte de réception.']);
    }

    private function sameSite(?string $stored, ?string $given): bool
    {
        if ($given === null || $given === '' || $stored === null) {
            return true;
        }

        return $this->host($stored) === $this->host($given);
    }

    private function host(string $url): string
    {
        if (! preg_match('#^[a-z][a-z0-9+.-]*://#i', $url)) {
            $url = 'https://' . $url;
        }

        return preg_replace('/^www\./', '', strtolower((string) parse_url($url, PHP_URL_HOST)));
    }

    /**
     * Remplace la carte « Chargement rapide » par la mesure Google affichée à
     * l'écran (même visiteur, même site), comme site-report.js.
     *
     * @param  array<string, mixed>  $summary
     * @param  array<string, mixed>|null  $cwv
     * @return array<string, mixed>
     */
    private function withGoogleSpeed(array $summary, ?array $cwv): array
    {
        $ms = $cwv['meta']['lcpMs'] ?? null;
        if (! is_int($ms) || ! $this->sameSite($summary['url'] ?? null, $cwv['url'] ?? null) || empty($cwv['url'])) {
            return $summary;
        }

        $field = (bool) ($cwv['meta']['lcpField'] ?? false);
        $verdict = $cwv['meta']['lcpVerdict'] ?? null;
        $good = $verdict ? $verdict === 'good' : $ms <= 2500;
        $s = str_replace('.', ',', (string) round($ms / 1000, 1)) . ' s';
        $where = $field ? 'chez vos vrais visiteurs' : 'lors du test mobile de Google';

        foreach ($summary['items'] as $i => $item) {
            if (($item['title'] ?? '') === 'Chargement rapide') {
                $summary['items'][$i] = [
                    'status' => $good ? 'good' : 'work',
                    'title' => 'Chargement rapide',
                    'label' => ($field ? 'Visiteurs réels : ' : 'Test Google : ') . $s,
                    'detail' => $good
                        ? "Google mesure l'arrivée du contenu principal en {$s} {$where} : c'est rapide."
                        : "Google mesure l'arrivée du contenu principal en {$s} {$where} (objectif : 2,5 s). Les pages lentes perdent des clients.",
                ];
            }
        }

        return $summary;
    }
}
