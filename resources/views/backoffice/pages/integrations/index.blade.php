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

{{-- Se connecter avec Google (GA4, Tag Manager, Search Console) --}}
@php
    $gAccount = $google['account'];
    $gFound = $google['found'] ?? ['ga4' => [], 'gtm' => [], 'gsc' => null, 'errors' => []];
@endphp
<div class="admin-card mb-6" data-google-connect>
    <div class="admin-card-header">
        <div class="flex items-center gap-3 min-w-0">
            <span class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 bg-white border border-[var(--border-default)]" aria-hidden="true">
                <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.4-.4-3.5z"/><path fill="#FF3D00" d="m6.3 14.7 6.6 4.8C14.7 15.1 19 12 24 12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/><path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.6 16.2 44 24 44z"/><path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.2-4.1 5.6l6.2 5.2C37 39.2 44 34 44 24c0-1.3-.1-2.4-.4-3.5z"/></svg>
            </span>
            <div class="min-w-0">
                <h3 class="truncate">Connexion Google</h3>
                @if($gAccount)
                    <span class="admin-badge mt-0.5" style="background:#ECFDF5;color:#047857"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Connect&eacute; : {{ $gAccount['email'] ?: 'compte Google' }}</span>
                @else
                    <span class="admin-badge mt-0.5" style="background:#F5F5F5;color:#737373">Non connect&eacute;</span>
                @endif
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            @if($gAccount)
                <button type="submit" form="google-refresh" class="admin-btn admin-btn-secondary admin-btn-sm">Actualiser</button>
                <button type="submit" form="google-disconnect" class="admin-btn admin-btn-secondary admin-btn-sm">D&eacute;connecter</button>
            @elseif($google['configured'])
                <a href="{{ route('admin.integrations.google.connect') }}" class="admin-btn admin-btn-primary admin-btn-sm">Se connecter avec Google</a>
            @endif
        </div>
    </div>
    <div class="admin-card-body space-y-3">
        <p class="text-[13px] text-[var(--text-secondary)] leading-relaxed">Connectez votre compte Gmail une seule fois : vos ID Google Analytics et Tag Manager s'affichent en liste (plus de copier-coller), et Search Console est valid&eacute; automatiquement avec envoi du sitemap. Meta Pixel, Clarity et Bing n'acceptent pas la connexion Google : leurs champs restent manuels.</p>
        @if(! $google['configured'])
            <details class="text-[12.5px] text-[var(--text-secondary)] leading-relaxed" open>
                <summary class="cursor-pointer font-semibold text-[var(--text-primary)]">Configurer la connexion Google (une fois, ~5 min)</summary>
                <ol class="list-decimal pl-5 mt-2 space-y-1">
                    <li>Ouvrez <a href="https://console.cloud.google.com/projectcreate" target="_blank" rel="noopener" class="underline">Google Cloud Console</a> avec votre Gmail et cr&eacute;ez un projet &laquo; CodeSommet Admin &raquo;.</li>
                    <li>Activez ces 4 API : <a href="https://console.cloud.google.com/apis/library/analyticsadmin.googleapis.com" target="_blank" rel="noopener" class="underline">Google Analytics Admin</a>, <a href="https://console.cloud.google.com/apis/library/tagmanager.googleapis.com" target="_blank" rel="noopener" class="underline">Tag Manager</a>, <a href="https://console.cloud.google.com/apis/library/searchconsole.googleapis.com" target="_blank" rel="noopener" class="underline">Search Console</a>, <a href="https://console.cloud.google.com/apis/library/siteverification.googleapis.com" target="_blank" rel="noopener" class="underline">Site Verification</a>.</li>
                    <li><a href="https://console.cloud.google.com/auth/branding" target="_blank" rel="noopener" class="underline">&Eacute;cran de consentement OAuth</a> : type &laquo; Externe &raquo;, puis dans &laquo; Audience &raquo; cliquez &laquo; Publier l'application &raquo; (sinon l'acc&egrave;s expire apr&egrave;s 7 jours).</li>
                    <li><a href="https://console.cloud.google.com/apis/credentials/oauthclient" target="_blank" rel="noopener" class="underline">Cr&eacute;er un ID client OAuth</a> &rarr; &laquo; Application Web &raquo; &rarr; URI de redirection autoris&eacute; :<br><code class="select-all">{{ $google['redirect_uri'] }}</code></li>
                    <li>Copiez l'ID client et le code secret dans le <code>.env</code> du serveur : <code>GOOGLE_OAUTH_CLIENT_ID=&hellip;</code> et <code>GOOGLE_OAUTH_CLIENT_SECRET=&hellip;</code>, puis <code>php artisan config:clear</code>.</li>
                </ol>
            </details>
        @endif
        @foreach($gFound['errors'] as $gError)
            <p class="text-xs text-amber-700">{{ $gError }}</p>
        @endforeach
    </div>
</div>
@if($gAccount)
    <form id="google-refresh" method="POST" action="{{ route('admin.integrations.google.refresh') }}" class="hidden">@csrf</form>
    <form id="google-disconnect" method="POST" action="{{ route('admin.integrations.google.disconnect') }}" class="hidden">@csrf @method('DELETE')</form>
    <form id="google-gsc" method="POST" action="{{ route('admin.integrations.google.search-console') }}" class="hidden">@csrf</form>
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
                @if($gAccount && in_array($svc['key'], ['ga4', 'gtm'], true))
                    <div>
                        <label class="admin-label" for="pick-{{ $svc['key'] }}">Depuis votre compte Google</label>
                        @if(count($gFound[$svc['key']]))
                            <select id="pick-{{ $svc['key'] }}" class="admin-input" data-fill="{{ $svc['field'] }}" data-switch="{{ $svc['switch'] }}">
                                <option value="">&mdash; Choisir &mdash;</option>
                                @foreach($gFound[$svc['key']] as $item)
                                    <option value="{{ $item['id'] }}" {{ $old($svc['field']) === $item['id'] ? 'selected' : '' }}>{{ $item['id'] }} &mdash; {{ $item['label'] }}{{ $item['uri'] ? ' ('.$item['uri'].')' : '' }}</option>
                                @endforeach
                            </select>
                        @else
                            <p class="text-[12px] text-[var(--text-tertiary)]">Aucun {{ $svc['key'] === 'ga4' ? 'flux Web GA4' : 'conteneur Web' }} trouv&eacute; sur {{ $gAccount['email'] }}. Cr&eacute;ez-en un via le bouton ci-dessous puis cliquez &laquo; Actualiser &raquo;.</p>
                        @endif
                    </div>
                @endif
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
                @if($v['field'] === 'gsc_verification' && $gAccount)
                    <div class="rounded-lg border border-[var(--border-default)] p-3 flex items-center justify-between gap-3 flex-wrap">
                        <p class="text-[12.5px] text-[var(--text-secondary)]">
                            @if($gFound['gsc'])
                                <strong class="text-emerald-700">&check; {{ $google['site_url'] }} est dans Search Console</strong> ({{ $gFound['gsc'] }}).
                            @else
                                Validation automatique de {{ $google['site_url'] }} + envoi du sitemap.
                            @endif
                        </p>
                        <button type="submit" form="google-gsc" class="admin-btn admin-btn-primary admin-btn-sm">{{ $gFound['gsc'] ? 'Revalider' : 'Valider avec Google' }}</button>
                    </div>
                @endif
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
@push('scripts')
<script>
document.querySelectorAll('select[data-fill]').forEach(function (sel) {
    sel.addEventListener('change', function () {
        if (!sel.value) return;
        var input = document.getElementById(sel.dataset.fill);
        if (input) input.value = sel.value;
        var sw = document.querySelector('input[name="' + sel.dataset.switch + '"]');
        if (sw) sw.checked = true;
    });
});
</script>
@endpush
@endsection
