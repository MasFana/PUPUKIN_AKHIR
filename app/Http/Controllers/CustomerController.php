<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Return the customer dashboard view
        return view('customer.dashboard');
    }

    

}
