<?php

namespace App\Services\ToolsV2\Handlers;

use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\ToolsV2\Input;
use App\Services\ToolsV2\InvalidInputException;
use App\Services\ToolsV2\ToolHandler;
use Illuminate\Http\Request;

/**
 * Aperçu SERP : pré-remplit titre, description et canonique depuis une URL.
 * L'aperçu et la mesure en pixels se font dans le navigateur.
 */
class SerpSnippetPreviewTool implements ToolHandler
{
    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    public function handle(Request $request): array
    {
        $url = Input::url($request);

        $response = $this->fetcher->get($url, 12, ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.5']);
        if (! $response->successful()) {
            throw new InvalidInputException("La page a répondu avec le code HTTP {$response->status()}.");
        }

        $doc = HtmlDocument::fromHtml($this->fetcher->cappedBody($response));
        $h1 = $doc->query('//h1');

        return [
            'url' => $url,
            'title' => $doc->title(),
            'description' => $doc->metaByName('description'),
            'ogTitle' => $doc->metaByNameOrProperty('og:title'),
            'ogDescription' => $doc->metaByNameOrProperty('og:description'),
            'canonical' => $doc->canonicals()[0] ?? null,
            'h1' => $h1 === [] ? '' : trim(preg_replace('/\s+/u', ' ', $h1[0]->textContent)),
            'lang' => $doc->lang(),
        ];
    }
}
