@extends('backoffice.layouts.auth')

@section('title', 'Connexion Admin | CodeSommet')

@section('content')
<div class="min-h-screen bg-[#F5F5F5] flex flex-col">

    {{-- Background grid pattern (same as get-quote & home) --}}
    <div class="absolute inset-0 pointer-events-none" style="z-index:0">
        <div class="absolute inset-0 w-full h-full" style="background-image:linear-gradient(to right, rgba(180, 180, 180, 0.2) 1px, transparent 1px),
                   linear-gradient(to bottom, rgba(180, 180, 180, 0.2) 1px, transparent 1px);
                   background-size:30px 30px;background-position:center center">
        </div>
        <div class="absolute inset-0 w-full h-full" style="background:radial-gradient(
                ellipse 70% 70% at center,
                transparent 0%,
                transparent 10%,
                rgba(245, 245, 245, 0.14) 25%,
                rgba(245, 245, 245, 0.33) 40%,
                rgba(245, 245, 245, 0.57) 60%,
                rgba(245, 245, 245, 0.81) 80%,
                rgba(245, 245, 245, 0.95) 100%
            )">
        </div>
    </div>

    <div class="flex-1 flex flex-col items-center justify-center px-4 py-8 sm:py-12 relative z-10">

        {{-- Logo --}}
        <div class="mb-6 auth-animate" style="opacity:0;transform:translateY(10px)" id="authLogo">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-14 h-14 flex items-center justify-center">
                    <img src="{{ asset('logo.svg') }}" alt="CodeSommet" class="w-full h-full object-contain" />
                </div>
                <span class="text-[var(--text-primary)] font-bold text-xl font-heading">CodeSommet</span>
            </a>
        </div>

        {{-- Header --}}
        <div class="text-center mb-6 max-w-md auth-animate" id="authHeader" style="opacity:0;transform:translateY(10px)">
            <h1 class="text-2xl sm:text-3xl font-bold text-[var(--text-primary)] mb-2" style="font-family:var(--font-display)">Espace Administration</h1>
            <p class="text-sm text-[var(--text-secondary)]">Connectez-vous pour acc&eacute;der au tableau de bord.</p>
        </div>

        {{-- Login Card --}}
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl p-5 sm:p-7 shadow-lg border border-gray-100 auth-animate" id="authCard" style="opacity:0;transform:translateY(20px)">

                {{-- Error message --}}
                @if($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-100">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 flex-shrink-0">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="m15 9-6 6"></path>
                            <path d="m9 9 6 6"></path>
                        </svg>
                        <span class="text-xs text-red-600">{{ $errors->first() }}</span>
                    </div>
                </div>
                @endif

                {{-- Success message --}}
                @if(session('status'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-100">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500 flex-shrink-0">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <path d="m9 11 3 3L22 4"></path>
                        </svg>
                        <span class="text-xs text-green-600">{{ session('status') }}</span>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4" id="loginForm">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Adresse e-mail <span class="text-[#00AEEF]">*</span></label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-350">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-3.5 py-2.5 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350 pl-10" style="border-radius:8px" placeholder="admin@codesommet.com" />
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-medium text-[var(--text-primary)] mb-1.5">Mot de passe <span class="text-[#00AEEF]">*</span></label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-350">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" id="password" name="password" required class="w-full px-3.5 py-2.5 text-sm border border-gray-200 bg-white focus:outline-none focus:ring-1 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] transition-all duration-150 placeholder:text-gray-350 pl-10 pr-10" style="border-radius:8px" placeholder="&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;" />
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-350 hover:text-gray-500 transition-colors" id="togglePasswordBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIcon">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeOffIcon" class="hidden">
                                    <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"></path>
                                    <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"></path>
                                    <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"></path>
                                    <path d="m2 2 20 20"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" id="remember" class="w-3.5 h-3.5 rounded border-gray-300 text-[#00AEEF] focus:ring-[#00AEEF]/30" {{ old('remember') ? 'checked' : '' }} />
                            <span class="text-xs text-[var(--text-secondary)]">Se souvenir de moi</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" id="loginSubmitBtn" class="group relative w-full inline-flex items-center justify-center gap-3 px-8 py-3 rounded-full overflow-hidden transition-all duration-300" style="background-color:rgba(0, 0, 0, 0.08);border-radius:118px;box-shadow:rgba(0, 0, 0, 0.1) 0px 2.52px 2.52px -0.47px,
                               rgba(0, 0, 0, 0.1) 0px 5.97px 5.97px -0.94px,
                               rgba(0, 0, 0, 0.08) 0px 10.89px 10.89px -1.41px,
                               rgba(0, 0, 0, 0.08) 0px 18.11px 18.11px -1.88px,
                               rgba(0, 0, 0, 0.06) 0px 29.24px 29.24px -2.34px,
                               rgba(0, 0, 0, 0.05) 0px 47.87px 47.87px -2.81px">
                        <div class="shine-wrapper-hero">
                            <div class="shine-element-hero"></div>
                        </div>
                        <div class="absolute inset-[3px] rounded-[114px] bg-black z-0"></div>
                        <div class="relative z-10 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" x2="3" y1="12" y2="12"></line>
                            </svg>
                            <span class="text-sm font-semibold text-white tracking-wide">Se connecter</span>
                        </div>
                    </button>
                </form>

                {{-- Security note --}}
                <div class="mt-5 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-center gap-4">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-[#00AEEF]">
                                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                            </svg>
                            <span class="text-[10px] text-[var(--text-secondary)]">Connexion s&eacute;curis&eacute;e</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-[#00AEEF]">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span class="text-[10px] text-[var(--text-secondary)]">Chiffrement SSL</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-[#00AEEF]">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span class="text-[10px] text-[var(--text-secondary)]">Acc&egrave;s restreint</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back to site --}}
            <div class="text-center mt-5 auth-animate" id="authBackLink" style="opacity:0;transform:translateY(10px)">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-[var(--text-secondary)] hover:text-[#00AEEF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>
                    Retour au site
                </a>
            </div>
        </div>
    </div>
</div>

@push('head')
<style>
    /* Auth page animations */
    .auth-animate {
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }

    /* Checkbox custom style */
    input[type="checkbox"] {
        accent-color: #00AEEF;
    }

    /* Loading spinner for submit button */
    .auth-spinner {
        animation: auth-spin 0.6s linear infinite;
    }

    @keyframes auth-spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Staggered entrance animations (matching get-quote page pattern)
        var animElements = [{
                el: document.getElementById('authLogo'),
                delay: 100
            },
            {
                el: document.getElementById('authHeader'),
                delay: 200
            },
            {
                el: document.getElementById('authCard'),
                delay: 350
            },
            {
                el: document.getElementById('authBackLink'),
                delay: 500
            }
        ];

        animElements.forEach(function(item) {
            if (item.el) {
                setTimeout(function() {
                    item.el.style.opacity = '1';
                    item.el.style.transform = 'translateY(0)';
                }, item.delay);
            }
        });

        // Form submit loading state
        var form = document.getElementById('loginForm');
        var btn = document.getElementById('loginSubmitBtn');
        if (form && btn) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                var btnContent = btn.querySelector('.relative.z-10');
                if (btnContent) {
                    btnContent.innerHTML = '<svg class="auth-spinner" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg><span class="text-sm font-semibold text-white tracking-wide">Connexion en cours...</span>';
                }
            });
        }
    });

    // Toggle password visibility
    function togglePassword() {
        var passwordInput = document.getElementById('password');
        var eyeIcon = document.getElementById('eyeIcon');
        var eyeOffIcon = document.getElementById('eyeOffIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    }
</script>
@endsection