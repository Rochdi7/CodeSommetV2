<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Collapses inter-tag whitespace in rendered HTML responses.
 *
 * Blade indentation accounts for roughly a third of the homepage's uncompressed
 * payload. Stripping it is purely cosmetic at the byte level, but only when the
 * collapse never touches content where whitespace is significant:
 *
 *   - <pre>/<textarea> render whitespace literally.
 *   - <script>/<style> can break on newline removal (// comments, ASI).
 *   - Between two inline elements a single space is a rendered word gap;
 *     deleting it visually joins words. Runs are collapsed to one space rather
 *     than removed, so the rendered result is byte-different but pixel-identical.
 */
class MinifyHtml
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldMinify($request, $response)) {
            return $response;
        }

        $html = $response->getContent();

        if (! is_string($html) || $html === '') {
            return $response;
        }

        $minified = $this->minify($html);

        if ($minified !== '' && strlen($minified) < strlen($html)) {
            $response->setContent($minified);
        }

        return $response;
    }

    private function shouldMinify(Request $request, Response $response): bool
    {
        if (! config('minify.enabled', true)) {
            return false;
        }

        // Scoped to routes explicitly opted in, so no other page's output can
        // change as a side effect of this middleware.
        $routes = (array) config('minify.routes', []);
        if ($routes !== [] && ! $request->routeIs(...$routes)) {
            return false;
        }

        if (! $response->isSuccessful()) {
            return false;
        }

        // Streamed/binary responses have no buffered content to rewrite.
        if (! method_exists($response, 'getContent')) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type');

        return str_contains($contentType, 'text/html');
    }

    private function minify(string $html): string
    {
        // Protect regions where whitespace is significant or newline-sensitive.
        $placeholders = [];
        $protectedPattern = '#<(pre|textarea|script|style)\b[^>]*>.*?</\1>#is';

        $html = preg_replace_callback($protectedPattern, function (array $m) use (&$placeholders): string {
            $key = "\x00MIN".count($placeholders)."\x00";
            $placeholders[$key] = $m[0];

            return $key;
        }, $html);

        if ($html === null) {
            return '';
        }

        // Drop HTML comments, keeping conditional comments and IE hacks intact.
        $html = preg_replace('#<!--(?!\[if|<!)(?!.*?\[endif\]).*?-->#s', '', $html) ?? $html;

        // Collapse any whitespace run that sits between two tags. Runs
        // containing a newline came from Blade indentation and carry no
        // rendered meaning, so they are removed outright; a run with no newline
        // was authored on one line and may be a real word gap, so it is
        // collapsed to a single space instead.
        $html = preg_replace_callback('#>(\s+)<#s', function (array $m): string {
            return str_contains($m[1], "\n") ? '><' : '> <';
        }, $html) ?? $html;

        // Collapse leftover multi-whitespace runs inside text nodes.
        $html = preg_replace('#[ \t]{2,}#', ' ', $html) ?? $html;
        $html = preg_replace('#\n\s*\n+#', "\n", $html) ?? $html;

        return strtr($html, $placeholders);
    }
}
