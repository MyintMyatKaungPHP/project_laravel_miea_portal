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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Basic Site Information
            $table->string('site_name');
            $table->string('site_logo')->nullable();
            $table->string('site_logo_light')->nullable();
            $table->string('site_logo_dark')->nullable();
            $table->string('site_favicon')->nullable();
            $table->text('site_description')->nullable();

            // Contact Information
            $table->string('contact_email');
            $table->string('contact_email_2')->nullable();
            $table->string('contact_phone');
            $table->string('contact_phone_2')->nullable();
            $table->text('contact_address')->nullable();

            // Social Media Links
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('telegram_url')->nullable();
            $table->string('tiktok_url')->nullable();

            // Hero Section
            $table->string('school_name')->nullable();
            $table->json('typewriter_texts')->nullable();
            $table->text('intro_text')->nullable();
            $table->json('hero_images')->nullable();
            $table->string('hero_button_text')->nullable();
            $table->string('hero_button_link')->nullable();
            $table->boolean('hero_button_show')->default(true);

            // About Section
            $table->string('about_title')->nullable();
            $table->text('about_content')->nullable();
            $table->string('about_image')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();

            // Footer
            $table->text('footer_text')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('footer_logo')->nullable();

            // SEO
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('google_analytics_id')->nullable();

            // Additional Settings
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();

            // Page Maintenance
            $table->boolean('page_under_maintenance')->default(false);
            $table->text('under_maintenance_message')->nullable();

            // Statistics
            $table->string('graduated_students')->nullable();
            $table->string('qualified_teachers')->nullable();
            $table->string('student_teacher_ratio')->nullable();
            $table->string('courses_offered')->nullable();

            // Video Section
            $table->string('intro_video_title')->nullable();
            $table->string('intro_video_url')->nullable();

            // Organization Structure
            $table->string('org_structure_image_light')->nullable();
            $table->string('org_structure_image_dark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
