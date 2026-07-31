<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Mail\QuoteRequestReceived;
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
            ]);
        } catch (\Throwable $e) {
            Log::error('Quote request could not be stored: '.$e->getMessage());

            return response()->json([
                'error' => 'Une erreur est survenue. Veuillez réessayer.',
            ], 500);
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

        return response()->json([
            'success' => true,
            'message' => 'Votre demande de devis a bien été envoyée.',
        ]);
    }
}
