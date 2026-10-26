<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Link every lead back to the analytics session that produced it, so the
     * admin can replay the full journey (landing page, source, clicks) of a
     * contact message, quote request or newsletter sign-up.
     */
    public function up(): void
    {
        foreach (['contact_messages', 'quote_requests', 'newsletter_subscribers'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('visitor_id', 64)->nullable()->after('ip_address');
                $table->string('analytics_session_id', 64)->nullable()->after('visitor_id');

                $table->index('analytics_session_id');
            });
        }
    }

    public function down(): void
    {
        foreach (['contact_messages', 'quote_requests', 'newsletter_subscribers'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropIndex(['analytics_session_id']);
                $table->dropColumn(['visitor_id', 'analytics_session_id']);
            });
        }
    }
};
