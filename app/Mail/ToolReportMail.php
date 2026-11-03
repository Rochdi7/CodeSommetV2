<?php

namespace App\Mail;

use App\Models\ToolReportRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Rapport d'outil envoyé au visiteur (« Recevez ce rapport par e-mail »). */
class ToolReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ToolReportRequest $lead)
    {
    }

    public function envelope(): Envelope
    {
        $r = $this->lead->report ?? [];
        $host = parse_url((string) ($r['url'] ?? ''), PHP_URL_HOST) ?: ($r['url'] ?? '');

        return new Envelope(
            subject: 'Votre rapport ' . ($r['tool'] ?? 'CodeSommet') . ($host ? ' — ' . $host : ''),
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.tool-report');
    }
}
