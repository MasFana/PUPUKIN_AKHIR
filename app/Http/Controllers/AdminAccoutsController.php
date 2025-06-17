<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
class AdminAccoutsController extends Controller
{
    // Show profile
    public function index()
    {
        $users = User::with(['owner', 'customer'])->whereNot('role', '=','admin')->paginate(10);
        return view('admin.accounts.index', compact('users'));
    }

    // Edit profile form
    public function edit($id)
    {
        $user = User::with(['owner', 'customer'])->findOrFail($id);

        if ($user->role === 'owner') {
            $owner = $user->owner;
            return view('admin.accounts.editOwner', compact('owner', 'user'));
        } elseif ($user->role === 'customer') {
            $customer = $user->customer;
            return view('admin.accounts.editCustomer', compact('customer', 'user'));
        }else {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Akun tidak ditemukan atau tidak valid');
        }
    }

    // Update profile
    public function update(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        // Common validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
            ],
            'current_password' => 'nullable|current_password',
            'new_password' => 'nullable|min:6|different:current_password',
        ];

        // Customer specific rules
        if ($user->role === 'customer') {
            $rules = array_merge($rules, [
                'nik' => [
                    'required',
                    'string',
                    'max:16',
                ],
                'farm_area' => 'required|numeric|min:0.1',
                'address' => 'required|string|max:255',
            ]);
        }

        // Owner specific rules
        if ($user->role === 'owner') {
            $rules = array_merge($rules, [
                'shop_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);
        }

        $request->validate($rules);

        // Update user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password if provided
        if ($request->new_password) {
            $userData['password'] = Hash::make($request->new_password);
        }

        $user->update($userData);

        // Update customer data
        if ($user->role === 'customer') {
            $user->customer->update([
                'nik' => $request->nik,
                'farm_area' => $request->farm_area,
                'address' => $request->address,
            ]);
        }

        // Update owner data
        if ($user->role === 'owner') {
            $user->owner->update([
                'shop_name' => $request->shop_name,
                'address' => $request->address,
                'lat' => $request->lat,
                'long' => $request->long,
            ]);
        }

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
    public function show($id)
    {
        $user = User::with([
            'owner' => function ($query) {
                $query->withCount('transactions')
                    ->with([
                        'transactions' => function ($query) {
                            $query->with(['fertilizer', 'customer.user'])->latest();
                        }
                    ]);
            },
            'customer' => function ($query) {
                $query->withCount('transactions')
                    ->with([
                        'transactions' => function ($query) {
                            $query->with(['fertilizer', 'owner'])->latest();
                        },
                        'quotas'
                    ]);
            }
        ])->findOrFail($id);

        $owner = $user->owner;
        $customer = $user->customer;

        return view('admin.accounts.show', compact('user', 'owner', 'customer'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil dihapus');
    }
}
