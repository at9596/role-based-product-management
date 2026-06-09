<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::firstOrCreate(
        ['email' => 'manager@example.com'],
        [
            'name' => 'Manager User',
            'password' => Hash::make('password'),
        ]
     ); 

      $manager->assignRole('Manager');
    }
}
