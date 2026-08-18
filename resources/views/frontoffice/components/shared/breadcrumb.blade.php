{{--
    Breadcrumb component
    Usage: @include('frontoffice.components.shared.breadcrumb', ['items' => [['label' => 'Home', 'url' => route('home')], ['label' => 'Industries'], ['label' => 'E-commerce']]])
--}}
<nav class="flex items-center justify-center gap-2 text-xs text-gray-400" aria-label="Breadcrumb">
    @foreach ($items as $index => $item)
        @if ($index > 0)
            <span>/</span>
        @endif

        @if (isset($item['url']) && $index < count($items) - 1)
            @if ($item['label'] === 'Home')
                <a class="hover:text-gray-600 transition-colors" aria-label="Home" href="{{ $item['url'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-house w-3 h-3" aria-hidden="true">
                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                        <path
                            d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z">
                        </path>
                    </svg>
                </a>
            @else
                <a class="hover:text-gray-600 transition-colors" href="{{ $item['url'] }}">{{ $item['label'] }}</a>
            @endif
        @else
            <span class="text-gray-600">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
