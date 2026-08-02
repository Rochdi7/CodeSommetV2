<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMessageConfirmation;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Persist first so the enquiry is never lost, even if mail fails later.
        try {
            $contactMessage = ContactMessage::create([
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

        // Mail notifications are best-effort — the DB record above is the
        // source of truth, so a mail failure here must not lose the enquiry
        // or block the visitor's success response.
        try {
            Mail::to(config('mail.from.address'))->send(new ContactMessageReceived($contactMessage));
        } catch (\Throwable $e) {
            Log::error('Contact message #'.$contactMessage->id.' stored but notification email failed: '.$e->getMessage());
        }

        try {
            Mail::to($contactMessage->email)->send(new ContactMessageConfirmation($contactMessage));
        } catch (\Throwable $e) {
            Log::error('Contact message #'.$contactMessage->id.' confirmation email to sender failed: '.$e->getMessage());
        }

        return back()->with('contact_success', 'Merci ! Votre message a bien été envoyé. Nous vous répondrons rapidement.');
    }
}
