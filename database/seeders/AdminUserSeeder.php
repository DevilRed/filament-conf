<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Filament Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('123456'),
            'is_filament_admin' => true
            // Add any other necessary fields, e.g., 'is_filament_admin' => true
        ]);
    }
}
