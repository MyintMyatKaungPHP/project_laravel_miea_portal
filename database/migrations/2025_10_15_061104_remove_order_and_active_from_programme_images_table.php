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
        Schema::table('programme_images', function (Blueprint $table) {
            // Remove order and is_active fields
            $table->dropColumn(['order', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programme_images', function (Blueprint $table) {
            // Add back order and is_active fields
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
        });
    }
};
