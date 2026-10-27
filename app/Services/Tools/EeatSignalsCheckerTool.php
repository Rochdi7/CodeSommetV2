<?php

namespace App\Services\Tools;

use App\Models\AnalysisRun;
use App\Services\HtmlDocument;
use App\Services\SafeHttpFetcher;
use App\Services\SafeUrlValidator;
use App\Services\Tools\Concerns\InspectsPage;
use App\Services\Tools\Concerns\ValidatesUrls;

/**
 * E-E-A-T signals checker — looks for the on-page trust, expertise,
 * experience and authority signals that quality raters are told to look for
 * (who is behind the page, how to reach them, sources, dates, reviews).
 *
 * This is NOT a Google score: E-E-A-T is not a single ranking factor and
 * reputation off the site cannot be read from one page. Every check is a
 * documented rule on the fetched HTML; article-only signals (author, dates)
 * are `info` on non-article pages instead of failing them.
 */
class EeatSignalsCheckerTool implements AnalysisTool
{
    use InspectsPage;
    use ValidatesUrls;

    private const ARTICLE_TYPES = ['Article', 'BlogPosting', 'NewsArticle', 'TechArticle', 'Report', 'ScholarlyArticle', 'HowTo'];

    private const PROFILE_HOSTS = '/(?:^|\.)(?:linkedin\.com|facebook\.com|instagram\.com|x\.com|twitter\.com|youtube\.com|github\.com|tiktok\.com|pinterest\.com|wikipedia\.org|wikidata\.org|crunchbase\.com|behance\.net|dribbble\.com|clutch\.co|trustpilot\.com|g\.page|maps\.google\.com|business\.google\.com)$/i';

    private const ABOUT = '/(about|a-propos|à-propos|à propos|qui-sommes-nous|qui sommes-nous|notre-agence|notre agence|notre-equipe|notre équipe|equipe|équipe|team)/u';

    private const CONTACT = '/(contact|nous-joindre|nous joindre)/u';

    private const PRIVACY = '/(privacy|confidentialit|donnees-personnelles|données personnelles|rgpd|gdpr|cookie)/u';

    private const TERMS = '/(terms|conditions|cgv|cgu|mentions-legales|mentions légales|legal|imprint|impressum)/u';

    private const EXPERIENCE = '/(etude-de-cas|étude de cas|etudes-de-cas|case-stud|cas-client|realisation|réalisation|portfolio|our-work|projets|projects|temoignage|témoignage|testimonial|avis-clients|avis clients|reviews)/u';

    public function __construct(private SafeUrlValidator $validator, private SafeHttpFetcher $fetcher)
    {
    }

    protected function urlValidator(): SafeUrlValidator
    {
        return $this->validator;
    }

    protected function httpFetcher(): SafeHttpFetcher
    {
        return $this->fetcher;
    }

    public function slug(): string
    {
        return 'eeat-signals-checker';
    }

    public function mode(): string
    {
        return AnalysisRun::MODE_SYNC;
    }

    public function allowsInlineFallback(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['url' => ['required', 'string', 'max:2048']];
    }

    public function normalizeInput(array $validated): array
    {
        return ['url' => $this->safeUrl((string) $validated['url'])];
    }

    public function run(array $input, callable $progress): array
    {
        $url = $input['url'];
        $progress(null, 'Téléchargement de la page');
        $page = $this->fetchPage($url);
        $dom = $page['dom'];

        $links = self::classifyLinks($dom, $url);
        $nodes = self::jsonLdNodes($dom);
        $isArticle = self::nodesOfType($nodes, self::ARTICLE_TYPES) !== []
            || strtolower($dom->metaByProperty('og:type')) === 'article';

        $orgs = array_values(array_filter($nodes, fn ($n) => self::isOrganization($n)));
        $orgTypes = [];
        $sameAs = [];
        foreach ($orgs as $org) {
            $orgTypes = array_merge($orgTypes, array_filter((array) $org['@type'], 'is_string'));
            foreach ((array) ($org['sameAs'] ?? []) as $s) {
                if (is_string($s) && preg_match('#^https?://#i', $s)) {
                    $sameAs[] = $s;
                }
            }
        }
        foreach ($links['external'] as $link) {
            if (preg_match(self::PROFILE_HOSTS, (string) parse_url($link['url'], PHP_URL_HOST))) {
                $sameAs[] = $link['url'];
            }
        }
        $profileHosts = array_values(array_unique(array_map(
            fn ($u) => preg_replace('/^www\./', '', strtolower((string) parse_url($u, PHP_URL_HOST))),
            $sameAs
        )));
        $citationHosts = array_values(array_unique(array_filter(array_map(
            fn ($l) => preg_replace('/^www\./', '', strtolower((string) parse_url($l['url'], PHP_URL_HOST))),
            $links['external']
        ), fn ($h) => $h !== '' && ! preg_match(self::PROFILE_HOSTS, $h))));

        $signals = [
            'aboutUrl' => self::findLink($links['internal'], self::ABOUT),
            'contactUrl' => self::findLink($links['internal'], self::CONTACT),
            'privacyUrl' => self::findLink($links['internal'], self::PRIVACY),
            'termsUrl' => self::findLink($links['internal'], self::TERMS),
            'experienceUrl' => self::findLink($links['internal'], self::EXPERIENCE),
            'phoneLinks' => $links['tel'],
            'emailLinks' => $links['mailto'],
            'organizationTypes' => array_values(array_unique($orgTypes)),
            'profiles' => $profileHosts,
            'citedDomains' => array_slice($citationHosts, 0, 20),
            'authors' => self::authors($dom, $nodes),
            'dates' => self::pageDates($dom, $nodes),
            'isArticle' => $isArticle,
            'wordCount' => self::wordCount($dom->visibleText()),
        ];
        $hasAddress = self::nodesOfType($nodes, ['PostalAddress']) !== [] || $dom->query('//address') !== [];
        $hasReviews = self::nodesOfType($nodes, ['Review', 'AggregateRating']) !== [];

        $checks = [];
        // Trust
        $https = str_starts_with(strtolower($url), 'https://');
        $checks[] = self::check('https', 'trust', 'Connexion HTTPS', $https ? 'pass' : 'fail',
            $https ? 'La page est servie en HTTPS.' : 'La page est servie en HTTP : les visiteurs voient « Non sécurisé ».', 15);
        $legal = (int) ($signals['privacyUrl'] !== null) + (int) ($signals['termsUrl'] !== null);
        $checks[] = self::check('legal', 'trust', 'Pages légales liées', [0 => 'fail', 1 => 'warn', 2 => 'pass'][$legal],
            $legal === 2 ? 'Liens vers la politique de confidentialité et les mentions légales / CGV trouvés.'
                : ($legal === 1 ? 'Une seule des deux pages légales est liée (confidentialité ou mentions légales / CGV).' : 'Aucun lien vers une politique de confidentialité ni des mentions légales.'), 10);
        $contactKinds = (int) ($signals['contactUrl'] !== null) + (int) ($links['tel'] > 0 || $links['mailto'] > 0);
        $checks[] = self::check('contact', 'trust', 'Moyens de contact', [0 => 'fail', 1 => 'warn', 2 => 'pass'][$contactKinds],
            $contactKinds === 2 ? 'Page contact liée et lien téléphone ou e-mail cliquable.'
                : ($contactKinds === 1 ? 'Un seul moyen de contact trouvé (page contact, ou téléphone / e-mail cliquable).' : 'Aucune page contact ni lien téléphone / e-mail sur la page.'), 10);
        $checks[] = self::check('organization', 'trust', 'Identité de l\'organisation (schema.org)', $orgs !== [] ? 'pass' : 'warn',
            $orgs !== [] ? 'Données structurées ' . implode(', ', $signals['organizationTypes']) . ' présentes.' : 'Aucune donnée structurée Organization / LocalBusiness : l\'éditeur du site n\'est pas déclaré aux moteurs.', 10);
        $checks[] = self::check('address', 'trust', 'Adresse physique', $hasAddress ? 'pass' : 'info',
            $hasAddress ? 'Adresse déclarée (PostalAddress ou balise <address>).' : 'Aucune adresse détectée — attendue surtout pour une entreprise locale.', 5);
        // Authority
        $checks[] = self::check('about', 'authority', 'Page « À propos » liée', $signals['aboutUrl'] !== null ? 'pass' : 'fail',
            $signals['aboutUrl'] !== null ? 'Lien vers une page de présentation de l\'entreprise ou de l\'équipe.' : 'Aucun lien vers une page « À propos » / « Qui sommes-nous » / équipe.', 10);
        $n = count($profileHosts);
        $checks[] = self::check('profiles', 'authority', 'Profils externes (sameAs, réseaux)', $n >= 2 ? 'pass' : ($n === 1 ? 'warn' : 'fail'),
            $n > 0 ? "{$n} profil(s) externe(s) relié(s) : " . implode(', ', array_slice($profileHosts, 0, 6)) . '.' : 'Aucun profil externe (LinkedIn, Google Business, réseaux…) relié à la page ou au schema sameAs.', 10);
        $c = count($citationHosts);
        $checks[] = self::check('citations', 'authority', 'Sources externes citées', $c > 0 ? 'pass' : 'warn',
            $c > 0 ? "Liens vers {$c} domaine(s) externe(s) hors réseaux sociaux." : 'Aucun lien vers une source externe : citez études, normes ou documentation quand vous avancez un chiffre.', 5);
        // Expertise
        $hasAuthor = $signals['authors'] !== [];
        $checks[] = self::check('author', 'expertise', 'Auteur identifié', $hasAuthor ? 'pass' : ($isArticle ? 'fail' : 'info'),
            $hasAuthor ? 'Auteur : ' . implode(', ', array_slice($signals['authors'], 0, 3)) . '.'
                : ($isArticle ? 'Article sans auteur identifiable (schema author, meta author, rel=author ou signature).' : 'Pas un article : un auteur n\'est pas attendu sur ce type de page.'), 10);
        // Experience
        $hasExperience = $signals['experienceUrl'] !== null || $hasReviews;
        $checks[] = self::check('experience', 'experience', 'Preuves d\'expérience', $hasExperience ? 'pass' : 'warn',
            $hasExperience ? 'Études de cas, réalisations ou avis clients liés / déclarés.' : 'Aucun lien vers des réalisations, études de cas ou témoignages.', 10);
        $checks[] = self::check('reviews', 'experience', 'Avis structurés', $hasReviews ? 'pass' : 'info',
            $hasReviews ? 'Données Review / AggregateRating présentes.' : 'Aucun avis en données structurées (facultatif, à n\'ajouter que pour de vrais avis).', 5);
        $hasDates = $signals['dates']['published'] !== null || $signals['dates']['modified'] !== null;
        $checks[] = self::check('dates', 'experience', 'Date de publication / mise à jour', $hasDates ? 'pass' : ($isArticle ? 'warn' : 'info'),
            $hasDates ? 'Date trouvée : ' . ($signals['dates']['modified'] ?? $signals['dates']['published']) . '.'
                : ($isArticle ? 'Article sans date visible ou structurée.' : 'Pas un article : une date n\'est pas attendue.'), 5);
        // Content
        $w = $signals['wordCount'];
        $checks[] = self::check('depth', 'content', 'Volume de contenu', $w >= 300 ? 'pass' : ($w >= 100 ? 'warn' : 'fail'),
            "{$w} mots de texte visible dans le HTML" . ($w < 300 ? ' : peu pour démontrer une expertise.' : '.'), 10);

        return [
            'url' => $url,
            'status' => $page['status'],
            'checks' => $checks,
            'signals' => $signals,
            'analyzedAt' => now()->toIso8601String(),
        ] + self::score($checks);
    }

    private static function isOrganization(array $node): bool
    {
        foreach ((array) $node['@type'] as $t) {
            if (is_string($t) && $t !== 'Service' && preg_match('/(Organization|Business|Corporation|Service|Store|Agency|NGO|Restaurant|Hotel|Dentist|Physician|Attorney)$/', $t)) {
                return true;
            }
        }

        return false;
    }

    /** @return list<string> */
    private static function authors(HtmlDocument $dom, array $nodes): array
    {
        $names = [];
        foreach ($nodes as $node) {
            foreach (isset($node['author']) ? (array_is_list((array) $node['author']) ? (array) $node['author'] : [$node['author']]) : [] as $a) {
                $name = is_array($a) ? ($a['name'] ?? null) : $a;
                if (is_string($name) && trim($name) !== '') {
                    $names[] = trim($name);
                }
            }
        }
        if (($meta = trim($dom->metaByName('author'))) !== '') {
            $names[] = $meta;
        }
        foreach ($dom->query('//*[@rel="author" or contains(concat(" ", normalize-space(@rel), " "), " author ") or @itemprop="author"]') as $el) {
            $text = trim(preg_replace('/\s+/u', ' ', $el->textContent));
            if ($text !== '' && mb_strlen($text) <= 80) {
                $names[] = $text;
            }
        }
        if ($names === []) {
            foreach ($dom->query('//*[contains(@class, "byline") or contains(@class, "author-name") or contains(@class, "post-author")]') as $el) {
                $text = trim(preg_replace('/\s+/u', ' ', $el->textContent));
                if ($text !== '' && mb_strlen($text) <= 80) {
                    $names[] = $text;
                }
            }
        }

        return array_values(array_unique($names));
    }
}
