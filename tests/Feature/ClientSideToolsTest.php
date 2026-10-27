<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Batch 2 browser-only tools. The pure logic is covered by
 * tests/js/free-tools.test.cjs (node --test); this checks the pages render,
 * load their script, are listed on /tools, and that the scripts really never
 * send user data to a server (the pages promise "traitement 100 % local").
 */
class ClientSideToolsTest extends TestCase
{
    private const TOOLS = [
        'url-editor' => 'ue-input',
        'text-editor' => 'te-input',
        'domain-extractor' => 'de-input',
        'invisible-character-cleaner' => 'ic-input',
        'image-compressor' => 'ix-files',
        'keyword-modifier-generator' => 'km-seeds',
    ];

    public function test_each_page_renders_its_form_and_script(): void
    {
        foreach (self::TOOLS as $slug => $inputId) {
            $this->get("/tools/{$slug}")
                ->assertOk()
                ->assertSee('id="'.$inputId.'"', false)
                ->assertSee("js/tools/{$slug}.js", false)
                ->assertSee('js/tools/v2-core.js', false)
                ->assertSee(e(__("tools/{$slug}.h1")), false);
        }
    }

    public function test_each_tool_has_a_card_on_the_index(): void
    {
        $index = $this->get('/tools')->assertOk();
        foreach (array_keys(self::TOOLS) as $slug) {
            $index->assertSee('/tools/'.$slug, false);
            $index->assertSee(e(__("tools/{$slug}.card_title")), false);
        }
    }

    public function test_scripts_make_no_network_requests(): void
    {
        foreach (array_keys(self::TOOLS) as $slug) {
            $js = file_get_contents(public_path("js/tools/{$slug}.js"));
            foreach (['fetch(', 'XMLHttpRequest', 'sendBeacon', 'T.call(', 'WebSocket'] as $needle) {
                $this->assertStringNotContainsString($needle, $js, "{$slug}.js must stay client-side ({$needle})");
            }
        }
    }
}
