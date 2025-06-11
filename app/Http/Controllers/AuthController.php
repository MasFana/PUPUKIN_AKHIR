<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed, redirect based on role
            $user = auth()->user();

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully.');
            } else if ($user->role === 'owner') {
                return redirect()->route('owner.dashboard')->with('success', 'Logged in successfully.');
            } else if ($user->role === 'customer') {
                return redirect()->route('customer.dashboard')->with('success', 'Logged in successfully.');
            } else {
                return redirect('/')->with('success', 'Logged in successfully.');
            }
        }


        // If login fails, redirect back with an error message
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logged out successfully.');
    }

    public function showCustomerRegisterForm()
    {
        return view('auth.register-customer');
    }

    public function showOwnerRegisterForm()
    {
        return view('auth.register-owner');
    }

    public function register(Request $request)
    {
        if($request->role=='owner'){
            // Validate the request data
            $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'shop_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'long' => 'required|numeric',
            'lat' => 'required|numeric',
        ]);

        // Create the user
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'owner', 
        ]);

        // Create the shop profile
        $user->owner()->create([
            'user_id' => $user->id,
            'shop_name' => $request->shop_name,
            'address' => $request->address,
            'long' => $request->long,
            'lat' => $request->lat,
        ]);

    } else {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nik' => 'required|string|max:16|unique:customers,nik',
            'farm_area' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

        // Create the user
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer',
        ]);

        $user->customer()->create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'farm_area' => $request->farm_area,
            'address' => $request->address,
        ]);
    }

        return redirect('login')->with('success', 'Registration successful. You can now log in.');

    }

}
