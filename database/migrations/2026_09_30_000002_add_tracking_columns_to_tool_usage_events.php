<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Per-use detail for the admin "Suivi des outils" page: who (IP, country,
     * user agent), what they scanned (target_url), whether it looks like a bot,
     * and where the row came from (live request vs. access-log import).
     */
    public function up(): void
    {
        Schema::table('tool_usage_events', function (Blueprint $table) {
            $table->string('ip', 45)->nullable()->after('visitor_hash');
            $table->string('country', 2)->nullable()->after('ip');
            $table->string('user_agent', 512)->nullable()->after('country');
            $table->boolean('is_bot')->default(false)->after('user_agent');
            $table->text('target_url')->nullable()->after('is_bot');
            $table->string('referer', 512)->nullable()->after('target_url');
            $table->string('source', 16)->default('live')->after('referer');

            $table->index('ip');
            $table->index(['is_bot', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('tool_usage_events', function (Blueprint $table) {
            $table->dropIndex(['ip']);
            $table->dropIndex(['is_bot', 'created_at']);
            $table->dropColumn(['ip', 'country', 'user_agent', 'is_bot', 'target_url', 'referer', 'source']);
        });
    }
};
