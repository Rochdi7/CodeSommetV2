<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

/**
 * Guides SEO (recherche Semrush 2026, docs/seo/2026) : prix d'un site web au Maroc
 * et e-commerce au Maroc. Ils répondent aux intentions informationnelles qui dominent
 * les SERP « création site web maroc » et « e-commerce maroc », et renvoient vers
 * les pages commerciales correspondantes.
 *
 * Idempotent : upsert par slug, date de publication fixe (pas recalculée à chaque exécution).
 * Séparé de SeoArticlesSeeder pour ne pas modifier les dates des articles existants.
 *   php artisan db:seed --class=SeoGuidesSeeder
 */
class SeoGuidesSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'web-development'],
            ['name' => 'Développement Web', 'color' => '#00AEEF']
        );

        foreach ($this->articles() as $article) {
            BlogPost::updateOrCreate(
                ['slug' => $article['slug']],
                [
                    'title'            => $article['title'],
                    'excerpt'          => $article['excerpt'],
                    'content'          => $article['content'],
                    'meta_title'       => $article['meta_title'],
                    'meta_description' => $article['meta_description'],
                    'category_id'      => $category->id,
                    'author'           => 'CodeSommet',
                    'status'           => 'published',
                    'published_at'     => CarbonImmutable::parse($article['published_at']),
                ]
            );
        }
    }

    private function articles(): array
    {
        $r = fn (string $name, ?string $slug = null) => $slug === null ? route($name, [], false) : route($name, $slug, false);

        return [
            // ───────────────────────────────────────────── 1. PRIX D'UN SITE WEB AU MAROC
            [
                'slug'             => 'prix-site-web-maroc-combien-coute-la-creation-d-un-site-internet',
                'published_at'     => '2026-10-30 09:00:00',
                'title'            => "Prix d'un site web au Maroc : combien coûte la création d'un site internet ?",
                'meta_title'       => "Prix d'un site web au Maroc : ce qui fait le coût",
                'meta_description' => "Site vitrine, e-commerce, plateforme sur mesure : ce qui fait varier le prix d'un site web au Maroc, les coûts récurrents et les questions à poser.",
                'excerpt'          => "Pourquoi deux devis pour « un site web » peuvent varier du simple au multiple ? Voici les facteurs qui déterminent le prix d'une création de site web au Maroc, les coûts récurrents à prévoir et les questions à poser avant de signer.",
                'content'          => <<<HTML
<p>« Combien coûte un site web au Maroc ? » est souvent la première question que se pose une entreprise avant de contacter une agence. La réponse honnête est qu'il n'existe pas de prix unique : un site vitrine de cinq pages, une boutique en ligne et une plateforme métier ne demandent ni le même travail, ni les mêmes compétences, ni la même maintenance. Ce guide explique ce qui fait réellement varier le prix d'une création de site web au Maroc, pour que vous puissiez comparer des devis sur des bases solides.</p>

<h2>Pourquoi il n'existe pas de prix unique</h2>
<p>Le prix d'un site dépend de trois choses : ce que le site doit faire (présenter, vendre, gérer), la quantité de travail sur mesure qu'il demande (design, fonctionnalités, intégrations) et l'accompagnement inclus (contenus, référencement, formation, maintenance). Deux devis très différents pour « un site web » décrivent souvent deux projets différents. Avant de comparer les montants, comparez donc le périmètre.</p>

<h2>Prix d'un site vitrine au Maroc : ce qui le fait varier</h2>
<p>Le site vitrine présente votre entreprise, vos services et vos coordonnées afin de générer des appels, des demandes de devis ou des visites. C'est le type de site le plus accessible, mais son prix varie selon :</p>
<ul>
<li><strong>le nombre de pages</strong> et de modèles de pages différents (accueil, services, réalisations, contact…) ;</li>
<li><strong>le nombre de langues</strong> : français, arabe, anglais, parfois espagnol pour le nord du Maroc ;</li>
<li><strong>le design</strong> : adaptation d'un modèle ou création d'une maquette sur mesure ;</li>
<li><strong>les contenus</strong> : fournis par vous ou rédigés par l'agence, photos comprises ou non ;</li>
<li><strong>les fonctionnalités</strong> : formulaire de devis, prise de rendez-vous, bouton WhatsApp, blog.</li>
</ul>
<p>Un site vitrine bien construit peut être livré en quelques jours une fois le périmètre validé. Il constitue souvent le meilleur point de départ : il pourra évoluer ensuite vers la vente en ligne ou un espace client.</p>

<h2>Prix d'un site e-commerce : les postes à prévoir</h2>
<p>Une boutique en ligne coûte nettement plus qu'un site vitrine, car elle gère un catalogue, des paiements, des commandes et des stocks. Les postes qui pèsent le plus sont :</p>
<ul>
<li>la taille du catalogue, les variantes (tailles, couleurs) et l'import des produits ;</li>
<li>les moyens de paiement : paiement par carte via votre banque marocaine, paiement à la livraison, solutions internationales ;</li>
<li>la livraison : zones, frais par ville, connexion avec vos partenaires logistiques ;</li>
<li>les fonctionnalités de vente : codes promo, comptes clients, relances de panier abandonné ;</li>
<li>les intégrations : logiciel de stock, de facturation ou CRM.</li>
</ul>
<p>Le choix de la solution compte aussi : une plateforme par abonnement, un CMS open source avec extensions ou une <a href="{$r('service', 'ecommerce-website-development')}">création de site e-commerce sur mesure</a> n'ont pas la même structure de coûts. Nous détaillons ces options dans notre <a href="{$r('blog.show', 'e-commerce-maroc-guide-lancer-boutique-en-ligne')}">guide du e-commerce au Maroc</a>.</p>

<h2>Plateforme sur mesure et application web : un budget par fonctionnalités</h2>
<p>Pour un portail client, un outil de réservation, un CRM adapté à vos processus ou une plateforme SaaS, le prix se construit fonctionnalité par fonctionnalité : nombre de profils utilisateurs, règles métier, tableaux de bord, intégrations avec d'autres logiciels, exigences de sécurité. La bonne pratique consiste à lancer une première version limitée à l'essentiel (le MVP), puis à l'enrichir. Notre article <a href="{$r('blog.show', 'creer-une-plateforme-saas-mvp-multi-tenant-facturation-par-ou-commencer')}">créer une plateforme SaaS : par où commencer</a> détaille cette démarche.</p>

<h2>Les coûts récurrents : nom de domaine, hébergement, maintenance</h2>
<p>Le prix de création n'est pas le seul budget à prévoir. Chaque année, comptez :</p>
<ul>
<li><strong>le nom de domaine</strong> (.ma, .com ou les deux) : les noms en .ma relèvent de l'ANRT et s'enregistrent auprès d'un registrar agréé ;</li>
<li><strong>l'hébergement</strong>, dont le niveau dépend du trafic et du type de site ;</li>
<li><strong>la maintenance</strong> : mises à jour de sécurité, sauvegardes, corrections et petites évolutions ;</li>
<li>pour un site e-commerce, <strong>les commissions de paiement</strong> prélevées par la banque ou le prestataire.</li>
</ul>
<p>Demandez toujours que ces coûts récurrents figurent clairement dans le devis, distinctement du prix de création.</p>

<h2>Le référencement (SEO) : inclus, en option ou à part ?</h2>
<p>Un site sans visibilité sur Google génère peu de contacts. Vérifiez ce que le devis inclut : une base technique propre (vitesse, structure, balises) devrait faire partie de toute création de site. Le travail de mots-clés, de contenus et de SEO local est en revanche un service à part entière, souvent mené dans la durée. Si la visibilité est votre priorité, faites chiffrer le site et l'<a href="{$r('service', 'seo-maroc')}">accompagnement SEO au Maroc</a> ensemble, pour que la structure du site serve vos objectifs de référencement dès le départ.</p>

<h2>Délais de création : ce qui est réaliste</h2>
<p>Le délai dépend du type de site et de la rapidité des échanges. Un site vitrine peut être mis en ligne en quelques jours une fois le contenu disponible ; une boutique en ligne ou une plateforme sur mesure se planifie par étapes, avec des validations intermédiaires. Le facteur qui retarde le plus souvent un projet n'est pas le développement, mais l'attente des contenus (textes, photos, logo) et des validations.</p>

<h2>Ce que doit contenir un site professionnel</h2>
<ul>
<li>un affichage rapide et lisible sur mobile, où se fait la majorité des visites ;</li>
<li>des pages qui répondent aux questions de vos clients, avec des appels à l'action clairs ;</li>
<li>des mentions légales, une politique de confidentialité et, au Maroc, le respect de la loi 09-08 sur les données personnelles ;</li>
<li>un certificat SSL (HTTPS) et des sauvegardes régulières ;</li>
<li>un outil de mesure d'audience pour suivre les visites et les demandes ;</li>
<li>un accès d'administration pour mettre à jour vos contenus sans dépendre de l'agence.</li>
</ul>

<h2>Les questions à poser à une agence avant de demander un devis</h2>
<ol>
<li>Pouvez-vous me montrer des sites comparables au mien, en ligne aujourd'hui ?</li>
<li>Qu'est-ce qui est inclus dans le prix, et qu'est-ce qui est en option ?</li>
<li>Combien de cycles de révision sont prévus avant la mise en ligne ?</li>
<li>Quels sont les coûts récurrents (hébergement, maintenance, nom de domaine) ?</li>
<li>Pourrai-je modifier mes contenus moi-même ?</li>
<li>Quel est le calendrier, et quel est l'échéancier de paiement ?</li>
<li>Qui interviendra sur mon projet et comment communiquerons-nous ?</li>
</ol>
<p>Méfiez-vous des promesses de première position sur Google et des prix très bas sans détail du périmètre : ils cachent souvent des coûts reportés ou un site difficile à faire évoluer.</p>

<h2>Obtenir un prix précis pour votre projet</h2>
<p>Le moyen le plus fiable de connaître le prix de votre site est de décrire votre projet : objectifs, pages, fonctionnalités, langues et délai souhaité. CodeSommet pratique une tarification sur mesure : vous recevez un <a href="{$r('get-quote')}">devis gratuit</a> et détaillé sous 24 heures, sans engagement. Pour découvrir notre approche de la <a href="{$r('home')}">création de site web au Maroc</a>, consultez aussi nos <a href="{$r('our-work')}">études de cas</a>.</p>
HTML,
            ],

            // ───────────────────────────────────────────── 2. E-COMMERCE AU MAROC
            [
                'slug'             => 'e-commerce-maroc-guide-lancer-boutique-en-ligne',
                'published_at'     => '2026-10-30 10:00:00',
                'title'            => 'E-commerce au Maroc : le guide pour lancer une boutique en ligne',
                'meta_title'       => 'E-commerce au Maroc : lancer sa boutique en ligne',
                'meta_description' => "Statut, paiement en ligne, livraison, confiance, choix de la plateforme : les étapes pour lancer une boutique en ligne au Maroc, et les erreurs à éviter.",
                'excerpt'          => "Vendre en ligne au Maroc demande de régler cinq sujets avant même le design : statut juridique, paiement, livraison, confiance des acheteurs et choix de la plateforme. Voici le guide pour lancer votre boutique sur de bonnes bases.",
                'content'          => <<<HTML
<p>Le e-commerce au Maroc progresse, porté par l'usage massif du smartphone et des réseaux sociaux. Mais une boutique en ligne qui vend vraiment ne se résume pas à un catalogue joliment présenté : il faut un cadre juridique, des moyens de paiement adaptés, une logistique fiable et des acheteurs rassurés. Ce guide passe en revue les étapes pour lancer un site de vente en ligne au Maroc, dans l'ordre où les décisions doivent être prises.</p>

<h2>1. Choisir un statut juridique adapté</h2>
<p>Pour vendre en ligne de façon durable, il faut une existence légale : le statut d'auto-entrepreneur convient pour démarrer une petite activité, tandis qu'une société (SARL par exemple) devient nécessaire dès que l'activité grandit ou que vous recrutez. Les identifiants de votre entreprise (RC, ICE) doivent figurer dans vos mentions légales et sur vos factures. Ce cadre est aussi un préalable pour ouvrir un contrat d'encaissement en ligne avec votre banque.</p>

<h2>2. Proposer les bons moyens de paiement</h2>
<p>Au Maroc, le paiement à la livraison reste très répandu : il rassure les acheteurs qui n'ont pas encore confiance dans la boutique. Proposer aussi le paiement par carte bancaire réduit les refus à la livraison et les coûts de retour. Pour accepter les cartes marocaines, vous signez un contrat de vente à distance avec votre banque, qui vous donne accès à la plateforme de paiement du CMI ; la banque vérifie au préalable que votre site affiche des conditions générales de vente, une politique de retour et vos mentions légales. Si vous vendez à l'international, une solution comme PayPal peut compléter le dispositif selon les pays visés.</p>

<h2>3. Organiser la livraison et les retours</h2>
<p>La livraison est souvent ce qui fait ou défait l'expérience client. Choisissez des partenaires capables de couvrir vos villes cibles, d'encaisser le paiement à la livraison si vous le proposez et de vous transmettre un suivi des colis. Affichez clairement les délais et les frais par zone, et rédigez une politique de retour simple : c'est un argument de vente autant qu'une obligation.</p>

<h2>4. Construire la confiance dès la première visite</h2>
<ul>
<li>des fiches produits complètes : photos réelles, dimensions, matières, disponibilité ;</li>
<li>des coordonnées visibles et un contact rapide, par exemple via WhatsApp ;</li>
<li>des avis clients authentiques et des conditions de vente faciles à trouver ;</li>
<li>un site sécurisé (HTTPS) et une politique de confidentialité conforme à la loi 09-08 sur les données personnelles, contrôlée par la CNDP.</li>
</ul>

<h2>5. Choisir la bonne plateforme</h2>
<p>Trois grandes options existent. Une plateforme par abonnement se lance vite, mais repose sur des frais mensuels et des applications payantes, et ses solutions de paiement intégrées ne sont pas toujours disponibles pour les entreprises établies au Maroc. Un CMS open source comme WooCommerce est gratuit au départ, mais demande un hébergement, des extensions et une maintenance régulière. Une boutique sur mesure coûte davantage au lancement, mais s'adapte à vos règles (tarifs professionnels, livraison par ville, paiement à la livraison) et n'impose pas de commission de plateforme. Le bon choix dépend de la taille de votre catalogue, de vos intégrations et de vos ambitions ; notre article sur le <a href="{$r('blog.show', 'prix-site-web-maroc-combien-coute-la-creation-d-un-site-internet')}">prix d'un site web au Maroc</a> détaille l'impact de chaque option sur le budget.</p>

<h2>6. Préparer la visibilité : SEO et réseaux sociaux</h2>
<p>Beaucoup de boutiques marocaines démarrent sur Instagram ou Facebook. C'est un bon canal d'acquisition, mais votre site doit aussi être trouvable sur Google : catégories et fiches produits structurées, titres et descriptions uniques, vitesse de chargement sur mobile. Avant le lancement, vérifiez la base technique de votre site avec notre <a href="{$r('tool', 'website-analyzer')}">audit SEO gratuit</a>, puis travaillez les recherches de vos clients dans la durée.</p>

<h2>7. La check-list avant la mise en ligne</h2>
<ol>
<li>Mentions légales, CGV, politique de retour et de confidentialité publiées.</li>
<li>Paiements testés en conditions réelles (carte et paiement à la livraison).</li>
<li>Frais et délais de livraison affichés pour chaque zone.</li>
<li>Commandes de test passées de bout en bout, e-mails de confirmation compris.</li>
<li>Site vérifié sur mobile, images optimisées, pages rapides.</li>
<li>Outil de mesure d'audience et suivi des conversions en place.</li>
</ol>

<h2>Se faire accompagner</h2>
<p>Lancer un site de vente en ligne au Maroc demande de coordonner juridique, paiement, logistique et technique. Notre offre de <a href="{$r('service', 'ecommerce-website-development')}">création de site e-commerce au Maroc</a> couvre le cadrage, le développement de la boutique, l'intégration du paiement et les tests avant lancement. Décrivez votre projet pour recevoir un <a href="{$r('get-quote')}">devis gratuit</a>.</p>
HTML,
            ],
        ];
    }
}
