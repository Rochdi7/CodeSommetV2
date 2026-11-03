@php
    $r = $lead->report ?? [];
    $items = $r['items'] ?? [];
    $fixes = $r['fixes'] ?? [];
    $score = $r['score'] ?? null;
    $host = parse_url((string) ($r['url'] ?? ''), PHP_URL_HOST) ?: ($r['url'] ?? '');
    $work = array_values(array_filter($items, fn ($i) => ($i['status'] ?? '') === 'work'));
    $good = array_values(array_filter($items, fn ($i) => ($i['status'] ?? '') === 'good'));
    $info = array_values(array_filter($items, fn ($i) => ($i['status'] ?? '') === 'info'));
    $tone = $score === null ? '#64748b' : ($score >= 80 ? '#16a34a' : ($score >= 50 ? '#d97706' : '#dc2626'));
    $calUrl = 'https://app.cal.eu/code-sommet/new-client-meeting';
    $waUrl = 'https://api.whatsapp.com/send?phone=212632582096&text=' . rawurlencode('Bonjour CodeSommet ! J\'ai reçu le rapport ' . ($r['tool'] ?? '') . ' pour ' . $host . '. Pouvez-vous m\'aider à corriger les points relevés ?');
    $heading = 'Votre rapport' . ($lead->name ? ', ' . $lead->name : '');
@endphp
<x-mail-layout :subject="'Votre rapport ' . ($r['tool'] ?? '')" :eyebrow="$r['tool'] ?? 'Outil CodeSommet'" :heading="$heading" :subheading="$host ? 'Analyse de ' . $host . ' — ' . $lead->created_at->translatedFormat('d F Y à H:i') : null">

    @if($score !== null)
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin:0 0 20px; background:#f8fafc; border:1px solid #eef2f7; border-radius:12px;">
        <tr>
            <td style="padding:18px 20px; width:90px; vertical-align:middle;">
                <div style="width:72px; height:72px; border-radius:50%; border:6px solid {{ $tone }}; text-align:center; line-height:60px; font-size:24px; font-weight:800; color:#0f172a;">{{ $score }}</div>
            </td>
            <td style="padding:18px 20px 18px 0; vertical-align:middle;">
                <p style="margin:0 0 4px; font-size:16px; font-weight:700; color:#0f172a;">Score : {{ $score }} / 100</p>
                @if(!empty($r['headline']))
                <p style="margin:0 0 4px; font-size:13px; color:#334155;">{{ $r['headline'] }}</p>
                @endif
                @if(count($items))
                <p style="margin:0; font-size:13px; color:#334155;"><strong>{{ count($good) }} bon(s) point(s)</strong> et <strong style="color:#c2410c;">{{ count($work) }} à corriger</strong>.</p>
                @endif
            </td>
        </tr>
    </table>
    @endif

    @if(count($work))
    <p style="margin:0 0 10px; font-size:12px; font-weight:700; color:#c2410c; text-transform:uppercase; letter-spacing:0.06em;">À corriger</p>
    @foreach($work as $item)
    <div style="margin:0 0 10px; padding:12px 14px; border:1px solid #f9c9aa; border-radius:10px; background:#fffaf6;">
        <p style="margin:0; font-size:14px; font-weight:700; color:#0f172a;">{{ $item['title'] }}</p>
        @if(!empty($item['label']))
        <p style="margin:2px 0 0; font-size:12px; font-weight:600; color:#c2410c;">{{ $item['label'] }}</p>
        @endif
        @if(!empty($item['detail']))
        <p style="margin:6px 0 0; font-size:13px; color:#475569; line-height:1.6;">{{ $item['detail'] }}</p>
        @endif
    </div>
    @endforeach
    @endif

    @if(count($fixes))
    <p style="margin:22px 0 10px; font-size:12px; font-weight:700; color:#0071bc; text-transform:uppercase; letter-spacing:0.06em;">Comment corriger</p>
    <ol style="margin:0 0 8px; padding-left:20px; color:#334155; font-size:13px; line-height:1.6;">
        @foreach($fixes as $fix)
        <li style="margin:0 0 8px;"><strong style="color:#0f172a;">{{ $fix['title'] }}</strong>
            @if(!empty($fix['detail']))
            <br>{{ $fix['detail'] }}
            @endif
        </li>
        @endforeach
    </ol>
    @endif

    @if(count($good))
    <p style="margin:22px 0 10px; font-size:12px; font-weight:700; color:#15803d; text-transform:uppercase; letter-spacing:0.06em;">Déjà bien</p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        @foreach($good as $item)
        <tr>
            <td style="padding:7px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#0f172a; vertical-align:top;">&#10003;&nbsp; {{ $item['title'] }}</td>
            <td style="padding:7px 0; border-bottom:1px solid #f1f5f9; font-size:12px; color:#15803d; text-align:right; vertical-align:top;">{{ $item['label'] ?? '' }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    @if(count($info))
    <p style="margin:22px 0 10px; font-size:12px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.06em;">Mesures</p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        @foreach($info as $item)
        <tr>
            <td style="padding:7px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#0f172a; vertical-align:top;">{{ $item['title'] }}</td>
            <td style="padding:7px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#334155; text-align:right; vertical-align:top;">{{ $item['label'] ?? '' }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    <div style="margin-top:28px; padding:22px; background:#0d0d0d; border-radius:14px; text-align:center;">
        <p style="margin:0 0 6px; font-size:17px; font-weight:700; color:#ffffff;">Vous voulez qu'on corrige tout ça ?</p>
        <p style="margin:0 0 16px; font-size:13px; color:#cbd5e1; line-height:1.6;">Lors d'un appel gratuit, nous vous montrons ce que nous corrigerions en premier, et en combien de temps.</p>
        <a href="{{ $calUrl }}" style="display:inline-block; background:#00AEEF; color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; padding:12px 24px; border-radius:999px;">Réserver un appel</a>
        <p style="margin:14px 0 0; font-size:12px;"><a href="{{ $waUrl }}" style="color:#cbd5e1;">Vous préférez écrire ? Discutons sur WhatsApp</a></p>
    </div>

    <p style="margin:24px 0 0; font-size:12px; color:#94a3b8; line-height:1.6;">
        Rapport généré par l'outil gratuit <a href="{{ url('/tools/' . $lead->tool_slug) }}" style="color:#00AEEF; text-decoration:none;">{{ $r['tool'] ?? $lead->tool_slug }}</a>.
        Un seul e-mail : pas de newsletter, pas de relance automatique.
    </p>

</x-mail-layout>
