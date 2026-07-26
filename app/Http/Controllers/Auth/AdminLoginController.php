<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->is_super_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('backoffice.pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $throttleKey = $request->ip() . '|' . strtolower((string) $request->input('email'));

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (! Auth::user()->is_super_admin) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Vous n\'avez pas les droits d\'accès à l\'administration.',
                ])->onlyInput('email');
            }

            // Successful admin login: clear the rate-limit counter.
            RateLimiter::clear('admin-login:' . $throttleKey);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        Log::warning('Failed admin login attempt', ['email' => $request->input('email'), 'ip' => $request->ip()]);

        return back()->withErrors([
            'email' => 'Les identifiants fournis sont incorrects.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Vous avez été déconnecté avec succès.');
    }
}
