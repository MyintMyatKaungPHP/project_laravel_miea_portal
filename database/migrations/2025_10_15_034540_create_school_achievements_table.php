<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_setting_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('ac_year');
            $table->json('achievement_list');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_achievements');
    }
};
