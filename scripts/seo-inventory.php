<?php
/**
 * SEO inventory / validation crawler (local, no HTTP server needed).
 *
 * Renders every public URL through the Laravel kernel and extracts the
 * SEO-critical elements into a CSV.
 *
 *   php scripts/seo-inventory.php [out.csv]
 *
 * Columns: url,status,indexable,canonical,title,title_len,description,
 *          description_len,h1_count,h1,h2_count,h3_count,words,images,
 *          images_no_alt,internal_links,lang
 */

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$out = $argv[1] ?? 'php://stdout';

$paths = ['/', '/about', '/contact', '/get-quote', '/our-work', '/industries', '/locations', '/tools', '/blog'];
foreach (config('pages.legal', []) as $s) {
    $paths[] = "/legal/{$s}";
}
foreach (config('pages.services', []) as $s) {
    $paths[] = "/services/{$s}";
}
foreach (config('pages.cities', []) as $c) {
    $paths[] = "/web-development-company/{$c}";
}
foreach (glob(resource_path('views/frontoffice/pages/tools/*.blade.php')) as $f) {
    $paths[] = '/tools/'.basename($f, '.blade.php');
}
foreach (glob(resource_path('views/frontoffice/pages/our-work/*.blade.php')) as $f) {
    $paths[] = '/our-work/'.basename($f, '.blade.php');
}
try {
    foreach (App\Models\BlogPost::published()->pluck('slug') as $slug) {
        $paths[] = '/blog/'.$slug;
    }
} catch (Throwable $e) {
    fwrite(STDERR, "blog posts skipped: {$e->getMessage()}\n");
}

$fh = fopen($out, 'w');
fwrite($fh, "\xEF\xBB\xBF");
fputcsv($fh, ['url', 'status', 'indexable', 'canonical', 'title', 'title_len', 'description', 'description_len',
    'h1_count', 'h1', 'h2_count', 'h3_count', 'words', 'images', 'images_no_alt', 'internal_links', 'lang'], ';');

$text = static fn (?DOMNode $n): string => $n ? trim(preg_replace('/\s+/u', ' ', $n->textContent)) : '';

foreach ($paths as $path) {
    $request = Illuminate\Http\Request::create($path, 'GET');
    try {
        $response = $kernel->handle($request);
        $status = $response->getStatusCode();
        $html = (string) $response->getContent();
        $kernel->terminate($request, $response);
    } catch (Throwable $e) {
        $status = 500;
        $html = '';
        fwrite(STDERR, "{$path}: {$e->getMessage()}\n");
    }

    $row = [$path, $status, '', '', '', 0, '', 0, 0, '', 0, 0, 0, 0, 0, 0, ''];
    if ($html !== '') {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();
        $xp = new DOMXPath($doc);

        $robots = $xp->query('//meta[@name="robots"]/@content')->item(0)?->nodeValue ?? '';
        $row[2] = str_contains(strtolower($robots), 'noindex') ? 'noindex' : 'index';
        $row[3] = $xp->query('//link[@rel="canonical"]/@href')->item(0)?->nodeValue ?? '';
        $row[4] = $text($xp->query('//title')->item(0));
        $row[5] = mb_strlen($row[4]);
        $row[6] = trim($xp->query('//meta[@name="description"]/@content')->item(0)?->nodeValue ?? '');
        $row[7] = mb_strlen($row[6]);
        $h1 = $xp->query('//h1');
        $row[8] = $h1->length;
        $row[9] = $text($h1->item(0));
        $row[10] = $xp->query('//h2')->length;
        $row[11] = $xp->query('//h3')->length;
        $main = $xp->query('//main')->item(0) ?? $doc->getElementsByTagName('body')->item(0);
        $row[12] = str_word_count(strip_tags($text($main)));
        $imgs = $xp->query('//img');
        $row[13] = $imgs->length;
        $noAlt = 0;
        foreach ($imgs as $img) {
            if (! $img->hasAttribute('alt')) {
                $noAlt++;
            }
        }
        $row[14] = $noAlt;
        $base = rtrim((string) config('app.url'), '/');
        // Request::create() renders route() URLs against http://localhost, so count that host too.
        $row[15] = $xp->query('//a[starts-with(@href,"/") or starts-with(@href,"'.$base.'") or starts-with(@href,"http://localhost") or contains(@href,"codesommet.com")]')->length;
        $row[16] = $doc->documentElement?->getAttribute('lang') ?? '';
    }
    fputcsv($fh, $row, ';');
}
fclose($fh);
fwrite(STDERR, count($paths)." urls\n");
