<?php

namespace App\Http\Controllers;

use App\Models\Fertilizer;
use App\Models\Owner;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $customerId = Auth::user()->customer->id;

        $transactions = Transaction::with(['fertilizer', 'owner'])
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('transactions'));
    }

    public function create()
    {
        // Get owners with available stock
        $owners = Owner::with([
            'stock' => function ($query) {
                $query->where('quantity_kg', '>', 0);
            }
        ])->get();

        // Get customer's remaining quota
        $customer = Auth::user()->customer;
        $remainingQuota = $this->calculateRemainingQuota($customer);

        return view('customer.orders.create', compact('owners', 'remainingQuota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'fertilizer_id' => 'required|exists:fertilizers,id',
            'quantity_kg' => 'required|numeric|min:1',
        ]);

        $customer = Auth::user()->customer;
        $fertilizer = Fertilizer::findOrFail($request->fertilizer_id);

        // Check if fertilizer belongs to selected owner
        $stock = Stock::where('owner_id', $request->owner_id)
            ->where('fertilizer_id', $request->fertilizer_id)
            ->first();

        if (!$stock || $stock->quantity_kg < $request->quantity_kg) {
            return back()->withErrors([
                'quantity_kg' => 'Stok tidak mencukupi untuk pesanan ini'
            ])->withInput();
        }

        // Check quota
        $remainingQuota = $this->calculateRemainingQuota($customer);
        if ($request->quantity_kg > $remainingQuota) {
            return back()->withErrors([
                'quantity_kg' => 'Jumlah melebihi kuota tersisa. Kuota tersisa: ' . $remainingQuota . ' kg'
            ])->withInput();
        }

        $totalPrice = $fertilizer->price_per_kg * $request->quantity_kg;

        // Create transaction
        $transaction = Transaction::create([
            'customer_id' => $customer->id,
            'owner_id' => $request->owner_id,
            'fertilizer_id' => $fertilizer->id,
            'quantity_kg' => $request->quantity_kg,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.orders.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    private function calculateRemainingQuota($customer)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $usedQuota = Transaction::where('customer_id', $customer->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('status', 'completed')
            ->sum('quantity_kg');

        return max(0, ($customer->farm_area * 10) - $usedQuota);
    }
}