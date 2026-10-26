<?php

namespace App\Services\ToolsV2\Handlers;

use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\ToolsV2\Input;
use App\Services\ToolsV2\InvalidInputException;
use App\Services\ToolsV2\SchemaRules;
use App\Services\ToolsV2\ToolHandler;
use Illuminate\Http\Request;

/**
 * Extracteur et validateur de données structurées : JSON-LD (blocs, entités,
 * propriétés requises / recommandées), présence de microdonnées et RDFa.
 * Accepte une URL ou du JSON-LD collé.
 */
class StructuredDataExtractorTool implements ToolHandler
{
    public const MAX_CODE = 256 * 1024;

    public const MAX_ENTITIES = 200;

    public function __construct(private SafeHttpFetcher $fetcher)
    {
    }

    public function handle(Request $request): array
    {
        $code = Input::text($request, 'code', self::MAX_CODE, false);
        $url = Input::url($request, 'url', false);

        if ($code === '' && $url === null) {
            throw new InvalidInputException('Indiquez une URL ou collez du JSON-LD.');
        }

        $blocks = [];
        $page = null;

        if ($code !== '') {
            // Code collé : du JSON brut, ou un fragment HTML contenant des <script>.
            if (preg_match('/<script/i', $code)) {
                $doc = HtmlDocument::fromHtml($code);
                $blocks = $this->rawBlocks($doc);
            } else {
                $blocks = [['raw' => $code, 'index' => 1]];
            }
            $page = ['source' => 'code', 'microdata' => 0, 'rdfa' => 0];
        } else {
            $response = $this->fetcher->get($url, 12, ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.5']);
            if (! $response->successful()) {
                throw new InvalidInputException("La page a répondu avec le code HTTP {$response->status()}.");
            }
            $html = $this->fetcher->cappedBody($response);
            $doc = HtmlDocument::fromHtml($html);
            $blocks = $this->rawBlocks($doc);
            $page = [
                'source' => 'url',
                'url' => $url,
                'title' => $doc->title(),
                'microdata' => count($doc->query('//*[@itemscope]')),
                'microdataTypes' => array_values(array_unique(array_map(
                    fn ($n) => preg_replace('#^https?://schema\.org/#', '', $n->getAttribute('itemtype')),
                    $doc->query('//*[@itemtype]')
                ))),
                'rdfa' => count($doc->query('//*[@typeof]')),
                'rdfaTypes' => array_values(array_unique(array_map(fn ($n) => $n->getAttribute('typeof'), $doc->query('//*[@typeof]')))),
            ];
        }

        $entities = [];
        $outBlocks = [];
        foreach ($blocks as $block) {
            $decoded = json_decode($block['raw'], true, 64);
            $error = null;
            if (! is_array($decoded)) {
                $error = json_last_error_msg();
                // Erreurs fréquentes : virgule finale, commentaires, guillemets simples.
                $fixed = preg_replace(['#^\s*//[^\n]*$#m', '/,\s*([}\]])/'], ['', '$1'], $block['raw']);
                $decodedFixed = json_decode($fixed, true, 64);
                if (is_array($decodedFixed)) {
                    $error .= ' (corrigible : virgule finale ou commentaire)';
                }
            }
            $found = [];
            if (is_array($decoded)) {
                $this->collect($decoded, $found, isset($decoded['@context']) ? (string) (is_array($decoded['@context']) ? ($decoded['@context']['@vocab'] ?? 'https://schema.org') : $decoded['@context']) : null);
            }
            $outBlocks[] = [
                'index' => $block['index'],
                'valid' => $error === null,
                'error' => $error,
                'bytes' => strlen($block['raw']),
                'entities' => count($found),
                'pretty' => is_array($decoded) ? json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : mb_substr($block['raw'], 0, 5000),
            ];
            foreach ($found as $entity) {
                if (count($entities) >= self::MAX_ENTITIES) {
                    break;
                }
                $entities[] = $this->validate($entity['node'], $entity['context'], $block['index'], $entity['path']);
            }
        }

        $errors = count(array_filter($entities, fn ($e) => $e['status'] === 'error')) + count(array_filter($outBlocks, fn ($b) => ! $b['valid']));
        $warnings = count(array_filter($entities, fn ($e) => $e['status'] === 'warn'));
        $types = array_values(array_unique(array_map(fn ($e) => $e['type'], $entities)));

        return [
            'page' => $page,
            'blocks' => $outBlocks,
            'entities' => $entities,
            'summary' => [
                'blocks' => count($outBlocks),
                'invalidBlocks' => count(array_filter($outBlocks, fn ($b) => ! $b['valid'])),
                'entities' => count($entities),
                'types' => $types,
                'errors' => $errors,
                'warnings' => $warnings,
                'richResultTypes' => array_values(array_filter($types, fn ($t) => SchemaRules::for($t) !== null)),
            ],
        ];
    }

    /** @return list<array{raw: string, index: int}> */
    private function rawBlocks(HtmlDocument $doc): array
    {
        $out = [];
        $i = 0;
        foreach ($doc->query('//script') as $node) {
            if (strtolower(trim($node->getAttribute('type'))) !== 'application/ld+json') {
                continue;
            }
            $out[] = ['raw' => trim($node->textContent), 'index' => ++$i];
        }

        return $out;
    }

    /**
     * Parcourt récursivement le JSON et collecte chaque objet porteur d'un @type.
     *
     * @param  list<array{node: array, context: string|null, path: string}>  $found
     */
    private function collect(array $node, array &$found, ?string $context, string $path = '', int $depth = 0): void
    {
        if ($depth > 12 || count($found) > self::MAX_ENTITIES) {
            return;
        }
        if (array_is_list($node)) {
            foreach ($node as $i => $child) {
                if (is_array($child)) {
                    $this->collect($child, $found, $context, $path . '[' . $i . ']', $depth + 1);
                }
            }

            return;
        }
        if (isset($node['@context']) && is_string($node['@context'])) {
            $context = $node['@context'];
        }
        if (isset($node['@type'])) {
            $found[] = ['node' => $node, 'context' => $context, 'path' => $path === '' ? '$' : $path];
        }
        foreach ($node as $key => $child) {
            if (is_array($child) && $key !== '@context') {
                $this->collect($child, $found, $context, ($path === '' ? '$' : $path) . '.' . $key, $depth + 1);
            }
        }
    }

    /** @return array<string, mixed> */
    private function validate(array $entity, ?string $context, int $block, string $path): array
    {
        $type = $entity['@type'];
        $types = is_array($type) ? array_values(array_filter($type, 'is_string')) : [(string) $type];
        $primary = $types[0] ?? 'Thing';
        $rules = null;
        foreach ($types as $t) {
            $rules = SchemaRules::for($t);
            if ($rules !== null) {
                $primary = $t;
                break;
            }
        }

        $issues = [];
        $missingRequired = [];
        $missingRecommended = [];
        if ($context === null) {
            $issues[] = ['level' => 'error', 'message' => '@context absent : les moteurs ignorent le bloc sans « https://schema.org ».'];
        } elseif (! preg_match('#^https?://schema\.org/?$#i', $context)) {
            $issues[] = ['level' => 'warn', 'message' => '@context inhabituel : ' . mb_substr($context, 0, 80)];
        }
        if ($rules !== null) {
            foreach ($rules['required'] as $spec) {
                if (! SchemaRules::has($entity, $spec)) {
                    $missingRequired[] = $spec;
                }
            }
            foreach ($rules['recommended'] as $spec) {
                if (! SchemaRules::has($entity, $spec)) {
                    $missingRecommended[] = $spec;
                }
            }
        }
        foreach ($entity as $key => $value) {
            if (is_string($key) && $key !== '' && $key[0] !== '@' && ! preg_match('/^[a-z][A-Za-z0-9]*$/', $key)) {
                $issues[] = ['level' => 'warn', 'message' => "Propriété « {$key} » : les propriétés schema.org commencent par une minuscule (camelCase)."];
            }
            if (is_string($value) && preg_match('/^(https?:)?\/\/.+\.(jpe?g|png|webp|gif|svg)$/i', $value) && $key === 'image') {
                // ok
            }
            if (in_array($key, ['datePublished', 'dateModified', 'startDate', 'endDate', 'uploadDate', 'datePosted', 'validThrough'], true)
                && is_string($value) && ! preg_match('/^\d{4}-\d{2}-\d{2}(T\d{2}:\d{2}(:\d{2})?([+-]\d{2}:\d{2}|Z)?)?$/', $value)) {
                $issues[] = ['level' => 'warn', 'message' => "« {$key} » n'est pas au format ISO 8601 (AAAA-MM-JJ ou AAAA-MM-JJThh:mm:ss+hh:mm)."];
            }
        }
        if ($primary === 'FAQPage' && isset($entity['mainEntity']) && is_array($entity['mainEntity'])) {
            $questions = array_is_list($entity['mainEntity']) ? $entity['mainEntity'] : [$entity['mainEntity']];
            foreach ($questions as $i => $q) {
                if (! is_array($q) || ! SchemaRules::has($q, 'name') || ! SchemaRules::has($q, 'acceptedAnswer.text')) {
                    $issues[] = ['level' => 'error', 'message' => 'Question n°' . ($i + 1) . ' : « name » et « acceptedAnswer.text » sont requis.'];
                }
            }
        }
        if ($primary === 'BreadcrumbList' && isset($entity['itemListElement']) && is_array($entity['itemListElement'])) {
            $positions = [];
            foreach ($entity['itemListElement'] as $item) {
                if (is_array($item)) {
                    $positions[] = $item['position'] ?? null;
                }
            }
            $expected = range(1, count($positions));
            if (array_map('intval', $positions) !== $expected) {
                $issues[] = ['level' => 'warn', 'message' => 'Les « position » du fil d\'Ariane devraient aller de 1 à ' . count($positions) . ' sans trou.'];
            }
        }

        $status = 'ok';
        if ($missingRequired !== [] || array_filter($issues, fn ($i) => $i['level'] === 'error')) {
            $status = 'error';
        } elseif ($missingRecommended !== [] || $issues !== []) {
            $status = 'warn';
        }

        $name = $entity['name'] ?? $entity['headline'] ?? $entity['title'] ?? null;

        return [
            'block' => $block,
            'path' => $path,
            'type' => $primary,
            'types' => $types,
            'name' => is_string($name) ? mb_substr($name, 0, 120) : null,
            'id' => isset($entity['@id']) && is_string($entity['@id']) ? $entity['@id'] : null,
            'properties' => count(array_filter(array_keys($entity), fn ($k) => is_string($k) && $k[0] !== '@')),
            'known' => $rules !== null,
            'status' => $status,
            'missingRequired' => $missingRequired,
            'missingRecommended' => $missingRecommended,
            'issues' => $issues,
        ];
    }
}
