@extends('layouts.app')

@section('title', 'Get a Free Quote | CodeSommet')
@section('meta_description', 'Tell us about your project and get a custom quote within 24 hours. Free quote, no obligation, custom pricing for websites, dashboards, and SaaS platforms.')
@section('meta_keywords', 'web development Morocco, AI web development agency, Next.js development agency, dashboard development, SaaS development, education website development, healthcare website development, React development Morocco, TypeScript development, web development worldwide, AI chatbot integration, custom dashboard design, web agency Morocco')
@section('og_title', 'Get a Free Quote | CodeSommet')
@section('og_description', 'Tell us about your project and get a custom quote within 24 hours. Free quote, no obligation, custom pricing for websites, dashboards, and SaaS platforms.')
@section('twitter_description', 'Tell us about your project and get a custom quote within 24 hours. Free quote, no obligation, custom pricing for websites, dashboards, and SaaS platforms.')

@section('content')
<div class="min-h-screen bg-[#F5F5F5] flex flex-col">
<div class="flex-1 flex flex-col items-center px-4 py-8 sm:py-12">

{{-- Header --}}
<div class="text-center mb-6 sm:mb-8 max-w-lg" id="quoteHeader" style="opacity:0;transform:translateY(10px)">
    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[var(--text-primary)] mb-3" style="font-family:var(--font-display)">Get a Free Quote</h1>
    <p class="text-sm sm:text-base text-[var(--text-secondary)]">Tell us about your project and we&#x27;ll provide a custom quote based on your needs.</p>
    <div class="flex items-center justify-center gap-4 sm:gap-6 mt-4">
        <div class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gift w-3.5 h-3.5 text-[#00AEEF]" aria-hidden="true"><rect x="3" y="8" width="18" height="4" rx="1"></rect><path d="M12 8v13"></path><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path></svg>
            <span class="text-xs text-[var(--text-secondary)]">Free quote</span>
        </div>
        <div class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5 text-[#00AEEF]" aria-hidden="true"><path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle></svg>
            <span class="text-xs text-[var(--text-secondary)]">24h response</span>
        </div>
        <div class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield w-3.5 h-3.5 text-[#00AEEF]" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
            <span class="text-xs text-[var(--text-secondary)]">No obligation</span>
        </div>
        <div class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag w-3.5 h-3.5 text-[#00AEEF]" aria-hidden="true"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"></path><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"></circle></svg>
            <span class="text-xs text-[var(--text-secondary)]">Custom pricing</span>
        </div>
    </div>
</div>

<div class="w-full max-w-2xl">
<div class="bg-white rounded-xl p-5 sm:p-7 shadow-lg border border-gray-100" id="quoteCard" style="opacity:0;transform:translateY(20px)">

    {{-- Step Indicator --}}
    <div class="mb-6">
        <div class="flex items-center justify-between max-w-xs mx-auto">
            {{-- Step 1 indicator --}}
            <div class="flex flex-col items-center relative" id="stepIndicator1">
                <div class="absolute top-3.5 left-[calc(50%+14px)] h-[2px]" id="stepLine1" style="width:calc(100% + 32px);background-color:#E5E7EB"></div>
                <div class="relative z-10 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 bg-[#00AEEF] text-white ring-[3px] ring-[#00AEEF]/20" id="stepBadge1">1</div>
                <span class="mt-1.5 text-[10px] font-medium text-[#00AEEF]" id="stepLabel1">About You</span>
            </div>
            {{-- Step 2 indicator --}}
            <div class="flex flex-col items-center relative" id="stepIndicator2">
                <div class="absolute top-3.5 left-[calc(50%+14px)] h-[2px]" id="stepLine2" style="width:calc(100% + 32px);background-color:#E5E7EB"></div>
                <div class="relative z-10 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 bg-gray-100 text-gray-400 border border-gray-200" id="stepBadge2">2</div>
                <span class="mt-1.5 text-[10px] font-medium text-gray-400" id="stepLabel2">Your Project</span>
            </div>
            {{-- Step 3 indicator --}}
            <div class="flex flex-col items-center relative" id="stepIndicator3">
                <div class="relative z-10 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 bg-gray-100 text-gray-400 border border-gray-200" id="stepBadge3">3</div>
                <span class="mt-1.5 text-[10px] font-medium text-gray-400" id="stepLabel3">Details</span>
            </div>
        </div>
    </div>

    <form id="quoteForm" onsubmit="return false;">
        <div class="overflow-hidden min-h-[280px]" id="stepsContainer">

            {{-- STEP 1: About You --}}
            <div class="space-y-3.5 quote-step" id="step1" style="opacity:1;transform:translateX(0)">
                <div>
                    <label for="fullName" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Full Name <span class="text-[#00AEEF]">*</span></label>
                    <input type="text" id="fullName" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350" style="border-radius:8px" placeholder="John Doe" name="fullName" value=""/>
                    <p class="mt-1 text-xs text-red-500 hidden" id="error-fullName"></p>
                </div>
                <div>
                    <label for="email" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Email Address <span class="text-[#00AEEF]">*</span></label>
                    <input type="email" id="email" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350" style="border-radius:8px" placeholder="john@company.com" name="email" value=""/>
                    <p class="mt-1 text-xs text-red-500 hidden" id="error-email"></p>
                </div>
                <div class="grid sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="phone" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Phone / WhatsApp <span class="text-[#00AEEF]">*</span></label>
                        <input type="tel" id="phone" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350" style="border-radius:8px" placeholder="+1 (555) 000-0000" name="phone" value=""/>
                        <p class="mt-1 text-xs text-red-500 hidden" id="error-phone"></p>
                    </div>
                    <div>
                        <label for="companyName" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Company / Brand Name <span class="text-[#00AEEF]">*</span></label>
                        <input type="text" id="companyName" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350" style="border-radius:8px" placeholder="Acme Corp" name="companyName" value=""/>
                        <p class="mt-1 text-xs text-red-500 hidden" id="error-companyName"></p>
                    </div>
                </div>
            </div>

            {{-- STEP 2: Your Project --}}
            <div class="space-y-3.5 quote-step" id="step2" style="display:none;opacity:0;transform:translateX(200px)">
                <div>
                    <label for="referenceWebsite1" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Reference Website 1 <span class="text-[#00AEEF]">*</span></label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-350"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
                        <input type="url" id="referenceWebsite1" name="referenceWebsite1" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350 pl-10" style="border-radius:8px" placeholder="https://example.com" value=""/>
                    </div>
                    <p class="mt-1 text-xs text-[var(--text-secondary)]">A website whose design or functionality you admire</p>
                    <p class="mt-1 text-xs text-red-500 hidden" id="error-referenceWebsite1"></p>
                </div>
                <div>
                    <label for="referenceWebsite2" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Reference Website 2 (Optional)</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-350"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
                        <input type="url" id="referenceWebsite2" name="referenceWebsite2" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350 pl-10" style="border-radius:8px" placeholder="https://another-example.com" value=""/>
                    </div>
                    <p class="mt-1 text-xs text-red-500 hidden" id="error-referenceWebsite2"></p>
                </div>
                <div class="grid sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="projectType" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Project Type</label>
                        <select id="projectType" name="projectType" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150" style="border-radius:8px">
                            <option value="">Select type</option>
                            <option value="New Website">New Website</option>
                            <option value="Website Redesign">Website Redesign</option>
                            <option value="Web Application">Web Application</option>
                            <option value="E-commerce Store">E-commerce Store</option>
                            <option value="SaaS Platform">SaaS Platform</option>
                            <option value="Landing Page">Landing Page</option>
                            <option value="Dashboard">Dashboard</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="industry" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Industry</label>
                        <select id="industry" name="industry" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150" style="border-radius:8px">
                            <option value="">Select industry</option>
                            <option value="Education / EdTech">Education / EdTech</option>
                            <option value="Healthcare / Medical">Healthcare / Medical</option>
                            <option value="Study Abroad / Immigration">Study Abroad / Immigration</option>
                            <option value="SaaS / B2B Software">SaaS / B2B Software</option>
                            <option value="E-commerce / Retail">E-commerce / Retail</option>
                            <option value="FinTech / Finance">FinTech / Finance</option>
                            <option value="Real Estate">Real Estate</option>
                            <option value="Travel / Hospitality">Travel / Hospitality</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="currentWebsite" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Current Website URL</label>
                        <input type="url" id="currentWebsite" name="currentWebsite" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350" style="border-radius:8px" placeholder="https://yoursite.com" value=""/>
                        <p class="mt-1 text-xs text-red-500 hidden" id="error-currentWebsite"></p>
                    </div>
                    <div>
                        <label for="estimatedPages" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Estimated Pages</label>
                        <select id="estimatedPages" name="estimatedPages" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150" style="border-radius:8px">
                            <option value="">Select range</option>
                            <option value="1-5 pages">1-5 pages</option>
                            <option value="6-10 pages">6-10 pages</option>
                            <option value="11-20 pages">11-20 pages</option>
                            <option value="20+ pages">20+ pages</option>
                            <option value="Not sure">Not sure</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- STEP 3: Details --}}
            <div class="space-y-3.5 quote-step" id="step3" style="display:none;opacity:0;transform:translateX(200px)">
                <div>
                    <label class="block text-xs font-medium text-[var(--text-primary)] mb-2">Key Features Needed</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" id="featuresGrid">
                        @php
                        $features = ['AI Chatbot','Blog/CMS','E-commerce','Contact Forms','SEO','Analytics','Multi-language','Payment Integration','User Auth','Admin Dashboard','Custom API','Booking System'];
                        @endphp
                        @foreach($features as $feature)
                        <button type="button" onclick="toggleFeature(this)" data-feature="{{ $feature }}" class="feature-btn flex items-center gap-1.5 px-2.5 py-1.5 border text-xs font-medium transition-all duration-150 border-gray-200 bg-white text-gray-600 hover:border-gray-300" style="border-radius:6px">
                            <div class="w-3.5 h-3.5 rounded flex-shrink-0 flex items-center justify-center transition-colors bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-2.5 h-2.5 text-white hidden"><path d="M20 6 9 17l-5-5"></path></svg>
                            </div>
                            <span class="truncate">{{ $feature }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Brief Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350 resize-none" style="border-radius:8px" placeholder="Tell us about your project goals, target audience, or any specific requirements..."></textarea>
                </div>
                <div class="grid sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="budgetRange" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Budget Range</label>
                        <select id="budgetRange" name="budgetRange" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150" style="border-radius:8px">
                            <option value="">Select budget range</option>
                            <option value="Starter (Small Project)">Starter (Small Project)</option>
                            <option value="Growth (Medium Project)">Growth (Medium Project)</option>
                            <option value="Scale (Large Project)">Scale (Large Project)</option>
                            <option value="Enterprise (Custom)">Enterprise (Custom)</option>
                            <option value="Not sure yet">Not sure yet</option>
                        </select>
                        <p class="mt-1 text-xs text-[var(--text-secondary)]">We'll provide a custom quote based on your needs</p>
                    </div>
                    <div>
                        <label for="startTimeline" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">When do you want to start?</label>
                        <select id="startTimeline" name="startTimeline" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150" style="border-radius:8px">
                            <option value="">Select timeline</option>
                            <option value="ASAP">ASAP</option>
                            <option value="Within 2 weeks">Within 2 weeks</option>
                            <option value="Within 1 month">Within 1 month</option>
                            <option value="1-3 months">1-3 months</option>
                            <option value="Just exploring">Just exploring</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="howFoundUs" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">How did you find us?</label>
                    <select id="howFoundUs" name="howFoundUs" class="w-full px-3.5 py-2 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150" style="border-radius:8px">
                        <option value="">Select option</option>
                        <option value="Google Search">Google Search</option>
                        <option value="Social Media">Social Media</option>
                        <option value="Referral">Referral</option>
                        <option value="LinkedIn">LinkedIn</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Clutch / Directory">Clutch / Directory</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

        </div>

        {{-- Error banner --}}
        <div class="mt-3 p-3 bg-red-50 border border-red-200 hidden" id="submitError" style="border-radius:8px">
            <p class="text-xs text-red-600" id="submitErrorText"></p>
        </div>

        {{-- Navigation buttons --}}
        <div class="flex items-center justify-between mt-6">
            <div id="backBtnContainer">
                {{-- Back button (hidden on step 1) --}}
            </div>
            <div id="nextBtnContainer">
                <button type="button" id="nextBtn" onclick="goNext()" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-white text-sm font-medium transition-all duration-200" style="background-color:#00AEEF;box-shadow:0 3px 12px rgba(0, 174, 239, 0.25)">Next<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3.5 h-3.5" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></button>
            </div>
        </div>

        <p class="text-[11px] text-center text-[var(--text-secondary)] mt-4">By submitting this form, you agree to our <a href="{{ url('privacy-policy') }}" class="text-[#00AEEF] hover:text-[#0071BC] underline">Privacy Policy</a></p>
    </form>

    {{-- Success message (hidden by default) --}}
    <div id="successMessage" class="hidden text-center py-4">
        <div class="w-14 h-14 rounded-full bg-[#22C55E]/10 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-[#22C55E]"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
        </div>
        <h3 class="text-lg sm:text-xl font-bold text-[var(--text-primary)] mb-2">Quote Request Submitted!</h3>
        <p class="text-sm text-[var(--text-secondary)] mb-5">We'll review your project details and get back to you within 24 hours with a custom quote tailored to your needs.</p>
        <button onclick="resetForm()" class="inline-flex items-center gap-2 px-5 py-2 bg-[#00AEEF] text-white rounded-full text-sm font-medium hover:bg-[#0071BC] transition-colors">Submit Another Request</button>
    </div>

</div>
</div>

</div>
</div>

<script>
(function() {
    // Animate in header and card
    var header = document.getElementById('quoteHeader');
    var card = document.getElementById('quoteCard');
    if (header) {
        setTimeout(function() {
            header.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            header.style.opacity = '1';
            header.style.transform = 'translateY(0)';
        }, 100);
    }
    if (card) {
        setTimeout(function() {
            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 200);
    }
    // Animate step 1 in
    var step1 = document.getElementById('step1');
    if (step1) {
        setTimeout(function() {
            step1.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
            step1.style.opacity = '1';
            step1.style.transform = 'translateX(0)';
        }, 350);
    }
})();

var currentStep = 1;
var selectedFeatures = [];
var checkSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M20 6 9 17l-5-5"></path></svg>';

function isValidURL(str) {
    try {
        var url = new URL(str);
        return url.protocol === 'http:' || url.protocol === 'https:';
    } catch (e) {
        return false;
    }
}

function clearErrors() {
    document.querySelectorAll('[id^="error-"]').forEach(function(el) {
        el.classList.add('hidden');
        el.textContent = '';
    });
    // Reset error styling on inputs
    document.querySelectorAll('#quoteForm input, #quoteForm select, #quoteForm textarea').forEach(function(el) {
        el.classList.remove('border-red-400', 'bg-red-50/50');
    });
}

function showError(fieldId, message) {
    var errorEl = document.getElementById('error-' + fieldId);
    var inputEl = document.getElementById(fieldId);
    if (errorEl) {
        errorEl.textContent = message;
        errorEl.classList.remove('hidden');
    }
    if (inputEl) {
        inputEl.classList.add('border-red-400');
    }
}

function validateStep(step) {
    clearErrors();
    var valid = true;

    if (step === 1) {
        var fullName = document.getElementById('fullName').value.trim();
        var email = document.getElementById('email').value.trim();
        var phone = document.getElementById('phone').value.trim();
        var companyName = document.getElementById('companyName').value.trim();

        if (!fullName) { showError('fullName', 'Full name is required'); valid = false; }
        else if (fullName.length < 2) { showError('fullName', 'Name must be at least 2 characters'); valid = false; }

        if (!email) { showError('email', 'Email is required'); valid = false; }
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showError('email', 'Please enter a valid email address'); valid = false; }

        if (!phone) { showError('phone', 'Phone number is required'); valid = false; }
        else if (phone.length < 10) { showError('phone', 'Please enter a valid phone number'); valid = false; }

        if (!companyName) { showError('companyName', 'Company name is required'); valid = false; }
        else if (companyName.length < 2) { showError('companyName', 'Company name must be at least 2 characters'); valid = false; }
    }

    if (step === 2) {
        var ref1 = document.getElementById('referenceWebsite1').value.trim();
        var ref2 = document.getElementById('referenceWebsite2').value.trim();
        var currentSite = document.getElementById('currentWebsite').value.trim();

        if (!ref1) { showError('referenceWebsite1', 'At least one reference website is required'); valid = false; }
        else if (!isValidURL(ref1)) { showError('referenceWebsite1', 'Please enter a valid URL (e.g. https://example.com)'); valid = false; }

        if (ref2 && !isValidURL(ref2)) { showError('referenceWebsite2', 'Please enter a valid URL (e.g. https://example.com)'); valid = false; }
        if (currentSite && !isValidURL(currentSite)) { showError('currentWebsite', 'Please enter a valid URL'); valid = false; }
    }

    return valid;
}

function updateStepIndicators() {
    for (var i = 1; i <= 3; i++) {
        var badge = document.getElementById('stepBadge' + i);
        var label = document.getElementById('stepLabel' + i);
        var line = document.getElementById('stepLine' + i);

        if (i < currentStep) {
            // Completed step
            badge.className = 'relative z-10 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 bg-[#00AEEF] text-white';
            badge.innerHTML = checkSvg;
            label.className = 'mt-1.5 text-[10px] font-medium text-[#00AEEF]';
            if (line) line.style.backgroundColor = '#00AEEF';
        } else if (i === currentStep) {
            // Active step
            badge.className = 'relative z-10 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 bg-[#00AEEF] text-white ring-[3px] ring-[#00AEEF]/20';
            badge.textContent = i;
            label.className = 'mt-1.5 text-[10px] font-medium text-[#00AEEF]';
            if (line) line.style.backgroundColor = '#E5E7EB';
        } else {
            // Future step
            badge.className = 'relative z-10 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 bg-gray-100 text-gray-400 border border-gray-200';
            badge.textContent = i;
            label.className = 'mt-1.5 text-[10px] font-medium text-gray-400';
            if (line) line.style.backgroundColor = '#E5E7EB';
        }
    }
}

function updateButtons() {
    var backContainer = document.getElementById('backBtnContainer');
    var nextContainer = document.getElementById('nextBtnContainer');

    // Back button
    if (currentStep > 1) {
        backContainer.innerHTML = '<button type="button" onclick="goBack()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-gray-200 text-[var(--text-secondary)] text-sm font-medium hover:bg-gray-50 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>Back</button>';
    } else {
        backContainer.innerHTML = '';
    }

    // Next / Submit button
    if (currentStep < 3) {
        nextContainer.innerHTML = '<button type="button" id="nextBtn" onclick="goNext()" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-white text-sm font-medium transition-all duration-200" style="background-color:#00AEEF;box-shadow:0 3px 12px rgba(0, 174, 239, 0.25)">Next<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3.5 h-3.5" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></button>';
    } else {
        nextContainer.innerHTML = '<button type="button" id="submitBtn" onclick="submitForm()" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-white text-sm font-medium transition-all duration-200" style="background-color:#00AEEF;box-shadow:0 3px 12px rgba(0, 174, 239, 0.25)">Submit Request<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"></path><path d="m21.854 2.147-10.94 10.939"></path></svg></button>';
    }
}

function showStep(step, direction) {
    var oldStep = document.getElementById('step' + currentStep);
    var newStep = document.getElementById('step' + step);

    // Slide out current step
    oldStep.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
    oldStep.style.opacity = '0';
    oldStep.style.transform = 'translateX(' + (direction > 0 ? '-200px' : '200px') + ')';

    setTimeout(function() {
        oldStep.style.display = 'none';

        currentStep = step;
        updateStepIndicators();
        updateButtons();

        // Prepare new step off-screen
        newStep.style.display = '';
        newStep.style.opacity = '0';
        newStep.style.transform = 'translateX(' + (direction > 0 ? '200px' : '-200px') + ')';
        newStep.style.transition = 'none';

        // Force reflow
        newStep.offsetHeight;

        // Slide in new step
        newStep.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
        newStep.style.opacity = '1';
        newStep.style.transform = 'translateX(0)';
    }, 200);
}

function goNext() {
    if (!validateStep(currentStep)) return;
    if (currentStep < 3) {
        showStep(currentStep + 1, 1);
    }
}

function goBack() {
    if (currentStep > 1) {
        showStep(currentStep - 1, -1);
    }
}

function toggleFeature(btn) {
    var feature = btn.getAttribute('data-feature');
    var idx = selectedFeatures.indexOf(feature);
    var box = btn.querySelector('div');
    var svg = btn.querySelector('svg');

    if (idx > -1) {
        // Deselect
        selectedFeatures.splice(idx, 1);
        btn.className = 'feature-btn flex items-center gap-1.5 px-2.5 py-1.5 border text-xs font-medium transition-all duration-150 border-gray-200 bg-white text-gray-600 hover:border-gray-300';
        box.className = 'w-3.5 h-3.5 rounded flex-shrink-0 flex items-center justify-center transition-colors bg-gray-100';
        svg.classList.add('hidden');
    } else {
        // Select
        selectedFeatures.push(feature);
        btn.className = 'feature-btn flex items-center gap-1.5 px-2.5 py-1.5 border text-xs font-medium transition-all duration-150 border-[#00AEEF] bg-[#00AEEF]/5 text-[#00AEEF]';
        box.className = 'w-3.5 h-3.5 rounded flex-shrink-0 flex items-center justify-center transition-colors bg-[#00AEEF]';
        svg.classList.remove('hidden');
    }
}

function submitForm() {
    if (!validateStep(currentStep)) return;

    var submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.7';
    submitBtn.style.cursor = 'not-allowed';
    submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 animate-spin"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg>Submitting...';

    var data = {
        fullName: document.getElementById('fullName').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        companyName: document.getElementById('companyName').value,
        referenceWebsite1: document.getElementById('referenceWebsite1').value,
        referenceWebsite2: document.getElementById('referenceWebsite2').value || undefined,
        projectType: document.getElementById('projectType').value || undefined,
        industry: document.getElementById('industry').value || undefined,
        currentWebsite: document.getElementById('currentWebsite').value || undefined,
        estimatedPages: document.getElementById('estimatedPages').value || undefined,
        keyFeatures: selectedFeatures.length ? selectedFeatures : undefined,
        description: document.getElementById('description').value || undefined,
        budgetRange: document.getElementById('budgetRange').value || undefined,
        startTimeline: document.getElementById('startTimeline').value || undefined,
        howFoundUs: document.getElementById('howFoundUs').value || undefined
    };

    fetch('/api/get-quote', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(function(res) {
        return res.json().then(function(json) {
            if (!res.ok) throw new Error(json.error || 'Failed to submit quote request');
            // Show success
            document.getElementById('quoteForm').classList.add('hidden');
            document.getElementById('successMessage').classList.remove('hidden');
        });
    })
    .catch(function(err) {
        var errorBanner = document.getElementById('submitError');
        var errorText = document.getElementById('submitErrorText');
        errorText.textContent = err.message || 'Failed to submit. Please try again.';
        errorBanner.classList.remove('hidden');
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
        submitBtn.innerHTML = 'Submit Request<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"></path><path d="m21.854 2.147-10.94 10.939"></path></svg>';
    });
}

function resetForm() {
    document.getElementById('quoteForm').reset();
    selectedFeatures = [];
    document.querySelectorAll('.feature-btn').forEach(function(btn) {
        btn.className = 'feature-btn flex items-center gap-1.5 px-2.5 py-1.5 border text-xs font-medium transition-all duration-150 border-gray-200 bg-white text-gray-600 hover:border-gray-300';
        var box = btn.querySelector('div');
        box.className = 'w-3.5 h-3.5 rounded flex-shrink-0 flex items-center justify-center transition-colors bg-gray-100';
        btn.querySelector('svg').classList.add('hidden');
    });
    currentStep = 1;
    document.getElementById('step2').style.display = 'none';
    document.getElementById('step3').style.display = 'none';
    document.getElementById('step1').style.display = '';
    document.getElementById('step1').style.opacity = '1';
    document.getElementById('step1').style.transform = 'translateX(0)';
    updateStepIndicators();
    updateButtons();
    document.getElementById('successMessage').classList.add('hidden');
    document.getElementById('quoteForm').classList.remove('hidden');
    document.getElementById('submitError').classList.add('hidden');
    clearErrors();
}

// Clear field errors on input
document.querySelectorAll('#quoteForm input, #quoteForm select, #quoteForm textarea').forEach(function(el) {
    el.addEventListener('input', function() {
        var errorEl = document.getElementById('error-' + el.name);
        if (errorEl) {
            errorEl.classList.add('hidden');
            errorEl.textContent = '';
        }
        el.classList.remove('border-red-400');
    });
});
</script>
@endsection
