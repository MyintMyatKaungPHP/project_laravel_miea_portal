<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leadership;
use Illuminate\Http\JsonResponse;

class LeadershipController extends Controller
{
    /**
     * Display a listing of active leadership.
     */
    public function index(): JsonResponse
    {
        $leadership = Leadership::active()
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
            });

        return response()->json([
            'success' => true,
            'data' => $leadership
        ]);
    }

    /**
     * Display the specified leadership member.
     */
    public function show(Leadership $leadership): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $leadership->id,
                'name' => $leadership->name,
                'role' => $leadership->role,
                'image' => $leadership->image_url,
                'color_code' => $leadership->color_code,
                'order' => $leadership->order,
                'is_active' => $leadership->is_active,
            ]
        ]);
    }
}
