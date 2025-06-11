<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
class CustomerShopsController extends Controller
{
    public function index()
    {
        $shops = Owner::with(['stock.fertilizer'])
            ->get();

        $shops = $shops->map(function ($shop) {
            return [
                'id' => $shop->id,
                'name' => $shop->shop_name,
                'address' => $shop->address,
                'lng' => $shop->long,
                'lat' => $shop->lat,
                'license_number' => $shop->license_number,
                'user_id' => $shop->user_id,
                'status' => 'Buka',
                'stock' => $shop->stock->map(function ($stock) {
                    return $stock->fertilizer->name . ' - ' . 
                           number_format($stock->quantity_kg, 0, ',', '.') . ' kg';
                })->implode(', '),
            ];
        });
        return view('customer.shops.index', compact('shops'));
    }
}
