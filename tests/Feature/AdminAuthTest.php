<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('admin-login:127.0.0.1|admin@example.com');
        RateLimiter::clear('admin-login:127.0.0.1|bad@example.com');
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
    }

    public function test_non_super_admin_is_rejected(): void
    {
        $user = User::factory()->create(['is_super_admin' => false, 'password' => bcrypt('secret123')]);

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'secret123'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_super_admin_can_log_in(): void
    {
        $user = User::factory()->create(['is_super_admin' => true, 'password' => bcrypt('secret123')]);

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'secret123'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_is_throttled(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', ['email' => 'bad@example.com', 'password' => 'wrong']);
        }

        $this->post('/admin/login', ['email' => 'bad@example.com', 'password' => 'wrong'])
            ->assertStatus(429);
    }
}
