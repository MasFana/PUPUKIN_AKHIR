<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Stock;
use App\Models\StockRequest;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function index()
    {
        $owner = auth()->user()->owner;

        // Calculate total stock
        $totalStock = $owner->stock()->sum('quantity_kg');

        // Count pending transactions
        $pendingTransactions = $owner->transactions()
            ->where('status', 'pending')
            ->count();

        // Calculate monthly sales (completed transactions)
        $monthlySales = $owner->transactions()
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_price');

        // Count pending stock requests
        $pendingStockRequests = $owner->stockRequests()
            ->where('status', 'pending')
            ->count();

        // Get recent transactions
        $recentTransactions = $owner->transactions()
            ->with(['customer.user', 'fertilizer'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('owner.dashboard', compact(
            'totalStock',
            'pendingTransactions',
            'monthlySales',
            'pendingStockRequests',
            'recentTransactions'
        ));
    }
}