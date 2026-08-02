<x-mail-layout subject="Bienvenue dans la newsletter CodeSommet" eyebrow="Newsletter" heading="Bienvenue{{ $subscriber->name ? ', '.$subscriber->name : '' }} !" subheading="Votre inscription à la newsletter CodeSommet est confirmée.">

    <p style="margin:0 0 16px; font-size:14px; color:#334155; line-height:1.7;">
        Vous recevrez désormais nos derniers articles, conseils et actualités autour du développement web, directement dans votre boîte mail.
    </p>

    <div style="margin-top:8px;">
        <a href="{{ url('/') }}" style="display:inline-block; background:#00AEEF; color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; padding:12px 24px; border-radius:8px;">Découvrir CodeSommet</a>
    </div>

    <p style="margin:24px 0 0; font-size:13px; color:#94a3b8; line-height:1.6;">
        À très bientôt,<br>
        L'équipe CodeSommet
    </p>

</x-mail-layout>
