<x-mail-layout :subject="'Nouvelle demande de devis - '.$quoteRequest->name" eyebrow="Demande de devis" heading="Nouvelle demande de devis" :subheading="'Reçue le '.$quoteRequest->created_at->translatedFormat('d F Y à H:i')">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <x-mail-field-row label="Nom" :value="$quoteRequest->name" />
        <x-mail-field-row label="Email">
            <a href="mailto:{{ $quoteRequest->email }}" style="color:#00AEEF; text-decoration:none;">{{ $quoteRequest->email }}</a>
        </x-mail-field-row>
        <x-mail-field-row label="Téléphone" :value="$quoteRequest->phone" />
        <x-mail-field-row label="Entreprise" :value="$quoteRequest->company" />
        <x-mail-field-row label="Type de projet" :value="$quoteRequest->project_type" />
        <x-mail-field-row label="Budget" :value="$quoteRequest->budget" />
        <x-mail-field-row label="Délai souhaité" :value="$quoteRequest->timeline" />
    </table>

    @if($quoteRequest->details)
        <div style="margin-top:20px; padding:16px; background:#f8fafc; border-radius:10px; border:1px solid #eef2f7;">
            <p style="margin:0 0 8px; font-size:12px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.04em;">Détails du projet</p>
            <p style="margin:0; font-size:14px; color:#334155; line-height:1.7; white-space:pre-line;">{{ $quoteRequest->details }}</p>
        </div>
    @endif

    <div style="margin-top:28px;">
        <a href="mailto:{{ $quoteRequest->email }}" style="display:inline-block; background:#00AEEF; color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; padding:12px 24px; border-radius:8px;">Répondre au client</a>
    </div>

</x-mail-layout>
