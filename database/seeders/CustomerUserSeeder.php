<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerUserSeeder extends Seeder
{
    /**
     * Create a default Customer user and assign the Customer role.
     */
    public function run(): void
    {
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name'     => 'Customer User',
                'password' => Hash::make('password'),
            ]
        );

        $customer->assignRole('Customer');
    }
}
