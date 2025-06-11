<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Owner;
use App\Models\Customer;
use App\Models\Fertilizer;
use App\Models\Stock;
use App\Models\StockRequest;
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
        StockRequest::truncate();
        Quota::truncate();
        Transaction::truncate();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pupukin.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create fertilizer types
        $fertilizers = [
            ['name' => 'Urea', 'subsidized' => true, 'price_per_kg' => 1800],
            ['name' => 'NPK', 'subsidized' => true, 'price_per_kg' => 2200],
            ['name' => 'ZA', 'subsidized' => true, 'price_per_kg' => 1600],
            ['name' => 'SP-36', 'subsidized' => true, 'price_per_kg' => 2000],
            ['name' => 'Organik', 'subsidized' => false, 'price_per_kg' => 3500],
        ];

        foreach ($fertilizers as $fertilizer) {
            Fertilizer::create($fertilizer);
        }

        // Base coordinates (Jember area)
        $baseLat = -8.165000;
        $baseLng = 113.715811;

        // Create 10 owners with shops near the base coordinates
        for ($i = 1; $i <= 10; $i++) {
            // Generate random offset within 20km (most within 5km)
            $maxDistance = $i <= 7 ? 5 : 20; // 7 shops within 5km, 3 up to 20km
            $distance = rand(1, $maxDistance) / 100; // Convert to degrees (~111km per degree)
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

            // Create stock for each owner
            foreach (Fertilizer::all() as $fertilizer) {
                // 80% chance to have this fertilizer in stock
                if (rand(1, 100) <= 80) {
                    Stock::create([
                        'owner_id' => $owner->id,
                        'fertilizer_id' => $fertilizer->id,
                        'quantity_kg' => rand(100, 5000),
                    ]);
                }
            }

            // Create some stock requests (50% chance)
            if (rand(0, 1)) {
                StockRequest::create([
                    'owner_id' => $owner->id,
                    'fertilizer_id' => Fertilizer::inRandomOrder()->first()->id,
                    'quantity_kg' => rand(1000, 5000),
                    'status' => ['pending', 'approved', 'rejected'][rand(0, 2)],
                    'admin_notes' => rand(0, 1) ? 'Permintaan pupuk untuk stok musim tanam' : null,
                    'processed_at' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                ]);
            }
        }

        // Create 20 customers
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => 'Petani ' . $i,
                'email' => 'customer' . $i . '@pupukin.test',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'nik' => '35' . str_pad($i, 14, '0', STR_PAD_LEFT),
                'farm_area' => rand(1, 50) / 10, // 0.1 to 5.0 hectares
                'address' => $this->getCustomerAddress($i),
            ]);

            // Create quota for customer
            Quota::create([
                'customer_id' => $customer->id,
                'fertilizer_id' => Fertilizer::where('subsidized', true)->inRandomOrder()->first()->id,
                'max_kg_per_month' => $customer->farm_area * 10, // 10kg per hectare
                'remaining_kg' => $customer->farm_area * rand(5, 10), // Random remaining
            ]);

            // Create some transactions (70% chance)
            if (rand(1, 100) <= 70) {
                $fertilizer = Fertilizer::inRandomOrder()->first();
                $quantity = rand(5, 100);

                Transaction::create([
                    'customer_id' => $customer->id,
                    'owner_id' => Owner::inRandomOrder()->first()->id,
                    'fertilizer_id' => $fertilizer->id,
                    'quantity_kg' => $quantity,
                    'total_price' => $quantity * $fertilizer->price_per_kg,
                    'status' => ['pending', 'completed', 'cancelled'][rand(0, 2)],
                    'completed_at' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                ]);
            }
        }
    }

    private function getShopName($index)
    {
        $names = [
            'Maju',
            'Sejahtera',
            'Subur',
            'Makmur',
            'Tani',
            'Hijau',
            'Lestari',
            'Panen',
            'Berkah',
            'Agro'
        ];
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

    private function getCustomerAddress($index)
    {
        $villages = [
            'Mangli',
            'Kaliwates',
            'Sumbersari',
            'Patrang',
            'Karangrejo',
            'Arjasa',
            'Pakusari',
            'Jenggawah',
            'Ambulu',
            'Tempurejo',
            'Tanggul',
            'Bangsalsari',
            'Panti',
            'Sukorambi',
            'Rambipuji'
        ];
        return 'Dusun ' . chr(65 + ($index % 5)) . ', Desa ' . $villages[$index % count($villages)] . ', Jember';
    }
}