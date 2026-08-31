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
            'services.recaptcha.version' => 'v3',
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

    /**
     * v2 mode must draw the visible checkbox container instead of the hidden
     * v3 token input, and must use explicit rendering (the widget is mounted
     * by our own callback, not auto-scanned).
     *
     * @dataProvider formPages
     */
    public function test_v2_renders_the_visible_checkbox(string $uri, string $action): void
    {
        config(['services.recaptcha.version' => 'v2']);

        $html = $this->get($uri)->getContent();

        $this->assertStringContainsString('recaptchaWidget-'.$action, $html, 'Checkbox mount point is missing.');
        $this->assertStringContainsString('cs-recaptcha__box', $html, 'Styled container is missing.');
        $this->assertStringContainsString('render=explicit', $html, 'Widget must be rendered explicitly.');
        $this->assertStringContainsString('onload=csRenderRecaptcha', $html);

        // The hidden v3 token field must NOT be present: in v2 the token comes
        // from grecaptcha.getResponse(), and an empty input of the same name
        // would override it in the POST body.
        $this->assertStringNotContainsString('id="recaptchaToken-'.$action.'"', $html);

        // Exactly one widget per page: two elements sharing a DOM id would
        // leave the second one permanently blank.
        $this->assertSame(1, substr_count($html, 'id="recaptchaWidget-'.$action.'"'));
    }

    /**
     * The v2 loader script is shared by both forms on a page, so it must be
     * emitted exactly once — a second copy re-runs the render callback.
     */
    public function test_v2_loader_script_is_included_once(): void
    {
        config(['services.recaptcha.version' => 'v2']);

        $html = $this->get('/contact')->getContent();

        $this->assertSame(1, substr_count($html, 'recaptcha/api.js?onload='));

        // The stylesheet is pushed under @once; count a marker that appears
        // exactly once inside it rather than a selector the block reuses.
        $this->assertSame(1, substr_count($html, '.cs-recaptcha {'), 'Widget CSS should be emitted once.');

        // One mount point per form — a duplicate include would create two
        // elements sharing a DOM id and Google would render into only one.
        $this->assertSame(1, substr_count($html, 'id="recaptchaWidget-contact"'));
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
