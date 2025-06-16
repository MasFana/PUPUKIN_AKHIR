<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Auth;
use Illuminate\Http\Request;
use DB;

class OwnerTransactionController extends Controller
{
    public function index()
    {
        $owner = Auth::user()->owner;
        $transactions = Transaction::where('owner_id', $owner->id)
            ->with(['customer.user', 'fertilizer'])
            ->orderByRaw("
                CASE status
                    WHEN 'pending' THEN 1
                    WHEN 'completed' THEN 2
                    WHEN 'cancelled' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('owner.transactions.index', compact('transactions'));
    }

    public function completed($id)
    {
        $owner = Auth::user()->owner;
        $transaction = Transaction::findOrFail($id);

        if ($transaction->owner_id !== $owner->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        if ($transaction->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Transaction is not pending.'
            ], 400);
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Transaction approved successfully',
            'transaction_id' => $transaction->id,
            'status' => 'completed'
        ]);
    }

    public function canceled($id)
    {
        $owner = Auth::user()->owner;
        $transaction = Transaction::findOrFail($id);

        if ($transaction->owner_id !== $owner->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        if ($transaction->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Transaction is not pending.'
            ], 400);
        }

        DB::transaction(function () use ($transaction) {
            // Return stock to fertilizer
            $transaction->fertilizer()->increment('stock', $transaction->quantity_kg);

            // Return quota to customer
            $transaction->customer()->increment('remaining_kg', $transaction->quantity_kg);

            // Update transaction status
            $transaction->update([
                'status' => 'cancelled',
                'completed_at' => now()
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Transaction canceled successfully',
            'transaction_id' => $transaction->id,
            'status' => 'cancelled'
        ]);
    }
}