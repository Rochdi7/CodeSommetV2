<x-mail-layout subject="Nous avons bien reçu votre message" eyebrow="Contact" heading="Merci, {{ $contactMessage->name }} !" subheading="Votre message a bien été reçu. Notre équipe vous répondra sous 24 à 48h ouvrées.">

    <div style="background:#f8fafc; border-radius:10px; border:1px solid #eef2f7; padding:18px 20px; margin-bottom:22px;">
        <p style="margin:0 0 8px; font-size:12px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.04em;">Votre message</p>
        <p style="margin:0; font-size:14px; color:#334155; line-height:1.7; white-space:pre-line;">{{ \Illuminate\Support\Str::limit($contactMessage->message, 400) }}</p>
    </div>

    <p style="margin:0; font-size:14px; color:#334155; line-height:1.7;">
        Si votre demande est urgente, vous pouvez répondre directement à cet e-mail.
    </p>

    <p style="margin:24px 0 0; font-size:13px; color:#94a3b8; line-height:1.6;">
        À très bientôt,<br>
        L'équipe CodeSommet
    </p>

</x-mail-layout>
