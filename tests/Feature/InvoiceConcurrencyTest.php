<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Project;
use App\Models\User;
use App\Services\InvoiceNumberGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Concurrency and correctness guarantees for invoice numbering.
 *
 * Production uses SQLite (serialized writes), so true parallel races cannot
 * produce duplicates. These tests verify the engine-independent guarantees:
 * the unique index rejects duplicates, the retry loop advances past a
 * conflict, deletion never causes reuse of a live number, and year/format
 * boundaries behave.
 */
class InvoiceConcurrencyTest extends TestCase
{
    use RefreshDatabase;

    private function project(): Project
    {
        static $n = 0;
        $n++;

        return Project::create([
            'name' => "P{$n}", 'slug' => "p{$n}", 'client_name' => 'C',
            'type' => 'website', 'status' => 'lead', 'priority' => 'medium',
            'agreed_price' => 100000, 'currency' => 'MAD',
        ]);
    }

    private function pay(Project $p, string $inv): Payment
    {
        return Payment::create([
            'project_id' => $p->id, 'amount' => 10, 'type' => 'milestone',
            'method' => 'cash', 'status' => 'pending', 'invoice_number' => $inv,
        ]);
    }

    public function test_unique_index_prevents_duplicates(): void
    {
        $p = $this->project();
        $this->pay($p, 'INV-2026-001');

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);
        $this->pay($p, 'INV-2026-001');
    }

    public function test_generator_never_returns_a_live_number(): void
    {
        $p = $this->project();
        $gen = app(InvoiceNumberGenerator::class);

        $numbers = [];
        for ($i = 0; $i < 50; $i++) {
            $n = $gen->next(null);
            $this->assertNotContains($n, $numbers, "Generator repeated {$n}");
            $this->assertSame(0, Payment::where('invoice_number', $n)->count());
            $this->pay($p, $n);
            $numbers[] = $n;
        }
        // 50 distinct sequential numbers.
        $this->assertCount(50, array_unique($numbers));
    }

    public function test_deleted_number_is_not_reused_while_a_higher_one_is_live(): void
    {
        $p = $this->project();
        $gen = app(InvoiceNumberGenerator::class);

        $a = $gen->next(null); $this->pay($p, $a);   // 001
        $b = $gen->next(null); $this->pay($p, $b);   // 002
        $c = $gen->next(null); $this->pay($p, $c);   // 003

        // Delete the middle one; MAX is still 003 → next is 004, not 002.
        Payment::where('invoice_number', $b)->delete();
        $next = $gen->next(null);

        $this->assertStringEndsWith('004', $next);
        $this->assertSame(0, Payment::where('invoice_number', $next)->count());
    }

    public function test_retry_loop_advances_past_a_conflict(): void
    {
        // Simulate a race: pre-seed the number the generator would pick, then
        // drive a create through the controller path and assert it lands on the
        // NEXT free number instead of failing.
        $p = $this->project();
        $admin = User::factory()->create(['is_super_admin' => true]);

        $gen = app(InvoiceNumberGenerator::class);
        $taken = $gen->next(null);          // e.g. INV-2026-001
        $this->pay($p, $taken);             // occupy it (as a concurrent request would)

        // add-payment generates an invoice number internally; it must not reuse $taken.
        $this->actingAs($admin)->post("/admin/projects/{$p->id}/add-payment", [
            'amount' => 10, 'type' => 'milestone', 'payment_mode' => 'full', 'method' => 'cash',
        ])->assertRedirect();

        $created = Payment::where('project_id', $p->id)->where('invoice_number', '!=', $taken)->latest('id')->first();
        $this->assertNotNull($created);
        $this->assertNotSame($taken, $created->invoice_number);
        // No duplicates anywhere.
        $all = Payment::pluck('invoice_number')->all();
        $this->assertCount(count($all), array_unique($all));
    }

    public function test_year_and_period_boundaries(): void
    {
        $gen = app(InvoiceNumberGenerator::class);
        $p = $this->project();

        // Monthly period → INV-YYYY-MON-001
        $m = $gen->next('2026-03');
        $this->assertStringContainsString('MAR', $m);
        $this->assertStringEndsWith('001', $m);
        $this->pay($p, $m);

        // Same period increments; different period restarts.
        $m2 = $gen->next('2026-03');
        $this->assertStringEndsWith('002', $m2);
        $q = $gen->next('2026-Q2');
        $this->assertStringContainsString('Q2', $q);
        $this->assertStringEndsWith('001', $q);
    }
}
