<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Car;
use App\Models\CarType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create branches
        $branches = [
            ['name' => 'Shah Alam Branch', 'address' => 'No. 123, Jalan Persiaran Kayangan, 40000 Shah Alam', 'phone' => '03-5512345'],
            ['name' => 'Gombak Branch', 'address' => 'No. 45, Jalan Gombak, 53100 Gombak', 'phone' => '03-6123456'],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }

        // Create car types
        $carTypes = [
            ['name' => 'SUV', 'description' => 'Sport Utility Vehicle'],
            ['name' => 'Sedan', 'description' => 'Four-door sedan'],
            ['name' => 'Hatchback', 'description' => 'Compact hatchback'],
        ];

        foreach ($carTypes as $type) {
            CarType::create($type);
        }

        // Create cars
        $cars = [
            [
                'brand' => 'Honda',
                'model' => 'CR-V',
                'plate_number' => 'WXY 1234',
                'transmission' => 'Auto',
                'car_type_id' => 1, // SUV
                'branch_id' => 1, // Shah Alam
                'daily_rate' => 250.00,
                'is_available' => true,
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'plate_number' => 'ABC 5678',
                'transmission' => 'Auto',
                'car_type_id' => 2, // Sedan
                'branch_id' => 1, // Shah Alam
                'daily_rate' => 200.00,
                'is_available' => true,
            ],
            [
                'brand' => 'Honda',
                'model' => 'City',
                'plate_number' => 'DEF 9012',
                'transmission' => 'Auto',
                'car_type_id' => 2, // Sedan
                'branch_id' => 2, // Gombak
                'daily_rate' => 180.00,
                'is_available' => true,
            ],
            [
                'brand' => 'Perodua',
                'model' => 'Myvi',
                'plate_number' => 'GHI 3456',
                'transmission' => 'Auto',
                'car_type_id' => 3, // Hatchback
                'branch_id' => 2, // Gombak
                'daily_rate' => 120.00,
                'is_available' => true,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
