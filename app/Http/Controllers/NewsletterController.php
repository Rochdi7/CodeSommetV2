<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        // Check for duplicate before validation to return friendly message
        if (NewsletterSubscriber::where('email', $request->input('email'))->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous êtes déjà inscrit(e) à notre newsletter.',
            ]);
        }

        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:newsletter_subscribers,email',
                'name'  => 'nullable|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?? 'Adresse email invalide.',
                'errors'  => $e->errors(),
            ], 422);
        }

        NewsletterSubscriber::create([
            'email'         => $validated['email'],
            'name'          => $validated['name'] ?? null,
            'source'        => $request->input('source', 'website'),
            'ip_address'    => $request->ip(),
            'is_confirmed'  => true,
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Merci pour votre inscription !',
        ]);
    }
}
