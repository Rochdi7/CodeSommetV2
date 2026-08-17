<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Coverage added ahead of the Phase 1 view-tree migration (RFC-001 Step 1):
 * HomeAdController::index() is the only controller rendering a view from the
 * legacy resources/views/pages/ tree, and this page previously had zero test
 * coverage — a botched move would 500 silently.
 */
class AdminHomeAdsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_home_ads(): void
    {
        $this->get('/admin/home-ads')->assertRedirect();
    }

    public function test_super_admin_can_render_home_ads_page(): void
    {
        $admin = User::factory()->create(['is_super_admin' => true]);

        $this->actingAs($admin)
            ->get('/admin/home-ads')
            ->assertOk();
    }
}
