<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ahrefs audit 2026-10-27: "Title too long" / "Meta description too long"
     * on the 5 published posts. Titles now fit "<meta_title> | CodeSommet"
     * in 60 characters, descriptions in 155. Data-only: no schema change.
     */
    private array $meta = [
        'site-web-fintech-7-elements-qui-rassurent-un-visiteur' => [
            'meta_title' => 'Site fintech : 7 éléments qui rassurent',
        ],
        'site-web-telemedecine-cabinet-clinique-que-doit-il-contenir' => [
            'meta_title' => 'Site de télémédecine : le contenu essentiel',
            'meta_description' => "Pages, infos pratiques, prise de rendez-vous, confidentialité, mobile : ce qu'un site de télémédecine doit contenir pour un cabinet ou une clinique.",
        ],
        'lms-sur-mesure-ou-produit-edtech-quelle-plateforme-e-learning' => [
            'meta_title' => 'LMS sur mesure ou EdTech : que choisir ?',
        ],
        'site-immobilier-structurer-les-annonces-pour-le-seo-et-la-conversion' => [
            'meta_title' => 'Site immobilier : des annonces qui convertissent',
            'meta_description' => "URL, titres, contenu, données structurées, photos, formulaire : construire des pages d'annonces immobilières qui se positionnent et convertissent.",
        ],
        'creer-une-plateforme-saas-mvp-multi-tenant-facturation-par-ou-commencer' => [
            'meta_title' => 'Créer une plateforme SaaS : MVP et multi-tenant',
            'meta_description' => "Périmètre du MVP, architecture multi-tenant, abonnements, facturation, sécurité : les décisions à prendre dans l'ordre pour lancer un SaaS.",
        ],
    ];

    public function up(): void
    {
        foreach ($this->meta as $slug => $values) {
            DB::table('blog_posts')->where('slug', $slug)->update($values);
        }
    }

    public function down(): void
    {
        // Contenu éditorial : pas de retour arrière automatique.
    }
};
