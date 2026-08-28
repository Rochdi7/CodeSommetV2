/**
 * Source of truth for the browser audit: the 46 tool slugs, their architecture
 * type, and the input fixtures each one needs to produce a real result.
 *
 * type:
 *   'client'  — pure browser-side, no network call
 *   'api'     — POSTs to /api/tools/{slug} (server fetches a remote URL)
 *   'hybrid'  — client-side with optional server assistance
 */

const TOOLS = [
    // ─── API-backed (server-side fetch of a remote URL) ──────────────────
    { slug: 'website-analyzer', name: 'Analyseur de Site Web', type: 'api', input: 'https://example.com' },
    { slug: 'heading-analyzer', name: 'Analyseur de Structure de Titres', type: 'api', input: 'https://example.com' },
    { slug: 'keyword-density-analyzer', name: 'Analyseur de Densité de Mots-Clés', type: 'api', input: 'https://example.com' },
    { slug: 'broken-link-checker', name: 'Vérificateur de Liens Cassés', type: 'api', input: 'https://example.com' },
    { slug: 'redirect-checker', name: 'Vérificateur de Redirections', type: 'api', input: 'https://example.com' },
    { slug: 'ssl-certificate-checker', name: 'Vérificateur de Certificat SSL', type: 'api', input: 'example.com' },
    { slug: 'mobile-friendly-test', name: 'Test de Compatibilité Mobile', type: 'api', input: 'https://example.com' },
    { slug: 'core-web-vitals-checker', name: 'Vérificateur Core Web Vitals', type: 'api', input: 'https://example.com' },
    { slug: 'domain-authority-checker', name: 'Vérificateur d’Autorité de Domaine', type: 'api', input: 'example.com' },
    { slug: 'domain-health-checker', name: 'Vérificateur de Santé du Domaine', type: 'api', input: 'example.com' },
    { slug: 'canonical-checker', name: 'Vérificateur d’URL Canonique', type: 'api', input: 'https://example.com' },
    { slug: 'image-alt-analyzer', name: 'Analyseur de Texte Alt d’Images', type: 'api', input: 'https://example.com' },
    { slug: 'image-compression-analyzer', name: 'Analyseur de Compression d’Images', type: 'api', input: 'https://example.com' },
    { slug: 'internal-link-analyzer', name: 'Analyseur de Liens Internes', type: 'api', input: 'https://example.com' },
    { slug: 'page-speed-analyzer', name: 'Analyseur de Vitesse de Page', type: 'api', input: 'https://example.com' },
    { slug: 'robots-validator', name: 'Validateur Robots.txt', type: 'api', input: 'https://example.com' },
    { slug: 'sitemap-validator', name: 'Validateur de Sitemap', type: 'api', input: 'https://example.com/sitemap.xml' },
    { slug: 'website-readiness-checker', name: 'Vérificateur de Préparation du Site', type: 'api', input: 'https://example.com' },
    { slug: 'og-preview-generator', name: 'Aperçu Open Graph', type: 'api', input: 'https://example.com' },

    // ─── AI-branded generators (server templates via /api/tools/*) ───────
    { slug: 'meta-tag-generator', name: 'Générateur de Balises Meta IA', type: 'api', input: 'https://example.com' },
    { slug: 'blog-title-generator', name: 'Générateur de Titres de Blog IA', type: 'api', input: 'marketing digital' },
    { slug: 'chatbot-script-generator', name: 'Générateur de Scripts Chatbot IA', type: 'api', input: 'E-commerce' },
    { slug: 'landing-page-generator', name: 'Générateur de Pages d’Atterrissage IA', type: 'api', input: 'CodeSommet', fields: ['Assistant Email IA', 'Un assistant qui trie et rédige vos emails automatiquement. Il fait gagner deux heures par jour aux équipes commerciales.'] },

    // ─── Pure client-side ────────────────────────────────────────────────
    { slug: 'base64-encoder', name: 'Encodeur/Décodeur Base64', type: 'client', input: 'Bonjour CodeSommet' },
    { slug: 'json-formatter', name: 'Formateur/Validateur JSON', type: 'client', input: '{"name":"CodeSommet","active":true}' },
    { slug: 'css-minifier', name: 'Minificateur CSS', type: 'client', input: 'body { color : red ; margin : 0 ; }' },
    { slug: 'html-minifier', name: 'Minificateur HTML/CSS/JS', type: 'client', input: '<div>  <p>Bonjour</p>  </div>' },
    { slug: 'html-to-text', name: 'Convertisseur HTML vers Texte Brut', type: 'client', input: '<h1>Titre</h1><p>Paragraphe accentué : éèà</p>' },
    { slug: 'text-case-converter', name: 'Convertisseur de Casse de Texte', type: 'client', input: 'bonjour le monde éèà' },
    { slug: 'word-counter', name: 'Compteur de Mots et Caractères', type: 'client', input: 'Bonjour le monde. Ceci est un test de comptage de mots en français.' },
    // Ce tampon dépasse volontairement le minimum de 30 mots exigé par l'outil.
    { slug: 'readability-analyzer', name: 'Analyseur de Score de Lisibilité', type: 'client', input: 'Bonjour le monde. Ceci est un test de lisibilité rédigé en français courant. Les phrases restent courtes et le vocabulaire demeure simple. Un lecteur pressé doit pouvoir comprendre ce paragraphe sans effort particulier. Nous mesurons ici le niveau de lecture réel du contenu proposé.' },
    { slug: 'lorem-ipsum-generator', name: 'Générateur de Lorem Ipsum', type: 'client', input: null },
    { slug: 'url-slug-generator', name: 'Générateur de Slug URL', type: 'client', input: 'Mon Article Génial à Lire' },
    { slug: 'qr-code-generator', name: 'Générateur de Code QR', type: 'client', input: 'https://codesommet.com' },
    // PNG 64×64 réel (deux aplats de couleur) — l'extraction se fait via Canvas,
    // côté navigateur : aucun fichier n'est envoyé au serveur.
    {
        slug: 'color-palette-generator', name: 'Générateur de Palette de Couleurs', type: 'client', input: null,
        upload: {
            name: 'palette-test.png',
            mimeType: 'image/png',
            base64: 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAADhSURBVHhe7dAxEcNAAMRAg0gdJAYZgOFi9wKw31yxvUbX/3M/J31/z1FXg7QGaRvQIK1B2gY0SGuQtgEN0hqkbUCDtAZpG9AgrUHaBjRIa5C2AQ3SGqRtQIO0Bmkb0CCtQdoGNEhrkLYBDdIapG1Ag7QGaRvQIK1B2gY0SGuQtgEN0hqkbUCDtAZpG9AgrUHaBjRIa5C2AQ3SGqRtQIO0Bmkb0CCtQdoGNEhrkLYBDdIapG1Ag7QGaRvQIK1B2gY0SGuQtgEN0hqkbUCDtAZpG9AgrUHaBjRIa5C2AQ3SGqS9iiG6O5upAG0AAAAASUVORK5CYII=',
        },
    },
    { slug: 'utm-builder', name: 'Constructeur de Paramètres UTM', type: 'client', input: 'https://example.com', fields: ['https://example.com/page', 'google', 'cpc', 'promo_ete'] },
    { slug: 'schema-generator', name: 'Générateur de Balisage Schema', type: 'client', input: 'CodeSommet' },
    // L'outil exige des paires « Q : … / R : … » — un simple titre ne suffit pas.
    { slug: 'faq-schema-generator', name: 'Générateur de Schema FAQ', type: 'client', input: 'Q : Quelle est votre garantie ?\nR : Nous offrons une garantie de 30 jours satisfait ou remboursé.\n\nQ : Livrez-vous à l\'international ?\nR : Oui, nous livrons dans toute l\'Europe et en Afrique du Nord.' },
    { slug: 'local-business-schema', name: 'Générateur de Schema Entreprise Locale', type: 'client', input: 'CodeSommet', fields: ['CodeSommet', '12 rue de la Paix', 'Casablanca', 'Casablanca-Settat', '20000', 'Maroc', '+212-522-000-000', 'https://codesommet.com'] },
    { slug: 'hreflang-generator', name: 'Générateur de Balises Hreflang', type: 'client', input: 'https://example.com', fields: ['https://example.com/fr/page', 'fr-FR', 'https://example.com/en/page', 'en-US'] },
    { slug: 'xml-sitemap-generator', name: 'Générateur de Sitemap XML', type: 'client', input: 'https://example.com' },
    { slug: 'robots-txt-generator', name: 'Générateur Robots.txt', type: 'client', input: 'https://example.com/sitemap.xml', fields: ['/admin/', '/private/', '/tmp/', 'https://example.com/sitemap.xml'] },
    { slug: 'meta-refresh-generator', name: 'Générateur de Redirection Meta Refresh', type: 'client', input: 'https://example.com' },
    { slug: 'nofollow-link-checker', name: 'Vérificateur de Liens Nofollow', type: 'client', input: '<a href="https://a.com" rel="nofollow">A</a><a href="https://b.com">B</a>' },
    { slug: 'duplicate-content-checker', name: 'Vérificateur de Contenu Dupliqué', type: 'client', input: 'Ceci est un texte de test pour la détection de contenu dupliqué en français.', fields: ['Ceci est un texte de test pour la détection de contenu dupliqué en français.', 'Ceci est un texte de test pour la detection de contenu duplique en francais.'] },
];

/** Payloads used for the invalid / hostile input pass. */
const HOSTILE_INPUTS = {
    xss: '<img src=x onerror=alert(1)>',
    scriptTag: '<script>alert(1)</script>',
    svgOnload: '"><svg onload=alert(1)>',
    jsUrl: 'javascript:alert(1)',
    templateBlade: '{{7*7}}',
    templateJs: '${7*7}',
    traversal: '../../../../etc/passwd',
    traversalEnc: '%2e%2e%2f',
};

/** URLs the backend must refuse (SSRF / non-HTTP schemes). */
const UNSAFE_URLS = [
    'https://127.0.0.1',
    'http://localhost',
    'http://169.254.169.254',
    'file:///etc/passwd',
    'javascript:alert(1)',
    'data:text/html,test',
];

module.exports = { TOOLS, HOSTILE_INPUTS, UNSAFE_URLS };
