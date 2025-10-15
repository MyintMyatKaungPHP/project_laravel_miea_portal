<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolAchievement;
use Illuminate\Http\JsonResponse;

class SchoolAchievementController extends Controller
{
    /**
     * Display a listing of active school achievements.
     */
    public function index(): JsonResponse
    {
        $achievements = SchoolAchievement::active()
            ->ordered()
            ->get()
            ->map(function ($achievement) {
                return [
                    'id' => $achievement->id,
                    'ac_year' => $achievement->ac_year,
                    'achievement_list' => $achievement->achievement_list,
                    'order' => $achievement->order,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $achievements
        ]);
    }

    /**
     * Display the specified school achievement.
     */
    public function show(SchoolAchievement $schoolAchievement): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $schoolAchievement->id,
                'ac_year' => $schoolAchievement->ac_year,
                'achievement_list' => $schoolAchievement->achievement_list,
                'order' => $schoolAchievement->order,
                'is_active' => $schoolAchievement->is_active,
            ]
        ]);
    }
}
