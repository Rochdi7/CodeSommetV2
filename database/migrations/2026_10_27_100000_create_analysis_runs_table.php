<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Persisted SEO analysis runs (Phase A). Additive only: no existing table is
 * touched, rollback simply drops this table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analysis_runs', function (Blueprint $table) {
            $table->id();
            // Public identifier. Not an authorization: reading a run also
            // requires its access token or being its owner.
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tool', 64)->index();
            $table->string('mode', 10)->default('sync');
            // Normalized input only (what is needed to reproduce the run).
            $table->json('input');
            $table->string('status', 16)->default('pending');
            // Null when the tool cannot report granular progress.
            $table->unsignedTinyInteger('progress')->nullable();
            $table->string('stage', 120)->nullable();
            $table->json('result')->nullable();
            // Sanitized {code, message} only — never exception text.
            $table->json('error')->nullable();
            // SHA-256 of the access token handed to the creator once.
            $table->string('access_token_hash', 64);
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analysis_runs');
    }
};
