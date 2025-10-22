<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    /**
     * Get hero section data only
     */
    public function getHeroSection()
    {
        try {
            $settings = SiteSetting::first();

            if (!$settings) {
                return response()->json([
                    'success' => false,
                    'message' => 'Site settings not found'
                ], 404);
            }

            $heroImage = null;
            if (!empty($settings->hero_images_urls)) {
                // If stored as array, pick the first; if string, use as-is
                $heroImage = is_array($settings->hero_images_urls)
                    ? ($settings->hero_images_urls[0] ?? null)
                    : $settings->hero_images_urls;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $settings->id,
                    'school_name' => $settings->miea_school_name,
                    'typewriter_texts' => $settings->typewriter_texts,
                    'intro_text' => $settings->intro_text,
                    'hero_image' => $heroImage,
                    'button_text' => $settings->hero_button_text,
                    'button_link' => $settings->hero_button_link,
                    'button_show' => $settings->hero_button_show,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch hero section data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
