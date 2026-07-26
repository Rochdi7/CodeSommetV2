<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Persist first so the enquiry is never lost, even if mail fails later.
        try {
            ContactMessage::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'company' => $data['company'] ?? null,
                'budget' => $data['budget'] ?? null,
                'inquiry_type' => $data['inquiryType'] ?? null,
                'message' => $data['message'],
                'source' => 'contact-form',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
            ]);
        } catch (\Throwable $e) {
            Log::error('Contact message could not be stored: '.$e->getMessage());

            return back()
                ->withInput($request->except('message'))
                ->with('contact_error', 'Une erreur est survenue. Veuillez réessayer.');
        }

        // Optional mail notification — failure must not lose the DB record.
        // (Mail sending intentionally left as a documented, config-gated step.)

        return back()->with('contact_success', 'Merci ! Votre message a bien été envoyé. Nous vous répondrons rapidement.');
    }
}
