<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fertilizer;

class AdminFertilizerController extends Controller
{
    public function index()
    {
        $fertilizers = Fertilizer::all();

        // Return JSON for API requests, view for regular requests
        if (request()->wantsJson()) {
            return response()->json($fertilizers);
        }

        return view('admin.stocks.inventory', compact('fertilizers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'subsidized' => 'required|boolean',
            'price_per_kg' => 'required|numeric|min:0',
        ]);

        $fertilizer = Fertilizer::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Fertilizer created successfully',
            'data' => $fertilizer
        ]);
    }

    public function update(Request $request, Fertilizer $fertilizer)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'subsidized' => 'required|boolean',
            'price_per_kg' => 'required|numeric|min:0',
        ]);

        $fertilizer->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Fertilizer updated successfully',
            'data' => $fertilizer
        ]);
    }

    public function destroy(Fertilizer $fertilizer)
    {
        $fertilizer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fertilizer deleted successfully'
        ]);
    }
}