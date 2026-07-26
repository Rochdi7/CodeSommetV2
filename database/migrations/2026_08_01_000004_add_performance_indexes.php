<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add indexes for the hot filter columns used on dashboards and the public blog.
 * (payments.status/paid_at/due_date already indexed in the invoice migration.)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->index('expense_date');
            $table->index('category');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index('status');
            $table->index('published_at');
        });

        Schema::table('personal_budget_entries', function (Blueprint $table) {
            $table->index('entry_date');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex(['expense_date']);
            $table->dropIndex(['category']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['published_at']);
        });

        Schema::table('personal_budget_entries', function (Blueprint $table) {
            $table->dropIndex(['entry_date']);
            $table->dropIndex(['category']);
        });
    }
};
