{{-- Vérifications de propriété (Search Console, Bing) — gérées depuis l'admin « Intégrations & tags ». --}}
@php $tracking = \App\Support\TrackingIntegrations::config(); @endphp
@if($tracking['gsc'])
    <meta name="google-site-verification" content="{{ $tracking['gsc'] }}" />
@endif
@if($tracking['bing'])
    <meta name="msvalidate.01" content="{{ $tracking['bing'] }}" />
@endif
