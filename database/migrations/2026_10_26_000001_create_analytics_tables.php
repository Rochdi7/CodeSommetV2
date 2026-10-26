<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * First-party traffic analytics (no Google Analytics).
     *
     * `analytics_sessions` — one row per visit (30 min of inactivity starts a
     * new one). Carries where the visitor came from (referrer, UTM), who they
     * are (hashed visitor id, IP, country, device) and the roll-up counters the
     * dashboard reads without touching the events table.
     *
     * `analytics_events` — one row per thing that happened: page view, click
     * on any button/link, form submission, scroll depth, time on page, lead.
     */
    public function up(): void
    {
        Schema::create('analytics_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->unique();
            $table->string('visitor_id', 64);

            $table->string('ip', 45)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->boolean('is_bot')->default(false);
            $table->string('device', 16)->nullable();   // mobile | tablet | desktop
            $table->string('browser', 32)->nullable();
            $table->string('os', 32)->nullable();
            $table->string('language', 16)->nullable();
            $table->string('screen', 16)->nullable();   // "1920x1080"

            $table->string('landing_path', 512)->nullable();
            $table->string('landing_title', 255)->nullable();
            $table->string('referrer', 512)->nullable();
            $table->string('referrer_host', 255)->nullable();
            $table->string('source', 32)->default('direct'); // direct | organic | social | ai | campaign | paid | referral
            $table->string('utm_source', 255)->nullable();
            $table->string('utm_medium', 255)->nullable();
            $table->string('utm_campaign', 255)->nullable();
            $table->string('utm_term', 255)->nullable();
            $table->string('utm_content', 255)->nullable();

            $table->unsignedInteger('pageviews')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->unsignedInteger('events')->default(0);
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->unsignedTinyInteger('max_scroll')->default(0);
            $table->string('exit_path', 512)->nullable();

            $table->string('lead_type', 16)->nullable();  // contact | quote | newsletter
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->timestamp('converted_at')->nullable();

            $table->timestamp('started_at');
            $table->timestamp('last_seen_at');

            $table->index(['visitor_id', 'started_at']);
            $table->index('started_at');
            $table->index('last_seen_at');
            $table->index(['is_bot', 'started_at']);
            $table->index('source');
            $table->index('country');
            $table->index('lead_type');
            $table->index('referrer_host');
            $table->index('utm_campaign');
        });

        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64);
            $table->string('visitor_id', 64);
            $table->string('type', 24);           // pageview | click | form_submit | scroll | leave | lead | tool_use | js_error
            $table->string('kind', 24)->nullable(); // click: cta | cal | whatsapp | phone | email | outbound | download | nav | footer | submit | link | button
            $table->string('path', 512)->nullable();
            $table->string('label', 255)->nullable();
            $table->string('element', 255)->nullable(); // "button#cta.btn-primary"
            $table->string('section', 120)->nullable();
            $table->string('href', 1024)->nullable();
            $table->unsignedInteger('value')->nullable(); // scroll %, seconds, lead id
            $table->json('meta')->nullable();
            $table->boolean('is_bot')->default(false);
            $table->timestamp('created_at');

            $table->index(['session_id', 'created_at']);
            $table->index(['visitor_id', 'created_at']);
            $table->index(['type', 'created_at']);
            $table->index(['type', 'kind']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
        Schema::dropIfExists('analytics_sessions');
    }
};
