@extends('frontoffice.layouts.app')

@section('title', __('tools/utm-builder.title'))
@section('meta_description', __('tools/utm-builder.meta_description'))
@section('meta_keywords', __('tools/utm-builder.meta_keywords'))
@section('og_title', __('tools/utm-builder.og_title'))
@section('og_description', __('tools/utm-builder.og_description'))
@section('twitter_description', __('tools/utm-builder.twitter_description'))

@section('content')
    <section class="relative overflow-hidden pt-28 pb-16 bg-white">
        <div class="absolute inset-0 pointer-events-none" style="z-index:0">
            <div class="absolute inset-0 w-full h-full"
                style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);background-size:30px 30px;background-position:center center">
            </div>
            <div class="absolute inset-0 w-full h-full"
                style="background:radial-gradient(
            ellipse 70% 70% at center,
            transparent 0%,
            transparent 10%,
            rgba(255, 255, 255, 0.1425) 25%,
            rgba(255, 255, 255, 0.33249999999999996) 40%,
            rgba(255, 255, 255, 0.57) 60%,
            rgba(255, 255, 255, 0.8075) 80%,
            rgba(255, 255, 255, 0.95) 100%
          )">
            </div>
        </div>
        <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
            <nav class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-8"><a
                    class="hover:text-[#00AEEF] transition-colors" href="/">Accueil</a><span>/</span><a
                    class="hover:text-[#00AEEF] transition-colors" href="/tools">Outils</a><span>/</span><span
                    class="text-black font-medium">{{ __('tools/utm-builder.text_0') }}</span></nav>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-4 leading-tight">
                    {{ __('tools/utm-builder.text_1') }}</h1>
                <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    {{ __('tools/utm-builder.text_2') }}</p>
            </div>
            <div
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-50 border border-green-200 rounded-full text-sm">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <div class="absolute inset-0 w-2 h-2 bg-green-500 rounded-full animate-ping opacity-75"></div>
                </div><span class="text-green-700 font-medium">{{ __('tools/utm-builder.text_3') }}</span>
            </div>
        </div>
    </section>
    <section class="max-w-5xl mx-auto px-4 py-12">
        <div class="space-y-8">
            <div id="utm-form-card" class="bg-white rounded-2xl border-2 border-gray-200 p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('tools/utm-builder.text_4') }}</h3>
                <div class="space-y-6">
                    <div class="space-y-2"><label
                            class="block text-sm font-medium text-black">{{ __('tools/utm-builder.label_148') }}<span
                                class="text-[#00AEEF] ml-1">*</span></label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-link2 lucide-link-2 w-5 h-5"
                                    aria-hidden="true">
                                    <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                    <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                    <line x1="8" x2="16" y1="12" y2="12"></line>
                                </svg></div><input type="url" id="utm-url" placeholder="https://example.com/page" required=""
                                class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60 pl-11"
                                value="" />
                        </div>
                        <p class="text-sm text-gray-500">{{ __('tools/utm-builder.text_5') }}</p>
                    </div>
                    <div class="space-y-4">
                        <p class="text-sm font-medium text-gray-900">{{ __('tools/utm-builder.text_6') }}</p>
                        <div class="space-y-2"><label
                                class="block text-sm font-medium text-black">{{ __('tools/utm-builder.label_149') }}<span
                                    class="text-[#00AEEF] ml-1">*</span></label>
                            <div class="relative"><input type="text" id="utm-source" placeholder="google" required=""
                                    class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60"
                                    value="" /></div>
                            <p class="text-sm text-gray-500">{{ __('tools/utm-builder.text_7') }}</p>
                        </div>
                        <div class="space-y-2"><label
                                class="block text-sm font-medium text-black">{{ __('tools/utm-builder.label_150') }}<span
                                    class="text-[#00AEEF] ml-1">*</span></label>
                            <div class="relative"><input type="text" id="utm-medium" placeholder="cpc" required=""
                                    class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60"
                                    value="" /></div>
                            <p class="text-sm text-gray-500">{{ __('tools/utm-builder.text_154') }}</p>
                        </div>
                        <div class="space-y-2"><label
                                class="block text-sm font-medium text-black">{{ __('tools/utm-builder.label_151') }}<span
                                    class="text-[#00AEEF] ml-1">*</span></label>
                            <div class="relative"><input type="text" id="utm-campaign" placeholder="summer_sale" required=""
                                    class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60"
                                    value="" /></div>
                            <p class="text-sm text-gray-500">{{ __('tools/utm-builder.text_155') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <p class="text-sm font-medium text-gray-900">{{ __('tools/utm-builder.text_8') }}</p>
                        <div class="space-y-2"><label
                                class="block text-sm font-medium text-black">{{ __('tools/utm-builder.label_152') }}</label>
                            <div class="relative"><input type="text" id="utm-term" placeholder="ai+websites"
                                    class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60"
                                    value="" /></div>
                            <p class="text-sm text-gray-500">{{ __('tools/utm-builder.text_9') }}</p>
                        </div>
                        <div class="space-y-2"><label
                                class="block text-sm font-medium text-black">{{ __('tools/utm-builder.label_153') }}</label>
                            <div class="relative"><input type="text" id="utm-content" placeholder="ad_variant_1"
                                    class="h-12 w-full px-4 rounded-lg bg-white border border-gray-200 text-black placeholder:text-gray-400 transition-all duration-200 focus:border-[#00AEEF] focus:ring-2 focus:ring-[#00AEEF]/20 focus:outline-none disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-60"
                                    value="" /></div>
                            <p class="text-sm text-gray-500">{{ __('tools/utm-builder.text_10') }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-900 mb-3">{{ __('tools/utm-builder.text_11') }}</p>
                        <div class="flex flex-wrap gap-2"><button type="button" data-utm-preset
                                data-utm-source="google" data-utm-medium="cpc" data-utm-campaign="google_ads"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">Campagne
                                Google Ads</button><button type="button" data-utm-preset
                                data-utm-source="newsletter" data-utm-medium="email" data-utm-campaign="newsletter"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">{{ __('tools/utm-builder.text_12') }}</button><button type="button" data-utm-preset
                                data-utm-source="facebook" data-utm-medium="social" data-utm-campaign="social_post"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">{{ __('tools/utm-builder.text_13') }}</button>
                        </div>
                    </div>
                    <div class="flex gap-3"><button id="utm-generate-btn" type="button"
                            class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] bg-gradient-to-r from-[var(--color-primary-orange)] to-[var(--color-orange-hover)] text-white shadow-[0_8px_20px_rgba(0,174,239,0.3),0_4px_10px_rgba(0,174,239,0.2)] hover:-translate-y-0.5 hover:shadow-[0_12px_30px_rgba(0,174,239,0.4),0_6px_15px_rgba(0,174,239,0.3)] active:translate-y-0 active:shadow-[0_4px_15px_rgba(0,174,239,0.3)] h-10 px-6 text-base rounded-full flex-1"
                            tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link-2 mr-2 h-4 w-4"
                                aria-hidden="true">
                                <path d="M9 17H7A5 5 0 0 1 7 7h2"></path>
                                <path d="M15 7h2a5 5 0 1 1 0 10h-2"></path>
                                <line x1="8" x2="16" y1="12" y2="12"></line>
                            </svg>{{ __('tools/utm-builder.action_generate') }}</button><button id="utm-reset-btn" type="button"
                            class="inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer disabled:pointer-events-none disabled:opacity-50 relative overflow-hidden transform-gpu focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--focus-ring)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--bg-primary)] border border-[var(--border-default)] text-[var(--text-primary)] bg-transparent hover:border-[var(--color-primary-orange)] hover:text-[var(--color-primary-orange)] hover:bg-[var(--hover-primary)] h-10 px-6 text-base rounded-full flex-1"
                            tabindex="0">{{ __('tools/utm-builder.text_14') }}</button></div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('tools/utm-builder.text_15') }}</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('tools/utm-builder.text_16') }}</p>
                        <p class="text-sm text-gray-700 leading-relaxed">UTM parameters are tags you add to URLs to track
                            the effectiveness of marketing campaigns in Google Analytics. They help you identify which
                            campaigns, sources, and content drive the most traffic and conversions.</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('tools/utm-builder.text_17') }}</p>
                        <div class="space-y-2">
                            <div class="p-3 bg-white rounded-lg border border-gray-200">
                                <p class="text-sm font-medium text-gray-900">utm_source (Required)</p>
                                <p class="text-xs text-gray-600">{{ __('tools/utm-builder.text_156') }}</p>
                            </div>
                            <div class="p-3 bg-white rounded-lg border border-gray-200">
                                <p class="text-sm font-medium text-gray-900">utm_medium (Required)</p>
                                <p class="text-xs text-gray-600">{{ __('tools/utm-builder.text_157') }}</p>
                            </div>
                            <div class="p-3 bg-white rounded-lg border border-gray-200">
                                <p class="text-sm font-medium text-gray-900">utm_campaign (Required)</p>
                                <p class="text-xs text-gray-600">{{ __('tools/utm-builder.text_158') }}</p>
                            </div>
                            <div class="p-3 bg-white rounded-lg border border-gray-200">
                                <p class="text-sm font-medium text-gray-900">utm_term (Optional)</p>
                                <p class="text-xs text-gray-600">{{ __('tools/utm-builder.text_18') }}</p>
                            </div>
                            <div class="p-3 bg-white rounded-lg border border-gray-200">
                                <p class="text-sm font-medium text-gray-900">utm_content (Optional)</p>
                                <p class="text-xs text-gray-600">{{ __('tools/utm-builder.text_19') }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 mb-2">Meilleures Pratiques</p>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span>{{ __('tools/utm-builder.text_20') }}</span>
                            </li>
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span>{{ __('tools/utm-builder.text_21') }}</span>
                            </li>
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span>{{ __('tools/utm-builder.text_22') }}</span>
                            </li>
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span>{{ __('tools/utm-builder.text_23') }}</span>
                            </li>
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span>{{ __('tools/utm-builder.text_24') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 mb-2">Cas d'Utilisation Courants</p>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span><strong>Email campaigns:</strong> Track
                                    which emails drive traffic (source=newsletter, medium=email)</span></li>
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span><strong>Paid ads:</strong> Measure ROI
                                    for Google Ads, Facebook Ads (source=google, medium=cpc)</span></li>
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span><strong>Social media:</strong> Compare
                                    performance across platforms (source=linkedin, medium=social)</span></li>
                            <li class="flex items-start gap-2"><span
                                    class="text-[#00AEEF] font-bold">•</span><span><strong>Banner ads:</strong> Track
                                    display advertising effectiveness (medium=banner)</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-6 md:p-8">
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-question-mark w-5 h-5 text-[#00AEEF]" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <path d="M12 17h.01"></path>
                        </svg>
                        <h3 class="text-xl md:text-2xl font-bold text-black">{{ __('tools/utm-builder.text_25') }}</h3>
                    </div>
                    <p class="text-sm md:text-base text-gray-600">{{ __('tools/utm-builder.text_26') }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4 md:p-6">
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">1</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/utm-builder.text_27') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>UTM parameters are tags added to URLs that help track the performance of marketing campaigns
                                in Google Analytics. They allow you to see exactly where your traffic comes from, which
                                campaigns are most effective, and which content drives the most conversions. This data is
                                essential for optimizing your marketing spend and strategy.</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">2</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/utm-builder.text_28') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>Three parameters are required: utm_source (identifies traffic source like 'google'),
                                utm_medium (identifies marketing channel like 'cpc' or 'email'), and utm_campaign
                                (identifies the specific campaign like 'summer_sale'). Two are optional: utm_term (for paid
                                search keywords) and utm_content (to differentiate similar ads or links).</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">3</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/utm-builder.text_29') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>Always use lowercase letters and replace spaces with underscores (e.g., 'summer_sale' not
                                'Summer Sale'). Be consistent across all campaigns-decide on a naming structure and stick to
                                it. Avoid special characters and keep names descriptive but concise. Document your
                                conventions so your entire team uses the same standards.</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">4</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/utm-builder.text_30') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>When someone clicks a URL with UTM parameters, Google Analytics automatically captures those
                                parameters and organizes your traffic data by source, medium, and campaign. You can view
                                this data in the Acquisition reports to analyze campaign performance, compare traffic
                                sources, and measure ROI on your marketing efforts.</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">5</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/utm-builder.text_31') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>Yes, it's highly recommended to use URL shorteners like Bitly or TinyURL for UTM-tagged URLs,
                                especially for social media and printed materials. Long URLs with multiple parameters look
                                unprofessional and may get truncated. URL shorteners preserve all tracking parameters while
                                making links clean and shareable.</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">6</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/utm-builder.text_32') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>Avoid inconsistent naming (using both 'Facebook' and 'facebook'), using spaces instead of
                                underscores, adding UTM parameters to internal links (this breaks your analytics),
                                forgetting to encode special characters, and creating URLs longer than 2000 characters.
                                Always test your URLs before launching campaigns to ensure tracking works correctly.</p>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 last:border-0"><button
                            class="w-full py-6 flex items-start gap-4 text-left hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors duration-200">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#00AEEF]/10 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-[#00AEEF]">7</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg font-semibold text-black">
                                    {{ __('tools/utm-builder.text_33') }}</h3>
                            </div>
                            <div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down w-5 h-5 text-gray-400" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg></div>
                        </button>
                        <div class="faq-answer hidden px-4 pb-6 text-sm text-gray-700 leading-relaxed"
                            style="padding-left:3.5rem">
                            <p>Absolutely! UTM parameters work for any traffic source, not just paid ads. Use them for email
                                newsletters (medium=email), organic social posts (medium=social), blog guest posts
                                (medium=referral), QR codes (medium=qr_code), and any other marketing channel. This gives
                                you complete visibility into all your traffic sources, not just paid campaigns.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('tools/utm-builder.text_34') }}</p><a href="/contact"
                        class="text-[#00AEEF] font-semibold hover:underline inline-flex items-center gap-2 text-sm md:text-base">{{ __('tools/utm-builder.text_35') }}<svg
                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg></a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-black mb-3" style="font-family:var(--font-heading)">
                    {{ __('tools/utm-builder.text_36') }}</h2>
                <p class="text-gray-600 text-lg">{{ __('tools/utm-builder.text_37') }}</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mb-8"><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/og-preview-generator">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-eye w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path
                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                </path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">{{ __('tools/utm-builder.text_38') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/utm-builder.text_39') }}</p>
                    <div
                        class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"
                            aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="absolute top-4 right-4"><span
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span>
                    </div>
                </a><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/heading-analyzer">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-list w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M3 5h.01"></path>
                                <path d="M3 12h.01"></path>
                                <path d="M3 19h.01"></path>
                                <path d="M8 5h13"></path>
                                <path d="M8 12h13"></path>
                                <path d="M8 19h13"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">{{ __('tools/utm-builder.text_40') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/utm-builder.text_41') }}</p>
                    <div
                        class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"
                            aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="absolute top-4 right-4"><span
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span>
                    </div>
                </a><a
                    class="group relative bg-white rounded-xl border border-gray-200 p-6 hover:border-[#00AEEF] hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    href="/tools/keyword-density-analyzer">
                    <div class="mb-4">
                        <div class="inline-flex p-3 rounded-xl bg-[#00AEEF]/10 group-hover:bg-[#00AEEF] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-chart-column w-6 h-6 text-[#00AEEF] group-hover:text-white transition-colors"
                                aria-hidden="true">
                                <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                <path d="M18 17V9"></path>
                                <path d="M13 17V5"></path>
                                <path d="M8 17v-3"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-black mb-2 group-hover:text-[#00AEEF] transition-colors"
                        style="font-family:var(--font-heading)">{{ __('tools/utm-builder.text_42') }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('tools/utm-builder.text_43') }}</p>
                    <div
                        class="flex items-center gap-2 text-[#00AEEF] font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Essayez gratuitement</span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"
                            aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                    <div class="absolute top-4 right-4"><span
                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">seo</span>
                    </div>
                </a></div>
            <div class="text-center"><a
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-[#00AEEF] text-[#00AEEF] rounded-full font-semibold hover:bg-[#00AEEF] hover:text-white transition-colors"
                    href="/tools">{{ __('tools/utm-builder.text_44') }} <!-- -->41<!-- --> Outils Gratuits<svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg></a></div>
        </div>
    </section>
    <section class="py-12 bg-[#F5F5F5]">
        <div class="max-w-5xl mx-auto px-4">
            <div class="relative overflow-hidden rounded-2xl px-6 py-8 md:py-10"
                style="background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%)">
                <div class="absolute inset-0 z-0"
                    style="background-image:linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
                                 linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);background-size:50px 50px">
                </div>
                <div class="absolute inset-0 z-[1]"
                    style="background:radial-gradient(
                  ellipse 70% 70% at center,
                  transparent 0%,
                  rgba(10, 10, 10, 0.3) 50%,
                  rgba(10, 10, 10, 0.8) 100%
                )">
                </div>
                <div class="relative z-10 text-center space-y-6">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight text-white"
                        style="font-family:var(--font-display)">{{ __('tools/utm-builder.text_45') }}</h2>
                    <p class="text-base md:text-lg text-white/70 max-w-2xl mx-auto">{{ __('tools/utm-builder.text_46') }}
                    </p>
                    <div class="pt-2"><a target="_blank" rel="noopener noreferrer"
                            class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-full overflow-hidden transition-transform hover:scale-105"
                            style="background-color:rgba(0, 0, 0, 0.11);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.067) 0px 2.51941px 2.51941px -0.46875px,
                      rgba(0, 0, 0, 0.067) 0px 5.97144px 5.97144px -0.9375px,
                      rgba(0, 0, 0, 0.063) 0px 10.8925px 10.8925px -1.40625px,
                      rgba(0, 0, 0, 0.063) 0px 18.1088px 18.1088px -1.875px"
                            data-cal-link="code-sommet/new-client-meeting" data-cal-namespace="new-client-meeting"
                            data-cal-config='{"layout":"month_view","useSlotsViewOnSmallScreen":"true"}' href="#">
                            <div class="absolute inset-[3px] rounded-[114px] bg-white z-0"></div><span
                                class="relative z-10 text-base md:text-lg font-medium tracking-tight text-black"
                                style="font-family:Inter, sans-serif;font-weight:500;letter-spacing:-0.04em">{{ __('tools/utm-builder.text_47') }}</span>
                        </a></div>
                    <p class="text-sm text-white/50 pt-2">{{ __('tools/utm-builder.text_48') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/tools-common.js') }}" defer></script>
    <script src="{{ asset('js/tools/utm-builder.js') }}" defer></script>
@endpush
