<?php

/**
 * Generate downscaled WebP variants next to the originals (suffix -<w>w.webp).
 * Originals are never modified or overwritten. Idempotent: existing variants
 * are skipped unless the source is newer.
 *
 * Usage: php scripts/generate-image-variants.php
 */

$public = dirname(__DIR__).'/public';

$jobs = [
    // Showcase carousel (1280×853 originals, rendered 480×320 CSS px)
    'images' => [
        'files' => [
            'study-abroad-hero2ad8', 'fintech-hero835e', 'healthcare-provider-hero8f91',
            'saas-dashboard-hero338c', 'ecommerce-hero7b6e', 'professional-services-hero4f40',
            'edtech-herodbd9', 'ai-heroc6fe', 'saas-herod5d6', 'healthcare-heroeb9b',
        ],
        'widths' => [480, 960],
    ],
    // Benefits illustrations (800×800, rendered 112–256 CSS px)
    'images:benefits' => [
        'files' => [
            'benefits-ai-intelligence', 'benefits-dashboard-design', 'benefits-growth-strategy',
            'benefits-complete-solution', 'benefits-industry-expertise', 'benefits-tech-stack',
        ],
        'widths' => [224, 512],
        'dir' => 'images',
    ],
    // Testimonial avatars (256×256, rendered 33–48 CSS px)
    'images/testimonials' => [
        'files' => ['mounira-kajia', 'dental-pro', 'gls-ceo', 'mohammed-chajia', 'mohammed-al-raba', 'sarah-al-mansouri'],
        'widths' => [96],
    ],
    // Case-study mockups (640×983/991, rendered 146–300 CSS px)
    'mockups' => [
        'files' => [
            'morocco-quest-top', 'morocco-quest-bottom', 'dental-pro-top', 'dental-pro-bottom',
            'gls-top', 'gls-bottom', 'local-morocco-tours-top', 'local-morocco-tours-bottom',
            'authentic-morocco-adventures-top', 'authentic-morocco-adventures-bottom',
        ],
        'widths' => [320],
    ],
];

$made = 0; $skipped = 0; $missing = [];

foreach ($jobs as $key => $job) {
    $dir = $job['dir'] ?? explode(':', $key)[0];
    foreach ($job['files'] as $name) {
        $src = "$public/$dir/$name.webp";
        if (! is_file($src)) { $missing[] = "$dir/$name.webp"; continue; }

        $img = imagecreatefromwebp($src);
        if (! $img) { $missing[] = "$dir/$name.webp (decode failed)"; continue; }
        $w = imagesx($img); $h = imagesy($img);

        foreach ($job['widths'] as $tw) {
            if ($tw >= $w) { continue; } // never upscale
            $out = "$public/$dir/$name-{$tw}w.webp";
            if (is_file($out) && filemtime($out) >= filemtime($src)) { $skipped++; continue; }

            $th = (int) round($h * $tw / $w);
            $scaled = imagescale($img, $tw, $th, IMG_BICUBIC);
            imagealphablending($scaled, false);
            imagesavealpha($scaled, true);
            imagewebp($scaled, $out, 82);
            imagedestroy($scaled);

            printf("%-60s %4dx%-4d %7.1f KiB (orig %7.1f KiB)\n",
                "$dir/$name-{$tw}w.webp", $tw, $th,
                filesize($out) / 1024, filesize($src) / 1024);
            $made++;
        }
        imagedestroy($img);
    }
}

echo "\n$made variant(s) generated, $skipped up-to-date.\n";
if ($missing) { echo "Missing sources:\n  ".implode("\n  ", $missing)."\n"; }
