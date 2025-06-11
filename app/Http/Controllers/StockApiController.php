<?php

use App\Http\Controllers\Controller;
use App\Models\Fertilizer;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockApiController extends Controller
{
    /**
     * Get all fertilizer stocks with their quantities
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get all fertilizers with their stock information
        $fertilizers = Fertilizer::with([
            'stock' => function ($query) {
                $query->select('fertilizer_id', 'owner_id', 'quantity_kg')
                    ->with([
                        'owner' => function ($query) {
                            $query->select('id', 'shop_name');
                        }
                    ]);
            }
        ])->get();

        // Transform the data for better API response
        $response = $fertilizers->map(function ($fertilizer) {
            return [
                'id' => $fertilizer->id,
                'name' => $fertilizer->name,
                'subsidized' => (bool) $fertilizer->subsidized,
                'price_per_kg' => (float) $fertilizer->price_per_kg,
                'total_stock' => $fertilizer->stock->sum('quantity_kg'),
                'stocks' => $fertilizer->stock->map(function ($stock) {
                    return [
                        'owner_id' => $stock->owner_id,
                        'shop_name' => $stock->owner->shop_name,
                        'quantity_kg' => (int) $stock->quantity_kg,
                    ];
                }),
                'created_at' => $fertilizer->created_at,
                'updated_at' => $fertilizer->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $response
        ]);
    }

    /**
     * Get stock details for a specific fertilizer
     * 
     * @param int $id Fertilizer ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $fertilizer = Fertilizer::with([
            'stock' => function ($query) {
                $query->select('fertilizer_id', 'owner_id', 'quantity_kg')
                    ->with([
                        'owner' => function ($query) {
                            $query->select('id', 'shop_name');
                        }
                    ]);
            }
        ])->find($id);

        if (!$fertilizer) {
            return response()->json([
                'success' => false,
                'message' => 'Fertilizer not found'
            ], 404);
        }

        $response = [
            'id' => $fertilizer->id,
            'name' => $fertilizer->name,
            'subsidized' => (bool) $fertilizer->subsidized,
            'price_per_kg' => (float) $fertilizer->price_per_kg,
            'total_stock' => $fertilizer->stock->sum('quantity_kg'),
            'stocks' => $fertilizer->stock->map(function ($stock) {
                return [
                    'owner_id' => $stock->owner_id,
                    'shop_name' => $stock->owner->shop_name,
                    'quantity_kg' => (int) $stock->quantity_kg,
                ];
            }),
            'created_at' => $fertilizer->created_at,
            'updated_at' => $fertilizer->updated_at,
        ];

        return response()->json([
            'success' => true,
            'data' => $response
        ]);
    }
}