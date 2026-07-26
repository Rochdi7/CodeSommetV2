<?php

namespace Tests\Feature;

use App\Services\HtmlSanitizer;
use Tests\TestCase;

class HtmlSanitizerTest extends TestCase
{
    private HtmlSanitizer $sanitizer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sanitizer = app(HtmlSanitizer::class);
    }

    public static function maliciousPayloads(): array
    {
        return [
            'img onerror' => ['<img src=x onerror=alert(1)>', ['onerror', 'alert']],
            'javascript href' => ['<a href="javascript:alert(1)">x</a>', ['javascript:', 'alert']],
            'svg script' => ['<svg><script>alert(1)</script></svg>', ['<svg', '<script', 'alert']],
            'math href js' => ['<math href="javascript:alert(1)">', ['javascript:', '<math']],
            'iframe srcdoc' => ['<iframe srcdoc="<script>alert(1)</script>"></iframe>', ['<iframe', 'srcdoc', 'alert']],
            // After stripping both <script> tags the residue is inert text, so
            // we only assert no live <script> element survives.
            'nested script' => ['<scr<script>ipt>alert(1)</scr<script>ipt>', ['<script']],
            'entity-encoded js' => ['<a href="&#x6a;avascript:alert(1)">x</a>', ['javascript:', 'alert']],
            'object' => ['<object data="evil.swf"></object>', ['<object']],
            'embed' => ['<embed src="evil.swf">', ['<embed']],
            'form' => ['<form action="/evil"><input></form>', ['<form']],
            'style expression' => ['<div style="width:expression(alert(1))">x</div>', ['expression', 'alert']],
            'data uri img' => ['<img src="data:text/html,<script>alert(1)</script>">', ['data:', 'alert']],
            'onload body' => ['<body onload=alert(1)>', ['onload', 'alert']],
            'vbscript' => ['<a href="vbscript:msgbox(1)">x</a>', ['vbscript:']],
        ];
    }

    /**
     * @dataProvider maliciousPayloads
     */
    public function test_malicious_payloads_are_neutralized(string $input, array $mustNotContain): void
    {
        $out = strtolower($this->sanitizer->clean($input));

        foreach ($mustNotContain as $needle) {
            $this->assertStringNotContainsString(strtolower($needle), $out, "Payload leaked: {$needle} in [{$input}]");
        }
    }

    public function test_no_executable_script_survives(): void
    {
        $payloads = [
            '<script>alert(1)</script>',
            '<SCRIPT>alert(1)</SCRIPT>',
            '<scr\0ipt>alert(1)</script>',
            '"><script>alert(1)</script>',
        ];
        foreach ($payloads as $p) {
            $out = $this->sanitizer->clean($p);
            $this->assertStringNotContainsString('<script', strtolower($out));
        }
    }

    public function test_legitimate_formatting_is_preserved(): void
    {
        $input = '<h2>Titre</h2><p>Un <strong>texte</strong> avec <em>emphase</em> et un '
            . '<a href="https://example.com" title="lien">lien</a>.</p>'
            . '<ul><li>un</li><li>deux</li></ul>'
            . '<blockquote>citation</blockquote>'
            . '<pre><code>code()</code></pre>'
            . '<img src="https://example.com/pic.png" alt="photo">'
            . '<table><thead><tr><th>A</th></tr></thead><tbody><tr><td>1</td></tr></tbody></table>';

        $out = $this->sanitizer->clean($input);

        $this->assertStringContainsString('<h2>Titre</h2>', $out);
        $this->assertStringContainsString('<strong>texte</strong>', $out);
        $this->assertStringContainsString('<em>emphase</em>', $out);
        $this->assertStringContainsString('href="https://example.com"', $out);
        $this->assertStringContainsString('<li>un</li>', $out);
        $this->assertStringContainsString('<blockquote>', $out);
        $this->assertStringContainsString('<code>code()</code>', $out);
        $this->assertStringContainsString('<img', $out);
        $this->assertStringContainsString('src="https://example.com/pic.png"', $out);
        $this->assertStringContainsString('<td>1</td>', $out);
    }

    public function test_safe_link_schemes_preserved(): void
    {
        $out = $this->sanitizer->clean('<a href="mailto:hi@example.com">mail</a><a href="http://a.test">http</a>');
        $this->assertStringContainsString('mailto:hi@example.com', $out);
        $this->assertStringContainsString('http://a.test', $out);
    }
}
