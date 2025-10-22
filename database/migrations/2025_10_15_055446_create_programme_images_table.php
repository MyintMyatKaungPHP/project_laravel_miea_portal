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
        Schema::create('programme_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_setting_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('programme_name')->unique(); // Advanced Level, Upper Secondary (IGCSE), Lower Secondary (Pre-IGCSE)
            $table->string('image')->nullable(); // Single image for each programme
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programme_images');
    }
};
