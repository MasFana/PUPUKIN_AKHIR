<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OwnerProfileController extends Controller
{
    // Show profile
    public function show()
    {
        $user = Auth::user();
        $owner = $user->owner;

        return view('owner.profile.show', compact('user', 'owner'));
    }

    // Edit profile form
    public function edit()
    {
        $user = Auth::user();
        $owner = $user->owner;

        return view('owner.profile.edit', compact('user', 'owner'));
    }

    // Update profile
    public function update(Request $request)
    {
        $user = Auth::user();
        $owner = $user->owner;

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
            'shop_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'long' => 'required|numeric',
            'lat' => 'required|numeric',
            // License number intentionally omitted from validation
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

        // Update owner data (excluding license_number)
        $owner->update([
            'shop_name' => $request->shop_name,
            'address' => $request->address,
            'long' => $request->long,
            'lat' => $request->lat,
        ]);

        return redirect()->route('owner.profile.show')
            ->with('success', 'Profile updated successfully');
    }
}