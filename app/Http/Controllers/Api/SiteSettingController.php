<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Get all basic site information
     */
    public function getBasicInfo(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'site_name' => $settings->site_name,
                'site_description' => $settings->site_description,
                'site_logo_light' => $settings->site_logo_light_url,
                'site_logo_dark' => $settings->site_logo_dark_url,
                'site_favicon' => $settings->site_favicon_url,
                'maintenance_mode' => $settings->maintenance_mode,
                'maintenance_message' => $settings->maintenance_message,
            ]
        ]);
    }

    /**
     * Get contact information
     */
    public function getContactInfo(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'email' => $settings->contact_email,
                'phone_1' => $settings->contact_phone,
                'phone_2' => $settings->contact_phone_2,
                'address' => $settings->contact_address,
            ]
        ]);
    }

    /**
     * Get social media links
     */
    public function getSocialMedia(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'facebook' => $settings->facebook_url,
                'instagram' => $settings->instagram_url,
                'linkedin' => $settings->linkedin_url,
                'youtube' => $settings->youtube_url,
                'telegram' => $settings->telegram_url,
                'tiktok' => $settings->tiktok_url,
            ]
        ]);
    }

    /**
     * Get footer information
     */
    public function getFooterInfo(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'copyright_text' => $settings->footer_text,
                'description' => $settings->footer_description,
                'logo' => $settings->footer_logo_url,
            ]
        ]);
    }

    /**
     * Get SEO settings
     */
    public function getSeoSettings(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'meta_description' => $settings->meta_description,
                'meta_keywords' => $settings->meta_keywords,
                'google_analytics_id' => $settings->google_analytics_id,
            ]
        ]);
    }

    /**
     * Get homepage settings
     */
    public function getHomepageSettings(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'page_under_contract' => $settings->page_under_contract,
                'under_contract_message' => $settings->under_contract_message,
            ]
        ]);
    }

    /**
     * Get hero section data
     */
    public function getHeroSection(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'school_name' => $settings->miea_school_name,
                'typewriter_texts' => $settings->typewriter_texts,
                'intro_text' => $settings->intro_text,
                'hero_images' => $settings->hero_images_urls,
                'button_text' => $settings->hero_button_text,
                'button_link' => $settings->hero_button_link,
            ]
        ]);
    }

    /**
     * Get about section data
     */
    public function getAboutSection(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $settings->about_title,
                'content' => $settings->about_content,
                'image' => $settings->about_image_url,
                'mission' => $settings->mission,
                'vision' => $settings->vision,
            ]
        ]);
    }

    /**
     * Get achievement statistics
     */
    public function getAchievements(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'graduated_students' => $settings->graduated_students,
                'qualified_teachers' => $settings->qualified_teachers,
                'student_teacher_ratio' => $settings->student_teacher_ratio,
                'courses_offered' => $settings->courses_offered,
            ]
        ]);
    }

    /**
     * Get intro video information
     */
    public function getIntroVideo(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $settings->intro_video_title,
                'video_url' => $settings->intro_video_url,
            ]
        ]);
    }


    /**
     * Get Organizational Structure Page data
     */
    public function getOrganizationalStructurePageData(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                // Organisational Structure Images
                'org_structure' => [
                    'light_image' => $settings->org_structure_image_light_url,
                    'dark_image' => $settings->org_structure_image_dark_url,
                ],

                // Leadership Team
                'leadership' => $settings->leadership()
                    ->active()
                    ->ordered()
                    ->get()
                    ->map(function ($leader) {
                        return [
                            'id' => $leader->id,
                            'name' => $leader->name,
                            'role' => $leader->role,
                            'image' => $leader->image_url,
                            'color_code' => $leader->color_code,
                            'order' => $leader->order,
                        ];
                    }),
            ]
        ]);
    }

    /**
     * Get About Page data
     */
    public function getAboutPageData(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                // Organisational Structure Images
                'org_structure' => [
                    'light_image' => $settings->org_structure_image_light_url,
                    'dark_image' => $settings->org_structure_image_dark_url,
                ],

                // Leadership Team
                'leadership' => $settings->leadership()
                    ->active()
                    ->ordered()
                    ->get()
                    ->map(function ($leader) {
                        return [
                            'id' => $leader->id,
                            'name' => $leader->name,
                            'role' => $leader->role,
                            'image' => $leader->image_url,
                            'color_code' => $leader->color_code,
                            'order' => $leader->order,
                        ];
                    }),
            ]
        ]);
    }

    /**
     * Get all site settings (complete data)
     */
    public function getAllSettings(): JsonResponse
    {
        $settings = SiteSetting::current();

        return response()->json([
            'success' => true,
            'data' => [
                // Basic Information
                'basic_info' => [
                    'site_name' => $settings->site_name,
                    'site_description' => $settings->site_description,
                    'site_logo_light' => $settings->site_logo_light_url,
                    'site_logo_dark' => $settings->site_logo_dark_url,
                    'site_favicon' => $settings->site_favicon_url,
                    'maintenance_mode' => $settings->maintenance_mode,
                    'maintenance_message' => $settings->maintenance_message,
                ],

                // Contact Information
                'contact_info' => [
                    'email' => $settings->contact_email,
                    'phone_1' => $settings->contact_phone,
                    'phone_2' => $settings->contact_phone_2,
                    'address' => $settings->contact_address,
                ],

                // Social Media
                'social_media' => [
                    'facebook' => $settings->facebook_url,
                    'instagram' => $settings->instagram_url,
                    'linkedin' => $settings->linkedin_url,
                    'youtube' => $settings->youtube_url,
                    'telegram' => $settings->telegram_url,
                    'tiktok' => $settings->tiktok_url,
                ],

                // Footer
                'footer' => [
                    'copyright_text' => $settings->footer_text,
                    'description' => $settings->footer_description,
                    'logo' => $settings->footer_logo_url,
                ],

                // SEO
                'seo' => [
                    'meta_description' => $settings->meta_description,
                    'meta_keywords' => $settings->meta_keywords,
                    'google_analytics_id' => $settings->google_analytics_id,
                ],

                // Homepage
                'homepage' => [
                    'page_under_contract' => $settings->page_under_contract,
                    'under_contract_message' => $settings->under_contract_message,
                    'hero_section' => [
                        'school_name' => $settings->miea_school_name,
                        'typewriter_texts' => $settings->typewriter_texts,
                        'intro_text' => $settings->intro_text,
                        'hero_images' => $settings->hero_images_urls,
                        'button_text' => $settings->hero_button_text,
                        'button_link' => $settings->hero_button_link,
                    ],
                    'about_section' => [
                        'title' => $settings->about_title,
                        'content' => $settings->about_content,
                        'image' => $settings->about_image_url,
                        'mission' => $settings->mission,
                        'vision' => $settings->vision,
                    ],
                    'achievements' => [
                        'graduated_students' => $settings->graduated_students,
                        'qualified_teachers' => $settings->qualified_teachers,
                        'student_teacher_ratio' => $settings->student_teacher_ratio,
                        'courses_offered' => $settings->courses_offered,
                    ],
                    'intro_video' => [
                        'title' => $settings->intro_video_title,
                        'video_url' => $settings->intro_video_url,
                    ],
                ],
            ]
        ]);
    }
}
