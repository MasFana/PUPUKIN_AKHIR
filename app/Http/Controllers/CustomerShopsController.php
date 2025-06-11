<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner; 
class CustomerShopsController extends Controller
{
    public function index()
    {
        $shops = Owner::get();
        return view('customer.shops.index', compact('shops'));
    }
}
