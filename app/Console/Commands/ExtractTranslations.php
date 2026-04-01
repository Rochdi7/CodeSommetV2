<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ExtractTranslations extends Command
{
    protected $signature = 'translations:extract {--dry-run : Show what would be done without writing files}';
    protected $description = 'Extract hardcoded French text from frontoffice Blade files and create translation files';

    private string $basePath;
    private array $frStrings = [];
    private array $enStrings = [];
    private int $totalKeys = 0;
    private int $totalFiles = 0;

    // Common French → English translations for repeated patterns
    private array $commonTranslations = [
        // Meta / SEO
        'Accueil' => 'Home',
        'Emplacements' => 'Locations',
        'Industries' => 'Industries',
        'Outils' => 'Tools',
        'Services' => 'Services',

        // Breadcrumb
        'Retour' => 'Back',

        // Badges
        'Nous Acceptons Maintenant' => 'Now Accepting',
        'Accepte Actuellement les' => 'Currently Accepting',
        'Projets' => 'Projects',

        // CTA
        'Réserver une Consultation Gratuite' => 'Book a Free Consultation',
        'Réserver un Appel Découverte Gratuit' => 'Book a Free Discovery Call',
        'Réserver un Appel Découverte' => 'Book a Discovery Call',
        'Voir le Portfolio' => 'View Portfolio',
        'Voir les Tarifs' => 'View Pricing',
        'Commencer Votre Projet' => 'Start Your Project',
        'Voir Nos Projets' => 'View Our Projects',
        'Demander un Devis' => 'Request a Quote',
        'Commencer' => 'Get Started',
        'En Savoir Plus' => 'Learn More',
        'Obtenir un Devis Gratuit' => 'Get a Free Quote',
        'Lancer Votre Projet' => 'Launch Your Project',
        'Démarrer un Projet' => 'Start a Project',

        // Stats
        'Basé à' => 'Based in',
        'Basé dans le secteur' => 'Specialized in',
        'Livraison en 7-10 Jours' => 'Delivery in 7-10 Days',
        'Livraison en 7 Jours' => 'Delivery in 7 Days',
        'clients à' => 'clients in',
        'Clients' => 'Clients',
        'Projets Livrés' => 'Projects Delivered',
        'Satisfaction Client' => 'Client Satisfaction',
        'Pays Servis' => 'Countries Served',
        'Ans d\'Expérience' => 'Years of Experience',

        // Sections
        'Pourquoi Nous Choisir' => 'Why Choose Us',
        'Questions Fréquemment Posées' => 'Frequently Asked Questions',
        'Questions Fréquentes' => 'Frequently Asked Questions',
        'FAQ' => 'FAQ',
        'Prêt à Lancer Votre Projet ?' => 'Ready to Launch Your Project?',
        'Prêt à Transformer Votre Présence en Ligne ?' => 'Ready to Transform Your Online Presence?',
        'Outils Associés' => 'Related Tools',
        'Nos Services' => 'Our Services',
        'Notre Processus' => 'Our Process',
        'Nos Valeurs' => 'Our Values',
        'Notre Équipe' => 'Our Team',
        'Ce Que Nous Offrons' => 'What We Offer',
        'Comment Ça Marche' => 'How It Works',
        'Fonctionnalités Clés' => 'Key Features',
        'Fonctionnalités' => 'Features',
        'Technologies' => 'Technologies',
        'Avantages' => 'Benefits',
        'Témoignages' => 'Testimonials',

        // Form
        'Nom complet' => 'Full name',
        'Adresse e-mail' => 'Email address',
        'Numéro de téléphone' => 'Phone number',
        'Entreprise' => 'Company',
        'Message' => 'Message',
        'Envoyer le Message' => 'Send Message',
        'Soumettre' => 'Submit',
        'Obligatoire' => 'Required',

        // Tool pages
        'Gratuit' => 'Free',
        'Aucune inscription requise' => 'No signup required',
        'Analyser' => 'Analyze',
        'Générer' => 'Generate',
        'Vérifier' => 'Check',
        'Résultats' => 'Results',
        'Copier' => 'Copy',
        'Télécharger' => 'Download',
        'Réinitialiser' => 'Reset',
    ];

    public function handle(): int
    {
        $this->basePath = resource_path('views/frontoffice/pages');
        $isDryRun = $this->option('dry-run');

        $this->info('🔍 Scanning frontoffice Blade files...');
        $this->newLine();

        $files = $this->getAllBladeFiles($this->basePath);
        $this->info("Found " . count($files) . " Blade files to process.");
        $this->newLine();

        foreach ($files as $file) {
            $this->processFile($file, $isDryRun);
        }

        $this->newLine();
        $this->info("✅ Processed {$this->totalFiles} files, extracted {$this->totalKeys} translation keys.");

        if ($isDryRun) {
            $this->warn('⚠️  Dry run mode — no files were modified. Remove --dry-run to apply changes.');
        }

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

    private function processFile(string $filePath, bool $isDryRun): void
    {
        $content = file_get_contents($filePath);
        $relativePath = str_replace([$this->basePath . DIRECTORY_SEPARATOR, '.blade.php'], '', $filePath);
        $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);

        // Build translation key prefix: "locations.web-development-company-dubai" → "locations/web-development-company-dubai"
        $translationFile = $relativePath; // e.g., "locations/web-development-company-dubai"
        $keyPrefix = str_replace('/', '.', $relativePath); // e.g., "locations.web-development-company-dubai"

        $fr = [];
        $en = [];
        $modified = $content;
        $keyIndex = 0;

        // ── 1. Extract @section meta tags ────────────────────────────────────
        $sectionFields = ['title', 'meta_description', 'meta_keywords', 'og_title', 'og_description', 'twitter_description'];

        foreach ($sectionFields as $field) {
            // Match @section('field', 'value') or @section('field', "value")
            $pattern = "/@section\(\s*['\"]" . preg_quote($field, '/') . "['\"]\s*,\s*(['\"])((?:(?!(?<!\\\\)\1).)*)\1\s*\)/s";

            if (preg_match($pattern, $modified, $match)) {
                $quote = $match[1];
                $value = $match[2];

                // Unescape
                $cleanValue = str_replace("\\{$quote}", $quote, $value);

                if ($this->isFrenchText($cleanValue)) {
                    $key = $field; // meta_title, meta_description, etc.
                    $fr[$key] = $cleanValue;
                    $en[$key] = $this->translateText($cleanValue);

                    $replacement = "@section('{$field}', __(\"{$keyPrefix}.{$key}\"))";
                    $modified = str_replace($match[0], $replacement, $modified);
                    $keyIndex++;
                }
            }
        }

        // ── 2. Extract visible text between HTML tags ────────────────────────
        // Match >French text< patterns (text content of HTML elements)
        $modified = preg_replace_callback(
            '/>((?:(?!<|>|\{\{|\{!!|@).)+)</m',
            function ($match) use (&$fr, &$en, &$keyIndex, $keyPrefix) {
                $text = $match[1];
                $trimmed = trim(str_replace(['<!-- -->', "\n", "\r"], ['', ' ', ''], $text));
                $trimmed = preg_replace('/\s+/', ' ', $trimmed);

                // Skip if too short, only numbers/symbols, or not French
                if (
                    mb_strlen($trimmed) < 3 ||
                    preg_match('/^[\d\s\.\,\:\;\-\–\—\|\•\+\#\@\/\\\%\&\=\!\?\*\(\)]+$/', $trimmed) ||
                    preg_match('/^[A-Z0-9\s\.\,\:\-]+$/', $trimmed) || // All caps English
                    preg_match('/^\d+[\+\%]?$/', $trimmed) ||
                    preg_match('/^(CodeSommet|CodeSommetStudio|Google Meet|Africa\/Casablanca|UAE|USA|UK)$/i', $trimmed) ||
                    preg_match('/^https?:\/\//', $trimmed) ||
                    !$this->isFrenchText($trimmed)
                ) {
                    return $match[0];
                }

                $key = 'text_' . $keyIndex;
                $fr[$key] = $trimmed;
                $en[$key] = $this->translateText($trimmed);
                $keyIndex++;

                // Preserve original whitespace around text
                $originalText = $match[1];
                $leadingSpace = '';
                $trailingSpace = '';
                if (preg_match('/^(\s+)/', $originalText, $lm)) $leadingSpace = $lm[1];
                if (preg_match('/(\s+)$/', $originalText, $tm)) $trailingSpace = $tm[1];

                return ">{$leadingSpace}{{ __(\"{$keyPrefix}.{$key}\") }}{$trailingSpace}<";
            },
            $modified
        );

        // ── 3. Extract placeholder attributes ────────────────────────────────
        $modified = preg_replace_callback(
            '/placeholder="([^"]+)"/',
            function ($match) use (&$fr, &$en, &$keyIndex, $keyPrefix) {
                $text = $match[1];
                if (!$this->isFrenchText($text) || mb_strlen($text) < 3) {
                    return $match[0];
                }

                $key = 'placeholder_' . $keyIndex;
                $fr[$key] = $text;
                $en[$key] = $this->translateText($text);
                $keyIndex++;

                return "placeholder=\"{{ __(\"{$keyPrefix}.{$key}\") }}\"";
            },
            $modified
        );

        // ── 4. Extract aria-label attributes ─────────────────────────────────
        $modified = preg_replace_callback(
            '/aria-label="([^"]+)"/',
            function ($match) use (&$fr, &$en, &$keyIndex, $keyPrefix) {
                $text = $match[1];
                if (!$this->isFrenchText($text) || mb_strlen($text) < 3) {
                    return $match[0];
                }

                $key = 'aria_' . $keyIndex;
                $fr[$key] = $text;
                $en[$key] = $this->translateText($text);
                $keyIndex++;

                return "aria-label=\"{{ __(\"{$keyPrefix}.{$key}\") }}\"";
            },
            $modified
        );

        // Skip file if no keys extracted
        if (empty($fr)) {
            return;
        }

        $this->totalKeys += count($fr);
        $this->totalFiles++;

        // ── Write translation files ──────────────────────────────────────────
        $langBasePath = base_path('lang');
        $frFilePath = $langBasePath . '/fr/' . $translationFile . '.php';
        $enFilePath = $langBasePath . '/en/' . $translationFile . '.php';

        $this->info("  📄 {$relativePath}.blade.php → " . count($fr) . " keys");

        if (!$isDryRun) {
            // Ensure directories exist
            $dir = dirname($frFilePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $dir = dirname($enFilePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // Write FR translation file
            file_put_contents($frFilePath, $this->buildPhpArray($fr));

            // Write EN translation file
            file_put_contents($enFilePath, $this->buildPhpArray($en));

            // Write modified Blade file
            file_put_contents($filePath, $modified);
        }
    }

    private function isFrenchText(string $text): bool
    {
        $text = trim($text);

        // Skip empty or very short
        if (mb_strlen($text) < 2) return false;

        // Skip if looks like code/technical
        if (preg_match('/^[\{\}\[\]\(\)<>\/\\\\]/', $text)) return false;
        if (preg_match('/^[a-z_\-\.]+$/i', $text) && !str_contains($text, ' ')) return false;

        // French indicators: accented characters, French words
        $frenchIndicators = [
            '/[àâäéèêëïîôùûüÿçœæÀÂÄÉÈÊËÏÎÔÙÛÜŸÇŒÆ]/',
            '/\b(nous|votre|notre|avec|pour|dans|des|les|une|est|sont|par|sur|aux|cette|ces|qui|que|dont|tout|tous|toutes|très|mais|aussi|plus|sans|chez|vers|entre|comme|même|après|avant|encore|chaque|autres|leurs|ses|mes|tes|nos|vos)\b/iu',
            '/\b(développement|spécialisé|numérique|agence|projets|entreprise|solution|gestion|conception|optimisation|personnalisé|intégration|sécurisé|évolutif|performant|gratuit|réserver|consultat|découverte|tarifs|devis|fonctionnal|processus|technolog|avantage|témoignage|fréquemment|comment|pourquoi)\b/iu',
        ];

        foreach ($frenchIndicators as $pattern) {
            if (preg_match($pattern, $text)) {
                return true;
            }
        }

        return false;
    }

    private function translateText(string $frText): string
    {
        // Check exact matches first
        if (isset($this->commonTranslations[$frText])) {
            return $this->commonTranslations[$frText];
        }

        // Check partial matches
        $result = $frText;
        foreach ($this->commonTranslations as $fr => $en) {
            if (str_contains($result, $fr)) {
                $result = str_replace($fr, $en, $result);
            }
        }

        // If we made changes, return the result
        if ($result !== $frText) {
            return $result;
        }

        // Return original with [EN] prefix to flag for manual translation
        return '[TRANSLATE] ' . $frText;
    }

    private function buildPhpArray(array $translations): string
    {
        $lines = ["<?php\n", "return ["];

        foreach ($translations as $key => $value) {
            $escapedValue = str_replace("'", "\\'", $value);
            $lines[] = "    '{$key}' => '{$escapedValue}',";
        }

        $lines[] = "];\n";

        return implode("\n", $lines);
    }
}
