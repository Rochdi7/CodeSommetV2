<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_security_headers_present_on_front_office_response(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $this->assertNotNull($response->headers->get('Permissions-Policy'));
        // CSP is emitted (report-only by default).
        $this->assertTrue(
            $response->headers->has('Content-Security-Policy')
            || $response->headers->has('Content-Security-Policy-Report-Only')
        );
    }

    public function test_csp_does_not_allow_unsafe_eval(): void
    {
        $response = $this->get('/');
        $csp = $response->headers->get('Content-Security-Policy-Report-Only')
            ?? $response->headers->get('Content-Security-Policy')
            ?? '';

        $this->assertStringNotContainsString('unsafe-eval', $csp);
    }
}
