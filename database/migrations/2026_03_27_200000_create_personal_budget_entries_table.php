<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_budget_entries', function (Blueprint $table) {
            $table->id();
            $table->date('entry_date');
            $table->string('category');           // slug (essence, repas, etc.)
            $table->string('category_label')->nullable(); // for custom "autre"
            $table->decimal('amount', 10, 2);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_budget_entries');
    }
};
