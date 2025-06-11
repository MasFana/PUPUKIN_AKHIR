<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockApiController extends Controller
{


    public function getOwnerFertilizers($ownerId)
    {
        $stocks = Stock::where('owner_id', $ownerId)
            ->with(['fertilizer:id,name,price_per_kg'])
            ->get();

        $response = $stocks->map(function ($stock) {
            return [
                'id' => $stock->fertilizer->id,
                'name' => $stock->fertilizer->name,
                'price_per_kg' => $stock->fertilizer->price_per_kg,
                'stock_quantity' => (int) str_replace(['.', ','], '', $stock->quantity_kg)
            ];
        });

        return response()->json($response);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
