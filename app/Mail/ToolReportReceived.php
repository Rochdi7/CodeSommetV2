<?php

namespace App\Mail;

use App\Models\ToolReportRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Notification interne : un visiteur a demandé son rapport d'outil. */
class ToolReportReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ToolReportRequest $lead)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau lead outil — ' . ($this->lead->report['tool'] ?? $this->lead->tool_slug) . ' — ' . $this->lead->email,
            replyTo: [$this->lead->email],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.tool-report-received');
    }
}
