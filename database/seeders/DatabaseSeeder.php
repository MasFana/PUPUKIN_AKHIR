<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Owner;
use App\Models\Customer;
use App\Models\Fertilizer;
use App\Models\Stock;
use App\Models\Quota;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        User::truncate();
        Owner::truncate();
        Customer::truncate();
        Fertilizer::truncate();
        Stock::truncate();
        Quota::truncate();
        Transaction::truncate();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pupukin.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create fertilizers
        $fertilizers = [
            ['name' => 'Urea', 'subsidized' => true, 'price_per_kg' => 1800],
            ['name' => 'NPK', 'subsidized' => true, 'price_per_kg' => 2200],
            ['name' => 'ZA', 'subsidized' => true, 'price_per_kg' => 1600],
            ['name' => 'Organik', 'subsidized' => false, 'price_per_kg' => 3500],
        ];

        foreach ($fertilizers as $fertilizer) {
            Fertilizer::create($fertilizer);
        }

        // Base coordinates (Jember area)
        $baseLat = -8.165000;
        $baseLng = 113.715811;

        // Create 10 owners with shops near the base coordinates
        $owners = [];
        for ($i = 1; $i <= 10; $i++) {
            // Generate random offset within 5km
            $distance = rand(1, 5) / 100; // Convert to degrees (~111km per degree)
            $angle = deg2rad(rand(0, 359));

            // Calculate new coordinates
            $newLat = $baseLat + ($distance * cos($angle));
            $newLng = $baseLng + ($distance * sin($angle));

            $user = User::create([
                'name' => 'Pemilik Toko ' . $i,
                'email' => 'owner' . $i . '@pupukin.test',
                'password' => Hash::make('password'),
                'role' => 'owner',
            ]);

            $owner = Owner::create([
                'user_id' => $user->id,
                'shop_name' => 'Toko Pupuk ' . $this->getShopName($i),
                'address' => $this->getShopAddress($i),
                'long' => $newLng,
                'lat' => $newLat,
                'license_number' => 'LIC' . str_pad($i, 5, '0', STR_PAD_LEFT),
            ]);

            $owners[] = $owner;

            // Create stock for each owner (all fertilizer types)
            foreach (Fertilizer::all() as $fertilizer) {
                Stock::create([
                    'owner_id' => $owner->id,
                    'fertilizer_id' => $fertilizer->id,
                    'quantity_kg' => rand(1000, 5000),
                ]);
            }
        }

        // Create one test customer
        $customerUser = User::create([
            'name' => 'Test Customer',
            'email' => 'customer@pupukin.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $customer = Customer::create([
            'user_id' => $customerUser->id,
            'nik' => '3512345678901234',
            'farm_area' => 5, // 2.5 hectares
            'address' => 'Dusun A, Desa Mangli, Jember',
        ]);

        // Get Urea fertilizer (subsidized)
        $urea = Fertilizer::where('name', 'Urea')->first();

        // Create quota (max 25kg for 2.5 hectares)
        Quota::create([
            'customer_id' => $customer->id,
            'fertilizer_id' => $urea->id,
            'max_kg_per_month' => 50,
            'remaining_kg' => 10 // Will be updated below
        ]);

        // Select one specific owner (first owner) for transactions
        $transactionOwner = $owners[0];

        // Create current month transactions with the selected owner
        $this->createTransaction($customer, $transactionOwner, $urea, 5, 'completed', now());
        $this->createTransaction($customer, $transactionOwner, $urea, 7, 'completed', now()->subDays(3));
        $this->createTransaction($customer, $transactionOwner, $urea, 3, 'completed', now()->subDays(7));

        // Also add a pending transaction (shouldn't affect quota)
        $this->createTransaction($customer, $transactionOwner, $urea, 5, 'pending', now()->subDays(1));

        // Add a transaction for NPK (not affecting Urea quota)
        $npk = Fertilizer::where('name', 'NPK')->first();
        $this->createTransaction($customer, $transactionOwner, $npk, 10, 'completed', now()->subDays(2));

        // Update the remaining quota based on actual completed transactions
        $this->updateRemainingQuota($customer, $urea);
    }

    private function createTransaction($customer, $owner, $fertilizer, $quantity, $status, $date)
    {
        return Transaction::create([
            'customer_id' => $customer->id,
            'owner_id' => $owner->id,
            'fertilizer_id' => $fertilizer->id,
            'quantity_kg' => $quantity,
            'total_price' => $quantity * $fertilizer->price_per_kg,
            'status' => $status,
            'completed_at' => $status === 'completed' ? $date : null,
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }

    private function updateRemainingQuota($customer, $fertilizer)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $usedQuota = Transaction::where('customer_id', $customer->id)
            ->where('fertilizer_id', $fertilizer->id)
            ->where('status', 'completed')
            ->whereMonth('completed_at', $currentMonth)
            ->whereYear('completed_at', $currentYear)
            ->sum('quantity_kg');

        $quota = Quota::where('customer_id', $customer->id)
            ->where('fertilizer_id', $fertilizer->id)
            ->first();

        if ($quota) {
            $quota->remaining_kg = max(0, $quota->max_kg_per_month - $usedQuota);
            $quota->save();
        }
    }

    private function getShopName($index)
    {
        $names = ['Maju', 'Sejahtera', 'Subur', 'Makmur', 'Tani', 'Hijau', 'Lestari', 'Panen', 'Berkah', 'Agro'];
        return $names[$index - 1] ?? 'Pupuk ' . $index;
    }

    private function getShopAddress($index)
    {
        $streets = [
            'Jl. Raya Jember',
            'Jl. Kalimantan',
            'Jl. Jawa',
            'Jl. Sumatra',
            'Jl. Gajah Mada',
            'Jl. Sudirman',
            'Jl. Merdeka',
            'Jl. Diponegoro',
            'Jl. Hayam Wuruk',
            'Jl. Pattimura'
        ];
        return $streets[$index - 1] . ' No. ' . $index . ', Jember';
    }
}