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
        Schema::table('site_settings', function (Blueprint $table) {
            // Add new logo fields for light and dark mode
            $table->string('site_logo_light')->nullable()->after('site_logo');
            $table->string('site_logo_dark')->nullable()->after('site_logo_light');

            // Add second phone number
            $table->string('contact_phone_2')->nullable()->after('contact_phone');

            // Add Telegram and TikTok URLs
            $table->string('telegram_url')->nullable()->after('youtube_url');
            $table->string('tiktok_url')->nullable()->after('telegram_url');

            // Remove Twitter/X URL (will be dropped later)
            // $table->dropColumn('twitter_url'); // Commented out for safety

            // Add MIEA School fields
            $table->string('miea_school_name')->nullable()->after('hero_button_link');
            $table->json('typewriter_texts')->nullable()->after('miea_school_name');
            $table->text('intro_text')->nullable()->after('typewriter_texts');

            // Add support for multiple hero images (JSON array)
            $table->json('hero_images')->nullable()->after('intro_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_logo_light',
                'site_logo_dark',
                'contact_phone_2',
                'telegram_url',
                'tiktok_url',
                'miea_school_name',
                'typewriter_texts',
                'intro_text',
                'hero_images',
            ]);
        });
    }
};
