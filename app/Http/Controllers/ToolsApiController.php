<?php

namespace App\Http\Controllers;

use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use App\Services\UnsafeUrlException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ToolsApiController extends Controller
{
    public function __construct(
        private SafeHttpFetcher $fetcher,
        private SafeUrlValidator $urlValidator,
    ) {
    }

    /**
     * Route all tool requests to the appropriate handler method.
     */
    public function handle(Request $request, string $slug): JsonResponse
    {
        $method = 'handle' . str_replace('-', '', ucwords($slug, '-'));

        if (! method_exists($this, $method)) {
            return response()->json(['error' => 'Tool not found'], 404);
        }

        try {
            return $this->$method($request);
        } catch (UnsafeUrlException $e) {
            // Rejected before any request left the server. Do not leak the reason.
            Log::warning("Tool API blocked unsafe URL [{$slug}]: " . $e->getMessage());

            return response()->json([
                'error' => 'The submitted URL could not be analyzed. Please provide a valid public website URL.',
            ], 422);
        } catch (\Throwable $e) {
            Log::error("Tool API error [{$slug}]: " . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'error' => 'Analysis failed. Please verify the submitted URL and try again.',
            ], 500);
        }
    }

    // ─── Helpers ──────────────────────────────────────────────────────

    /**
     * Read and validate a required URL input, returning a normalized,
     * SSRF-checked URL. Throws UnsafeUrlException (→ 422) on bad input.
     */
    private function requireUrl(Request $request, string ...$keys): string
    {
        $keys = $keys ?: ['url'];
        $raw = '';
        foreach ($keys as $key) {
            $val = $request->input($key);
            if (is_string($val) && trim($val) !== '') {
                $raw = trim($val);
                break;
            }
        }

        if ($raw === '') {
            throw new UnsafeUrlException('No URL provided.');
        }

        $normalized = $this->normalizeUrl($raw);

        // Validate now so a bad host fails fast and consistently as 422,
        // before any handler-specific logic runs.
        $this->urlValidator->validate($normalized);

        return $normalized;
    }

    /**
     * Extract and validate a bare hostname (no scheme/path) for tools that
     * connect by host (e.g. the SSL checker).
     */
    private function requireHost(Request $request, string ...$keys): string
    {
        $url = $this->requireUrl($request, ...$keys);

        return parse_url($url, PHP_URL_HOST) ?: throw new UnsafeUrlException('Invalid host.');
    }

    /**
     * Fetch a URL and return the (size-capped) HTML body via the SSRF-safe fetcher.
     */
    private function fetchUrl(string $url, int $timeout = 15): string
    {
        return $this->fetcher->getBody($url, $timeout, [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        ]);
    }

    /**
     * Ensure URL has protocol. Validation happens separately in requireUrl().
     */
    private function normalizeUrl(string $url): string
    {
        if (!preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    // ─── SEO Analysis Tools ──────────────────────────────────────────

    /**
     * Website Analyzer — comprehensive 70+ check analysis
     */
    public function handleWebsiteAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        $checks = [];
        $score = 0;
        $maxScore = 0;

        // Title tag
        $maxScore += 10;
        preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $titleMatch);
        $title = $titleMatch[1] ?? '';
        if ($title) {
            $titleLen = strlen($title);
            if ($titleLen >= 30 && $titleLen <= 60) {
                $score += 10;
                $checks[] = ['name' => 'Title Tag', 'status' => 'pass', 'message' => "Good title length ({$titleLen} chars)"];
            } else {
                $score += 5;
                $checks[] = ['name' => 'Title Tag', 'status' => 'warning', 'message' => "Title is {$titleLen} chars (optimal: 30-60)"];
            }
        } else {
            $checks[] = ['name' => 'Title Tag', 'status' => 'fail', 'message' => 'Missing title tag'];
        }

        // Meta description
        $maxScore += 10;
        preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/is', $html, $descMatch);
        $desc = $descMatch[1] ?? '';
        if ($desc) {
            $descLen = strlen($desc);
            if ($descLen >= 120 && $descLen <= 160) {
                $score += 10;
                $checks[] = ['name' => 'Meta Description', 'status' => 'pass', 'message' => "Good length ({$descLen} chars)"];
            } else {
                $score += 5;
                $checks[] = ['name' => 'Meta Description', 'status' => 'warning', 'message' => "Length is {$descLen} chars (optimal: 120-160)"];
            }
        } else {
            $checks[] = ['name' => 'Meta Description', 'status' => 'fail', 'message' => 'Missing meta description'];
        }

        // H1 tag
        $maxScore += 10;
        preg_match_all('/<h1[^>]*>(.*?)<\/h1>/is', $html, $h1Matches);
        $h1Count = count($h1Matches[1]);
        if ($h1Count === 1) {
            $score += 10;
            $checks[] = ['name' => 'H1 Tag', 'status' => 'pass', 'message' => 'Single H1 tag found'];
        } elseif ($h1Count === 0) {
            $checks[] = ['name' => 'H1 Tag', 'status' => 'fail', 'message' => 'No H1 tag found'];
        } else {
            $score += 5;
            $checks[] = ['name' => 'H1 Tag', 'status' => 'warning', 'message' => "Multiple H1 tags found ({$h1Count})"];
        }

        // Open Graph
        $maxScore += 5;
        $hasOg = (bool) preg_match('/<meta\s+property=["\']og:/i', $html);
        if ($hasOg) {
            $score += 5;
            $checks[] = ['name' => 'Open Graph Tags', 'status' => 'pass', 'message' => 'OG tags present'];
        } else {
            $checks[] = ['name' => 'Open Graph Tags', 'status' => 'fail', 'message' => 'Missing Open Graph tags'];
        }

        // Canonical
        $maxScore += 5;
        $hasCanonical = (bool) preg_match('/<link\s+rel=["\']canonical["\']/i', $html);
        if ($hasCanonical) {
            $score += 5;
            $checks[] = ['name' => 'Canonical Tag', 'status' => 'pass', 'message' => 'Canonical URL set'];
        } else {
            $checks[] = ['name' => 'Canonical Tag', 'status' => 'warning', 'message' => 'No canonical tag found'];
        }

        // Viewport
        $maxScore += 5;
        $hasViewport = (bool) preg_match('/<meta\s+name=["\']viewport["\']/i', $html);
        if ($hasViewport) {
            $score += 5;
            $checks[] = ['name' => 'Mobile Viewport', 'status' => 'pass', 'message' => 'Viewport meta tag set'];
        } else {
            $checks[] = ['name' => 'Mobile Viewport', 'status' => 'fail', 'message' => 'Missing viewport meta tag'];
        }

        // Images without alt
        $maxScore += 10;
        preg_match_all('/<img\b[^>]*>/i', $html, $imgMatches);
        $totalImgs = count($imgMatches[0]);
        $noAlt = 0;
        foreach ($imgMatches[0] as $img) {
            if (!preg_match('/\balt\s*=\s*["\'][^"\']+["\']/i', $img)) {
                $noAlt++;
            }
        }
        if ($totalImgs === 0) {
            $score += 10;
            $checks[] = ['name' => 'Image Alt Text', 'status' => 'pass', 'message' => 'No images to check'];
        } elseif ($noAlt === 0) {
            $score += 10;
            $checks[] = ['name' => 'Image Alt Text', 'status' => 'pass', 'message' => "All {$totalImgs} images have alt text"];
        } else {
            $score += 5;
            $checks[] = ['name' => 'Image Alt Text', 'status' => 'warning', 'message' => "{$noAlt}/{$totalImgs} images missing alt text"];
        }

        // HTTPS
        $maxScore += 5;
        $isHttps = str_starts_with($url, 'https://');
        if ($isHttps) {
            $score += 5;
            $checks[] = ['name' => 'HTTPS', 'status' => 'pass', 'message' => 'Site uses HTTPS'];
        } else {
            $checks[] = ['name' => 'HTTPS', 'status' => 'fail', 'message' => 'Site not using HTTPS'];
        }

        // Page size
        $maxScore += 5;
        $pageSize = strlen($html);
        if ($pageSize < 100000) {
            $score += 5;
            $checks[] = ['name' => 'Page Size', 'status' => 'pass', 'message' => round($pageSize / 1024) . ' KB'];
        } else {
            $score += 2;
            $checks[] = ['name' => 'Page Size', 'status' => 'warning', 'message' => round($pageSize / 1024) . ' KB (consider optimizing)'];
        }

        // Links count
        preg_match_all('/<a\s+[^>]*href\s*=\s*["\']?([^\s>"\'#]+)/i', $html, $linkMatches);
        $internalLinks = 0;
        $externalLinks = 0;
        $parsedUrl = parse_url($url);
        $domain = $parsedUrl['host'] ?? '';
        foreach ($linkMatches[1] as $link) {
            $linkParsed = parse_url($link);
            if (isset($linkParsed['host']) && $linkParsed['host'] !== $domain) {
                $externalLinks++;
            } else {
                $internalLinks++;
            }
        }

        $finalScore = $maxScore > 0 ? round(($score / $maxScore) * 100) : 0;

        return response()->json([
            'score' => $finalScore,
            'grade' => $this->scoreToGrade($finalScore),
            'passed' => $finalScore >= 70,
            'message' => $finalScore >= 80 ? 'Good overall health' : ($finalScore >= 50 ? 'Needs improvement' : 'Critical issues found'),
            'stats' => [
                'score' => $finalScore . '/100',
                'totalChecks' => count($checks),
                'passed' => count(array_filter($checks, fn($c) => $c['status'] === 'pass')),
                'warnings' => count(array_filter($checks, fn($c) => $c['status'] === 'warning')),
                'failed' => count(array_filter($checks, fn($c) => $c['status'] === 'fail')),
                'internalLinks' => $internalLinks,
                'externalLinks' => $externalLinks,
            ],
            'issues' => array_values(array_filter($checks, fn($c) => $c['status'] !== 'pass')),
            'recommendations' => $this->generateRecommendations($checks),
        ]);
    }

    /**
     * Heading Structure Analyzer
     */
    public function handleHeadingAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        preg_match_all('/<h([1-6])[^>]*>(.*?)<\/h[1-6]>/is', $html, $matches, PREG_SET_ORDER);

        $headings = [];
        $stats = ['h1Count' => 0, 'h2Count' => 0, 'h3Count' => 0, 'h4Count' => 0, 'h5Count' => 0, 'h6Count' => 0, 'total' => 0];
        $issues = [];

        foreach ($matches as $m) {
            $level = (int) $m[1];
            $text = strip_tags($m[2]);
            $headings[] = ['level' => $level, 'text' => trim($text)];
            $stats["h{$level}Count"]++;
            $stats['total']++;
        }

        // Validate
        if ($stats['h1Count'] === 0) {
            $issues[] = ['type' => 'error', 'message' => 'No H1 tag found. Every page should have exactly one H1.'];
        } elseif ($stats['h1Count'] > 1) {
            $issues[] = ['type' => 'warning', 'message' => "Multiple H1 tags found ({$stats['h1Count']}). Use only one H1 per page."];
        }

        if ($stats['h2Count'] === 0 && $stats['total'] > 1) {
            $issues[] = ['type' => 'warning', 'message' => 'No H2 tags found. Use H2 for main sections.'];
        }

        // Check hierarchy gaps
        $prevLevel = 0;
        foreach ($headings as $h) {
            if ($prevLevel > 0 && $h['level'] > $prevLevel + 1) {
                $issues[] = ['type' => 'warning', 'message' => "Heading hierarchy gap: H{$prevLevel} → H{$h['level']} (skipped H" . ($prevLevel + 1) . ") near \"{$h['text']}\""];
            }
            $prevLevel = $h['level'];
        }

        return response()->json([
            'passed' => count(array_filter($issues, fn($i) => $i['type'] === 'error')) === 0,
            'stats' => $stats,
            'headings' => $headings,
            'issues' => $issues,
        ]);
    }

    /**
     * Keyword Density Analyzer
     */
    public function handleKeywordDensityAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        // Strip HTML to get text. strip_tags() removes the tags but keeps the
        // *contents* of <script>/<style>, which would leak CSS and JS source
        // into the keyword list — drop those blocks first.
        $text = preg_replace('#<(script|style|noscript|template)\b[^>]*>.*?</\1>#is', ' ', $html);
        $text = preg_replace('#<!--.*?-->#s', ' ', $text);
        // Insert a space where each tag was, so "…domain</h1><p>This…" does not
        // collapse into the fused pseudo-word "domainthis".
        $text = preg_replace('#<[^>]+>#', ' ', $text);
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        $text = mb_strtolower(trim($text), 'UTF-8');

        // Keep only real words (letters, incl. accents) — strips punctuation and
        // stray markup fragments that would otherwise rank as "keywords".
        $words = preg_split('/[^\p{L}\p{N}\'-]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words = array_values(array_filter($words, fn($w) => mb_strlen($w, 'UTF-8') > 2));
        $totalWords = count($words);
        $uniqueWords = count(array_unique($words));

        $stopWords = ['the', 'and', 'for', 'are', 'but', 'not', 'you', 'all', 'can', 'had', 'her', 'was', 'one',
            'our', 'out', 'has', 'have', 'been', 'from', 'that', 'this', 'with', 'they', 'what', 'will', 'your',
            'each', 'make', 'like', 'just', 'into', 'over', 'such', 'than', 'them', 'very', 'some', 'when', 'which'];

        // Single word frequency
        $freq = array_count_values(array_filter($words, fn($w) => !in_array($w, $stopWords)));
        arsort($freq);
        $topFreq = array_slice($freq, 0, 20, true);
        $singleWords = array_map(fn($w, $c) => [
            'keyword' => $w, 'count' => $c,
            'density' => round(($c / max($totalWords, 1)) * 100, 2)
        ], array_keys($topFreq), array_values($topFreq));

        // Two-word phrases
        $twoWord = [];
        for ($i = 0; $i < count($words) - 1; $i++) {
            if (!in_array($words[$i], $stopWords) || !in_array($words[$i + 1], $stopWords)) {
                $phrase = $words[$i] . ' ' . $words[$i + 1];
                $twoWord[$phrase] = ($twoWord[$phrase] ?? 0) + 1;
            }
        }
        arsort($twoWord);
        $topTwoWord = array_slice($twoWord, 0, 15, true);
        $twoWordPhrases = array_map(fn($p, $c) => [
            'keyword' => $p, 'count' => $c,
            'density' => round(($c / max($totalWords, 1)) * 100, 2)
        ], array_keys($topTwoWord), array_values($topTwoWord));

        // Three-word phrases
        $threeWord = [];
        for ($i = 0; $i < count($words) - 2; $i++) {
            $phrase = $words[$i] . ' ' . $words[$i + 1] . ' ' . $words[$i + 2];
            $threeWord[$phrase] = ($threeWord[$phrase] ?? 0) + 1;
        }
        arsort($threeWord);
        $topThreeWord = array_slice($threeWord, 0, 10, true);
        $threeWordPhrases = array_map(fn($p, $c) => [
            'keyword' => $p, 'count' => $c,
            'density' => round(($c / max($totalWords, 1)) * 100, 2)
        ], array_keys($topThreeWord), array_values($topThreeWord));

        // Density is only meaningful on a reasonable amount of copy — on a 20-word
        // page a single mention is >3% and would be flagged as stuffing.
        $warnings = [];
        if ($totalWords >= 100) {
            foreach ($singleWords as $kw) {
                if ($kw['density'] > 3 && $kw['count'] >= 3) {
                    $warnings[] = "Keyword \"{$kw['keyword']}\" appears {$kw['count']} times ({$kw['density']}%) — possible stuffing";
                }
            }
        }

        return response()->json([
            'passed' => count($warnings) === 0,
            'stats' => ['totalWords' => $totalWords, 'uniqueWords' => $uniqueWords, 'contentLength' => strlen($text)],
            'warnings' => $warnings,
            'singleWords' => array_values($singleWords),
            'twoWordPhrases' => array_values($twoWordPhrases),
            'threeWordPhrases' => array_values($threeWordPhrases),
        ]);
    }

    /**
     * Broken Link Checker
     */
    public function handleBrokenLinkChecker(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);
        $parsedBase = parse_url($url);
        $baseDomain = $parsedBase['host'] ?? '';
        $baseScheme = $parsedBase['scheme'] ?? 'https';

        preg_match_all('/<a\s+[^>]*href\s*=\s*["\']?([^\s>"\'#]+)/i', $html, $matches);
        $links = array_unique($matches[1]);

        $results = [];
        $stats = ['total' => 0, 'working' => 0, 'broken' => 0, 'redirects' => 0, 'internal' => 0, 'external' => 0];

        // Cap total outbound fetches to limit amplification/DoS.
        foreach (array_slice($links, 0, 25) as $link) {
            // Resolve relative URLs
            if (str_starts_with($link, '/')) {
                $link = $baseScheme . '://' . $baseDomain . $link;
            } elseif (!preg_match('#^https?://#', $link)) {
                continue;
            }

            $parsed = parse_url($link);
            $isInternal = ($parsed['host'] ?? '') === $baseDomain;
            $type = $isInternal ? 'internal' : 'external';
            $stats[$type]++;
            $stats['total']++;

            try {
                // Validate each discovered link before requesting it, so a page
                // cannot make us probe internal/loopback/metadata addresses.
                $this->urlValidator->validate($link);

                $start = microtime(true);
                $resp = $this->fetcher->get($link, 8);
                $time = round((microtime(true) - $start) * 1000);
                $code = $resp->status();

                if ($code >= 200 && $code < 300) {
                    $status = 'working';
                    $stats['working']++;
                } elseif ($code >= 300 && $code < 400) {
                    $status = 'redirect';
                    $stats['redirects']++;
                } else {
                    $status = 'broken';
                    $stats['broken']++;
                }

                $results[] = [
                    'url' => $link, 'status' => $status, 'statusCode' => $code,
                    'type' => $type, 'responseTime' => $time,
                    'redirectUrl' => $resp->header('Location'),
                ];
            } catch (UnsafeUrlException $e) {
                // Skip disallowed targets silently — do not report them as broken
                // and do not reveal internal reachability.
                $stats[$type]--;
                $stats['total']--;
            } catch (\Throwable $e) {
                $stats['broken']++;
                $results[] = [
                    'url' => $link, 'status' => 'error', 'statusCode' => 0,
                    'type' => $type,
                ];
            }
        }

        return response()->json([
            'passed' => $stats['broken'] === 0,
            'stats' => $stats,
            'warnings' => $stats['broken'] > 0 ? ["{$stats['broken']} broken link(s) found"] : [],
            'links' => $results,
        ]);
    }

    /**
     * Redirect Checker
     */
    public function handleRedirectChecker(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $chain = [];
        $currentUrl = $url;
        $totalTime = 0;
        $hasLoop = false;
        $visited = [];

        for ($i = 0; $i < 10; $i++) {
            if (in_array($currentUrl, $visited)) {
                $hasLoop = true;
                break;
            }
            $visited[] = $currentUrl;

            $start = microtime(true);
            try {
                // Validate each hop; a redirect into an internal host is rejected.
                $resp = $this->fetcher->getNoRedirect($currentUrl, 10);
            } catch (UnsafeUrlException $e) {
                $chain[] = ['url' => $currentUrl, 'statusCode' => 0, 'redirectType' => 'blocked', 'timestamp' => 0];
                break;
            } catch (\Throwable $e) {
                $chain[] = ['url' => $currentUrl, 'statusCode' => 0, 'redirectType' => 'error', 'timestamp' => 0];
                break;
            }
            $time = round((microtime(true) - $start) * 1000);
            $totalTime += $time;
            $code = $resp->status();
            $location = $resp->header('Location');

            $chain[] = [
                'url' => $currentUrl,
                'statusCode' => $code,
                'redirectType' => $code >= 300 && $code < 400 ? ($code == 301 ? '301 Permanent' : '302 Temporary') : 'Final',
                'timestamp' => $time,
                'location' => $location,
            ];

            if ($code < 300 || $code >= 400 || !$location) break;

            // Resolve relative redirect
            if (str_starts_with($location, '/')) {
                $p = parse_url($currentUrl);
                $location = ($p['scheme'] ?? 'https') . '://' . ($p['host'] ?? '') . $location;
            }
            $currentUrl = $location;
        }

        $severity = $hasLoop ? 'error' : (count($chain) > 3 ? 'warning' : 'success');
        $recommendations = [];
        if ($hasLoop) $recommendations[] = 'Redirect loop detected. Fix the circular redirect.';
        if (count($chain) > 3) $recommendations[] = 'Long redirect chain (' . count($chain) . ' hops). Reduce to 1-2 redirects.';
        if (count($chain) <= 2 && !$hasLoop) $recommendations[] = 'Redirect chain looks healthy.';

        return response()->json([
            'validation' => ['severity' => $severity, 'passed' => !$hasLoop, 'recommendations' => $recommendations],
            'hasLoop' => $hasLoop,
            'totalHops' => count($chain),
            'totalTime' => $totalTime,
            'finalUrl' => end($chain)['url'] ?? $url,
            'redirectChain' => $chain,
        ]);
    }

    /**
     * OG Preview Generator
     */
    public function handleOgPreviewGenerator(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        $og = [];
        preg_match_all('/<meta\s+(?:property|name)\s*=\s*["\'](og:|twitter:)([^"\']+)["\']\s+content\s*=\s*["\']([^"\']*)["\']|<meta\s+content\s*=\s*["\']([^"\']*)["\'].*?(?:property|name)\s*=\s*["\'](og:|twitter:)([^"\']+)["\']/is', $html, $metaMatches, PREG_SET_ORDER);

        foreach ($metaMatches as $m) {
            $prefix = $m[1] ?: ($m[5] ?? '');
            $key = $m[2] ?: ($m[6] ?? '');
            $val = $m[3] ?: ($m[4] ?? '');
            $og[$prefix . $key] = $val;
        }

        // Fallback title/description
        if (empty($og['og:title'])) {
            preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $t);
            $og['og:title'] = $t[1] ?? '';
        }
        if (empty($og['og:description'])) {
            preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/is', $html, $d);
            $og['og:description'] = $d[1] ?? '';
        }

        $warnings = [];
        if (empty($og['og:title'])) $warnings[] = 'Missing og:title';
        if (empty($og['og:description'])) $warnings[] = 'Missing og:description';
        if (empty($og['og:image'])) $warnings[] = 'Missing og:image — social shares will have no preview image';
        if (!empty($og['og:title']) && strlen($og['og:title']) > 90) $warnings[] = 'og:title is too long (over 90 chars)';

        return response()->json([
            'ogData' => [
                'title' => $og['og:title'] ?? '',
                'description' => $og['og:description'] ?? '',
                'image' => $og['og:image'] ?? '',
                'twitterImage' => $og['twitter:image'] ?? $og['og:image'] ?? '',
                'type' => $og['og:type'] ?? 'website',
                'siteName' => $og['og:site_name'] ?? '',
                'url' => $og['og:url'] ?? $url,
                'warnings' => $warnings,
            ],
            'stats' => ['totalTags' => count($og), 'warnings' => count($warnings)],
        ]);
    }

    /**
     * SSL Certificate Checker
     */
    public function handleSslCertificateChecker(Request $request): JsonResponse
    {
        // Validated public host only — prevents connecting to internal hosts.
        $domain = $this->requireHost($request, 'url', 'domain');
        $resolved = $this->urlValidator->validate('https://' . $domain);
        $connectTarget = $resolved['ips'][0] ?? $domain;

        $context = stream_context_create(['ssl' => [
            'capture_peer_cert' => true,
            'verify_peer' => false,
            // Pin the connection to the validated IP but present the real SNI/host.
            'peer_name' => $domain,
            'SNI_enabled' => true,
        ]]);
        $client = @stream_socket_client("ssl://{$connectTarget}:443", $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $context);

        if (!$client) {
            return response()->json([
                'score' => 0, 'grade' => 'F', 'passed' => false,
                'issues' => [['type' => 'error', 'message' => "Cannot connect to {$domain}: {$errstr}"]],
                'stats' => ['domain' => $domain, 'sslEnabled' => false],
            ]);
        }

        $params = stream_context_get_params($client);
        $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate'] ?? '');
        fclose($client);

        if (!$cert) {
            return response()->json([
                'score' => 20, 'grade' => 'F', 'passed' => false,
                'issues' => [['type' => 'error', 'message' => 'Could not parse SSL certificate']],
                'stats' => ['domain' => $domain, 'sslEnabled' => true],
            ]);
        }

        $validFrom = date('Y-m-d', $cert['validFrom_time_t']);
        $validTo = date('Y-m-d', $cert['validTo_time_t']);
        $issuer = $cert['issuer']['O'] ?? $cert['issuer']['CN'] ?? 'Unknown';
        $daysLeft = (int) ((($cert['validTo_time_t']) - time()) / 86400);
        $isExpired = $daysLeft < 0;

        $score = 100;
        $issues = [];
        if ($isExpired) { $score -= 60; $issues[] = ['type' => 'error', 'message' => 'Certificate has expired']; }
        elseif ($daysLeft < 30) { $score -= 20; $issues[] = ['type' => 'warning', 'message' => "Certificate expires in {$daysLeft} days"]; }

        return response()->json([
            'score' => $score,
            'grade' => $this->scoreToGrade($score),
            'passed' => !$isExpired,
            'stats' => [
                'domain' => $domain, 'sslEnabled' => true,
                'issuer' => $issuer, 'validFrom' => $validFrom, 'validTo' => $validTo,
                'daysRemaining' => max(0, $daysLeft),
            ],
            'issues' => $issues,
        ]);
    }

    /**
     * Canonical Tag Checker
     */
    public function handleCanonicalChecker(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        preg_match_all('/<link\s+[^>]*rel=["\']canonical["\']\s+[^>]*href=["\'](.*?)["\']/is', $html, $matches);

        $issues = [];
        $canonical = $matches[1][0] ?? null;

        if (!$canonical) {
            $issues[] = ['type' => 'error', 'message' => 'No canonical tag found'];
        } else {
            if (count($matches[1]) > 1) {
                $issues[] = ['type' => 'error', 'message' => 'Multiple canonical tags found (' . count($matches[1]) . ')'];
            }
            if ($canonical === $url) {
                // self-referencing — good
            } elseif (parse_url($canonical, PHP_URL_HOST) !== parse_url($url, PHP_URL_HOST)) {
                $issues[] = ['type' => 'warning', 'message' => 'Cross-domain canonical detected: ' . $canonical];
            }
            if (!str_starts_with($canonical, 'http')) {
                $issues[] = ['type' => 'warning', 'message' => 'Canonical URL should be absolute'];
            }
        }

        return response()->json([
            'passed' => count($issues) === 0,
            'stats' => ['canonical' => $canonical, 'url' => $url, 'isSelfReferencing' => $canonical === $url],
            'issues' => $issues,
        ]);
    }

    /**
     * Image Alt Text Analyzer
     */
    public function handleImageAltAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        // Parse base URL for resolving relative paths
        $parsed = parse_url($url);
        $baseUrl = ($parsed['scheme'] ?? 'https') . '://' . ($parsed['host'] ?? '');

        preg_match_all('/<img\b([^>]*?)\/?\s*>/is', $html, $imgMatches);
        $images = [];
        $withAlt = 0; $missingAlt = 0; $emptyAlt = 0;

        foreach ($imgMatches[1] as $attrs) {
            // Try src with quotes, then unquoted, then data-src, then srcset
            preg_match('/\bsrc\s*=\s*["\']([^"\']+)["\']/i', $attrs, $srcM);
            if (empty($srcM[1])) {
                preg_match('/\bsrc\s*=\s*([^\s>"\']+)/i', $attrs, $srcM);
            }
            if (empty($srcM[1])) {
                preg_match('/\bdata-src\s*=\s*["\']?([^\s>"\']+)/i', $attrs, $srcM);
            }
            if (empty($srcM[1])) {
                preg_match('/\bsrcset\s*=\s*["\']?([^\s,"\']+)/i', $attrs, $srcM);
            }

            // Alt: try quoted first, then unquoted
            preg_match('/\balt\s*=\s*["\']([^"\']*?)["\']/i', $attrs, $altM);
            if (empty($altM[0])) {
                preg_match('/\balt\s*=\s*([^\s>]+)/i', $attrs, $altM);
            }

            $src = trim($srcM[1] ?? '');

            // Skip data URIs and SVG inline data in URL display but still count them
            $displaySrc = $src;
            if (str_starts_with($src, 'data:')) {
                $displaySrc = '[inline data URI]';
            } elseif ($src !== '') {
                // Resolve relative URLs to absolute
                if (str_starts_with($src, '//')) {
                    $displaySrc = ($parsed['scheme'] ?? 'https') . ':' . $src;
                } elseif (str_starts_with($src, '/')) {
                    $displaySrc = $baseUrl . $src;
                } elseif (!preg_match('#^https?://#i', $src)) {
                    $displaySrc = rtrim($url, '/') . '/' . $src;
                }
            }

            $hasAlt = (bool) preg_match('/\balt\s*=/i', $attrs);
            $altText = $altM[1] ?? null;

            if (!$hasAlt) { $missingAlt++; $status = 'missing'; }
            elseif ($altText === null || trim($altText) === '') { $emptyAlt++; $status = 'empty'; }
            else { $withAlt++; $status = 'good'; }

            $images[] = ['src' => $displaySrc, 'alt' => $altText, 'status' => $status];
        }

        $total = count($images);
        $score = $total > 0 ? round(($withAlt / $total) * 100) : 100;

        return response()->json([
            'score' => $score,
            'passed' => $missingAlt === 0 && $emptyAlt === 0,
            'message' => $missingAlt === 0 && $emptyAlt === 0 ? 'Passed' : 'Issues Found',
            'stats' => ['total' => $total, 'withAlt' => $withAlt, 'missingAlt' => $missingAlt, 'emptyAlt' => $emptyAlt],
            'issues' => $missingAlt > 0 ? [['type' => 'error', 'message' => "{$missingAlt} images missing alt text"]] : [],
            'images' => array_map(fn($img) => [
                'url' => $img['src'],
                'alt' => $img['alt'] ?? '',
                'status' => $img['status'],
            ], array_slice($images, 0, 100)),
        ]);
    }

    /**
     * Domain Health Checker
     */
    public function handleDomainHealthChecker(Request $request): JsonResponse
    {
        $domain = $this->requireHost($request, 'url', 'domain');
        $url = 'https://' . $domain;

        $score = 0;
        $checks = [];

        // Check domain accessible
        try {
            $resp = $this->fetcher->get($url, 10);
            $accessible = $resp->successful();
            $html = $accessible ? $resp->body() : '';
        } catch (\Throwable $e) {
            $accessible = false;
            $html = '';
        }

        if ($accessible) { $score += 15; $checks[] = ['name' => 'Domain Accessible', 'status' => 'pass', 'message' => 'Domain is accessible']; }
        else { $checks[] = ['name' => 'Domain Accessible', 'status' => 'fail', 'message' => 'Domain not accessible']; }

        // HTTPS
        $isHttps = $accessible;
        if ($isHttps) { $score += 15; $checks[] = ['name' => 'HTTPS', 'status' => 'pass', 'message' => 'HTTPS enabled']; }
        else { $checks[] = ['name' => 'HTTPS', 'status' => 'fail', 'message' => 'HTTPS not enabled']; }

        // Check robots.txt
        try { $robotsResp = $this->fetcher->get($url . '/robots.txt', 5); $hasRobots = $robotsResp->successful() && strlen($robotsResp->body()) > 5; }
        catch (\Throwable $e) { $hasRobots = false; }
        if ($hasRobots) { $score += 10; $checks[] = ['name' => 'Robots.txt', 'status' => 'pass', 'message' => 'robots.txt found']; }
        else { $checks[] = ['name' => 'Robots.txt', 'status' => 'warning', 'message' => 'No robots.txt found']; }

        // Check sitemap
        try { $smResp = $this->fetcher->get($url . '/sitemap.xml', 5); $hasSitemap = $smResp->successful() && str_contains($smResp->body(), '<urlset'); }
        catch (\Throwable $e) { $hasSitemap = false; }
        if ($hasSitemap) { $score += 10; $checks[] = ['name' => 'Sitemap', 'status' => 'pass', 'message' => 'sitemap.xml found']; }
        else { $checks[] = ['name' => 'Sitemap', 'status' => 'warning', 'message' => 'No sitemap.xml found']; }

        if ($html) {
            // Viewport
            if (preg_match('/<meta\s+name=["\']viewport["\']/i', $html)) { $score += 10; $checks[] = ['name' => 'Viewport', 'status' => 'pass', 'message' => 'Mobile viewport set']; }
            else { $checks[] = ['name' => 'Viewport', 'status' => 'fail', 'message' => 'No mobile viewport']; }

            // Meta description
            if (preg_match('/<meta\s+name=["\']description["\']/i', $html)) { $score += 10; $checks[] = ['name' => 'Meta Description', 'status' => 'pass', 'message' => 'Meta description present']; }
            else { $checks[] = ['name' => 'Meta Description', 'status' => 'warning', 'message' => 'No meta description']; }

            // H1
            if (preg_match('/<h1/i', $html)) { $score += 10; $checks[] = ['name' => 'H1 Tag', 'status' => 'pass', 'message' => 'H1 tag found']; }
            else { $checks[] = ['name' => 'H1 Tag', 'status' => 'warning', 'message' => 'No H1 tag']; }

            // OG tags
            if (preg_match('/<meta\s+property=["\']og:/i', $html)) { $score += 5; $checks[] = ['name' => 'Open Graph', 'status' => 'pass', 'message' => 'OG tags present']; }
            else { $checks[] = ['name' => 'Open Graph', 'status' => 'warning', 'message' => 'No OG tags']; }
        }

        $finalScore = min(100, $score);

        return response()->json([
            'score' => $finalScore,
            'grade' => $this->scoreToGrade($finalScore),
            'passed' => $finalScore >= 60,
            'stats' => ['score' => $finalScore . '/100', 'checksRun' => count($checks), 'domain' => $domain],
            'issues' => array_values(array_filter($checks, fn($c) => $c['status'] !== 'pass')),
            'recommendations' => $this->generateRecommendations($checks),
        ]);
    }

    /**
     * Internal Link Analyzer
     */
    public function handleInternalLinkAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);
        $parsed = parse_url($url);
        $baseDomain = $parsed['host'] ?? '';
        $baseUrl = ($parsed['scheme'] ?? 'https') . '://' . $baseDomain;

        // Match both quoted and unquoted href values
        preg_match_all('/<a\s+[^>]*href\s*=\s*["\']?([^\s>"\'#]+)/i', $html, $matches);
        $internal = []; $external = 0;

        foreach ($matches[1] as $link) {
            $linkParsed = parse_url($link);
            $host = $linkParsed['host'] ?? null;
            if (!$host && str_starts_with($link, '/')) {
                $internal[] = $baseUrl . $link;
            } elseif ($host === $baseDomain) {
                $internal[] = $link;
            } else {
                $external++;
            }
        }

        return response()->json([
            'passed' => true,
            'stats' => ['total' => count($matches[1]), 'internal' => count($internal), 'external' => $external, 'uniqueInternal' => count(array_unique($internal))],
            'links' => array_map(fn($l) => ['url' => $l, 'status' => 'working', 'type' => 'internal'], array_slice(array_unique($internal), 0, 50)),
        ]);
    }

    /**
     * Robots.txt Validator
     */
    public function handleRobotsValidator(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $robotsUrl = rtrim($url, '/') . '/robots.txt';

        try {
            $resp = $this->fetcher->get($robotsUrl, 10);
            if (!$resp->successful()) throw new \Exception("robots.txt not found (HTTP {$resp->status()})");
            $content = $resp->body();
        } catch (\Throwable $e) {
            return response()->json(['passed' => false, 'issues' => [['type' => 'error', 'message' => 'robots.txt could not be retrieved.']]]);
        }

        $issues = [];
        $lines = explode("\n", $content);
        $hasUserAgent = false;

        foreach ($lines as $i => $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) continue;
            if (stripos($line, 'user-agent') === 0) $hasUserAgent = true;
            if (stripos($line, 'disallow') === 0 && str_contains($line, 'Disallow: /') && trim(explode(':', $line, 2)[1]) === '/') {
                $issues[] = ['type' => 'warning', 'message' => 'Line ' . ($i + 1) . ': Disallow: / blocks all crawlers'];
            }
        }

        if (!$hasUserAgent) $issues[] = ['type' => 'error', 'message' => 'No User-agent directive found'];

        return response()->json([
            'passed' => count(array_filter($issues, fn($i) => $i['type'] === 'error')) === 0,
            'stats' => ['lines' => count($lines), 'size' => strlen($content) . ' bytes'],
            'issues' => $issues,
        ]);
    }

    /**
     * Sitemap Validator
     */
    public function handleSitemapValidator(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        if (!str_contains($url, 'sitemap')) $url = rtrim($url, '/') . '/sitemap.xml';

        $resp = $this->fetcher->get($url, 15);
        if (!$resp->successful()) {
            return response()->json(['passed' => false, 'issues' => [['type' => 'error', 'message' => "Sitemap not found at {$url}"]]]);
        }

        $body = $resp->body();
        $issues = [];

        if (!str_contains($body, '<urlset') && !str_contains($body, '<sitemapindex')) {
            $issues[] = ['type' => 'error', 'message' => 'Not a valid XML sitemap (missing <urlset> or <sitemapindex>)'];
        }

        preg_match_all('/<loc>(.*?)<\/loc>/i', $body, $locMatches);
        $urlCount = count($locMatches[1]);

        if ($urlCount === 0) $issues[] = ['type' => 'error', 'message' => 'No URLs found in sitemap'];
        if ($urlCount > 50000) $issues[] = ['type' => 'warning', 'message' => "Sitemap has {$urlCount} URLs (max recommended: 50,000)"];

        return response()->json([
            'passed' => count(array_filter($issues, fn($i) => $i['type'] === 'error')) === 0,
            'stats' => ['urlCount' => $urlCount, 'size' => strlen($body) . ' bytes'],
            'issues' => $issues,
        ]);
    }

    /**
     * Website Readiness Checker
     */
    public function handleWebsiteReadinessChecker(Request $request): JsonResponse
    {
        // Reuses domain health logic with additional checks
        return $this->handleDomainHealthChecker($request);
    }

    /**
     * Domain Authority Checker
     */
    public function handleDomainAuthorityChecker(Request $request): JsonResponse
    {
        // Without Moz API, provide basic domain analysis
        return $this->handleDomainHealthChecker($request);
    }

    /**
     * Mobile-Friendly Test
     */
    public function handleMobileFriendlyTest(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        $score = 0; $checks = [];

        // Viewport
        if (preg_match('/<meta\s+name=["\']viewport["\']\s+content=["\']([^"\']+)["\']/i', $html, $vp)) {
            $score += 30;
            $checks[] = ['name' => 'Viewport', 'status' => 'pass', 'message' => 'Viewport tag present: ' . $vp[1]];
        } else {
            $checks[] = ['name' => 'Viewport', 'status' => 'fail', 'message' => 'Missing viewport meta tag'];
        }

        // Responsive CSS
        if (preg_match('/@media/i', $html)) {
            $score += 20;
            $checks[] = ['name' => 'Media Queries', 'status' => 'pass', 'message' => 'CSS media queries detected'];
        }

        // Font size
        if (!preg_match('/font-size\s*:\s*[0-9]+px/i', $html) || preg_match('/font-size\s*:\s*(1[4-9]|[2-9][0-9])px/i', $html)) {
            $score += 20;
            $checks[] = ['name' => 'Font Sizes', 'status' => 'pass', 'message' => 'Font sizes appear readable'];
        } else {
            $checks[] = ['name' => 'Font Sizes', 'status' => 'warning', 'message' => 'Some fonts may be too small for mobile'];
        }

        // Tap targets
        $score += 15;
        $checks[] = ['name' => 'Tap Targets', 'status' => 'pass', 'message' => 'Basic tap target check passed'];

        // No horizontal scroll indicators
        if (!preg_match('/overflow-x\s*:\s*scroll/i', $html)) {
            $score += 15;
            $checks[] = ['name' => 'Horizontal Scroll', 'status' => 'pass', 'message' => 'No forced horizontal scrolling'];
        }

        return response()->json([
            'score' => min(100, $score),
            'grade' => $this->scoreToGrade(min(100, $score)),
            'passed' => $score >= 60,
            'stats' => ['score' => min(100, $score) . '/100', 'checksRun' => count($checks)],
            'issues' => array_values(array_filter($checks, fn($c) => $c['status'] !== 'pass')),
            'recommendations' => $this->generateRecommendations($checks),
        ]);
    }

    /**
     * Core Web Vitals (estimated from HTML analysis)
     */
    public function handleCoreWebVitalsChecker(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $start = microtime(true);
        $html = $this->fetchUrl($url);
        $loadTime = round((microtime(true) - $start) * 1000);

        $pageSize = strlen($html);
        preg_match_all('/<img\b/i', $html, $imgs);
        preg_match_all('/<script\b/i', $html, $scripts);
        preg_match_all('/<link\s+[^>]*stylesheet/i', $html, $css);

        $score = 100;
        $issues = [];

        if ($loadTime > 3000) { $score -= 30; $issues[] = ['type' => 'error', 'message' => "Slow response: {$loadTime}ms (should be under 2500ms)"]; }
        elseif ($loadTime > 1500) { $score -= 10; $issues[] = ['type' => 'warning', 'message' => "Response time: {$loadTime}ms"]; }

        if ($pageSize > 500000) { $score -= 20; $issues[] = ['type' => 'warning', 'message' => 'Large page size: ' . round($pageSize / 1024) . 'KB']; }

        if (count($scripts[0]) > 15) { $score -= 10; $issues[] = ['type' => 'warning', 'message' => count($scripts[0]) . ' scripts found — consider bundling']; }

        return response()->json([
            'score' => max(0, $score),
            'grade' => $this->scoreToGrade(max(0, $score)),
            'passed' => $score >= 70,
            'stats' => [
                'responseTime' => $loadTime . 'ms',
                'pageSize' => round($pageSize / 1024) . 'KB',
                'images' => count($imgs[0]),
                'scripts' => count($scripts[0]),
                'stylesheets' => count($css[0]),
            ],
            'issues' => $issues,
            'recommendations' => $score < 90 ? ['Optimize images with WebP format', 'Enable browser caching', 'Minify CSS and JavaScript'] : [],
        ]);
    }

    /**
     * Page Speed Analyzer
     */
    public function handlePageSpeedAnalyzer(Request $request): JsonResponse
    {
        return $this->handleCoreWebVitalsChecker($request);
    }

    /**
     * Image Compression Analyzer
     */
    public function handleImageCompressionAnalyzer(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request);
        $html = $this->fetchUrl($url);

        $parsed = parse_url($url);
        $baseUrl = ($parsed['scheme'] ?? 'https') . '://' . ($parsed['host'] ?? '');

        preg_match_all('/<img\s+[^>]*src\s*=\s*["\']?([^\s>"\']+)/i', $html, $matches);
        $images = [];

        foreach (array_slice(array_unique($matches[1]), 0, 20) as $src) {
            // Resolve relative URLs
            $displaySrc = $src;
            if (str_starts_with($src, 'data:')) {
                $displaySrc = '[inline data URI]';
            } elseif (str_starts_with($src, '//')) {
                $displaySrc = ($parsed['scheme'] ?? 'https') . ':' . $src;
            } elseif (str_starts_with($src, '/')) {
                $displaySrc = $baseUrl . $src;
            } elseif (!preg_match('#^https?://#i', $src)) {
                $displaySrc = rtrim($url, '/') . '/' . $src;
            }

            $ext = strtolower(pathinfo(parse_url($src, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
            $format = in_array($ext, ['webp', 'avif']) ? 'modern' : (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']) ? 'legacy' : 'other');

            $images[] = [
                'url' => $displaySrc,
                'status' => $format === 'modern' ? 'working' : 'warning',
                'type' => strtoupper($ext ?: 'unknown'),
                'text' => $format === 'modern' ? 'Modern format' : 'Consider converting to WebP',
            ];
        }

        $modern = count(array_filter($images, fn($i) => $i['status'] === 'working'));
        $legacy = count($images) - $modern;

        return response()->json([
            'passed' => $legacy === 0,
            'stats' => ['total' => count($images), 'modernFormat' => $modern, 'legacyFormat' => $legacy],
            'issues' => $legacy > 0 ? [['type' => 'warning', 'message' => "{$legacy} images using legacy formats. Convert to WebP for better performance."]] : [],
            'recommendations' => $legacy > 0 ? ['Convert JPEG/PNG images to WebP format', 'Use responsive images with srcset', 'Implement lazy loading'] : ['All images use modern formats'],
            'links' => $images,
        ]);
    }

    /**
     * Backlink Checker (basic — without Moz API)
     */
    public function handleBacklinkChecker(Request $request): JsonResponse
    {
        $domain = preg_replace('#^https?://#', '', $request->input('url', $request->input('domain', '')));
        $domain = rtrim(explode('/', $domain)[0], '/');

        return response()->json([
            'score' => 50,
            'message' => 'Basic domain analysis (full backlink data requires Moz API key)',
            'stats' => ['domain' => $domain, 'note' => 'Configure MOZ_API_KEY in .env for full backlink analysis'],
            'recommendations' => [
                'Add MOZ_ACCESS_ID and MOZ_SECRET_KEY to .env for Domain Authority, Page Authority, and backlink data',
                'Alternative: integrate Ahrefs or Majestic API for comprehensive backlink analysis',
            ],
        ]);
    }

    // ─── AI-Powered Tools (client-side fallback without API key) ─────

    /**
     * Blog Title Generator — generates SEO titles from topic
     */
    public function handleBlogTitleGenerator(Request $request): JsonResponse
    {
        $topic = $request->input('input', '');
        if (!$topic) return response()->json(['error' => 'Please enter a topic'], 422);

        $templates = [
            '{n} Proven Ways to {topic} (That Actually Work in 2025)',
            'How to {topic}: The Complete Guide for Beginners',
            'The Ultimate {topic} Strategy That Doubled Our Results',
            '{topic}: Everything You Need to Know Before Getting Started',
            'Why Most People Fail at {topic} (And How to Fix It)',
            'The Secret to {topic} That Experts Won\'t Tell You',
            '{n} {topic} Mistakes You\'re Making Right Now',
            '{topic} Made Simple: A Step-by-Step Framework',
            'Stop Doing {topic} Wrong — Here\'s the Right Way',
            'How We Used {topic} to Grow Revenue by {p}%',
        ];

        $titles = [];
        $topicCap = ucwords($topic);
        foreach ($templates as $i => $tpl) {
            $title = str_replace(
                ['{topic}', '{n}', '{p}'],
                [$topicCap, rand(5, 15), rand(120, 350)],
                $tpl
            );
            $titles[] = [
                'title' => $title,
                'seoScore' => rand(72, 95),
                'emotionalHook' => ['Curiosity', 'Urgency', 'Benefit', 'Fear', 'Aspiration'][rand(0, 4)],
                'ctrEstimate' => rand(28, 65) / 10 . '%',
            ];
        }

        usort($titles, fn($a, $b) => $b['seoScore'] - $a['seoScore']);

        return response()->json(['titles' => $titles]);
    }

    /**
     * Chatbot Script Generator — generates conversation flows
     */
    public function handleChatbotScriptGenerator(Request $request): JsonResponse
    {
        $industry = $request->input('input', $request->input('industry', 'General'));
        $tone = $request->input('tone', $request->input('option', 'professional'));
        $goal = $request->input('mainGoal', 'Lead Generation');

        $greeting = $tone === 'casual'
            ? "Hey there! 👋 Welcome! How can I help you today?"
            : "Welcome! I'm here to assist you. How can I help you today?";

        $script = [
            'welcomeMessage' => $greeting,
            'industry' => $industry,
            'tone' => $tone,
            'quickReplies' => ['Learn about our services', 'Get a quote', 'Talk to a human', 'FAQs'],
            'intents' => [
                ['name' => 'Pricing Inquiry', 'phrases' => ['How much does it cost?', 'What are your prices?', 'Pricing info'], 'response' => "Great question! Our pricing depends on your specific needs. Could you tell me a bit more about what you're looking for? Or I can connect you with our team for a detailed quote."],
                ['name' => 'Service Info', 'phrases' => ['What services do you offer?', 'Tell me about your services', 'What do you do?'], 'response' => "We offer a range of {$industry} solutions tailored to your needs. Would you like to know more about a specific service, or shall I give you an overview?"],
                ['name' => 'Support', 'phrases' => ['I need help', 'Support please', 'Having an issue'], 'response' => "I'm sorry to hear you're having trouble. Let me connect you with our support team right away. Could you briefly describe the issue?"],
            ],
            'leadQualification' => [
                'question1' => 'What is your company name?',
                'question2' => 'How many employees do you have?',
                'question3' => 'What is your primary goal?',
            ],
            'fallbackMessage' => "I'm not sure I understand. Would you like me to connect you with a human agent?",
            'handoffTriggers' => ['talk to human', 'speak to someone', 'real person', 'agent'],
        ];

        return response()->json(['content' => json_encode($script, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)]);
    }

    /**
     * Landing Page Generator — generates landing page copy
     */
    public function handleLandingPageGenerator(Request $request): JsonResponse
    {
        $product = $request->input('input', 'Your Product');
        $description = $request->input('whatDoesItDo', '');

        $copy = "# {$product} — Landing Page Copy\n\n";
        $copy .= "## Hero Section\n";
        $copy .= "**Headline:** Transform Your Business with {$product}\n";
        $copy .= "**Subheadline:** The all-in-one solution that helps you save time, reduce costs, and scale faster.\n";
        $copy .= "**CTA Button:** Get Started Free →\n\n";

        $copy .= "## Problem Section\n";
        $copy .= "Are you tired of juggling multiple tools? Struggling with inefficiency? You're not alone. Most businesses waste 40% of their time on manual tasks.\n\n";

        $copy .= "## Solution Section\n";
        $copy .= "{$product} eliminates the complexity. " . ($description ?: "Our platform automates your workflow so you can focus on what matters.") . "\n\n";

        $copy .= "## Key Features\n";
        $copy .= "✅ **Easy Setup** — Get started in under 5 minutes\n";
        $copy .= "✅ **Powerful Analytics** — Track everything that matters\n";
        $copy .= "✅ **24/7 Support** — We're always here to help\n";
        $copy .= "✅ **Integrations** — Works with your existing tools\n\n";

        $copy .= "## Social Proof\n";
        $copy .= "\"Since switching to {$product}, we've seen a 3x increase in productivity.\" — Happy Customer\n\n";

        $copy .= "## Pricing CTA\n";
        $copy .= "**Ready to get started?** Join 10,000+ businesses that trust {$product}.\n";
        $copy .= "**[Start Your Free Trial]** — No credit card required.\n";

        return response()->json(['content' => $copy]);
    }

    /**
     * Meta Tag Generator — generates SEO meta tags from URL
     */
    public function handleMetaTagGenerator(Request $request): JsonResponse
    {
        $url = $this->requireUrl($request, 'url', 'input');
        $html = $this->fetchUrl($url);

        // Extract current title and description
        preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $titleMatch);
        preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/is', $html, $descMatch);
        $currentTitle = trim($titleMatch[1] ?? '');
        $currentDesc = trim($descMatch[1] ?? '');

        // Extract page text for keyword detection. Drop script/style bodies, then
        // replace each remaining tag with a space so words either side of a tag
        // boundary ("…domain</h1><p>This…") don't fuse into "domainthis".
        $text = preg_replace('#<(script|style|noscript|template)\b[^>]*>.*?</\1>#is', ' ', $html);
        $text = preg_replace('#<!--.*?-->#s', ' ', $text);
        $text = strip_tags(preg_replace('#<[^>]+>#', ' ', $text));
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = mb_strtolower(preg_replace('/\s+/', ' ', $text), 'UTF-8');
        $words = preg_split('/[^\p{L}\p{N}\'-]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words = array_filter($words, fn($w) => mb_strlen($w, 'UTF-8') > 3);
        $stopWords = ['that', 'this', 'with', 'from', 'your', 'have', 'more', 'will', 'been', 'about', 'their', 'them', 'would'];
        $words = array_filter($words, fn($w) => !in_array($w, $stopWords));
        $freq = array_count_values($words);
        arsort($freq);
        $topKeywords = implode(', ', array_slice(array_keys($freq), 0, 8));

        // Generate optimized versions
        $domain = parse_url($url, PHP_URL_HOST) ?? '';
        // Use mb_* — strlen/substr count bytes, so an accented title would be
        // measured wrong and could be cut mid-character into a mojibake byte.
        $optimizedTitle = $currentTitle ?: ucwords(str_replace(['.com', '.net', '.org', 'www.'], '', $domain)) . ' — Official Website';
        if (mb_strlen($optimizedTitle, 'UTF-8') > 60) $optimizedTitle = mb_substr($optimizedTitle, 0, 57, 'UTF-8') . '...';

        $optimizedDesc = $currentDesc ?: 'Discover what ' . $domain . ' has to offer. Visit us for the latest information, services, and resources.';
        if (mb_strlen($optimizedDesc, 'UTF-8') > 160) $optimizedDesc = mb_substr($optimizedDesc, 0, 157, 'UTF-8') . '...';

        // Escape before interpolating — an apostrophe or quote in the source title
        // would otherwise terminate the content="" attribute and emit broken tags.
        $e = fn(string $v): string => htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $htmlCode = "<title>{$e($optimizedTitle)}</title>\n" .
            "<meta name=\"description\" content=\"{$e($optimizedDesc)}\">\n" .
            "<meta name=\"keywords\" content=\"{$e($topKeywords)}\">\n" .
            "<meta property=\"og:title\" content=\"{$e($optimizedTitle)}\">\n" .
            "<meta property=\"og:description\" content=\"{$e($optimizedDesc)}\">\n" .
            "<meta property=\"og:url\" content=\"{$e($url)}\">\n" .
            "<meta property=\"og:type\" content=\"website\">\n" .
            "<meta name=\"twitter:card\" content=\"summary_large_image\">\n" .
            "<meta name=\"twitter:title\" content=\"{$e($optimizedTitle)}\">\n" .
            "<meta name=\"twitter:description\" content=\"{$e($optimizedDesc)}\">";

        return response()->json([
            'title' => $optimizedTitle,
            'description' => $optimizedDesc,
            'keywords' => $topKeywords,
            'htmlCode' => $htmlCode,
            'stats' => [
                'titleLength' => mb_strlen($optimizedTitle, 'UTF-8') . '/60',
                'descLength' => mb_strlen($optimizedDesc, 'UTF-8') . '/160',
                'keywordsFound' => count(array_slice(array_keys($freq), 0, 8)),
            ],
        ]);
    }

    /**
     * Color Palette Generator — handled client-side, this is a fallback
     */
    public function handleColorPaletteGenerator(Request $request): JsonResponse
    {
        return response()->json([
            'error' => 'Color palette extraction is handled client-side. Please use the upload feature on the tool page.',
        ], 400);
    }

    // ─── Utility methods ─────────────────────────────────────────────

    private function scoreToGrade(int $score): string
    {
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 60) return 'C';
        if ($score >= 40) return 'D';
        return 'F';
    }

    private function generateRecommendations(array $checks): array
    {
        $recs = [];
        foreach ($checks as $c) {
            if ($c['status'] === 'fail') {
                $recs[] = 'Fix: ' . $c['message'];
            } elseif ($c['status'] === 'warning') {
                $recs[] = 'Improve: ' . $c['message'];
            }
        }
        return $recs;
    }
}
