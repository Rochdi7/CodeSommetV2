<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_company')->nullable();
            $table->text('description')->nullable();

            // Project type & tech stack
            $table->enum('type', [
                'website', 'ecommerce', 'webapp', 'saas', 'dashboard',
                'mobile_app', 'landing_page', 'redesign', 'maintenance', 'other'
            ])->default('website');
            $table->string('type_custom')->nullable();
            $table->string('billing_type')->default('one_time'); // one_time | recurring
            $table->string('recurring_period')->nullable(); // monthly | quarterly | annually
            $table->json('tech_stack')->nullable(); // ["Laravel", "React", "Tailwind", ...]
            $table->string('domain')->nullable();
            $table->string('staging_url')->nullable();
            $table->string('production_url')->nullable();
            $table->string('repo_url')->nullable();

            // Project lifecycle
            $table->enum('status', [
                'lead', 'proposal', 'negotiation', 'contracted',
                'discovery', 'design', 'development', 'testing',
                'review', 'launched', 'maintenance', 'completed', 'cancelled', 'on_hold'
            ])->default('lead');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->integer('progress')->default(0); // 0-100

            // Dates
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->date('launched_at')->nullable();
            $table->date('completed_at')->nullable();

            // Financial
            $table->decimal('quoted_price', 12, 2)->default(0);
            $table->decimal('agreed_price', 12, 2)->default(0);
            $table->string('currency', 3)->default('MAD');
            $table->decimal('tva_percent', 5, 2)->default(0);

            // Phases / milestones (JSON)
            $table->json('phases')->nullable();
            /*
                Example:
                [
                    {"name": "Discovery & Brief", "status": "completed", "due_date": "2026-01-15"},
                    {"name": "Wireframes & UX", "status": "completed", "due_date": "2026-01-30"},
                    {"name": "UI Design", "status": "in_progress", "due_date": "2026-02-15"},
                    {"name": "Frontend Dev", "status": "pending", "due_date": "2026-03-01"},
                    {"name": "Backend Dev", "status": "pending", "due_date": "2026-03-20"},
                    {"name": "Testing & QA", "status": "pending", "due_date": "2026-04-01"},
                    {"name": "Launch", "status": "pending", "due_date": "2026-04-10"}
                ]
            */

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
