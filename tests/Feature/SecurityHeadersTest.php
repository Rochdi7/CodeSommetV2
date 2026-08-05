<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    /**
     * La page d'accueil interroge la table `home_ads`. Sans migration jouée
     * sur la base SQLite en mémoire, la requête échoue et la route renvoie
     * 500 : le test échouait donc sur le statut, avant même de vérifier les
     * en-têtes qu'il est censé contrôler.
     */
    use RefreshDatabase;

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
