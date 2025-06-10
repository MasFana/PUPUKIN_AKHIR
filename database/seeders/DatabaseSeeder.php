<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transaction;
use App\Models\StockRequest;
use App\Models\Stock;
use App\Models\Quota;
use App\Models\Owner;
use App\Models\Fertilizer;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing data
        User::truncate();
        Owner::truncate();
        Customer::truncate();
        Fertilizer::truncate();
        Stock::truncate();
        Quota::truncate();
        StockRequest::truncate();
        Transaction::truncate();

        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@masfana.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Owner User and Owner record at specified coordinates
        $ownerUser = User::create([
            'name' => 'Fertilizer Shop Owner',
            'email' => 'owner@masfana.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        $owner = Owner::create([
            'user_id' => $ownerUser->id,
            'shop_name' => 'MasFana Fertilizer Center',
            'address' => 'Jl. Raya Jember, Kec. Kalisat, Kab. Jember, Jawa Timur',
            'long' => 113.716944, // Converted from 113°43'01.0"E
            'lat' => -8.165833,   // Converted from 8°09'57.0"S
            'license_number' => 'LIC' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT),
        ]);

        // Create Customer Users
        $customer1 = User::create([
            'name' => 'John Farmer',
            'email' => 'john@farmer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $customer1Record = Customer::create([
            'user_id' => $customer1->id,
            'nik' => '3501234567890123',
            'farm_area' => 2.5,
            'address' => 'Jl. Mangga No. 12, Kec. Kalisat, Kab. Jember',
        ]);

        $customer2 = User::create([
            'name' => 'Jane Farmer',
            'email' => 'jane@farmer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $customer2Record = Customer::create([
            'user_id' => $customer2->id,
            'nik' => '3501987654321098',
            'farm_area' => 3.2,
            'address' => 'Jl. Jeruk No. 45, Kec. Kalisat, Kab. Jember',
        ]);

        // Create Fertilizers
        $urea = Fertilizer::create([
            'name' => 'Urea',
            'subsidized' => true,
            'price_per_kg' => 5000.00,
        ]);

        $npk = Fertilizer::create([
            'name' => 'NPK',
            'subsidized' => true,
            'price_per_kg' => 7000.00,
        ]);

        $za = Fertilizer::create([
            'name' => 'ZA',
            'subsidized' => false,
            'price_per_kg' => 8500.00,
        ]);

        // Create Stocks for the owner
        Stock::create([
            'owner_id' => $owner->id,
            'fertilizer_id' => $urea->id,
            'quantity_kg' => 1000,
        ]);

        Stock::create([
            'owner_id' => $owner->id,
            'fertilizer_id' => $npk->id,
            'quantity_kg' => 750,
        ]);

        Stock::create([
            'owner_id' => $owner->id,
            'fertilizer_id' => $za->id,
            'quantity_kg' => 500,
        ]);

        // Create Quotas for customers
        Quota::create([
            'customer_id' => $customer1Record->id,
            'fertilizer_id' => $urea->id,
            'max_kg_per_month' => 300,
            'remaining_kg' => 300,
        ]);

        Quota::create([
            'customer_id' => $customer1Record->id,
            'fertilizer_id' => $npk->id,
            'max_kg_per_month' => 200,
            'remaining_kg' => 200,
        ]);

        Quota::create([
            'customer_id' => $customer2Record->id,
            'fertilizer_id' => $urea->id,
            'max_kg_per_month' => 400,
            'remaining_kg' => 400,
        ]);

        // Create some requests
        StockRequest::create([
            'owner_id' => $owner->id,
            'fertilizer_id' => $urea->id,
            'quantity_kg' => 500,
            'status' => 'approved',
            'admin_notes' => 'Request approved for additional stock',
            'processed_at' => now(),
        ]);

        StockRequest::create([
            'owner_id' => $owner->id,
            'fertilizer_id' => $npk->id,
            'quantity_kg' => 300,
            'status' => 'pending',
            'admin_notes' => null,
            'processed_at' => null,
        ]);

        // Create some transactions
        Transaction::create([
            'customer_id' => $customer1Record->id,
            'owner_id' => $owner->id,
            'fertilizer_id' => $urea->id,
            'quantity_kg' => 50,
            'total_price' => 250000, // 50 * 5000
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        Transaction::create([
            'customer_id' => $customer2Record->id,
            'owner_id' => $owner->id,
            'fertilizer_id' => $npk->id,
            'quantity_kg' => 30,
            'total_price' => 210000, // 30 * 7000
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }
}