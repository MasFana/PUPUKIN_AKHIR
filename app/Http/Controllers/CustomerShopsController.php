<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerShopsController extends Controller
{
    public function index()
    {
        return view('customer.shops.index', [
        ]);
    }
}
