<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceValidationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_super_admin' => true]);
    }

    public function test_reversed_date_range_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/finance?start_date=2026-12-31&end_date=2026-01-01')
            ->assertSessionHasErrors('end_date');
    }

    public function test_extreme_date_range_is_capped_and_does_not_hang(): void
    {
        // Without the cap this would attempt ~108k loop iterations. With it,
        // the request completes normally.
        $response = $this->actingAs($this->admin())
            ->get('/admin/finance?start_date=1000-01-01&end_date=9999-12-31');

        $response->assertOk();
    }

    public function test_valid_range_works(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/finance?start_date=2026-01-01&end_date=2026-06-30')
            ->assertOk();
    }
}
