<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockRequest;
class AdminStockController extends Controller
{
    public function index()
    {
        $requests = StockRequest::with(['owner.user', 'fertilizer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.stocks.requests', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $stockRequest = StockRequest::findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:approved,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        if ($stockRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan sudah diproses sebelumnya.'
            ], 400);
        }

        try {
            \DB::transaction(function () use ($stockRequest, $validated) {
                $stockRequest->update([
                    'status' => $validated['action'],
                    'admin_notes' => $validated['notes'] ?? null,
                    'processed_at' => now()
                ]);

                // If approved, add to owner's stock
                if ($validated['action'] === 'approved') {
                    StockRequest::updateOrCreate(
                        [
                            'owner_id' => $stockRequest->owner_id,
                            'fertilizer_id' => $stockRequest->fertilizer_id
                        ],
                        [
                            'quantity_kg' => \DB::raw("quantity_kg + {$stockRequest->quantity_kg}")
                        ]
                    );
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Permintaan berhasil diproses.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
