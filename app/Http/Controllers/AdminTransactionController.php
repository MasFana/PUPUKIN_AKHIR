<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminTransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index()
    {
        $transactions = Transaction::with(['customer.user', 'owner.user', 'fertilizer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['customer.user', 'owner.user', 'fertilizer']);

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Update transaction status.
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string|max:500'
        ]);

        $transaction->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['notes'] ?? null,
            'completed_at' => $validated['status'] === 'completed' ? now() : null
        ]);

        return redirect()->back()
            ->with('success', 'Transaction status updated successfully');
    }

    /**
     * Filter transactions based on criteria.
     */
    public function filter(Request $request)
    {
        $query = Transaction::query()->with(['customer.user', 'owner.user', 'fertilizer']);

        // Date range filter
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to)->endOfDay()
            ]);
        }

        // Status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Customer filter
        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Owner filter
        if ($request->has('owner_id')) {
            $query->where('owner_id', $request->owner_id);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }
}