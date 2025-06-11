<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Owner;
class CustomerController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        $quota = [
            'remaining_kg' => $customer->quotas->first()->remaining_kg ?? 0,
            'used_percentage' => $customer->quotas->first()
                ? round(($customer->quotas->first()->max_kg_per_month - $customer->quotas->first()->remaining_kg) / $customer->quotas->first()->max_kg_per_month * 100)
                : 0
        ];

        $latestOrder = $customer->transactions()
            ->latest()
            ->first();

        // simple shops
        $nearbyShopsCount = Owner::count(); // In real app, calculate based on distance

        $recentActivities = $customer->transactions()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($transaction) {
                return (object) [
                    'type' => 'order',
                    'title' => 'Pemesanan Pupuk',
                    'description' => 'Anda memesan ' . $transaction->quantity_kg . ' kg pupuk ' . $transaction->fertilizer->name,
                    'created_at' => $transaction->created_at
                ];
            });

        return view('customer.dashboard', compact(
            'quota',
            'latestOrder',
            'nearbyShopsCount',
            'recentActivities'
        ));
    }

    

}
