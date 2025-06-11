<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerProfileController extends Controller
{
    // Show profile
    public function show()
    {
        $user = Auth::user();
        $customer = $user->customer;

        return view('customer.profile.show', compact('user', 'customer'));
    }

    // Edit profile form
    public function edit()
    {
        $user = Auth::user();
        $customer = $user->customer;

        return view('customer.profile.edit', compact('user', 'customer'));
    }

    // Update profile
    public function update(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer;

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => 'nullable|current_password',
            'new_password' => 'nullable|min:6|different:current_password',
            'nik' => [
                'required',
                'string',
                'max:16',
                Rule::unique('customers')->ignore($customer->id),
            ],
            'farm_area' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update password if provided
        if ($request->new_password) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        // Update customer data
        $customer->update([
            'nik' => $request->nik,
            'farm_area' => $request->farm_area,
            'address' => $request->address,
        ]);

        return redirect()->route('customer.profile.show')
            ->with('success', 'Profil berhasil diperbarui');
    }
}