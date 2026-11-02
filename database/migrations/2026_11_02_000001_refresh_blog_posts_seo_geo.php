<?php

use Database\Seeders\SeoArticlesSeeder;
use Database\Seeders\SeoGuidesSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Passe SEO/GEO du 2 novembre 2026 sur les 7 articles du blog : résumé « En bref »,
     * tableaux comparatifs, FAQ (reprise en FAQPage JSON-LD), maillage interne vers
     * services, villes, outils, études de cas et articles liés, image mise en avant
     * avec alt / légende / description, tags.
     *
     * Mise à jour seulement : un slug absent est ignoré (aucun article créé), et le
     * statut, la catégorie et la date de publication existants sont conservés.
     * Data-only : pas de changement de schéma.
     */
    public function up(): void
    {
        if (! Schema::hasTable('blog_posts')) {
            return;
        }

        (new SeoArticlesSeeder())->sync(createMissing: false);
        (new SeoGuidesSeeder())->sync(createMissing: false);
    }

    public function down(): void
    {
        // Contenu éditorial : pas de retour arrière automatique.
    }
};
