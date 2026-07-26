<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\QuoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class QuoteRequestController extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            QuoteRequest::create([
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

        return response()->json([
            'success' => true,
            'message' => 'Votre demande de devis a bien été envoyée.',
        ]);
    }
}
