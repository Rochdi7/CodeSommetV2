<?php

namespace Tests\Feature\ToolsV2;

use App\Services\SafeHttpFetcher;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * Socle des tests des outils v2 : réseau simulé (SafeHttpFetcher partiellement
 * mocké), raccourcis pour appeler l'endpoint et vérifier la page.
 */
abstract class ToolsV2TestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    protected function response(int $status, string $body = '', array $headers = []): Response
    {
        return new Response(new PsrResponse($status, $headers, $body));
    }

    /**
     * Simule les réponses GET : `$routes` associe une URL à une Response ou à
     * une closure ; toute autre URL lève un timeout.
     *
     * @param  array<string, Response|\Closure>  $routes
     */
    protected function fakeHttp(array $routes): void
    {
        $resolve = function (string $url) use ($routes) {
            $hit = $routes[$url] ?? null;
            if ($hit === null) {
                throw new \RuntimeException('cURL error 28: Operation timed out');
            }

            return $hit instanceof \Closure ? $hit($url) : $hit;
        };

        $this->partialMock(SafeHttpFetcher::class, function (MockInterface $mock) use ($resolve) {
            $mock->shouldReceive('get')->andReturnUsing(fn (string $url) => $resolve($url));
            $mock->shouldReceive('getNoRedirect')->andReturnUsing(fn (string $url) => $resolve($url));
            $mock->shouldReceive('getBody')->andReturnUsing(function (string $url) use ($resolve) {
                $r = $resolve($url);
                if (! $r->successful()) {
                    throw new \RuntimeException("Failed to fetch URL (HTTP {$r->status()}).");
                }

                return $r->body();
            });
        });
    }

    protected function tool(string $slug, array $payload = [])
    {
        return $this->postJson("/api/tools-v2/{$slug}", $payload);
    }

    /** La page existe, porte son <title> propre, son script et sa carte sur /tools. */
    protected function assertToolPage(string $slug, string $titleStart): void
    {
        $html = $this->get("/tools/{$slug}")->assertOk()->getContent();
        $this->assertStringContainsString('<title>' . $titleStart, $html);
        $this->assertStringContainsString("js/tools/{$slug}.js", $html);
        $this->assertStringContainsString('id="tv-form"', $html);
        $this->assertStringContainsString('id="tool-action-btn"', $html);
        $this->assertStringContainsString('data-tv-export="csv"', $html);
        $this->get('/tools')->assertOk()->assertSee("/tools/{$slug}", false);
    }
}
