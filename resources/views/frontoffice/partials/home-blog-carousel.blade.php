{{-- Derniers Articles du Blog --}}
@php
    $homeBlogPosts = \App\Models\BlogPost::published()
        ->with('category')
        ->orderByDesc('published_at')
        ->limit(6)
        ->get();
    $homeBlogPerPage = 3;
    $homeBlogPages = $homeBlogPosts->chunk($homeBlogPerPage);
@endphp

@if ($homeBlogPosts->isNotEmpty())
    <section class="w-full py-12 md:py-16 bg-white">
        <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
            <div class="text-center mb-8">
                <h2
                    class="font-heading font-semibold tracking-tight text-[var(--text-3xl)] md:text-[var(--text-4xl)] lg:text-[var(--text-5xl)] mb-4 text-3xl md:text-4xl lg:text-5xl">
                    Derniers Articles du Blog</h2>
                <p class="font-body leading-relaxed font-normal text-[var(--text-secondary)] max-w-2xl mx-auto">
                    Nos conseils, analyses et actualités sur le développement web et l'IA</p>
            </div>

            <div class="blog-carousel-container relative" data-current-slide="0">
                <div class="overflow-hidden">
                    @foreach ($homeBlogPages as $page => $posts)
                        <div class="blog-carousel-slide grid md:grid-cols-2 lg:grid-cols-3 gap-8" data-slide="{{ $page }}"
                            @if ($page !== 0) style="display: none;" @endif>
                            @foreach ($posts as $post)
                                @php $color = $post->category?->color ?: '#00AEEF'; @endphp
                                <article>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="block group">
                                        <div
                                            class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5 hover:shadow-[0_8px_30px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                                            <div
                                                class="relative aspect-[16/10] overflow-hidden rounded-[14px] bg-[#F3F4F6]">
                                                @if ($post->featured_image)
                                                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                                                        alt="{{ $post->image_alt }}" loading="lazy"
                                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center"
                                                        style="background-image:linear-gradient(to bottom right, {{ $color }}33, {{ $color }}1a, {{ $color }}0d)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="1" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-20 text-[var(--text-primary)]">
                                                            <path d="M12 20h9"></path>
                                                            <path
                                                                d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="absolute top-4 right-4 px-3 py-1.5 backdrop-blur-md rounded-full border border-white/30"
                                                    style="background-color:{{ $color }}cc">
                                                    <span
                                                        class="text-xs font-bold text-white tracking-wide uppercase">{{ $post->category_name }}</span>
                                                </div>
                                            </div>
                                            <div class="px-5 py-4">
                                                <div class="flex items-center gap-3 mb-3">
                                                    <span
                                                        class="text-xs text-[var(--text-tertiary)]">{{ $post->formatted_date }}</span>
                                                    <span class="text-[var(--text-tertiary)]">&middot;</span>
                                                    <span class="text-xs text-[var(--text-tertiary)]">{{ $post->read_time }}
                                                        de lecture</span>
                                                </div>
                                                <h3
                                                    class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors line-clamp-2">
                                                    {{ $post->title }}</h3>
                                                <p
                                                    class="text-sm text-[var(--text-secondary)] leading-relaxed line-clamp-2 mb-4">
                                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                                                </p>
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <div
                                                            class="w-6 h-6 rounded-full bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                                            @if ($post->author_avatar)
                                                                <img src="{{ asset('storage/' . $post->author_avatar) }}"
                                                                    alt="{{ $post->author }}" loading="lazy"
                                                                    class="w-full h-full object-cover" />
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                    height="12" viewBox="0 0 24 24" fill="none"
                                                                    stroke="#00AEEF" stroke-width="2">
                                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2">
                                                                    </path>
                                                                    <circle cx="12" cy="7" r="4"></circle>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                        <span
                                                            class="text-xs font-medium text-[var(--text-secondary)]">{{ $post->author }}</span>
                                                    </div>
                                                    <span
                                                        class="inline-flex items-center gap-1 text-xs font-semibold text-[#00AEEF] group-hover:gap-2 transition-all">
                                                        Lire
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path d="M5 12h14"></path>
                                                            <path d="m12 5 7 7-7 7"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                @if ($homeBlogPages->count() > 1)
                    {{-- Prev / Next --}}
                    <button type="button" class="blog-carousel-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-6 w-12 h-12 bg-white rounded-full shadow-lg border border-[var(--border-light)] flex items-center justify-center transition-all duration-300 hover:scale-110 z-10"
                        aria-label="Articles précédents">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="text-[var(--text-primary)]">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    <button type="button" class="blog-carousel-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-6 w-12 h-12 bg-white rounded-full shadow-lg border border-[var(--border-light)] flex items-center justify-center transition-all duration-300 hover:scale-110 z-10"
                        aria-label="Articles suivants">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="text-[var(--text-primary)]">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>

                    {{-- Dots --}}
                    <div class="flex justify-center items-center gap-3 mt-8">
                        @foreach ($homeBlogPages as $page => $posts)
                            <button type="button" class="blog-carousel-dot rounded-full transition-all duration-300 {{ $page === 0 ? 'w-3 h-3 bg-[#00AEEF] scale-125' : 'w-2.5 h-2.5 bg-[#0F0F0F]/20 hover:bg-[#0F0F0F]/40' }}"
                                data-dot="{{ $page }}" aria-label="Aller au groupe d'articles {{ $page + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('blog') }}"
                    class="inline-flex items-center gap-2 h-11 px-6 rounded-full border border-[var(--border-light)] text-sm font-semibold text-[var(--text-primary)] hover:bg-gray-50 transition-all duration-200">
                    Voir tous les articles
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    @if ($homeBlogPages->count() > 1)
        <script>
            (function() {
                var container = document.querySelector('.blog-carousel-container');
                if (!container || container.dataset.bound === 'true') return;
                container.dataset.bound = 'true';

                var slides = container.querySelectorAll('.blog-carousel-slide');
                var dots = container.querySelectorAll('.blog-carousel-dot');
                var prevBtn = container.querySelector('.blog-carousel-prev');
                var nextBtn = container.querySelector('.blog-carousel-next');
                var total = slides.length;
                var currentSlide = 0;
                var autoRotate = null;

                function showSlide(index) {
                    currentSlide = ((index % total) + total) % total;

                    slides.forEach(function(slide, i) {
                        slide.style.display = i === currentSlide ? '' : 'none';
                    });

                    dots.forEach(function(dot, i) {
                        if (i === currentSlide) {
                            dot.className = 'blog-carousel-dot rounded-full transition-all duration-300 w-3 h-3 bg-[#00AEEF] scale-125';
                        } else {
                            dot.className = 'blog-carousel-dot rounded-full transition-all duration-300 w-2.5 h-2.5 bg-[#0F0F0F]/20 hover:bg-[#0F0F0F]/40';
                        }
                    });

                    container.dataset.currentSlide = String(currentSlide);
                }

                function startAutoRotate() {
                    if (autoRotate) clearInterval(autoRotate);
                    autoRotate = setInterval(function() {
                        showSlide(currentSlide + 1);
                    }, 6000);
                }

                function stopAutoRotate() {
                    if (autoRotate) clearInterval(autoRotate);
                }

                dots.forEach(function(dot, i) {
                    dot.addEventListener('click', function() {
                        showSlide(i);
                        startAutoRotate();
                    });
                });

                if (prevBtn) {
                    prevBtn.addEventListener('click', function() {
                        showSlide(currentSlide - 1);
                        startAutoRotate();
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', function() {
                        showSlide(currentSlide + 1);
                        startAutoRotate();
                    });
                }

                container.addEventListener('mouseenter', stopAutoRotate);
                container.addEventListener('mouseleave', startAutoRotate);

                showSlide(0);
                startAutoRotate();
            })();
        </script>
    @endif
@endif
