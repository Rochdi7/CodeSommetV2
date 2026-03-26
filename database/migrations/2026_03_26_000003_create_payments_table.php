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
            $table->enum('type', ['deposit', 'milestone', 'final', 'maintenance', 'extra', 'refund'])->default('milestone');
            $table->enum('method', ['bank_transfer', 'paypal', 'stripe', 'cash', 'wise', 'crypto', 'other'])->default('bank_transfer');
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled', 'refunded'])->default('pending');
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
