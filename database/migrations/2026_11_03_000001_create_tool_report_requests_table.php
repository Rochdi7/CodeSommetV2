<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * « Recevez ce rapport par e-mail » sur les pages outils : chaque demande
     * est un lead (outil, site analysé, score) relié à sa visite.
     */
    public function up(): void
    {
        Schema::create('tool_report_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('tool_slug', 100);
            $table->string('target_url', 2048)->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->json('report')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('visitor_id', 64)->nullable();
            $table->string('analytics_session_id', 64)->nullable();
            $table->timestamp('emailed_at')->nullable();
            $table->timestamps();

            $table->index('email');
            $table->index('tool_slug');
            $table->index('analytics_session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tool_report_requests');
    }
};
