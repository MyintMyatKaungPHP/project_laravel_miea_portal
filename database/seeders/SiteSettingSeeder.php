<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            // Basic Site Information
            'site_name' => 'MIEA Portal',
            'site_description' => 'Myanmar Institute of Educational Advancement - Portal for excellence in education',

            // Contact Information
            'contact_email' => 'info@miea.edu.mm',
            'contact_phone' => '+95 9 123 456 789',
            'contact_address' => 'Yangon, Myanmar',

            // Social Media Links
            'facebook_url' => 'https://facebook.com/miea',
            'twitter_url' => 'https://twitter.com/miea',
            'instagram_url' => 'https://instagram.com/miea',
            'linkedin_url' => 'https://linkedin.com/company/miea',
            'youtube_url' => 'https://youtube.com/@miea',

            // Hero Section
            'hero_title' => 'Welcome to MIEA Portal',
            'hero_subtitle' => 'Excellence in Education, Innovation in Learning',
            'hero_button_text' => 'Learn More',
            'hero_button_link' => '/about',

            // About Section
            'about_title' => 'About MIEA',
            'about_content' => 'Myanmar Institute of Educational Advancement (MIEA) is dedicated to providing quality education and fostering innovation in learning. We strive to empower students and educators through comprehensive programs and resources.',

            // Footer
            'footer_text' => '© 2025 MIEA Portal. All rights reserved.',
            'footer_description' => 'Myanmar Institute of Educational Advancement - Building a better future through education.',

            // SEO
            'meta_keywords' => 'MIEA, Myanmar, Education, Institute, Learning, Portal',
            'meta_description' => 'Myanmar Institute of Educational Advancement - Portal for excellence in education and innovation in learning.',

            // Additional Settings
            'maintenance_mode' => false,
            'maintenance_message' => null,
        ]);
    }
}
