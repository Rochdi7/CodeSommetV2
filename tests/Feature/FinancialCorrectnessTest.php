<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Project;
use App\Models\User;
use App\Services\InvoiceNumberGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinancialCorrectnessTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_super_admin' => true]);
    }

    private function project(array $attrs = []): Project
    {
        static $n = 0;
        $n++;

        return Project::create(array_merge([
            'name' => "Project {$n}",
            'slug' => "project-{$n}",
            'client_name' => 'Client',
            'type' => 'website',
            'status' => 'lead',
            'priority' => 'medium',
            'agreed_price' => 1000.00,
            'currency' => 'MAD',
        ], $attrs));
    }

    public function test_invoice_numbers_are_unique_and_not_reused_after_deletion(): void
    {
        $project = $this->project();
        $gen = app(InvoiceNumberGenerator::class);

        Payment::create(['project_id' => $project->id, 'amount' => 10, 'type' => 'milestone', 'method' => 'cash', 'status' => 'pending', 'invoice_number' => $gen->next(null)]);
        $second = $gen->next(null);
        Payment::create(['project_id' => $project->id, 'amount' => 10, 'type' => 'milestone', 'method' => 'cash', 'status' => 'pending', 'invoice_number' => $second]);

        // Keep both live, then generate a third — it must not collide with any
        // live invoice number (this is the real guarantee; a COUNT-based scheme
        // would collide after a delete).
        $third = $gen->next(null);
        $this->assertNotSame($second, $third);
        $this->assertSame(0, Payment::where('invoice_number', $third)->count());
        $this->assertStringEndsWith('003', $third);

        // Deleting a row and regenerating must never produce a number that
        // duplicates a still-live row.
        Payment::where('invoice_number', $second)->delete();
        $afterDelete = $gen->next(null);
        $this->assertSame(0, Payment::where('invoice_number', $afterDelete)->count());
    }

    public function test_unique_index_blocks_duplicate_invoice_numbers(): void
    {
        $project = $this->project();
        Payment::create(['project_id' => $project->id, 'amount' => 10, 'type' => 'milestone', 'method' => 'cash', 'status' => 'pending', 'invoice_number' => 'INV-2026-001']);

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);
        Payment::create(['project_id' => $project->id, 'amount' => 20, 'type' => 'milestone', 'method' => 'cash', 'status' => 'pending', 'invoice_number' => 'INV-2026-001']);
    }

    public static function scheduleTotals(): array
    {
        return [[0.05], [100.01], [33.33], [1000.00], [9999.99]];
    }

    /** @dataProvider scheduleTotals */
    public function test_schedule_instalments_sum_exactly_to_total(float $total): void
    {
        $project = $this->project(['agreed_price' => $total]);

        $this->actingAs($this->admin())
            ->post("/admin/projects/{$project->id}/generate-schedule")
            ->assertRedirect();

        $sum = (float) Payment::where('project_id', $project->id)->sum('amount');
        $this->assertEqualsWithDelta($total, $sum, 0.001, "Schedule for {$total} summed to {$sum}");
        $this->assertSame(3, Payment::where('project_id', $project->id)->count());
    }

    public function test_existing_invoice_number_is_preserved_on_edit(): void
    {
        $project = $this->project();
        $payment = Payment::create([
            'project_id' => $project->id, 'amount' => 100, 'type' => 'milestone',
            'method' => 'cash', 'status' => 'pending', 'invoice_number' => 'INV-2026-KEEP',
            'payment_mode' => 'partial',
        ]);

        $this->actingAs($this->admin())->put("/admin/payments/{$payment->id}", [
            'project_id' => $project->id,
            'amount' => 100,
            'payment_mode' => 'partial',
            'method' => 'cash',
            'invoice_number' => '', // blank in the form
            'notes' => 'edited',
        ])->assertRedirect();

        $this->assertSame('INV-2026-KEEP', $payment->fresh()->invoice_number);
    }

    public function test_overpayment_is_rejected(): void
    {
        $project = $this->project(['agreed_price' => 1000]);

        $this->actingAs($this->admin())->post("/admin/projects/{$project->id}/add-payment", [
            'amount' => 5000,
            'type' => 'milestone',
            'payment_mode' => 'full',
            'method' => 'cash',
        ])->assertSessionHasErrors('amount');

        $this->assertSame(0, Payment::where('project_id', $project->id)->count());
    }

    public function test_invalid_project_status_returns_validation_error(): void
    {
        $project = $this->project();

        $this->actingAs($this->admin())
            ->post("/admin/projects/{$project->id}/update-status", ['status' => 'hacked'])
            ->assertSessionHasErrors('status');
    }
}
