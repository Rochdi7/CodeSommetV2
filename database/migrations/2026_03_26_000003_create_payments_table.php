<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('MAD');
            $table->string('type', 30)->default('milestone');
            $table->string('billing_period', 20)->nullable(); // e.g. "2026-03", "2026-Q2", "2026"
            $table->string('payment_mode')->default('full'); // full | partial
            $table->decimal('partial_amount', 12, 2)->nullable(); // amount received so far (for partial)
            $table->string('method', 30)->default('bank_transfer');
            $table->string('method_custom')->nullable();
            $table->string('status', 20)->default('pending');
            $table->string('invoice_number')->nullable();
            $table->string('reference')->nullable(); // transaction ref
            $table->date('due_date')->nullable();
            $table->date('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
