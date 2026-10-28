{{--
    Articles de blog liés à une page service (maillage interne blog → service → blog).
    Un article est "lié" s'il contient un lien vers /services/{serviceSlug} : la
    relation reste pilotée par le contenu rédigé dans l'admin, sans table de mapping.
    Rien n'est rendu si aucun article publié ne cite le service.
    Usage : @include('frontoffice.partials.related-articles', ['serviceSlug' => 'saas-platform-development'])
--}}
@php
    $relatedArticles = collect();
    if (!empty($serviceSlug)) {
        $relatedArticles = \App\Models\BlogPost::published()
            ->with('category')
            ->where('content', 'like', '%/services/' . $serviceSlug . '%')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get()
            ->filter(fn ($post) => preg_match('#/services/' . preg_quote($serviceSlug, '#') . '(?=["\'?\#/\s])#', (string) $post->content) === 1)
            ->take(3)
            ->values();
    }
@endphp
@if ($relatedArticles->isNotEmpty())
        <section class="w-full bg-white py-16 md:py-20" aria-labelledby="related-articles-heading">
            <div class="max-w-7xl mx-auto px-4 md:px-6">
                <div class="text-center mb-8 md:mb-10">
                    <h2 id="related-articles-heading" class="text-2xl md:text-3xl lg:text-4xl font-semibold text-[#0F0F0F] mb-3 px-4"
                        style="font-family:var(--font-heading)">Articles liés</h2>
                    <p class="text-base md:text-lg text-[#0F0F0F]/70 max-w-2xl mx-auto px-4">Guides et conseils de notre blog pour approfondir ce type de projet.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($relatedArticles as $article)
                    <article>
                        <div class="block group card-link relative">
                            <div class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5 hover:shadow-[0_8px_30px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                                <div class="relative aspect-[16/10] overflow-hidden rounded-[14px] bg-[#F3F4F6]">
                                    @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->image_alt ?: $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
                                    @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#00AEEF]/20 to-[#0071BC]/10"></div>
                                    @endif
                                    <div class="absolute top-4 right-4 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/30">
                                        <span class="text-xs font-bold text-white tracking-wide uppercase">{{ $article->category?->name ?? 'Général' }}</span>
                                    </div>
                                </div>
                                <div class="px-5 py-4">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="text-xs text-[var(--text-tertiary)]">{{ $article->formatted_date }}</span>
                                        <span class="text-[var(--text-tertiary)]">&middot;</span>
                                        <span class="text-xs text-[var(--text-tertiary)]">{{ $article->read_time }} de lecture</span>
                                    </div>
                                    <div class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors line-clamp-2 hd-3"><a href="{{ route('blog.show', $article->slug) }}" class="stretched-link">{{ $article->title }}</a></div>
                                    <p class="text-sm text-[var(--text-secondary)] leading-relaxed line-clamp-2">{{ $article->excerpt }}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
                <div class="text-center mt-8 md:mt-10"><a
                        class="inline-flex items-center gap-2 text-[#00AEEF] font-semibold hover:underline"
                        href="{{ route('blog') }}">Voir tous les articles<svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></a></div>
            </div>
        </section>
@endif
