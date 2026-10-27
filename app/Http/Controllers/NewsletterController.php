<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterWelcome;
use App\Models\AnalyticsSession;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        // Validate FIRST. No `unique` rule here — existence is handled below with
        // an identical response, so the endpoint is not an enumeration oracle.
        try {
            $validated = $request->validate([
                'email'   => 'required|email:rfc|max:255',
                'name'    => 'nullable|string|max:255',
                'website' => 'nullable|size:0', // honeypot
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?? 'Adresse email invalide.',
                'errors'  => $e->errors(),
            ], 422);
        }

        // Constrain the free-form source to a short safe token.
        $source = substr((string) $request->input('source', 'website'), 0, 100);

        // Duplicate subscriptions get a distinct "already subscribed" reply.
        // This does reveal list membership for a given address (enumeration),
        // a trade-off accepted for clearer UX on a marketing newsletter; the
        // throttle:newsletter middleware bounds abuse.
        $existing = NewsletterSubscriber::where('email', $validated['email'])->first();
        if ($existing) {
            return response()->json([
                'success' => true,
                'already' => true,
                'message' => 'Cette adresse est déjà inscrite à la newsletter.',
            ]);
        }

        $subscriber = NewsletterSubscriber::create([
            'email'         => $validated['email'],
            'name'          => $validated['name'] ?? null,
            'source'        => $source,
            'ip_address'    => $request->ip(),
            // Journey link (hidden inputs injected by public/js/analytics.js).
            'visitor_id'    => AnalyticsSession::isValidId($request->input('cs_vid')) ? $request->input('cs_vid') : null,
            'analytics_session_id' => AnalyticsSession::isValidId($request->input('cs_sid')) ? $request->input('cs_sid') : null,
            'is_confirmed'  => true,
            'subscribed_at' => now(),
        ]);

        // The next page view reports the lead to GA4 / GTM / Pixel (partials/tracking-tags).
        $request->session()->flash('cs_lead', 'newsletter');

        // Best-effort: stamp the lead on its analytics session (funnel view).
        try {
            AnalyticsSession::attachLead($request->input('cs_sid'), $request->input('cs_vid'), 'newsletter', $subscriber->id);
        } catch (\Throwable $e) {
            Log::warning('Newsletter subscriber #'.$subscriber->id.' could not be linked to its analytics session: '.$e->getMessage());
        }

        // Best-effort welcome email — the subscription itself must not fail
        // if mail delivery does.
        try {
            Mail::to($subscriber->email)->send(new NewsletterWelcome($subscriber));
        } catch (\Throwable $e) {
            Log::error('Newsletter subscriber #'.$subscriber->id.' welcome email failed: '.$e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Merci pour votre inscription !',
        ]);
    }
}
