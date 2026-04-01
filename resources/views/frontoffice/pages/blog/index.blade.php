@extends('frontoffice.layouts.app')

@section('title', __('blog/index.title'))
@section('meta_description', __('blog/index.meta_description'))
@section('meta_keywords', __('blog/index.meta_keywords'))
@section('og_title', __('blog/index.og_title'))
@section('og_description', __('blog/index.og_description'))

@section('content')
{{-- Hero Section --}}
<section class="relative min-h-[70vh] md:min-h-[80vh] flex items-center overflow-hidden pt-28 lg:pt-32 pb-16 md:pb-20">
    @include('frontoffice.components.hero-background')
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative z-10">
        <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-8 lg:gap-12 items-center">
            <div class="space-y-6 lg:space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#00AEEF]/10 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-[#00AEEF]" aria-hidden="true">
                        <path d="M12 20h9"></path>
                        <path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path>
                    </svg>
                    <span class="text-sm font-medium text-[#00AEEF]">{{ __('blog/index.text_0') }}</span>
                </div>
                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight font-heading">
                        Insights & <span class="block text-transparent bg-clip-text bg-gradient-to-r from-[#00AEEF] to-[#0071BC]">{{ __('blog/index.text_1') }}</span>
                    </h1>
                    <p class="text-lg md:text-xl text-[var(--text-secondary)] max-w-xl mx-auto lg:mx-0">{{ __('blog/index.ml_512') }}</p>
                </div>
                <div class="flex flex-wrap justify-center lg:justify-start gap-6 md:gap-8">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                            <path d="M12 20h9"></path>
                            <path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path>
                        </svg>
                        <span class="text-sm font-medium text-[var(--text-secondary)]">Articles Experts</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                            <path d="M16 7h6v6"></path>
                            <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                        </svg>
                        <span class="text-sm font-medium text-[var(--text-secondary)]">Tendances Tech</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                        <span class="text-sm font-medium text-[var(--text-secondary)]">Tutoriels Pratiques</span>
                    </div>
                </div>

                {{-- Search --}}
                <div class="max-w-lg mx-auto lg:mx-0">
                    <form method="GET" action="{{ route('blog') }}" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('blog/index.placeholder_109') }}" class="w-full h-12 pl-12 pr-4 rounded-full border border-[var(--border-light)] bg-white/90 backdrop-blur-sm text-sm text-[var(--text-primary)] placeholder:text-[var(--text-tertiary)] focus:outline-none focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 transition-all" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-tertiary)]">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </form>
                </div>
            </div>
            <div class="hidden lg:flex relative h-[400px] items-center justify-center" style="transform:scale(0.95)">
                <div class="absolute inset-0 bg-gradient-to-br from-[#00AEEF]/5 to-transparent rounded-3xl"></div>
                {{-- Blog illustration - decorative cards --}}
                <div class="relative w-full max-w-sm space-y-4">
                    <div class="bg-white rounded-2xl p-5 shadow-[0_4px_20px_rgba(0,0,0,0.08)] border border-gray-100 transform rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-[#00AEEF]/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-[var(--text-primary)]">{{ __('blog/index.text_2') }}</div>
                                <div class="text-[10px] text-[var(--text-tertiary)]">{{ __('blog/index.text_110') }}</div>
                            </div>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full w-full mb-2"></div>
                        <div class="h-2 bg-gray-100 rounded-full w-3/4"></div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-[0_4px_20px_rgba(0,0,0,0.08)] border border-gray-100 transform -rotate-1 hover:rotate-0 transition-transform duration-500 ml-8">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-[var(--text-primary)]">SEO & Marketing</div>
                                <div class="text-[10px] text-[var(--text-tertiary)]">{{ __('blog/index.text_111') }}</div>
                            </div>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full w-full mb-2"></div>
                        <div class="h-2 bg-gray-100 rounded-full w-2/3"></div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-[0_4px_20px_rgba(0,0,0,0.08)] border border-gray-100 transform rotate-1 hover:rotate-0 transition-transform duration-500">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m9 12 2 2 4-4"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-[var(--text-primary)]">Design UI/UX</div>
                                <div class="text-[10px] text-[var(--text-tertiary)]">{{ __('blog/index.text_112') }}</div>
                            </div>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full w-full mb-2"></div>
                        <div class="h-2 bg-gray-100 rounded-full w-5/6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Featured Post (Static) --}}
<section class="py-12 md:py-16 bg-[#F5F5F5]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="mb-8">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-[#00AEEF]/10 text-[#00AEEF] text-xs font-semibold rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                Article en Vedette
            </span>
        </div>
        <a href="#" class="block group">
            <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5">
                <div class="grid md:grid-cols-2 gap-0">
                    <div class="relative aspect-[16/10] md:aspect-auto overflow-hidden rounded-[14px] bg-[#F3F4F6]">
                        <div class="w-full h-full min-h-[300px] bg-gradient-to-br from-[#00AEEF]/20 via-[#0071BC]/10 to-[#00AEEF]/5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="opacity-20">
                                <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"></path>
                            </svg>
                        </div>
                        <div class="absolute top-5 right-5 px-3 py-1.5 bg-[#00AEEF]/80 backdrop-blur-md rounded-full border border-white/30">
                            <span class="text-xs font-bold text-white tracking-wide uppercase">{{ __('blog/index.text_3') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center px-6 md:px-10 py-6 md:py-8">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center gap-2 text-xs text-[var(--text-tertiary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                                25 Mars 2026
                            </div>
                            <span class="text-[var(--text-tertiary)]">&middot;</span>
                            <div class="flex items-center gap-1 text-xs text-[var(--text-tertiary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                8 min de lecture
                            </div>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-[var(--text-primary)] mb-3 group-hover:text-[#00AEEF] transition-colors" style="font-family:var(--font-heading)">{{ __('blog/index.text_4') }}</h2>
                        <p class="text-[var(--text-secondary)] leading-relaxed mb-6 line-clamp-3">{{ __('blog/index.text_5') }}</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-[var(--text-primary)]">CodeSommet</div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#00AEEF] group-hover:gap-3 transition-all">
                                Lire l'article
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>

{{-- Category Filters (Static) --}}
<section class="py-8 bg-white border-b border-[var(--border-light)]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('blog') }}" class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-[#00AEEF] text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)]">Tous</a>
            <a href="#" class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">{{ __('blog/index.text_6') }}</a>
            <a href="#" class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">Design</a>
            <a href="#" class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">SEO</a>
            <a href="#" class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">Marketing</a>
            <a href="#" class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">Business</a>
            <a href="#" class="px-6 py-2.5 rounded-full font-medium transition-all duration-300 bg-white border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF]/30 hover:text-[#00AEEF]">Tendances</a>
        </div>
    </div>
</section>

{{-- Static Blog Cards Grid --}}
<section class="py-16 md:py-20 bg-[#F5F5F5]">
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)]">

        @php
        $staticPosts = [
            [
                'title' => 'Les 10 Tendances du Design Web à Suivre en 2026',
                'excerpt' => 'Du bento grid au glassmorphism avancé, découvrez les tendances visuelles qui domineront le web design cette année et comment les intégrer dans vos projets.',
                'category' => 'Design',
                'date' => '22 Mars 2026',
                'read_time' => '6 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#8B5CF6]/20 via-[#7C3AED]/10 to-[#8B5CF6]/5',
                'badge_bg' => 'bg-[#8B5CF6]/80',
                'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="m9 12 2 2 4-4"></path>',
            ],
            [
                'title' => 'Guide Complet du SEO Technique pour les Sites Laravel',
                'excerpt' => 'Optimisez votre site Laravel pour les moteurs de recherche : sitemap XML, meta tags dynamiques, schema markup, Core Web Vitals et plus encore.',
                'category' => 'SEO',
                'date' => '20 Mars 2026',
                'read_time' => '12 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#10B981]/20 via-[#059669]/10 to-[#10B981]/5',
                'badge_bg' => 'bg-[#10B981]/80',
                'icon' => '<circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path>',
            ],
            [
                'title' => 'Pourquoi Choisir Laravel pour Votre Prochain Projet SaaS',
                'excerpt' => 'Laravel offre un écosystème complet pour construire des applications SaaS robustes. Eloquent ORM, queues, notifications, et bien plus pour accélérer le développement.',
                'category' => 'Développement',
                'date' => '18 Mars 2026',
                'read_time' => '9 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#00AEEF]/20 via-[#0071BC]/10 to-[#00AEEF]/5',
                'badge_bg' => 'bg-[#00AEEF]/80',
                'icon' => '<polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline>',
            ],
            [
                'title' => 'Comment Augmenter Vos Conversions de 300% avec le CRO',
                'excerpt' => 'Les meilleures stratégies de Conversion Rate Optimization : A/B testing, heatmaps, analyse du parcours utilisateur et optimisation des landing pages.',
                'category' => 'Marketing',
                'date' => '15 Mars 2026',
                'read_time' => '7 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#F59E0B]/20 via-[#D97706]/10 to-[#F59E0B]/5',
                'badge_bg' => 'bg-[#F59E0B]/80',
                'icon' => '<path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path>',
            ],
            [
                'title' => 'E-commerce au Maroc : État du Marché et Opportunités en 2026',
                'excerpt' => 'Le marché e-commerce marocain connaît une croissance exponentielle. Analyse des tendances, des plateformes populaires et des opportunités pour les entreprises.',
                'category' => 'Business',
                'date' => '12 Mars 2026',
                'read_time' => '10 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#EF4444]/20 via-[#DC2626]/10 to-[#EF4444]/5',
                'badge_bg' => 'bg-[#EF4444]/80',
                'icon' => '<circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>',
            ],
            [
                'title' => 'Les Meilleures Pratiques d\'Accessibilité Web (WCAG 2.2)',
                'excerpt' => 'Rendez votre site web accessible à tous : contrastes, navigation clavier, lecteurs d\'écran, ARIA labels. Un guide pratique pour respecter les standards WCAG.',
                'category' => 'Développement',
                'date' => '10 Mars 2026',
                'read_time' => '8 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#06B6D4]/20 via-[#0891B2]/10 to-[#06B6D4]/5',
                'badge_bg' => 'bg-[#06B6D4]/80',
                'icon' => '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>',
            ],
            [
                'title' => 'Créer une API RESTful Performante avec Laravel 12',
                'excerpt' => 'Architecture, authentification Sanctum, pagination, rate limiting, versioning et documentation automatique. Tout pour créer des APIs professionnelles.',
                'category' => 'Développement',
                'date' => '8 Mars 2026',
                'read_time' => '15 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#00AEEF]/20 via-[#0071BC]/10 to-[#00AEEF]/5',
                'badge_bg' => 'bg-[#00AEEF]/80',
                'icon' => '<path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>',
            ],
            [
                'title' => 'UI/UX : Comment Concevoir un Formulaire de Contact Efficace',
                'excerpt' => 'Un bon formulaire de contact peut doubler vos leads. Découvrez les principes de design, la validation en temps réel et les micro-interactions qui font la différence.',
                'category' => 'Design',
                'date' => '5 Mars 2026',
                'read_time' => '5 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#8B5CF6]/20 via-[#7C3AED]/10 to-[#8B5CF6]/5',
                'badge_bg' => 'bg-[#8B5CF6]/80',
                'icon' => '<path d="M12 20h9"></path><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"></path>',
            ],
            [
                'title' => 'Stratégie de Contenu : Attirer et Convertir avec le Blogging',
                'excerpt' => 'Comment créer une stratégie de contenu efficace pour votre site web : calendrier éditorial, recherche de mots-clés, création de contenu engageant et mesure des résultats.',
                'category' => 'Marketing',
                'date' => '2 Mars 2026',
                'read_time' => '11 min',
                'author' => 'CodeSommet',
                'gradient' => 'from-[#F59E0B]/20 via-[#D97706]/10 to-[#F59E0B]/5',
                'badge_bg' => 'bg-[#F59E0B]/80',
                'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>',
            ],
        ];
        @endphp

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($staticPosts as $index => $post)
            <article style="opacity:0;transform:translateY(30px)" data-delay="{{ ($index % 3) + 1 }}">
                <a href="#" class="block group">
                    <div class="w-full bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-hidden p-2.5 hover:shadow-[0_8px_30px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                        <div class="relative aspect-[16/10] overflow-hidden rounded-[14px] bg-[#F3F4F6]">
                            <div class="w-full h-full bg-gradient-to-br {{ $post['gradient'] }} flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="opacity-20 text-[var(--text-primary)]">{!! $post['icon'] !!}</svg>
                            </div>
                            <div class="absolute top-4 right-4 px-3 py-1.5 {{ $post['badge_bg'] }} backdrop-blur-md rounded-full border border-white/30">
                                <span class="text-xs font-bold text-white tracking-wide uppercase">{{ $post['category'] }}</span>
                            </div>
                        </div>
                        <div class="px-5 py-4">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-xs text-[var(--text-tertiary)]">{{ $post['date'] }}</span>
                                <span class="text-[var(--text-tertiary)]">&middot;</span>
                                <span class="text-xs text-[var(--text-tertiary)]">{{ $post['read_time'] }} de lecture</span>
                            </div>
                            <h3 class="text-lg font-semibold text-[var(--text-primary)] mb-2 group-hover:text-[#00AEEF] transition-colors line-clamp-2">{{ $post['title'] }}</h3>
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed line-clamp-2 mb-4">{{ $post['excerpt'] }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-[#00AEEF]/10 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    </div>
                                    <span class="text-xs font-medium text-[var(--text-secondary)]">{{ $post['author'] }}</span>
                                </div>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#00AEEF] group-hover:gap-2 transition-all">
                                    Lire
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        {{-- Pagination (Static) --}}
        <div class="flex justify-center mt-12">
            <nav class="flex items-center gap-2">
                <span class="w-10 h-10 rounded-full flex items-center justify-center border border-gray-200 text-gray-300 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>
                </span>
                <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium bg-[#00AEEF] text-white shadow-[0_4px_16px_rgba(0,174,239,0.25)]">1</a>
                <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF] hover:text-[#00AEEF] bg-white transition-colors">2</a>
                <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF] hover:text-[#00AEEF] bg-white transition-colors">3</a>
                <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center border border-gray-200 text-[var(--text-secondary)] hover:border-[#00AEEF] hover:text-[#00AEEF] transition-colors bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>
                </a>
            </nav>
        </div>

    </div>
</section>

{{-- Newsletter / CTA Section --}}
<section class="relative overflow-hidden py-20 lg:py-28" style="background:#F8F8F8">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(to right, rgba(0,0,0,0.04) 1px, transparent 1px),linear-gradient(to bottom, rgba(0,0,0,0.04) 1px, transparent 1px);background-size:30px 30px"></div>
    <div class="absolute top-0 left-1/2 pointer-events-none" style="transform:translateX(-50%);width:600px;height:600px;background:rgba(0,174,239,0.06);border-radius:50%;filter:blur(120px)"></div>
    <div class="w-full mx-auto px-[var(--container-padding)] max-w-[var(--container-max)] relative" style="z-index:10">
        <div class="text-center max-w-2xl mx-auto" style="display:flex;flex-direction:column;align-items:center;gap:2rem">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full" style="background:rgba(0,174,239,0.08);border:1px solid rgba(0,174,239,0.2)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#00AEEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>
                <span class="text-sm font-medium" style="color:#00AEEF">{{ __('blog/index.text_7') }}</span>
            </div>
            <h2 class="font-heading tracking-tight text-3xl md:text-4xl lg:text-5xl font-bold leading-tight" style="font-family:var(--font-display);color:#0F0F0F">
                NE MANQUEZ AUCUN ARTICLE
            </h2>
            <p class="max-w-xl mx-auto text-lg" style="color:rgba(15,15,15,0.6)">{{ __('blog/index.ml_513') }}</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-lg mx-auto" style="width:100%">
                <input type="email" placeholder="{{ __('blog/index.placeholder_9') }}" class="w-full sm:flex-1 h-12 px-6 rounded-full text-sm transition-all" style="background:white;border:1px solid rgba(15,15,15,0.15);color:#0F0F0F;outline:none" />
                <button class="w-full sm:w-auto h-12 px-8 text-base rounded-full inline-flex items-center justify-center font-medium transition-all duration-200 gap-2" style="background:linear-gradient(to right, var(--color-primary-orange), var(--color-orange-hover));color:white;box-shadow:0 4px 16px rgba(0,174,239,0.25)">
                    S'abonner
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                </button>
            </div>
            <p class="text-xs" style="color:rgba(15,15,15,0.45)">{{ __('blog/index.text_8') }}</p>
        </div>
    </div>

    @php
    $tagsRow1 = ['Développement Web', 'Laravel', 'UI/UX Design', 'SEO', 'React', 'E-commerce', 'SaaS', 'Marketing Digital'];
    $tagsRow2 = ['Next.js', 'WordPress', 'Performance Web', 'Accessibilité', 'TypeScript', 'Tailwind CSS', 'Node.js', 'API REST'];
    @endphp
    <div class="mt-16 relative" style="overflow:hidden;mask-image:linear-gradient(to right, transparent, black 10%, black 90%, transparent);-webkit-mask-image:linear-gradient(to right, transparent, black 10%, black 90%, transparent)">
        {{-- Row 1 - scrolls left --}}
        <div style="display:flex;gap:12px;width:max-content;animation:blog-marquee-left 35s linear infinite;padding-bottom:12px">
            @for($i = 0; $i < 3; $i++)
                @foreach($tagsRow1 as $tag)
                <span style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:9999px;border:1px solid rgba(15,15,15,0.1);color:rgba(15,15,15,0.45);font-size:13px;white-space:nowrap;background:white">
                    <span style="width:6px;height:6px;border-radius:50%;background:#00AEEF;display:inline-block;flex-shrink:0"></span>
                    {{ $tag }}
                </span>
                @endforeach
            @endfor
        </div>
        {{-- Row 2 - scrolls right --}}
        <div style="display:flex;gap:12px;width:max-content;animation:blog-marquee-right 40s linear infinite">
            @for($i = 0; $i < 3; $i++)
                @foreach($tagsRow2 as $tag)
                <span style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:9999px;border:1px dashed rgba(15,15,15,0.12);color:rgba(15,15,15,0.4);font-size:13px;white-space:nowrap;background:rgba(255,255,255,0.6)">
                    <span style="width:6px;height:6px;border-radius:50%;border:1.5px solid rgba(0,174,239,0.4);display:inline-block;flex-shrink:0"></span>
                    {{ $tag }}
                </span>
                @endforeach
            @endfor
        </div>
    </div>
    <style>
        @keyframes blog-marquee-left { 0%{transform:translateX(0)} 100%{transform:translateX(-33.333%)} }
        @keyframes blog-marquee-right { 0%{transform:translateX(-33.333%)} 100%{transform:translateX(0)} }
    </style>
</section>
@endsection
