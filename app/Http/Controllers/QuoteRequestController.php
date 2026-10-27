<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Mail\QuoteRequestConfirmation;
use App\Mail\QuoteRequestReceived;
use App\Models\AnalyticsSession;
use App\Models\QuoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class QuoteRequestController extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $quoteRequest = QuoteRequest::create([
                'name' => $data['fullName'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'company' => $data['companyName'] ?? null,
                'project_type' => $data['projectType'] ?? null,
                'budget' => $data['budgetRange'] ?? null,
                'timeline' => $data['startTimeline'] ?? null,
                'details' => $data['description'] ?? null,
                // Store the full submitted set for reference (excludes honeypot).
                'payload' => collect($data)->except('website')->toArray(),
                'source' => 'get-quote',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
                // Journey link (ids added to the JSON body by the quote page script).
                'visitor_id' => AnalyticsSession::isValidId($request->input('cs_vid')) ? $request->input('cs_vid') : null,
                'analytics_session_id' => AnalyticsSession::isValidId($request->input('cs_sid')) ? $request->input('cs_sid') : null,
            ]);
        } catch (\Throwable $e) {
            Log::error('Quote request could not be stored: '.$e->getMessage());

            return response()->json([
                'error' => 'Une erreur est survenue. Veuillez réessayer.',
            ], 500);
        }

        // The next page view reports the lead to GA4 / GTM / Pixel (partials/tracking-tags).
        $request->session()->flash('cs_lead', 'quote');

        // Best-effort: stamp the lead on its analytics session (funnel view).
        try {
            AnalyticsSession::attachLead($request->input('cs_sid'), $request->input('cs_vid'), 'quote', $quoteRequest->id, '/get-quote');
        } catch (\Throwable $e) {
            Log::warning('Quote request #'.$quoteRequest->id.' could not be linked to its analytics session: '.$e->getMessage());
        }

        // The request is only reported as a success once the notification email
        // has actually been sent — a saved-but-unsent request must surface as an
        // error so the visitor knows to retry or contact us another way.
        try {
            Mail::to(config('mail.from.address'))->send(new QuoteRequestReceived($quoteRequest));
        } catch (\Throwable $e) {
            Log::error('Quote request #'.$quoteRequest->id.' stored but notification email failed: '.$e->getMessage());

            return response()->json([
                'error' => 'Votre demande a été enregistrée, mais l\'envoi de l\'e-mail de confirmation a échoué. Veuillez réessayer ou nous écrire à codesommet@gmail.com.',
            ], 502);
        }

        // Best-effort auto-reply to the sender — its failure must not fail the
        // request, since the internal notification above already succeeded.
        try {
            Mail::to($quoteRequest->email)->send(new QuoteRequestConfirmation($quoteRequest));
        } catch (\Throwable $e) {
            Log::error('Quote request #'.$quoteRequest->id.' confirmation email to sender failed: '.$e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Votre demande de devis a bien été envoyée.',
        ]);
    }
}
