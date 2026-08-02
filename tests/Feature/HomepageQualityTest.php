<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Garanties non-régression pour l'audit Lighthouse/Seobility de la page
 * d'accueil (contraste, CSP jQuery/Toastr auto-hébergé, titres dupliqués,
 * ancres internes, taille du document, métadonnées).
 *
 * Voir docs/homepage-quality-fixes.md pour le détail de l'audit et des
 * correctifs.
 */
class HomepageQualityTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_returns_200(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_homepage_has_exactly_one_h1(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertSame(1, preg_match_all('/<h1[\s>]/', $html), 'La page d\'accueil doit contenir exactement un <h1>');
    }

    public function test_no_empty_headings(): void
    {
        $html = $this->get('/')->getContent();

        preg_match_all('/<h([1-6])[^>]*>(.*?)<\/h\1>/is', $html, $matches, PREG_SET_ORDER);
        $this->assertNotEmpty($matches, 'Aucun titre trouvé sur la page d\'accueil');

        foreach ($matches as $m) {
            $text = trim(strip_tags($m[2]));
            $this->assertNotSame('', $text, "Titre h{$m[1]} vide trouvé dans : ".substr($m[0], 0, 120));
        }
    }

    public function test_duplicate_heading_texts_are_limited_to_approved_cases(): void
    {
        // "Développement de Site Web" légitimement répété : titre de carte
        // "process demo" (état 1, décoratif) et titre de la carte tarifaire
        // réelle plus bas sur la page — contenu différent, sections différentes.
        $approvedDuplicates = [
            'Développement de Site Web' => 2,
        ];

        $html = $this->get('/')->getContent();
        preg_match_all('/<h([1-6])[^>]*>(.*?)<\/h\1>/is', $html, $matches, PREG_SET_ORDER);

        $this->assertNotEmpty($matches, 'Aucun titre trouvé sur la page d\'accueil');

        $counts = [];
        foreach ($matches as $m) {
            $text = trim(preg_replace('/\s+/', ' ', strip_tags($m[2])));
            if ($text === '') {
                continue;
            }
            $counts[$text] = ($counts[$text] ?? 0) + 1;
        }

        $unapprovedDuplicates = [];
        foreach ($counts as $text => $count) {
            if ($count <= 1) {
                continue;
            }
            if (($approvedDuplicates[$text] ?? null) === $count) {
                continue;
            }
            $unapprovedDuplicates[$text] = $count;
        }

        $this->assertSame(
            [],
            $unapprovedDuplicates,
            'Titres dupliqués non approuvés : '.json_encode($unapprovedDuplicates, JSON_UNESCAPED_UNICODE)
        );
    }

    public function test_heading_count_stays_within_regression_threshold(): void
    {
        $html = $this->get('/')->getContent();
        $count = preg_match_all('/<h[1-6][\s>]/', $html);

        // Baseline pré-correctifs : 46. Après suppression des titres
        // décoratifs dupliqués (cartes de démo desktop du process "3 étapes")
        // et sans jamais dépasser le total historique.
        $this->assertLessThanOrEqual(46, $count, 'Le nombre de titres a augmenté au-delà du seuil de régression');
        $this->assertGreaterThan(20, $count, 'Le nombre de titres semble anormalement bas — du contenu a peut-être disparu');
    }

    public function test_no_internal_links_have_empty_accessible_name(): void
    {
        $html = $this->get('/')->getContent();
        $anchors = $this->extractAnchors($html);
        $internal = array_filter($anchors, fn (array $a) => $this->isInternalHref($a['href']));
        $this->assertNotEmpty($internal, 'Aucun lien interne trouvé sur la page d\'accueil');

        foreach ($internal as $a) {
            $this->assertTrue(
                $a['text'] !== '' || $a['ariaLabel'] !== '' || $a['hasImgAlt'],
                'Lien interne sans nom accessible : href="'.$a['href'].'"'
            );
        }
    }

    /**
     * Découpe le HTML sur chaque balise <a ...>...</a> avec le DOM plutôt
     * qu'une seule regex globale : sur un document de 500+ Ko, une regex
     * .*? unique avec alternation dépasse le pcre.backtrack_limit et
     * preg_match_all échoue silencieusement (retourne un tableau vide).
     *
     * @return list<array{href: string, text: string, ariaLabel: string, hasImgAlt: bool}>
     */
    private function extractAnchors(string $html): array
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8"?>'.$html);
        libxml_clear_errors();

        $anchors = [];
        foreach ($doc->getElementsByTagName('a') as $a) {
            /** @var \DOMElement $a */
            $hasImgAlt = false;
            foreach ($a->getElementsByTagName('img') as $img) {
                if (trim($img->getAttribute('alt')) !== '') {
                    $hasImgAlt = true;
                    break;
                }
            }
            $anchors[] = [
                'href' => $a->getAttribute('href'),
                'text' => trim(preg_replace('/\s+/', ' ', $a->textContent)),
                'ariaLabel' => trim($a->getAttribute('aria-label')),
                'hasImgAlt' => $hasImgAlt,
            ];
        }

        return $anchors;
    }

    private function isInternalHref(string $href): bool
    {
        if ($href === '' || str_starts_with($href, '#') || str_starts_with($href, 'mailto:') || str_starts_with($href, 'tel:')) {
            return false;
        }
        if (str_starts_with($href, '/')) {
            return true;
        }
        // route()/url() résolvent en URL absolue sur APP_URL — en environnement
        // de test c'est http://localhost, pas codesommet.com.
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);
        $hrefHost = parse_url($href, PHP_URL_HOST);

        return $hrefHost !== null && $hrefHost === $appHost;
    }

    private function normalizeInternalUrl(string $href): string
    {
        $path = parse_url($href, PHP_URL_PATH) ?: $href;
        $path = rtrim($path, '/');

        return $path === '' ? '/' : $path;
    }

    public function test_generic_cta_text_is_not_repeated_across_unrelated_destinations(): void
    {
        // Les CTA génériques ("Découvrir Nos Projets", etc.) doivent rester
        // uniques par destination OU être des doublons responsive légitimes
        // (même bouton affiché en version mobile ET desktop vers la même URL).
        // On vérifie ici que le même libellé ne pointe jamais vers deux URLs
        // internes différentes.
        $html = $this->get('/')->getContent();
        $anchors = array_filter($this->extractAnchors($html), fn (array $a) => $this->isInternalHref($a['href']));
        $this->assertNotEmpty($anchors, 'Aucun lien interne trouvé sur la page d\'accueil');

        $textToUrls = [];
        foreach ($anchors as $a) {
            if ($a['text'] === '') {
                continue;
            }
            $textToUrls[$a['text']][$this->normalizeInternalUrl($a['href'])] = true;
        }
        $this->assertNotEmpty($textToUrls, 'Aucun texte de lien exploitable trouvé');

        foreach ($textToUrls as $text => $urls) {
            $this->assertCount(
                1,
                $urls,
                "Le libellé de lien \"{$text}\" pointe vers plusieurs URLs différentes : ".implode(', ', array_keys($urls))
            );
        }
    }

    public function test_viewport_meta_tag_exists(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertStringContainsString('name="viewport" content="width=device-width, initial-scale=1"', $html);
    }

    public function test_apple_touch_icon_is_present(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertMatchesRegularExpression('/<link rel="apple-touch-icon"[^>]*>/', $html);
    }

    public function test_csp_header_exists_and_is_not_weakened(): void
    {
        $response = $this->get('/');
        $csp = $response->headers->get('Content-Security-Policy-Report-Only')
            ?? $response->headers->get('Content-Security-Policy');

        $this->assertNotNull($csp, 'Aucun header CSP émis');
        $this->assertStringNotContainsString('unsafe-eval', $csp);
        $this->assertStringContainsString("default-src 'self'", $csp);
    }

    public function test_csp_does_not_use_wildcard_origins(): void
    {
        $response = $this->get('/');
        $csp = $response->headers->get('Content-Security-Policy-Report-Only')
            ?? $response->headers->get('Content-Security-Policy')
            ?? '';

        $this->assertStringNotContainsString('*', $csp, 'La CSP ne doit pas contenir de wildcard générique');
    }

    public function test_csp_does_not_reference_cdnjs_for_jquery_or_toastr(): void
    {
        // jQuery et Toastr sont désormais auto-hébergés (public/vendor/) —
        // cdnjs.cloudflare.com ne doit plus apparaître ni dans la CSP ni
        // dans le HTML de la page d'accueil.
        $response = $this->get('/');
        $csp = $response->headers->get('Content-Security-Policy-Report-Only')
            ?? $response->headers->get('Content-Security-Policy')
            ?? '';

        $this->assertStringNotContainsString('cdnjs.cloudflare.com', $csp);
        $this->assertStringNotContainsString('cdnjs.cloudflare.com', $response->getContent());
        $this->assertStringNotContainsString('code.jquery.com', $response->getContent());
    }

    public function test_local_jquery_and_toastr_assets_are_served(): void
    {
        // Ces fichiers statiques sont servis directement par le serveur web
        // (Apache/Nginx/LiteSpeed) en production, pas routés par Laravel —
        // le client de test HTTP de Laravel ne sert pas public/. On vérifie
        // donc leur présence sur le disque plutôt qu'une requête HTTP.
        $files = [
            'vendor/jquery/jquery-3.7.1.min.js',
            'vendor/toastr/toastr-2.1.4.min.js',
            'vendor/toastr/toastr-2.1.4.min.css',
        ];

        foreach ($files as $file) {
            $path = public_path($file);
            $this->assertFileExists($path, "Asset auto-hébergé manquant : {$file}");
            $this->assertGreaterThan(0, filesize($path), "Asset auto-hébergé vide : {$file}");
        }
    }

    public function test_homepage_references_local_jquery_and_toastr(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertStringContainsString('vendor/jquery/jquery-3.7.1.min.js', $html);
        $this->assertStringContainsString('vendor/toastr/toastr-2.1.4.min.js', $html);
        $this->assertStringContainsString('vendor/toastr/toastr-2.1.4.min.css', $html);
    }

    public function test_homepage_html_size_stays_below_regression_threshold(): void
    {
        $html = $this->get('/')->getContent();
        $bytes = strlen($html);

        // Baseline pré-correctifs (production) : 583 011 octets (~569 KB).
        // Après dédoublonnage des marquees (18→12 pastilles "Fonctionnalités
        // Premium", 3→2 itérations des pastilles technologiques) : ~511 KB
        // localement. Seuil de régression avec marge.
        $this->assertLessThan(560_000, $bytes, 'La taille du HTML de la page d\'accueil a régressé au-delà du seuil (569 KB pré-correctifs)');
    }

    public function test_no_duplicate_json_ld_blocks(): void
    {
        $html = $this->get('/')->getContent();

        preg_match_all('/<script[^>]*application\/ld\+json[^>]*>(.*?)<\/script>/is', $html, $matches);
        $this->assertNotEmpty($matches[1], 'Aucun bloc JSON-LD trouvé');

        $seen = [];
        foreach ($matches[1] as $block) {
            $decoded = json_decode(trim($block), true);
            $this->assertIsArray($decoded, 'Bloc JSON-LD invalide');
            $key = ($decoded['@type'] ?? 'unknown').'|'.($decoded['@id'] ?? $decoded['name'] ?? '');
            $this->assertArrayNotHasKey($key, $seen, "JSON-LD dupliqué détecté pour {$key}");
            $seen[$key] = true;
        }
    }

    public function test_no_base64_image_embedded_in_homepage_html(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertDoesNotMatchRegularExpression('/data:image\/[a-z+]+;base64,[A-Za-z0-9+\/=]{100,}/', $html);
    }

    public function test_metadata_canonical_and_og_tags_are_correct(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertMatchesRegularExpression('/<title[^>]*>[^<]{5,}<\/title>/', $html);
        $this->assertMatchesRegularExpression('/<meta name="description"\s+content="[^"]{20,}"/s', $html);

        preg_match('/<link rel="canonical" href="([^"]+)"/', $html, $m);
        $this->assertNotEmpty($m[1] ?? null, 'Canonical manquante');
        $this->assertStringStartsWith('http', $m[1]);

        $this->assertStringContainsString('property="og:title"', $html);
        $this->assertStringContainsString('property="og:url"', $html);
        $this->assertStringContainsString('property="og:image"', $html);

        preg_match_all('/<script[^>]*application\/ld\+json[^>]*>(.*?)<\/script>/is', $html, $ld);
        $this->assertNotEmpty($ld[1] ?? []);
    }

    public function test_badge_contrast_utility_class_is_the_darker_accessible_blue(): void
    {
        // La classe utilitaire text-[#006BB3] (4.86:1 sur le badge cyan/10%)
        // doit exister dans components.css et être référencée par le badge
        // "Urgent" de la démo de tâches. #0071BC seul (4.46:1) échouait AA.
        $css = file_get_contents(public_path('css/components.css'));
        $this->assertStringContainsString('.text-\[\#006BB3\]', $css);
        $this->assertStringContainsString('color: #006BB3;', $css);

        $html = $this->get('/')->getContent();
        $this->assertStringContainsString('text-[#006BB3]', $html);
    }
}
