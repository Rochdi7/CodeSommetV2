<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('label');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('MAD');
            $table->enum('category', [
                'hosting', 'domain', 'license', 'software', 'freelancer',
                'ads', 'tools', 'hardware', 'office', 'travel',
                'marketing', 'design_asset', 'api_service', 'other'
            ])->default('other');
            $table->string('category_custom')->nullable();
            $table->date('expense_date');
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_period')->nullable(); // monthly, yearly
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
