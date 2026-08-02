<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequestConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteRequest $quoteRequest)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nous avons bien reçu votre demande de devis',
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quote-request-confirmation',
        );
    }
}
