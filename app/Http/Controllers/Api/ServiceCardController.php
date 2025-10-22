<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceCard;
use Illuminate\Http\Request;

class ServiceCardController extends Controller
{
    /**
     * Get all active service cards
     */
    public function index()
    {
        try {
            $serviceCards = ServiceCard::where('active', true)
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($card) {
                    return [
                        'id' => $card->id,
                        'title' => $card->title,
                        'details' => $card->details,
                        'image' => $card->image_url,
                        'overlay_color' => $card->overlay_color,
                        'link' => $card->link,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $serviceCards
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch service cards',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific service card by ID
     */
    public function show($id)
    {
        try {
            $serviceCard = ServiceCard::where('active', true)->find($id);

            if (!$serviceCard) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service card not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $serviceCard->id,
                    'title' => $serviceCard->title,
                    'details' => $serviceCard->details,
                    'image' => $serviceCard->image_url,
                    'overlay_color' => $serviceCard->overlay_color,
                    'link' => $serviceCard->link,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch service card',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
