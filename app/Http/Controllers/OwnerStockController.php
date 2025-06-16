<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockRequest;

class OwnerStockController extends Controller
{
    public function index()
    {
        $owner = auth()->user()->owner;
        $stocks = $owner->stock()
            ->with('fertilizer')
            ->get();
        // Fetch requests related to the owner
        $requests = $owner->stockRequests()
            ->with('fertilizer')
            ->get();

        $fertilizers = \App\Models\Fertilizer::all();
        // Return the view with the stocks data
        return view('owner.stocks.inventory', compact('stocks', 'requests', 'fertilizers'));
    }

    public function storeRequest(Request $request)
    {
        $owner = auth()->user()->owner;

        // For AJAX requests
        if ($request->wantsJson()) {
            try {
                // Validate the request
                $request->validate([
                    'fertilizer_id' => 'required|exists:fertilizers,id',
                    'quantity_kg' => 'required|integer|min:1',
                ]);

                // Create the request
                $owner->stockRequests()->create([
                    'fertilizer_id' => $request->fertilizer_id,
                    'quantity_kg' => $request->quantity_kg,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Request submitted successfully'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error submitting request',
                    'errors' => $e->getMessage()
                ], 422);
            }
        }
    }
    public function destroyRequest($id)
    {

        $stockRequest = auth()->user()->owner->stockRequests()->findOrFail($id);
        // Check if the request exists
        if (!$stockRequest) {
            return response()->json([
                'success' => false,
                'message' => $stockRequest
            ], 200);
        }
        try {
            // Only allow deletion if request is pending
            if ($stockRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending requests can be deleted'
                ], 403);
            }

            $stockRequest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Request deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting request',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
