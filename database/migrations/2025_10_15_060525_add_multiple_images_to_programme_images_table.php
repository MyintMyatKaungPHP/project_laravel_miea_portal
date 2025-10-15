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
            // Drop single image field
            $table->dropColumn('image');

            // Add multiple images field
            $table->json('images')->nullable()->after('programme_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programme_images', function (Blueprint $table) {
            // Add back single image field
            $table->string('image')->nullable()->after('programme_name');

            // Drop multiple images field
            $table->dropColumn('images');
        });
    }
};
