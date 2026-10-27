<?php

namespace Tests\Feature\ToolsV2;

class SerpSnippetPreviewTest extends ToolsV2TestCase
{
    public function test_page_renders(): void
    {
        $this->assertToolPage('serp-snippet-preview', 'Aperçu SERP Google');
    }

    public function test_rejects_bad_input(): void
    {
        $this->tool('serp-snippet-preview', [])->assertStatus(422);
        $this->tool('serp-snippet-preview', ['url' => 'not a url'])->assertStatus(422);
        $this->tool('serp-snippet-preview', ['url' => 'http://127.0.0.1/'])->assertStatus(422);
        $this->tool('serp-snippet-preview', ['url' => str_repeat('a', 3000)])->assertStatus(422);
    }

    public function test_unknown_tool_is_404(): void
    {
        $this->tool('does-not-exist', ['url' => 'https://a.test/'])->assertStatus(404);
    }

    public function test_extracts_title_description_and_canonical(): void
    {
        $this->fakeHttp([
            'https://site.test/page' => $this->response(200, '<html lang="fr"><head><title> Ma page </title><meta name="description" content="Une description."><link rel="canonical" href="https://site.test/page/"><meta property="og:title" content="OG"></head><body><h1>Titre  H1</h1></body></html>'),
            'https://site.test/missing' => $this->response(404, 'nope'),
        ]);

        $this->tool('serp-snippet-preview', ['url' => 'site.test/page'])
            ->assertOk()
            ->assertJsonPath('title', 'Ma page')
            ->assertJsonPath('description', 'Une description.')
            ->assertJsonPath('canonical', 'https://site.test/page/')
            ->assertJsonPath('ogTitle', 'OG')
            ->assertJsonPath('h1', 'Titre H1')
            ->assertJsonPath('lang', 'fr');

        $this->tool('serp-snippet-preview', ['url' => 'https://site.test/missing'])
            ->assertStatus(422)->assertJsonPath('error', 'La page a répondu avec le code HTTP 404.');
        $this->tool('serp-snippet-preview', ['url' => 'https://site.test/slow'])
            ->assertStatus(500);
    }
}
