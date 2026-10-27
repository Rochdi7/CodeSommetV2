@extends('backoffice.layouts.admin')

@section('title', 'Intégrations & tags | CodeSommet Admin')
@section('page_title', 'Intégrations & tags')

@section('content')
@php
    $services = [
        [
            'key' => 'ga4', 'switch' => 'ga4_enabled', 'field' => 'ga4_id',
            'name' => 'Google Analytics 4', 'color' => '#F9AB00',
            'desc' => "Audience, sources, conversions et rapports Google. Les clics sur les boutons et les leads sont envoyés comme événements (cs_click, generate_lead).",
            'where' => 'Analytics → Administration → Flux de données → Web → « ID de mesure ».',
            'links' => [['Ouvrir Google Analytics', 'https://analytics.google.com/analytics/web/'], ['Temps réel', 'https://analytics.google.com/analytics/web/#/realtime']],
        ],
        [
            'key' => 'gtm', 'switch' => 'gtm_enabled', 'field' => 'gtm_id',
            'name' => 'Google Tag Manager', 'color' => '#4285F4',
            'desc' => "Pour gérer vos propres balises (Google Ads, LinkedIn, TikTok…) sans toucher au code. Reçoit cs_click, cs_form_submit et cs_lead dans le dataLayer.",
            'where' => 'Tag Manager → votre conteneur → ID « GTM-XXXXXXX » en haut à droite. Ne configurez pas GA4 ici ET dans GTM (double comptage).',
            'links' => [['Ouvrir Tag Manager', 'https://tagmanager.google.com/'], ['Tag Assistant (tester)', 'https://tagassistant.google.com/']],
        ],
        [
            'key' => 'pixel', 'switch' => 'meta_pixel_enabled', 'field' => 'meta_pixel_id',
            'name' => 'Meta Pixel (Facebook / Instagram)', 'color' => '#0866FF',
            'desc' => "Mesure les campagnes Meta Ads : PageView, Contact (clic WhatsApp / appel / e-mail / RDV) et Lead (formulaire envoyé).",
            'where' => "Gestionnaire d'événements → Sources de données → votre pixel → « ID ». Vous pouvez coller tout le code du pixel.",
            'links' => [["Gestionnaire d'événements", 'https://business.facebook.com/events_manager2']],
        ],
        [
            'key' => 'clarity', 'switch' => 'clarity_enabled', 'field' => 'clarity_id',
            'name' => 'Microsoft Clarity (insights)', 'color' => '#0078D4',
            'desc' => "Gratuit : cartes de chaleur, enregistrements de sessions, clics de rage. Idéal pour voir où les visiteurs bloquent.",
            'where' => "Clarity → Paramètres → Vue d'ensemble → « ID de projet ». Vous pouvez coller tout le script.",
            'links' => [['Ouvrir Clarity', 'https://clarity.microsoft.com/']],
        ],
    ];
    $verifications = [
        [
            'field' => 'gsc_verification', 'name' => 'Google Search Console', 'color' => '#34A853',
            'desc' => "Requêtes Google, positions, indexation. Choisissez la méthode « Balise HTML » et collez la balise complète.",
            'links' => [['Ouvrir Search Console', 'https://search.google.com/search-console'], ['Search Console Insights', 'https://search.google.com/search-console/insights']],
        ],
        [
            'field' => 'bing_verification', 'name' => 'Bing Webmaster Tools', 'color' => '#008373',
            'desc' => "Bing, Copilot et DuckDuckGo. Méthode « Balise meta » : collez la balise msvalidate.01 complète.",
            'links' => [['Ouvrir Bing Webmaster', 'https://www.bing.com/webmasters']],
        ],
    ];
    $old = fn (string $key) => old($key, $values[$key]);
    $checked = fn (string $key) => old('_token') !== null ? (bool) old($key) : (bool) $values[$key];
@endphp

<div class="flex items-start justify-between mb-6 gap-4 flex-wrap">
    <div>
        <h1>Int&eacute;grations &amp; tags</h1>
        <p>Connectez Google Analytics, Tag Manager, Search Console, Meta Pixel et Clarity sans toucher au code. Le suivi interne (Trafic &amp; leads) continue de fonctionner en parall&egrave;le.</p>
    </div>
    <a href="https://tagassistant.google.com/" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary">Tester avec Tag Assistant &nearr;</a>
</div>

@if($errors->any())
    <div class="admin-alert admin-alert-error mb-5">Certains identifiants sont invalides — rien n'a &eacute;t&eacute; enregistr&eacute;. Corrigez les champs en rouge.</div>
@endif

<form method="POST" action="{{ route('admin.integrations.update') }}" class="space-y-6">
    @csrf
    @method('PUT')

    {{-- Tags --}}
    <div class="grid lg:grid-cols-2 gap-5">
        @foreach($services as $svc)
        @php $active = (bool) $config[$svc['key']]; @endphp
        <div class="admin-card flex flex-col" data-integration="{{ $svc['key'] }}">
            <div class="admin-card-header">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 text-white text-sm font-bold" style="background:{{ $svc['color'] }}">{{ mb_substr($svc['name'], 0, 1) }}</span>
                    <div class="min-w-0">
                        <h3 class="truncate">{{ $svc['name'] }}</h3>
                        @if($active)
                            <span class="admin-badge mt-0.5" style="background:#ECFDF5;color:#047857"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Actif sur le site</span>
                        @else
                            <span class="admin-badge mt-0.5" style="background:#F5F5F5;color:#737373">Non connect&eacute;</span>
                        @endif
                    </div>
                </div>
                <label class="inline-flex items-center gap-2 text-xs font-medium text-[var(--text-secondary)] cursor-pointer select-none">
                    <input type="checkbox" name="{{ $svc['switch'] }}" value="1" class="w-4 h-4" {{ $checked($svc['switch']) ? 'checked' : '' }} />
                    Activer
                </label>
            </div>
            <div class="admin-card-body flex-1 flex flex-col gap-3">
                <p class="text-[13px] text-[var(--text-secondary)] leading-relaxed">{{ $svc['desc'] }}</p>
                <div>
                    <label class="admin-label" for="{{ $svc['field'] }}">{{ $ids[$svc['field']]['label'] }}</label>
                    <input type="text" id="{{ $svc['field'] }}" name="{{ $svc['field'] }}" value="{{ $old($svc['field']) }}" placeholder="{{ $ids[$svc['field']]['example'] }}" autocomplete="off" spellcheck="false" class="admin-input font-mono {{ $errors->has($svc['field']) ? '!border-red-400' : '' }}" />
                    @error($svc['field'])<p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>@enderror
                    <p class="text-[11.5px] text-[var(--text-tertiary)] mt-1.5">{{ $svc['where'] }}</p>
                </div>
                <div class="flex flex-wrap gap-2 mt-auto pt-1">
                    @foreach($svc['links'] as [$label, $href])
                        <a href="{{ $href }}" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary admin-btn-sm">{{ $label }} &nearr;</a>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Site verification --}}
    <div class="grid lg:grid-cols-2 gap-5">
        @foreach($verifications as $v)
        @php $verified = (bool) $config[$v['field'] === 'gsc_verification' ? 'gsc' : 'bing']; @endphp
        <div class="admin-card flex flex-col" data-integration="{{ $v['field'] }}">
            <div class="admin-card-header">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 text-white text-sm font-bold" style="background:{{ $v['color'] }}">{{ mb_substr($v['name'], 0, 1) }}</span>
                    <div class="min-w-0">
                        <h3 class="truncate">{{ $v['name'] }}</h3>
                        @if($verified)
                            <span class="admin-badge mt-0.5" style="background:#ECFDF5;color:#047857"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Balise publi&eacute;e</span>
                        @else
                            <span class="admin-badge mt-0.5" style="background:#F5F5F5;color:#737373">Non v&eacute;rifi&eacute;</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="admin-card-body flex-1 flex flex-col gap-3">
                <p class="text-[13px] text-[var(--text-secondary)] leading-relaxed">{{ $v['desc'] }}</p>
                <div>
                    <label class="admin-label" for="{{ $v['field'] }}">{{ $ids[$v['field']]['label'] }}</label>
                    <input type="text" id="{{ $v['field'] }}" name="{{ $v['field'] }}" value="{{ $old($v['field']) }}" placeholder='<meta name="…" content="…" /> ou le code seul' autocomplete="off" spellcheck="false" class="admin-input font-mono {{ $errors->has($v['field']) ? '!border-red-400' : '' }}" />
                    @error($v['field'])<p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>@enderror
                    <p class="text-[11.5px] text-[var(--text-tertiary)] mt-1.5">Apr&egrave;s l'enregistrement, revenez dans l'outil et cliquez sur « Valider ».</p>
                </div>
                <div class="flex flex-wrap gap-2 mt-auto pt-1">
                    @foreach($v['links'] as [$label, $href])
                        <a href="{{ $href }}" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary admin-btn-sm">{{ $label }} &nearr;</a>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Options --}}
    <div class="admin-card">
        <div class="admin-card-header"><h3>Options</h3></div>
        <div class="admin-card-body space-y-4">
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" name="forward_events" value="1" class="w-4 h-4 mt-0.5" {{ $checked('forward_events') ? 'checked' : '' }} />
                <span>
                    <span class="block text-sm font-semibold">Envoyer les clics et les leads aux outils connect&eacute;s</span>
                    <span class="block text-xs text-[var(--text-tertiary)] mt-0.5">Chaque clic sur un bouton ou un lien (CTA, WhatsApp, appel, e-mail, RDV Cal.com…) est envoy&eacute; &agrave; GA4 (<code>cs_click</code>), GTM (<code>dataLayer</code>) et Clarity ; les contacts deviennent <code>Contact</code> pour Meta. Chaque formulaire valid&eacute; envoie <code>generate_lead</code> / <code>Lead</code>.</span>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" name="exclude_admin" value="1" class="w-4 h-4 mt-0.5" {{ $checked('exclude_admin') ? 'checked' : '' }} />
                <span>
                    <span class="block text-sm font-semibold">Ne pas compter mes propres visites</span>
                    <span class="block text-xs text-[var(--text-tertiary)] mt-0.5">Les navigateurs qui ont ouvert cet admin ne chargent aucun tag. D&eacute;cochez le temps de tester l'installation (Temps r&eacute;el GA4, Tag Assistant, Pixel Helper), puis recochez.</span>
                </span>
            </label>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 sticky bottom-4">
        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer les int&eacute;grations</button>
    </div>
</form>
@endsection
