<?php

namespace App\Services\ToolsV2\Handlers;

use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\ToolsV2\Input;
use App\Services\ToolsV2\InvalidInputException;
use App\Services\ToolsV2\ToolHandler;
use Illuminate\Http\Request;

/**
 * Extracteur de n-grammes : le calcul se fait dans le navigateur ; le serveur
 * ne sert qu'à récupérer le texte visible d'une URL.
 */
class NgramExtractorTool implements ToolHandler
{
    public const MAX_TEXT = 400 * 1024;

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

        // Les titres comptent double dans la perception du sujet : on les
        // renvoie à part pour que le client puisse les signaler.
        $headings = array_map(fn ($h) => $h['text'], $doc->headings());
        $text = $doc->visibleText();
        if (trim($text) === '') {
            throw new InvalidInputException('Aucun texte visible sur cette page (contenu chargé en JavaScript ?).');
        }

        return [
            'url' => $url,
            'title' => $doc->title(),
            'lang' => $doc->lang(),
            'headings' => array_slice($headings, 0, 100),
            'text' => mb_substr($text, 0, self::MAX_TEXT),
        ];
    }
}
