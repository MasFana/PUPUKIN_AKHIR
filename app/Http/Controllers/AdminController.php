<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Owner;
use App\Models\StockRequest;
use App\Models\Fertilizer;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function index()
    {// Total users (excluding admins)
        $totalUsers = User::where('role', '!=', 'admin')->count();

        // Pending stock requests
        $pendingRequests = StockRequest::where('status', 'pending')->count();

        // Today's transactions
        $todaysTransactions = Transaction::whereDate('created_at', Carbon::today())->count();

        // Fertilizer types
        $fertilizerTypes = Fertilizer::count();

        // Recent transactions (5 most recent)
        $recentTransactions = Transaction::with(['customer.user', 'fertilizer'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent users (5 most recent, excluding admins)
        $recentUsers = User::where('role', '!=', 'admin')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingRequests',
            'todaysTransactions',
            'fertilizerTypes',
            'recentTransactions',
            'recentUsers'
        ));
    }

}

    