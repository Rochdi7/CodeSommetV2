<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds baseline security headers to every response.
 *
 * CSP is emitted in Report-Only mode by default because the site uses inline
 * scripts, a Cal.com embed, and Google Analytics; switch to an enforcing
 * `Content-Security-Policy` header once the policy is verified against every
 * page (see config/security.php).
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=()');

        // HSTS only over HTTPS in production.
        if ($request->secure() && app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $csp = (string) config('security.csp');
        if ($csp !== '') {
            $header = config('security.csp_enforce')
                ? 'Content-Security-Policy'
                : 'Content-Security-Policy-Report-Only';
            $response->headers->set($header, $csp);
        }

        return $response;
    }
}
