<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProgrammeImage;
use Illuminate\Http\JsonResponse;

class ProgrammeImageController extends Controller
{
    /**
     * Display a listing of programme images.
     */
    public function index(): JsonResponse
    {
        $programmeImages = ProgrammeImage::all()
            ->map(function ($programmeImage) {
                return [
                    'id' => $programmeImage->id,
                    'programme_name' => $programmeImage->programme_name,
                    'images' => $programmeImage->images_urls,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $programmeImages
        ]);
    }

    /**
     * Display programme images by programme name.
     */
    public function byProgrammeName(string $programmeName): JsonResponse
    {
        $programmeImage = ProgrammeImage::byProgrammeName($programmeName)
            ->first();

        if (!$programmeImage) {
            return response()->json([
                'success' => false,
                'message' => 'Programme images not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $programmeImage->id,
                'programme_name' => $programmeImage->programme_name,
                'images' => $programmeImage->images_urls,
            ]
        ]);
    }

    /**
     * Display the specified programme images.
     */
    public function show(ProgrammeImage $programmeImage): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $programmeImage->id,
                'programme_name' => $programmeImage->programme_name,
                'images' => $programmeImage->images_urls,
            ]
        ]);
    }
}
