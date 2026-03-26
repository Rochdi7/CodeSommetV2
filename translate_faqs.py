import re
import os

TOOLS_DIR = os.path.join(os.path.dirname(__file__), 'resources', 'views', 'pages', 'tools')

# Map of English FAQ answer text -> French translation for each tool file
# Key: filename, Value: dict of english->french for each FAQ answer

translations = {
    "base64-encoder.blade.php": {
        "Base64 is a binary-to-text encoding scheme that converts binary data into ASCII text format using 64 characters (A-Z, a-z, 0-9, +, /). It's essential for transmitting binary data over text-based protocols like HTTP, email (MIME), and JSON APIs. Common uses include embedding images in HTML/CSS as data URIs, encoding email attachments, API authentication headers, and safely transmitting complex data in URLs.":
        "Base64 est un schéma d'encodage binaire vers texte qui convertit les données binaires en format texte ASCII en utilisant 64 caractères (A-Z, a-z, 0-9, +, /). Il est essentiel pour transmettre des données binaires via des protocoles textuels comme HTTP, email (MIME) et les API JSON. Les utilisations courantes incluent l'intégration d'images en HTML/CSS sous forme de data URI, l'encodage des pièces jointes d'e-mails, les en-têtes d'authentification API et la transmission sécurisée de données complexes dans les URL.",

        "No, Base64 is NOT encryption or a security measure. It's simply an encoding format that makes binary data text-safe. Anyone can easily decode Base64 strings, so never use it to hide sensitive information like passwords or API keys. For security, use proper encryption algorithms like AES-256, RSA, or hashing algorithms like bcrypt/SHA-256.":
        "Non, Base64 n'est PAS du chiffrement ni une mesure de sécurité. C'est simplement un format d'encodage qui rend les données binaires compatibles avec le texte. N'importe qui peut facilement décoder des chaînes Base64, donc ne l'utilisez jamais pour masquer des informations sensibles comme des mots de passe ou des clés API. Pour la sécurité, utilisez des algorithmes de chiffrement appropriés comme AES-256, RSA, ou des algorithmes de hachage comme bcrypt/SHA-256.",

        "Base64 encoding increases file size by approximately 33% because it represents 3 bytes of binary data using 4 ASCII characters. This overhead is the tradeoff for making binary data text-safe and compatible with text-based protocols. For example, a 300KB image becomes roughly 400KB when Base64 encoded.":
        "L'encodage Base64 augmente la taille des fichiers d'environ 33 % car il représente 3 octets de données binaires en utilisant 4 caractères ASCII. Ce surcoût est le compromis pour rendre les données binaires compatibles avec les protocoles textuels. Par exemple, une image de 300 Ko devient environ 400 Ko une fois encodée en Base64.",

        "Use Base64 for images when you need inline data URIs in HTML/CSS for small icons or logos (under 10KB) to reduce HTTP requests and improve initial page load speed. Avoid Base64 for large images as it increases file size, prevents browser caching, and bloats your HTML/CSS files. For production websites, serve images as separate files with proper caching headers.":
        "Utilisez Base64 pour les images lorsque vous avez besoin de data URI en ligne dans HTML/CSS pour de petites icônes ou logos (moins de 10 Ko) afin de réduire les requêtes HTTP et améliorer la vitesse de chargement initiale. Évitez Base64 pour les grandes images car cela augmente la taille du fichier, empêche la mise en cache du navigateur et alourdit vos fichiers HTML/CSS. Pour les sites web en production, servez les images comme des fichiers séparés avec des en-têtes de cache appropriés.",

        "URL-safe Base64 replaces the standard '+' and '/' characters with '-' and '_' respectively, and removes padding '=' characters. This prevents issues when Base64 strings are used in URLs, where '+' and '/' have special meanings. It's commonly used for JWT tokens, URL shorteners, and API parameters.":
        "Le Base64 sécurisé pour les URL remplace les caractères standard '+' et '/' par '-' et '_' respectivement, et supprime les caractères de remplissage '='. Cela évite les problèmes lorsque les chaînes Base64 sont utilisées dans les URL, où '+' et '/' ont des significations spéciales. Il est couramment utilisé pour les jetons JWT, les raccourcisseurs d'URL et les paramètres API.",

        "No, Base64 encoding/decoding is a lossless process. Your original data remains perfectly intact when properly encoded and decoded. However, encoding errors can occur if you try to encode invalid UTF-8 characters or decode malformed Base64 strings. This tool handles UTF-8 encoding automatically to prevent corruption.":
        "Non, l'encodage/décodage Base64 est un processus sans perte. Vos données originales restent parfaitement intactes lorsqu'elles sont correctement encodées et décodées. Cependant, des erreurs d'encodage peuvent survenir si vous essayez d'encoder des caractères UTF-8 invalides ou de décoder des chaînes Base64 mal formées. Cet outil gère l'encodage UTF-8 automatiquement pour éviter la corruption.",

        "In développement web, Base64 is used for: embedding small images/fonts as data URIs in CSS, encoding HTTP Basic Authentication headers (username:password), storing binary data in JSON APIs, creating data URLs for file downloads, encoding JWT tokens for authentication, and transmitting binary files in email attachments (MIME encoding). It's a fundamental tool for handling binary data in text-based web protocols.":
        "En développement web, Base64 est utilisé pour : intégrer de petites images/polices sous forme de data URI en CSS, encoder les en-têtes d'authentification HTTP Basic (nom d'utilisateur:mot de passe), stocker des données binaires dans les API JSON, créer des URL de données pour le téléchargement de fichiers, encoder les jetons JWT pour l'authentification, et transmettre des fichiers binaires dans les pièces jointes d'e-mails (encodage MIME). C'est un outil fondamental pour gérer les données binaires dans les protocoles web textuels.",
    },

    "blog-title-generator.blade.php": {},
    "broken-link-checker.blade.php": {},
    "canonical-checker.blade.php": {},
    "chatbot-script-generator.blade.php": {},
    "color-palette-generator.blade.php": {},
    "core-web-vitals-checker.blade.php": {},
    "css-minifier.blade.php": {},
    "domain-authority-checker.blade.php": {},
    "domain-health-checker.blade.php": {},
    "duplicate-content-checker.blade.php": {},
    "heading-analyzer.blade.php": {},
    "hreflang-generator.blade.php": {},
    "html-minifier.blade.php": {},
    "html-to-text.blade.php": {},
    "image-alt-analyzer.blade.php": {},
    "image-compression-analyzer.blade.php": {},
    "internal-link-analyzer.blade.php": {},
    "json-formatter.blade.php": {},
    "keyword-density-analyzer.blade.php": {},
    "landing-page-generator.blade.php": {},
    "local-business-schema.blade.php": {},
    "lorem-ipsum-generator.blade.php": {},
    "meta-refresh-generator.blade.php": {},
    "meta-tag-generator.blade.php": {},
    "mobile-friendly-test.blade.php": {},
    "nofollow-link-checker.blade.php": {},
    "og-preview-generator.blade.php": {},
    "page-speed-analyzer.blade.php": {},
    "qr-code-generator.blade.php": {},
    "readability-analyzer.blade.php": {},
    "redirect-checker.blade.php": {},
    "robots-txt-generator.blade.php": {},
    "robots-validator.blade.php": {},
    "schema-generator.blade.php": {},
    "sitemap-validator.blade.php": {},
    "ssl-certificate-checker.blade.php": {},
    "text-case-converter.blade.php": {},
    "url-slug-generator.blade.php": {},
    "utm-builder.blade.php": {},
    "website-analyzer.blade.php": {},
    "website-readiness-checker.blade.php": {},
    "word-counter.blade.php": {},
    "xml-sitemap-generator.blade.php": {},
}

# This is a placeholder script structure. The actual approach will be to
# extract English FAQ answers from each file, then replace them inline.
# Since we can't use an API for translation, we'll do it file by file.

if __name__ == "__main__":
    for filename in translations:
        filepath = os.path.join(TOOLS_DIR, filename)
        if not os.path.exists(filepath):
            print(f"SKIP (not found): {filename}")
            continue

        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()

        # Extract all FAQ answers
        pattern = r'(<div class="faq-answer[^"]*"[^>]*><p>)(.*?)(</p></div>)'
        matches = list(re.finditer(pattern, content))

        if not matches:
            print(f"NO FAQ ANSWERS FOUND: {filename}")
            continue

        # Check if any are English
        english_count = 0
        for m in matches:
            text = m.group(2)
            # Simple heuristic: if it starts with common English words
            if re.match(r'^(The |A |An |No,|Yes,|Use |URL|Base64|CSS|HTML|Modern|Typical|Source|Always|Focus|In |It |This |For |When |Regular|Our |Domain|Page |Spam|Head|Hreflang|Duplicate|Image|Internal|JSON|Keyword|Landing|Local|Lorem|Meta|Mobile|Nofollow|OG |Open |Page|QR |Read|Redirect|Robot|Schema|Site|SSL|Text|UTM |Web|Word|XML)', text):
                english_count += 1

        print(f"{filename}: {len(matches)} FAQs, {english_count} in English")
