<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class BudgetAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_super_admin' => true]);
        // Deterministic PIN hash for tests.
        Config::set('budget.pin_hash', Hash::make('4321'));
        RateLimiter::clear('budget-unlock:'.session()->getId().'|127.0.0.1');
    }

    public function test_budget_is_locked_by_default(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/budget')
            ->assertRedirect(route('admin.budget.lock'));
    }

    public function test_incorrect_pin_is_rejected(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/budget/unlock', ['pin' => '0000'])
            ->assertSessionHasErrors('pin');

        $this->actingAs($this->admin)->get('/admin/budget')->assertRedirect(route('admin.budget.lock'));
    }

    public function test_correct_pin_unlocks_budget(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/budget/unlock', ['pin' => '4321'])
            ->assertRedirect(route('admin.budget.index'));

        $this->actingAs($this->admin)->get('/admin/budget')->assertOk();
    }

    public function test_unlock_expires_after_ttl(): void
    {
        Config::set('budget.unlock_ttl', 15);

        $this->actingAs($this->admin)->post('/admin/budget/unlock', ['pin' => '4321']);

        // Simulate an unlock older than the TTL.
        session(['budget_unlocked' => true, 'budget_unlocked_at' => time() - (16 * 60)]);

        $this->actingAs($this->admin)->get('/admin/budget')->assertRedirect(route('admin.budget.lock'));
    }

    public function test_lock_action_relocks(): void
    {
        $this->actingAs($this->admin)->post('/admin/budget/unlock', ['pin' => '4321']);
        $this->actingAs($this->admin)->post('/admin/budget/lock');

        $this->actingAs($this->admin)->get('/admin/budget')->assertRedirect(route('admin.budget.lock'));
    }
}
