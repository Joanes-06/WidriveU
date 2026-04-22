<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@widriveu.com'],
            [
                'name'     => 'Admin WidriveU',
                'email'    => 'admin@widriveu.com',
                'password' => bcrypt('admin123'),
                'role'     => 'admin',
                'phone'    => '+229 00000000',
            ]
        );

        // Default settings
        $settings = [
            'price_with_driver_multiplier' => '1.5',
            'discount_7_days'              => '15',
            'discount_14_days'             => '18',
            'discount_21_days'             => '20',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        // Create test client
        User::updateOrCreate(
            ['email' => 'client@test.com'],
            [
                'name'     => 'Jean Dupont',
                'email'    => 'client@test.com',
                'password' => Hash::make('password'),
                'role'     => 'client',
                'phone'    => '+229 97 00 00 00',
                'address'  => 'Cotonou, Bénin',
            ]
        );

        $this->call([
            ZoneSeeder::class,
            VehicleSeeder::class,
        ]);
    }
}
