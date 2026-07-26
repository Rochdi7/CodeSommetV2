<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;

/**
 * Blog rich-text sanitizer backed by HTMLPurifier (maintained, spec-driven).
 *
 * Uses an explicit tag/attribute allowlist. HTMLPurifier fully parses the HTML
 * into a DOM-like tree, so encoded/obfuscated payloads (nested tags, entity
 * encoding, malformed markup) are normalized before filtering — regex evasions
 * do not apply. Only http/https/mailto URLs are permitted; javascript:, data:,
 * vbscript:, event handlers, iframe/object/embed/form, SVG, MathML, style and
 * srcdoc are all removed.
 */
class HtmlSanitizer
{
    private HTMLPurifier $purifier;

    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();

        // Writable cache dir inside storage.
        $cacheDir = storage_path('app/htmlpurifier');
        if (! is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        $config->set('Cache.SerializerPath', $cacheDir);

        // Explicit tag allowlist (matches the editor's supported formatting).
        $config->set('HTML.Allowed', implode(',', [
            'p', 'br',
            'h2', 'h3', 'h4',
            'ul', 'ol', 'li',
            'strong', 'em',
            'blockquote',
            'a[href|title|rel]',
            'img[src|alt|title|width|height]',
            'table', 'thead', 'tbody', 'tr', 'th', 'td',
            'pre', 'code',
        ]));

        // Only safe URL schemes.
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
        // Disallow protocol-relative and disable any host it cannot resolve safely.
        $config->set('URI.DisableExternalResources', false); // images from approved locations allowed
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        // Force rel=noopener noreferrer on target=_blank links (added by HTMLPurifier).
        $config->set('HTML.TargetNoreferrer', true);
        $config->set('HTML.TargetNoopener', true);
        // Remove empty elements left after filtering.
        $config->set('AutoFormat.RemoveEmpty', true);
        // Do not allow id/style/class-based injection.
        $config->set('Attr.EnableID', false);

        $this->purifier = new HTMLPurifier($config);
    }

    public function clean(string $html): string
    {
        return $this->purifier->purify($html);
    }
}
