@php
    $r = $lead->report ?? [];
    $work = array_values(array_filter($r['items'] ?? [], fn ($i) => ($i['status'] ?? '') === 'work'));
@endphp
<x-mail-layout :subject="'Nouveau lead outil — ' . $lead->email" eyebrow="Lead outil SEO" heading="Rapport demandé par e-mail" :subheading="'Reçu le ' . $lead->created_at->translatedFormat('d F Y à H:i')">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <x-mail-field-row label="E-mail">
            <a href="mailto:{{ $lead->email }}" style="color:#00AEEF; text-decoration:none;">{{ $lead->email }}</a>
        </x-mail-field-row>
        <x-mail-field-row label="Nom" :value="$lead->name" />
        <x-mail-field-row label="Outil" :value="$r['tool'] ?? $lead->tool_slug" />
        <x-mail-field-row label="Site analysé" :value="$lead->target_url" />
        <x-mail-field-row label="Score" :value="$lead->score !== null ? $lead->score . ' / 100' : null" />
        <x-mail-field-row label="Points à corriger" :value="count($work) ? implode(', ', array_map(fn ($i) => $i['title'], array_slice($work, 0, 8))) : null" />
    </table>

    <div style="margin-top:28px;">
        <a href="mailto:{{ $lead->email }}" style="display:inline-block; background:#00AEEF; color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; padding:12px 24px; border-radius:8px;">Contacter le prospect</a>
    </div>

</x-mail-layout>
