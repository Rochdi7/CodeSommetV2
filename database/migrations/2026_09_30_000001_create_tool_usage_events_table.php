<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One row per tool use. `tool_usages` keeps the all-time total per tool;
     * this table adds the time dimension (today / 7d / 30d) and a hashed
     * visitor id so the dashboard can show *people*, not only clicks.
     */
    public function up(): void
    {
        Schema::create('tool_usage_events', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100);
            $table->string('visitor_hash', 64);
            $table->timestamp('created_at')->useCurrent();

            $table->index('created_at');
            $table->index(['slug', 'created_at']);
            $table->index(['visitor_hash', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tool_usage_events');
    }
};
