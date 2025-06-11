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

        // Calculate the monthly quota based on farm area (10 kg per hectare)
        $monthlyQuota = $customer->farm_area * 10;

        // Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Calculate total used quota this month from completed transactions
        $usedQuota = Transaction::where('customer_id', $customer->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('status', 'completed')
            ->sum('quantity_kg');

        // Calculate remaining quota
        $remainingQuota = max(0, $monthlyQuota - $usedQuota);

        // Update or create quota record
        Quota::updateOrCreate(
            ['customer_id' => $customer->id],
            [
                'max_kg_per_month' => $monthlyQuota,
                'remaining_kg' => $remainingQuota
            ]
        );

        return view('customer.quota.show', [
            'monthly_quota' => $monthlyQuota,
            'used_quota' => $usedQuota,
            'remaining_quota' => $remainingQuota,
            'customer' => $customer,
        ]);
    }


}