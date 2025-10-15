<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Basic Site Information
        'site_name',
        'site_logo',
        'site_logo_light',
        'site_logo_dark',
        'site_favicon',
        'site_description',

        // Contact Information
        'contact_email',
        'contact_phone',
        'contact_phone_2',
        'contact_address',

        // Social Media Links
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'telegram_url',
        'tiktok_url',

        // Hero Section
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'hero_images',
        'hero_button_text',
        'hero_button_link',
        'miea_school_name',
        'typewriter_texts',
        'intro_text',

        // About Section
        'about_title',
        'about_content',
        'about_image',
        'mission',
        'vision',


        // Footer
        'footer_text',
        'footer_description',
        'footer_logo',

        // SEO
        'meta_keywords',
        'meta_description',
        'google_analytics_id',

        // Additional Settings
        'maintenance_mode',
        'maintenance_message',
        'page_under_contract',
        'under_contract_message',

        // Achievement Section
        'graduated_students',
        'qualified_teachers',
        'student_teacher_ratio',
        'courses_offered',

        // Intro Video Section
        'intro_video_title',
        'intro_video_url',

        // About Page - Organisational Structure
        'org_structure_image_light',
        'org_structure_image_dark',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'maintenance_mode' => 'boolean',
        'page_under_contract' => 'boolean',
        'typewriter_texts' => 'array',
        'hero_images' => 'array',
        'graduated_students' => 'integer',
        'qualified_teachers' => 'integer',
        'courses_offered' => 'integer',
    ];

    /**
     * Get the site logo URL.
     */
    public function getSiteLogoUrlAttribute(): ?string
    {
        return $this->site_logo ? Storage::url($this->site_logo) : null;
    }

    /**
     * Get the site favicon URL.
     */
    public function getSiteFaviconUrlAttribute(): ?string
    {
        return $this->site_favicon ? Storage::url($this->site_favicon) : null;
    }

    /**
     * Get the hero image URL.
     */
    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->hero_image ? Storage::url($this->hero_image) : null;
    }

    /**
     * Get the about image URL.
     */
    public function getAboutImageUrlAttribute(): ?string
    {
        return $this->about_image ? Storage::url($this->about_image) : null;
    }

    /**
     * Get the site logo light URL.
     */
    public function getSiteLogoLightUrlAttribute(): ?string
    {
        return $this->site_logo_light ? Storage::url($this->site_logo_light) : null;
    }

    /**
     * Get the site logo dark URL.
     */
    public function getSiteLogoDarkUrlAttribute(): ?string
    {
        return $this->site_logo_dark ? Storage::url($this->site_logo_dark) : null;
    }

    /**
     * Get the hero images URLs.
     */
    public function getHeroImagesUrlsAttribute(): array
    {
        if (!$this->hero_images) {
            return [];
        }

        return array_map(function ($image) {
            return Storage::url($image);
        }, $this->hero_images);
    }

    /**
     * Get the footer logo URL.
     */
    public function getFooterLogoUrlAttribute(): ?string
    {
        return $this->footer_logo ? Storage::url($this->footer_logo) : null;
    }

    /**
     * Get the organisational structure image light URL.
     */
    public function getOrgStructureImageLightUrlAttribute(): ?string
    {
        return $this->org_structure_image_light ? Storage::url($this->org_structure_image_light) : null;
    }

    /**
     * Get the organisational structure image dark URL.
     */
    public function getOrgStructureImageDarkUrlAttribute(): ?string
    {
        return $this->org_structure_image_dark ? Storage::url($this->org_structure_image_dark) : null;
    }


    /**
     * Get the leadership relationship.
     */
    public function leadership()
    {
        return $this->hasMany(Leadership::class);
    }

    /**
     * Get the school achievements relationship.
     */
    public function schoolAchievements()
    {
        return $this->hasMany(SchoolAchievement::class);
    }

    /**
     * Get the programme images relationship.
     */
    public function programmeImages()
    {
        return $this->hasMany(ProgrammeImage::class);
    }


    /**
     * Get the current site settings.
     * Creates default settings if none exist.
     */
    public static function current(): self
    {
        $settings = self::first();

        if (!$settings) {
            $settings = self::create([
                'site_name' => 'MIEA Portal',
                'site_description' => 'Welcome to MIEA Portal',
                'footer_text' => '© 2025 MIEA Portal. All rights reserved.',
            ]);
        }

        return $settings;
    }
}
