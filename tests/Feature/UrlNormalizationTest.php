<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Legacy / duplicate URL variants are 301-redirected in ONE hop to their clean
 * equivalent, query strings preserved; clean URLs and non-GET requests are untouched.
 */
class UrlNormalizationTest extends TestCase
{
    private function location(string $uri): array
    {
        $response = $this->get($uri);

        return [$response->getStatusCode(), (string) $response->headers->get('Location')];
    }

    private function pathOf(string $location): string
    {
        $parts = parse_url($location);

        return ($parts['path'] ?? '') . (isset($parts['query']) ? '?' . $parts['query'] : '');
    }

    public function test_privacy_policy_legacy_url_redirects_to_legal_page(): void
    {
        [$status, $location] = $this->location('/privacy-policy');
        $this->assertSame(301, $status);
        $this->assertSame('/legal/privacy-policy', $this->pathOf($location));
    }

    public function test_privacy_policy_redirect_preserves_query_string(): void
    {
        [$status, $location] = $this->location('/privacy-policy?utm_source=news&utm_medium=email');
        $this->assertSame(301, $status);
        $this->assertSame('/legal/privacy-policy?utm_source=news&utm_medium=email', $this->pathOf($location));
    }

    public static function indexPhpVariants(): array
    {
        return [
            'bare' => ['/index.php', '/'],
            'trailing slash' => ['/index.php/', '/'],
            'page' => ['/index.php/about', '/about'],
            'page + trailing slash' => ['/index.php/about/', '/about'],
            'nested' => ['/index.php/tools/word-counter', '/tools/word-counter'],
            'query on root' => ['/index.php?utm_source=news', '/?utm_source=news'],
            'query on page' => ['/index.php/about?utm_source=news&utm_campaign=x', '/about?utm_source=news&utm_campaign=x'],
        ];
    }

    /** @dataProvider indexPhpVariants */
    public function test_index_php_variants_redirect_once_to_clean_url(string $from, string $to): void
    {
        [$status, $location] = $this->location($from);
        $this->assertSame(301, $status, "{$from} should 301");
        $this->assertSame($to, $this->pathOf($location));
        $this->assertStringNotContainsString('index.php', $location, 'no loop back to index.php');

        // Single hop: the destination itself must not redirect again.
        $this->assertNotSame(301, $this->get($this->pathOf($location))->getStatusCode(), "{$to} must not redirect again");
    }

    public function test_index_php_redirect_cannot_become_an_open_redirect(): void
    {
        [, $location] = $this->location('/index.php//evil.example/path');
        $host = parse_url($location, PHP_URL_HOST);
        $this->assertNotSame('evil.example', $host);
        $this->assertSame('/evil.example/path', $this->pathOf($location));
    }

    public function test_post_to_index_php_is_never_redirected(): void
    {
        $this->post('/index.php/privacy-policy-does-not-exist')->assertStatus(404);
    }

    public function test_clean_urls_are_not_redirected(): void
    {
        foreach (['/', '/about', '/legal/privacy-policy', '/tools/word-counter', '/index.phpx'] as $uri) {
            $this->assertNotSame(301, $this->get($uri)->getStatusCode(), "{$uri} must not redirect");
        }
    }

    public function test_destination_canonical_is_unchanged(): void
    {
        $html = $this->get('/legal/privacy-policy')->assertOk()->getContent();
        $this->assertMatchesRegularExpression('#<link rel="canonical" href="[^"]*/legal/privacy-policy"#', $html);
    }
}
