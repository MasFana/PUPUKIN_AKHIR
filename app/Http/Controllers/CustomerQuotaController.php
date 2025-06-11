<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quota;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerQuotaController extends Controller
{
    public function index()
    {
        // Get the authenticated user's customer record
        $customer = Customer::where('user_id', Auth::id())->firstOrFail();

        // Calculate the monthly quota based on farm area (1 kg per hectare)
        $monthlyQuota = $customer->farm_area * 1;

        // Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Calculate total used quota this month
        $usedQuota = Transaction::where('customer_id', $customer->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('status', 'completed')
            ->sum('quantity_kg');

        // Calculate remaining quota
        $remainingQuota = max(0, $monthlyQuota - $usedQuota);

        // Get detailed quota per fertilizer type
        $fertilizerQuotas = Quota::with('fertilizer')
            ->where('customer_id', $customer->id)
            ->get()
            ->map(function ($quota) use ($currentMonth, $currentYear) {
                // Calculate used quota for this specific fertilizer this month
                $used = Transaction::where('customer_id', $quota->customer_id)
                    ->where('fertilizer_id', $quota->fertilizer_id)
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->where('status', 'completed')
                    ->sum('quantity_kg');

                return [
                    'fertilizer_name' => $quota->fertilizer->name,
                    'max_kg_per_month' => $quota->max_kg_per_month,
                    'used_kg_this_month' => $used,
                    'remaining_kg' => max(0, $quota->max_kg_per_month - $used),
                ];
            });

        return view('customer.quota.show', [
            'monthly_quota' => $monthlyQuota,
            'used_quota' => $usedQuota,
            'remaining_quota' => $remainingQuota,
            'fertilizer_quotas' => $fertilizerQuotas,
            'customer' => $customer,
        ]);
    }
}