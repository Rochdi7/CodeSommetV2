<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Le site est francophone : le contenu produit par les générateurs doit l'être
 * aussi. Les trames étaient rédigées en anglais et la trame de page
 * d'atterrissage avançait des chiffres inventés (« 3x productivity »,
 * « 10,000+ businesses ») présentés comme des faits.
 */
class ToolsApiContentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('tools-api');
    }

    public function test_blog_titles_are_generated_in_french(): void
    {
        $data = $this->postJson('/api/tools/blog-title-generator', ['input' => 'marketing digital'])
            ->assertOk()
            ->json();

        $this->assertNotEmpty($data['titles']);

        $joined = implode(' | ', array_column($data['titles'], 'title'));
        foreach (['Proven Ways', 'Complete Guide', 'Everything You Need', 'Made Simple'] as $english) {
            $this->assertStringNotContainsString($english, $joined);
        }
        $this->assertMatchesRegularExpression('/méthodes|guide complet|secret|erreurs/iu', $joined);

        // Les accroches émotionnelles sont également localisées. Chaque gabarit
        // porte désormais l'intention qu'il exprime réellement, au lieu d'une
        // valeur tirée au sort — la liste s'est donc élargie.
        $hooks = array_unique(array_column($data['titles'], 'emotionalHook'));
        foreach ($hooks as $hook) {
            $this->assertContains($hook, [
                'Curiosité', 'Urgence', 'Bénéfice', 'Crainte', 'Aspiration',
                'Pédagogie', 'Preuve', 'Exhaustivité', 'Simplicité',
            ]);
        }
    }

    /**
     * Le générateur ne doit renvoyer aucune métrique inventée : ni score SEO
     * tiré au sort, ni estimation de taux de clic — le CTR dépend de la
     * position SERP et de la concurrence, invisibles depuis la chaîne.
     */
    public function test_blog_titles_expose_no_fabricated_metrics(): void
    {
        $data = $this->postJson('/api/tools/blog-title-generator', ['input' => 'marketing digital'])
            ->assertOk()
            ->json();

        foreach ($data['titles'] as $title) {
            $this->assertArrayNotHasKey('ctrEstimate', $title);
            $this->assertArrayHasKey('scoreBreakdown', $title);
            $this->assertNotEmpty($title['scoreBreakdown']);

            // Le score doit être la somme exacte de son propre détail.
            $sum = array_sum(array_column($title['scoreBreakdown'], 'points'));
            $this->assertSame($title['seoScore'], $sum, 'Le score doit égaler la somme des critères.');
        }

        $this->assertSame('deterministic', $data['scoring']['method']);
    }

    /**
     * Deux appels identiques doivent produire exactement le même résultat.
     * L'implémentation précédente utilisait rand(), donc chaque appel
     * renvoyait des scores différents pour les mêmes titres.
     */
    public function test_blog_title_scores_are_reproducible(): void
    {
        $first = $this->postJson('/api/tools/blog-title-generator', ['input' => 'marketing digital'])
            ->assertOk()->json('titles');

        RateLimiter::clear('tools-api');

        $second = $this->postJson('/api/tools/blog-title-generator', ['input' => 'marketing digital'])
            ->assertOk()->json('titles');

        $this->assertSame(
            array_column($first, 'title'),
            array_column($second, 'title'),
            'Les titres générés doivent être stables d\'un appel à l\'autre.'
        );
        $this->assertSame(
            array_column($first, 'seoScore'),
            array_column($second, 'seoScore'),
            'Les scores doivent être déterministes.'
        );
    }

    public function test_landing_page_copy_is_french_and_invents_no_metrics(): void
    {
        $content = $this->postJson('/api/tools/landing-page-generator', ['input' => 'CodeSommet'])
            ->assertOk()
            ->json('content');

        $this->assertStringContainsString('Section héros', $content);
        $this->assertStringContainsString('Appel à l\'action final', $content);

        // Aucune statistique fabriquée présentée comme réelle.
        foreach (['3x increase', '10,000+', '40% of their time', 'Happy Customer'] as $invented) {
            $this->assertStringNotContainsString($invented, $content);
        }
        // Le témoignage est explicitement signalé comme à remplacer.
        $this->assertStringContainsString('À remplacer par un témoignage client authentique', $content);
    }

    public function test_chatbot_script_is_generated_in_french(): void
    {
        $content = $this->postJson('/api/tools/chatbot-script-generator', ['input' => 'E-commerce'])
            ->assertOk()
            ->json('content');

        $script = json_decode($content, true);
        $this->assertIsArray($script, 'Le script renvoyé doit être un JSON valide.');

        $this->assertStringContainsString('Bienvenue', $script['welcomeMessage']);
        $this->assertContains('Demander un devis', $script['quickReplies']);
        $this->assertSame('Demande de tarif', $script['intents'][0]['name']);
    }

    public function test_unicode_input_is_preserved_in_generated_titles(): void
    {
        $data = $this->postJson('/api/tools/blog-title-generator', ['input' => 'référencement à Genève'])
            ->assertOk()
            ->json();

        $joined = implode(' ', array_column($data['titles'], 'title'));
        $this->assertStringContainsString('Référencement', $joined);
        $this->assertStringContainsString('Genève', $joined);
    }

    public function test_empty_topic_is_rejected(): void
    {
        $this->postJson('/api/tools/blog-title-generator', ['input' => ''])
            ->assertStatus(422)
            ->assertJsonStructure(['error']);
    }
}
