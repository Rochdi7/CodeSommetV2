<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_ads', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('slot')->unsigned()->unique()->comment('1, 2, or 3');
            $table->string('title')->nullable();
            $table->string('image_path')->nullable();
            $table->string('link_url', 500)->nullable()->default('#');
            $table->string('alt_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_ads');
    }
};
