<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExtractRemainingText extends Command
{
    protected $signature = 'translations:extract-remaining';
    protected $description = 'Second pass: extract remaining hardcoded text (options, labels, placeholders, li items)';

    private string $basePath;
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $files = $this->getAllBladeFiles($this->basePath);

        $this->info('🔍 Second pass: scanning for remaining hardcoded text...');

        foreach ($files as $file) {
            $this->processFile($file);
        }

        $this->newLine();
        $this->info("✅ Second pass: {$this->totalFiles} files updated, {$this->totalKeys} new keys extracted.");
        return Command::SUCCESS;
    }

    private function getAllBladeFiles(string $dir): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
                $files[] = $file->getPathname();
            }
        }
        sort($files);
        return $files;
    }

    private function processFile(string $filePath): void
    {
        $content = file_get_contents($filePath);
        $relativePath = str_replace([$this->basePath . DIRECTORY_SEPARATOR, '.blade.php'], '', $filePath);
        $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);

        // Build the translation key prefix using / for directories
        $keyPrefix = $relativePath;

        // Load existing translation keys to find the next index
        $langFile = base_path("lang/fr/{$relativePath}.php");
        $existing = [];
        if (file_exists($langFile)) {
            $existing = include $langFile;
            if (!is_array($existing)) $existing = [];
        }

        // Find the highest existing text_ index
        $maxIndex = 0;
        foreach (array_keys($existing) as $key) {
            if (preg_match('/^(?:text|opt|label|placeholder|li)_(\d+)$/', $key, $m)) {
                $maxIndex = max($maxIndex, (int)$m[1]);
            }
        }
        $nextIndex = $maxIndex + 100; // Start at offset to avoid collisions

        $fr = [];
        $en = [];
        $modified = $content;
        $changed = false;

        // ── 1. <option value="...">French text</option> ──────────────────────
        $modified = preg_replace_callback(
            '/<option(\s+value="[^"]*")>([^<{]+)<\/option>/',
            function ($match) use (&$fr, &$en, &$nextIndex, $keyPrefix, &$changed) {
                $attrs = $match[1];
                $text = trim($match[2]);

                if (mb_strlen($text) < 2 || $this->isEnglishOnly($text)) return $match[0];

                $key = 'opt_' . $nextIndex++;
                $fr[$key] = $text;
                $en[$key] = $this->translate($text);
                $changed = true;

                return "<option{$attrs}>{{ __('{$keyPrefix}.{$key}') }}</option>";
            },
            $modified
        );

        // ── 2. <label ...>French text <span>...</span></label> ──────────────
        $modified = preg_replace_callback(
            '/<label([^>]*)>([^<{]+?)(\s*<span[^>]*>\*<\/span>)?<\/label>/',
            function ($match) use (&$fr, &$en, &$nextIndex, $keyPrefix, &$changed) {
                $attrs = $match[1];
                $text = trim($match[2]);
                $asterisk = $match[3] ?? '';

                if (mb_strlen($text) < 2 || $this->isEnglishOnly($text)) return $match[0];

                $key = 'label_' . $nextIndex++;
                $fr[$key] = $text;
                $en[$key] = $this->translate($text);
                $changed = true;

                return "<label{$attrs}>{{ __('{$keyPrefix}.{$key}') }}{$asterisk}</label>";
            },
            $modified
        );

        // Also handle labels where text is before a <span> inside the label
        $modified = preg_replace_callback(
            '/>([A-ZÀ-Üa-zà-ÿ][^<{]*?)(\s*<span[^>]*class="text-\[#00AEEF\]"[^>]*>\*<\/span>)<\/label>/',
            function ($match) use (&$fr, &$en, &$nextIndex, $keyPrefix, &$changed) {
                $text = trim($match[1]);
                $asterisk = $match[2];

                if (mb_strlen($text) < 3 || $this->isEnglishOnly($text) || str_contains($text, '{{')) return $match[0];

                $key = 'label_' . $nextIndex++;
                $fr[$key] = $text;
                $en[$key] = $this->translate($text);
                $changed = true;

                return ">{{ __('{$keyPrefix}.{$key}') }}{$asterisk}</label>";
            },
            $modified
        );

        // ── 3. placeholder="French text" (not already using __()) ────────────
        $modified = preg_replace_callback(
            '/placeholder="([^"{}]+)"/',
            function ($match) use (&$fr, &$en, &$nextIndex, $keyPrefix, &$changed) {
                $text = $match[1];

                // Skip English-only placeholders, URLs, examples
                if (preg_match('/^https?:\/\//', $text)) return $match[0];
                if (preg_match('/^[a-zA-Z0-9\s\.\@\+\-\_]+$/', $text) && !$this->hasFrench($text)) return $match[0];
                if (mb_strlen($text) < 3) return $match[0];
                if (str_contains($match[0], '{{')) return $match[0];

                // Only process if text has French characters/words
                if (!$this->hasFrench($text)) return $match[0];

                $key = 'placeholder_' . $nextIndex++;
                $fr[$key] = $text;
                $en[$key] = $this->translate($text);
                $changed = true;

                return "placeholder=\"{{ __('{$keyPrefix}.{$key}') }}\"";
            },
            $modified
        );

        // ── 4. Remaining >French text< that was missed (aggressive match) ────
        $modified = preg_replace_callback(
            '/>((?:(?!<|>|\{\{|\{!!|@)[^\n])+)</m',
            function ($match) use (&$fr, &$en, &$nextIndex, $keyPrefix, &$changed) {
                $text = $match[1];
                $trimmed = trim(str_replace(['<!-- -->', "\r"], ['', ''], $text));
                $trimmed = preg_replace('/\s+/', ' ', $trimmed);

                // Skip very short, code-like, numbers-only
                if (mb_strlen($trimmed) < 3) return $match[0];
                if (preg_match('/^[\d\s\.\,\:\;\-\–\—\|\•\+\#\@\/\\\\%\&\=\!\?\*\(\)\[\]]+$/', $trimmed)) return $match[0];
                if (preg_match('/^\d+[\+\%]?$/', $trimmed)) return $match[0];
                if (preg_match('/^(CodeSommet|Blog|FAQ|SaaS|SEO|UI\/UX|API|CSS|HTML|JSON|XML|RSS|URL)$/i', $trimmed)) return $match[0];
                if (preg_match('/^[A-Z][a-z]+$/', $trimmed) && mb_strlen($trimmed) < 8) return $match[0]; // Single short English word

                // Must have French indicators
                if (!$this->hasFrench($trimmed)) return $match[0];

                $key = 'text_' . $nextIndex++;
                $fr[$key] = $trimmed;
                $en[$key] = $this->translate($trimmed);
                $changed = true;

                $leadingSpace = '';
                $trailingSpace = '';
                if (preg_match('/^(\s+)/', $match[1], $lm)) $leadingSpace = $lm[1];
                if (preg_match('/(\s+)$/', $match[1], $tm)) $trailingSpace = $tm[1];

                return ">{$leadingSpace}{{ __('{$keyPrefix}.{$key}') }}{$trailingSpace}<";
            },
            $modified
        );

        if (!$changed || empty($fr)) return;

        $this->totalFiles++;
        $this->totalKeys += count($fr);
        $this->info("  📄 {$relativePath} → " . count($fr) . " new keys");

        // Merge into existing translation files
        foreach (['fr' => $fr, 'en' => $en] as $locale => $newKeys) {
            $path = base_path("lang/{$locale}/{$relativePath}.php");
            $existingData = [];
            if (file_exists($path)) {
                $existingData = include $path;
                if (!is_array($existingData)) $existingData = [];
            }
            $merged = array_merge($existingData, $newKeys);
            $dir = dirname($path);
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            file_put_contents($path, $this->buildPhpArray($merged));
        }

        // Write modified Blade
        file_put_contents($filePath, $modified);
    }

    private function hasFrench(string $text): bool
    {
        // French accented characters
        if (preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/', $text)) return true;

        // Common French words
        if (preg_match('/\b(nous|votre|notre|avec|pour|dans|des|les|une|est|sont|par|sur|aux|cette|qui|que|tout|très|mais|aussi|plus|sans|vers|même|après|avant|encore|autres|leurs|ses|mes|tes|nos|vos|ou|et|le|la|du|un|au|de|ce|en|ne|pas|bien|bon|peu|ici|là|heure|jour|mois|semaine|nouveau|autre|petit|grand|moyen|projet|devis|site|page|nom|complet|adresse|gratuit|personnalisé|recommandation|annuaire|entreprise|immobilier|logiciel|boutique|refonte|atterrissage|tableau|bord|actuel|optionnel|secteur|activité|couleur|police|contenu|ajustement|modification|remboursement|comportement|mutuellement|blanchiment|plagiat|installation|suivi|espion|argent|fraude|travail|autrui)\b/iu', $text)) return true;

        // HTML entities for French chars
        if (preg_match('/&#x0[0-9A-F]{2};/', $text)) return true;

        return false;
    }

    private function isEnglishOnly(string $text): bool
    {
        return preg_match('/^[a-zA-Z0-9\s\.\,\:\;\-\–\—\/\(\)\[\]\{\}\@\#\$\%\^\&\*\!\?\+\=\_\~\`\'\"\|\\\\]+$/', $text)
            && !$this->hasFrench($text);
    }

    private function translate(string $frText): string
    {
        $map = [
            'Petit Projet' => 'Small Project',
            'Projet Moyen' => 'Medium Project',
            'Grand Projet' => 'Large Project',
            'Entreprise' => 'Enterprise',
            'Demande de Nouveau Projet' => 'New Project Request',
            'Support & Maintenance' => 'Support & Maintenance',
            'Support &amp; Maintenance' => 'Support & Maintenance',
            'Autre' => 'Other',
            'Nouveau site web' => 'New Website',
            'Refonte de site web' => 'Website Redesign',
            'Application web' => 'Web Application',
            'Boutique e-commerce' => 'E-commerce Store',
            'Plateforme SaaS' => 'SaaS Platform',
            "Page d'atterrissage" => 'Landing Page',
            'Tableau de bord' => 'Dashboard',
            'Santé / Médical' => 'Healthcare / Medical',
            'SaaS / Logiciel B2B' => 'SaaS / B2B Software',
            'FinTech / Finance' => 'FinTech / Finance',
            'Immobilier' => 'Real Estate',
            'Voyage / Hôtellerie' => 'Travel / Hospitality',
            'Pas sûr' => 'Not sure',
            'Croissance (Projet moyen)' => 'Growth (Medium Project)',
            'Sous 2 semaines' => 'Within 2 weeks',
            'Sous 1 mois' => 'Within 1 month',
            'Je me renseigne' => 'Just exploring',
            'Recommandation' => 'Referral',
            'Clutch / Annuaire' => 'Clutch / Directory',
            'Nom Complet' => 'Full Name',
            'Nom complet' => 'Full name',
            'Adresse e-mail' => 'Email address',
            'Téléphone / WhatsApp' => 'Phone / WhatsApp',
            'Taille du Projet (Optionnel)' => 'Project Size (Optional)',
            'Type de projet' => 'Project type',
            "Secteur d'activité" => 'Industry',
            'URL du site web actuel' => 'Current website URL',
            'Site web de référence 1' => 'Reference website 1',
            'Site web de référence 2 (Optionnel)' => 'Reference website 2 (Optional)',
            'Jean Dupont' => 'John Doe',
            'Salon de Coiffure' => 'Hair Salon',
            'Avocat / Juriste' => 'Attorney / Lawyer',
            'Agent Immobilier' => 'Real Estate Agent',
            'Conclusion' => 'Conclusion',
        ];

        if (isset($map[$frText])) return $map[$frText];

        foreach ($map as $fr => $en) {
            if (str_contains($frText, $fr)) {
                $frText = str_replace($fr, $en, $frText);
            }
        }

        if (preg_match('/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/', $frText)) {
            return '[TRANSLATE] ' . $frText;
        }

        return $frText;
    }

    private function buildPhpArray(array $translations): string
    {
        $lines = ["<?php\n", "return ["];
        foreach ($translations as $key => $value) {
            $escaped = str_replace("\\", "\\\\", $value);
            $escaped = str_replace("'", "\\'", $escaped);
            $lines[] = "    '{$key}' => '{$escaped}',";
        }
        $lines[] = "];\n";
        return implode("\n", $lines);
    }
}
