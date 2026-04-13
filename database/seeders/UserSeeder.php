<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users to ensure clean seeding
        DB::table('users')->truncate();

        // Create Admin User
        DB::table('users')->insert([
            'name' => 'Admin Marketplace',
            'email' => 'admin@marketplace.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Mahasiswa Users (5)
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'name' => 'Mahasiswa ' . $i,
                'email' => 'mahasiswa' . $i . '@kampus.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create Freelancer Users (3)
        for ($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                'name' => 'Freelancer ' . $i,
                'email' => 'freelancer' . $i . '@marketplace.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'freelancer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
