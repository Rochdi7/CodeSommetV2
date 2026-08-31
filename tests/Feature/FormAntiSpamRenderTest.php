<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Guards the client half of the anti-spam stack: if the honeypot or the
 * reCAPTCHA token field ever stops rendering, the server rules would either
 * reject every real visitor (missing token) or silently lose a defence layer.
 */
class FormAntiSpamRenderTest extends TestCase
{
    private const SITE_KEY = 'test-site-key';

    private const SECRET_KEY = 'test-secret-key';

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.recaptcha.site_key' => self::SITE_KEY,
            'services.recaptcha.secret_key' => self::SECRET_KEY,
        ]);
    }

    public static function formPages(): array
    {
        return [
            'contact' => ['/contact', 'contact'],
            'quote' => ['/get-quote', 'quote'],
        ];
    }

    /**
     * @dataProvider formPages
     */
    public function test_form_page_renders_the_anti_spam_fields(string $uri, string $action): void
    {
        $response = $this->get($uri);
        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('name="website"', $html, 'Honeypot field is missing.');
        $this->assertStringContainsString('name="g-recaptcha-response"', $html, 'reCAPTCHA token field is missing.');
        $this->assertStringContainsString('recaptcha/api.js?render='.self::SITE_KEY, $html, 'reCAPTCHA script is not loaded.');
        $this->assertStringContainsString('recaptchaToken-'.$action, $html, 'Token input id does not match the page action.');
    }

    /**
     * The secret key must never reach the browser — it would let anyone forge
     * a verified token.
     *
     * @dataProvider formPages
     */
    public function test_secret_key_is_never_rendered(string $uri): void
    {
        $this->assertStringNotContainsString(self::SECRET_KEY, $this->get($uri)->getContent());
    }

    /**
     * With no keys configured the third-party script must not load at all,
     * matching the server rule, which skips verification in that case.
     *
     * @dataProvider formPages
     */
    public function test_no_recaptcha_script_when_unconfigured(string $uri): void
    {
        config(['services.recaptcha.site_key' => null]);

        $html = $this->get($uri)->getContent();

        $this->assertStringNotContainsString('recaptcha/api.js', $html);
        $this->assertStringNotContainsString('name="g-recaptcha-response"', $html);
        // The honeypot is not third-party, so it must still be there.
        $this->assertStringContainsString('name="website"', $html);
    }

    public function test_csp_allows_the_recaptcha_origins(): void
    {
        $csp = config('security.csp');

        $this->assertStringContainsString('https://www.google.com', $csp);
        $this->assertStringContainsString('https://www.gstatic.com', $csp);

        // frame-src matters too: v3 mounts a hidden iframe, and without it no
        // token is ever issued, so every submission would fail validation.
        preg_match('~frame-src[^;]*~', $csp, $frameSrc);
        $this->assertStringContainsString('https://www.google.com', $frameSrc[0] ?? '');
    }
}
