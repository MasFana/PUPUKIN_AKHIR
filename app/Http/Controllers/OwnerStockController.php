<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerStockController extends Controller
{
    public function index()
    {
        return view('owner.stocks.inventory');
    }
}
