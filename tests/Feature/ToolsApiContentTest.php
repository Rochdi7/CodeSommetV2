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

        // Les accroches émotionnelles sont également localisées.
        $hooks = array_unique(array_column($data['titles'], 'emotionalHook'));
        foreach ($hooks as $hook) {
            $this->assertContains($hook, ['Curiosité', 'Urgence', 'Bénéfice', 'Crainte', 'Aspiration']);
        }
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
