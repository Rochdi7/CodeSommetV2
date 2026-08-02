<x-mail-layout subject="Nous avons bien reçu votre demande de devis" eyebrow="Demande de devis" heading="Merci, {{ $quoteRequest->name }} !" subheading="Votre demande de devis a bien été reçue. Notre équipe l'étudie et revient vers vous sous 24 à 48h ouvrées.">

    <div style="background:#f8fafc; border-radius:10px; border:1px solid #eef2f7; padding:18px 20px; margin-bottom:22px;">
        <p style="margin:0 0 10px; font-size:12px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.04em;">Récapitulatif de votre demande</p>
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            <x-mail-field-row label="Type de projet" :value="$quoteRequest->project_type" />
            <x-mail-field-row label="Budget" :value="$quoteRequest->budget" />
            <x-mail-field-row label="Délai souhaité" :value="$quoteRequest->timeline" />
        </table>
    </div>

    <p style="margin:0 0 16px; font-size:14px; color:#334155; line-height:1.7;">
        En attendant, n'hésitez pas à consulter quelques-unes de nos réalisations ou à nous répondre directement à cet e-mail si vous souhaitez ajouter des informations.
    </p>

    <div style="margin-top:24px;">
        <a href="{{ url('/our-work') }}" style="display:inline-block; background:#00AEEF; color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; padding:12px 24px; border-radius:8px;">Voir nos réalisations</a>
    </div>

    <p style="margin:24px 0 0; font-size:13px; color:#94a3b8; line-height:1.6;">
        À très bientôt,<br>
        L'équipe CodeSommet
    </p>

</x-mail-layout>
