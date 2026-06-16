<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixTranslations extends Command
{
    protected $signature = 'translations:fix-all';
    protected $description = 'Fix HTML entities in FR files and generate proper EN translations';

    private int $entitiesFixed = 0;
    private int $translated = 0;

    public function handle(): int
    {
        $this->info('🔧 Phase 1: Fixing HTML entities in FR files...');
        $this->fixEntities('fr');
        $this->info("   Fixed {$this->entitiesFixed} entities in FR files.");

        $this->info('🔧 Phase 2: Fixing HTML entities in EN files...');
        $entBefore = $this->entitiesFixed;
        $this->fixEntities('en');
        $this->info('   Fixed ' . ($this->entitiesFixed - $entBefore) . ' entities in EN files.');

        $this->info('🔧 Phase 3: Translating [TRANSLATE] markers in EN files...');
        $this->translateEn();
        $this->info("   Translated {$this->translated} keys.");

        $this->info('🔧 Phase 4: Verifying all files parse...');
        $errors = $this->verify();
        $this->info($errors === 0 ? '✅ All files parse OK.' : "❌ {$errors} errors.");

        return Command::SUCCESS;
    }

    private function fixEntities(string $locale): void
    {
        $dir = base_path("lang/{$locale}");
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS));

        foreach ($it as $f) {
            if (!$f->isFile() || !str_ends_with($f->getFilename(), '.php')) continue;

            $data = @include $f->getPathname();
            if (!is_array($data)) continue;

            $changed = false;
            foreach ($data as $key => $value) {
                $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                // Also fix double-encoded entities
                $decoded = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                // Fix specific patterns
                $decoded = str_replace(['&#x27;', '&#039;', '&amp;', '&quot;', '&lt;', '&gt;', '&#x00E9;', '&#x00E8;', '&#x00EA;', '&#x00F4;', '&#x00FB;', '&#x00E0;', '&#x00C9;'], ["'", "'", '&', '"', '<', '>', 'é', 'è', 'ê', 'ô', 'û', 'à', 'É'], $decoded);

                if ($decoded !== $value) {
                    $data[$key] = $decoded;
                    $changed = true;
                    $this->entitiesFixed++;
                }
            }

            if ($changed) {
                file_put_contents($f->getPathname(), $this->buildArray($data));
            }
        }
    }

    private function translateEn(): void
    {
        $dir = base_path('lang/en');
        $frDir = base_path('lang/fr');
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS));

        foreach ($it as $f) {
            if (!$f->isFile() || !str_ends_with($f->getFilename(), '.php')) continue;

            $data = @include $f->getPathname();
            if (!is_array($data)) continue;

            // Load corresponding FR file to get the source text
            $relativePath = str_replace($dir . DIRECTORY_SEPARATOR, '', $f->getPathname());
            $frFile = $frDir . DIRECTORY_SEPARATOR . $relativePath;
            $frData = file_exists($frFile) ? (include $frFile) : [];
            if (!is_array($frData)) $frData = [];

            $changed = false;
            foreach ($data as $key => $value) {
                if (!str_starts_with($value, '[TRANSLATE] ')) continue;

                $frText = $frData[$key] ?? substr($value, 12);
                // Decode entities in FR text first
                $frText = html_entity_decode($frText, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                $enText = $this->frToEn($frText);
                $data[$key] = $enText;
                $changed = true;
                $this->translated++;
            }

            if ($changed) {
                file_put_contents($f->getPathname(), $this->buildArray($data));
            }
        }
    }

    private function frToEn(string $fr): string
    {
        // Dictionary of French → English translations
        // Sorted by length (longest first) to avoid partial replacements
        static $dict = null;
        if ($dict === null) {
            $dict = [
                // Long phrases first
                'Prêt à Lancer Votre Projet ?' => 'Ready to Launch Your Project?',
                'Prêt à Transformer Votre Présence en Ligne ?' => 'Ready to Transform Your Online Presence?',
                'Questions Fréquemment Posées' => 'Frequently Asked Questions',
                'Questions Fréquentes' => 'Frequently Asked Questions',
                'Pourquoi Nous Choisir' => 'Why Choose Us',
                'Réserver une Consultation Gratuite' => 'Book a Free Consultation',
                'Réserver un Appel Découverte Gratuit' => 'Book a Free Discovery Call',
                'Réserver un Appel Découverte' => 'Book a Discovery Call',
                'Obtenir un Devis Gratuit' => 'Get a Free Quote',
                'Demander un Devis Gratuit' => 'Request a Free Quote',
                'Discutez de Vos Besoins' => 'Discuss Your Needs',
                'Commencer Votre Projet' => 'Start Your Project',
                'Lancer Votre Projet' => 'Launch Your Project',
                'Démarrer un Projet' => 'Start a Project',
                'Voir Nos Projets' => 'View Our Projects',
                'Voir le Portfolio' => 'View Portfolio',
                'Voir les Tarifs' => 'View Pricing',
                'Voir l\'Étude de Cas' => 'View Case Study',
                'En Savoir Plus' => 'Learn More',
                'Livraison en 7-10 Jours' => 'Delivery in 7-10 Days',
                'Livraison en 7 Jours' => 'Delivery in 7 Days',
                'Aucune inscription requise' => 'No signup required',
                'Notre Histoire' => 'Our Story',
                'Nos Services' => 'Our Services',
                'Notre Processus' => 'Our Process',
                'Nos Valeurs' => 'Our Values',
                'Notre Équipe' => 'Our Team',
                'Nos Projets' => 'Our Projects',
                'Nos Secteurs de Spécialisation' => 'Our Specialized Industries',
                'Nos réalisations' => 'Our achievements',
                'Ce Que Nous Offrons' => 'What We Offer',
                'Comment Ça Marche' => 'How It Works',
                'Fonctionnalités Clés' => 'Key Features',
                'Fonctionnalités' => 'Features',
                'Technologies' => 'Technologies',
                'Avantages' => 'Benefits',
                'Témoignages' => 'Testimonials',
                'Outils Associés' => 'Related Tools',
                'Outils Populaires' => 'Popular Tools',
                'Histoire de Succès' => 'Success Story',
                'Projets Livrés' => 'Projects Delivered',
                'Satisfaction Client' => 'Client Satisfaction',
                'Pays Servis' => 'Countries Served',
                'Ans d\'Expérience' => 'Years of Experience',
                'Équipe d\'Experts' => 'Expert Team',

                // Industry terms
                'développement web' => 'web development',
                'Développement Web' => 'Web Development',
                'Développement de Sites' => 'Website Development',
                'agence digitale' => 'digital agency',
                'Agence Digitale' => 'Digital Agency',
                'Agence de Développement Web' => 'Web Development Agency',
                'intelligence artificielle' => 'artificial intelligence',
                'alimenté par l\'IA' => 'AI-powered',
                'alimentés par l\'IA' => 'AI-powered',
                'tableaux de bord intelligents' => 'smart dashboards',
                'tableau de bord' => 'dashboard',
                'Tableau de bord' => 'Dashboard',
                'plateformes SaaS' => 'SaaS platforms',
                'plateforme SaaS' => 'SaaS platform',
                'Plateforme SaaS' => 'SaaS Platform',
                'boutique en ligne' => 'online store',
                'Boutique en Ligne' => 'Online Store',
                'e-commerce' => 'e-commerce',
                'E-commerce' => 'E-commerce',
                'site web' => 'website',
                'Site web' => 'Website',
                'sites web' => 'websites',
                'Sites web' => 'Websites',
                'application web' => 'web application',
                'Application web' => 'Web Application',
                'page d\'atterrissage' => 'landing page',
                'Page d\'atterrissage' => 'Landing Page',

                // Location terms
                'au Maroc' => 'in Morocco',
                'Maroc' => 'Morocco',
                'basé au' => 'based in',
                'Basé à' => 'Based in',
                'Basé dans le secteur' => 'Specialized in',

                // Common words
                'Nous Acceptons Maintenant' => 'Now Accepting',
                'Accepte Actuellement les' => 'Currently Accepting',
                'spécialisé' => 'specialized',
                'spécialisée' => 'specialized',
                'personnalisé' => 'customized',
                'personnalisée' => 'customized',
                'sur mesure' => 'custom',
                'gratuit' => 'free',
                'Gratuit' => 'Free',
                'premium' => 'premium',
                'expert' => 'expert',
                'sécurisé' => 'secure',
                'évolutif' => 'scalable',
                'performant' => 'high-performance',
                'optimisé' => 'optimized',
                'intégration' => 'integration',
                'Intégration' => 'Integration',
                'conception' => 'design',
                'Conception' => 'Design',
                'gestion' => 'management',
                'Gestion' => 'Management',
                'solution' => 'solution',
                'Solution' => 'Solution',
                'solutions' => 'solutions',
                'Solutions' => 'Solutions',
                'entreprise' => 'company',
                'Entreprise' => 'Company',
                'entreprises' => 'companies',
                'Entreprises' => 'Companies',
                'développement' => 'development',
                'Développement' => 'Development',
                'optimisation' => 'optimization',
                'Optimisation' => 'Optimization',

                // Verbs
                'Découvrir' => 'Discover',
                'Commencer' => 'Get Started',
                'Analyser' => 'Analyze',
                'Générer' => 'Generate',
                'Vérifier' => 'Check',
                'Copier' => 'Copy',
                'Télécharger' => 'Download',
                'Réinitialiser' => 'Reset',
                'Soumettre' => 'Submit',
                'Envoyer' => 'Send',
                'Essayer' => 'Try',
                'Créer' => 'Create',
                'Consulter' => 'View',

                // Common phrases
                'Plus de 50 projets livrés' => '50+ projects delivered',
                'Votre Partenaire Digital' => 'Your Digital Partner',
                'Devis personnalisés' => 'Custom quotes',
                'Processus 100% transparent' => '100% transparent process',
                'Support continu' => 'Ongoing support',
                'Résultats mesurables' => 'Measurable results',
                'Consultation gratuite' => 'Free consultation',
                'Approuvé par les' => 'Trusted by',
                'Nous créons' => 'We create',
                'NOUS CRÉONS' => 'WE BUILD',
                'Nous sommes' => 'We are',
                'nous sommes' => 'we are',
                'Nous aidons' => 'We help',
                'nous aidons' => 'we help',
                'Nous offrons' => 'We offer',
                'Nous avons' => 'We have',
                'depuis 2018' => 'since 2018',
                'Comment Nous Avons' => 'How We Built',

                // Single words
                'Accueil' => 'Home',
                'Emplacements' => 'Locations',
                'Secteurs' => 'Industries',
                'Légal' => 'Legal',
                'Outils' => 'Tools',
                'Projets' => 'Projects',
                'Clients' => 'Clients',
                'Résultats' => 'Results',
                'Santé' => 'Healthcare',
                'Éducation' => 'Education',
                'Immobilier' => 'Real Estate',
                'Voyage' => 'Travel',
                'Autre' => 'Other',
                'Nouveau' => 'New',
                'nouveau' => 'new',
                'Suivant' => 'Next',
                'Précédent' => 'Previous',
                'Fermer' => 'Close',
                'Recherche' => 'Search',
                'Professionnel' => 'Professional',
                'Formel' => 'Formal',
                'Amical' => 'Friendly',
                'International' => 'International',
                'mondial' => 'global',
                'Mondial' => 'Global',
                'mondiaux' => 'global',
            ];
            // Sort by length (longest first)
            uksort($dict, fn($a, $b) => mb_strlen($b) - mb_strlen($a));
        }

        $result = $fr;
        foreach ($dict as $frWord => $enWord) {
            $result = str_replace($frWord, $enWord, $result);
        }

        return $result;
    }

    private function verify(): int
    {
        $errors = 0;
        foreach (['fr', 'en'] as $locale) {
            $dir = base_path("lang/{$locale}");
            $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS));
            foreach ($it as $f) {
                if (!$f->isFile() || !str_ends_with($f->getFilename(), '.php')) continue;
                try {
                    $d = @include $f->getPathname();
                    if (!is_array($d)) { $errors++; $this->error("  ❌ Not array: {$f->getPathname()}"); }
                } catch (\Throwable $e) {
                    $errors++;
                    $this->error("  ❌ Parse error: {$f->getPathname()}");
                }
            }
        }
        return $errors;
    }

    private function buildArray(array $tr): string
    {
        $l = ["<?php\n", "return ["];
        foreach ($tr as $k => $v) {
            $e = str_replace("\\", "\\\\", $v);
            $e = str_replace("'", "\\'", $e);
            $l[] = "    '{$k}' => '{$e}',";
        }
        $l[] = "];\n";
        return implode("\n", $l);
    }
}
