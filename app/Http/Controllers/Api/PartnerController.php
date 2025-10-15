<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of active partners.
     */
    public function index(): JsonResponse
    {
        $partners = Partner::active()
            ->ordered()
            ->get()
            ->map(function ($partner) {
                return [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'image' => $partner->image_url,
                    'order' => $partner->order,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $partners
        ]);
    }

    /**
     * Display the specified partner.
     */
    public function show(Partner $partner): JsonResponse
    {
        if (!$partner->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Partner not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $partner->id,
                'name' => $partner->name,
                'image' => $partner->image_url,
                'order' => $partner->order,
            ]
        ]);
    }

    /**
     * Store a newly created partner.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $partner = Partner::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Partner created successfully',
            'data' => [
                'id' => $partner->id,
                'name' => $partner->name,
                'image' => $partner->image_url,
                'order' => $partner->order,
                'is_active' => $partner->is_active,
            ]
        ], 201);
    }

    /**
     * Update the specified partner.
     */
    public function update(Request $request, Partner $partner): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'image' => 'nullable|image|max:2048',
            'order' => 'sometimes|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $partner->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Partner updated successfully',
            'data' => [
                'id' => $partner->id,
                'name' => $partner->name,
                'image' => $partner->image_url,
                'order' => $partner->order,
                'is_active' => $partner->is_active,
            ]
        ]);
    }

    /**
     * Remove the specified partner.
     */
    public function destroy(Partner $partner): JsonResponse
    {
        $partner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Partner deleted successfully'
        ]);
    }
}
