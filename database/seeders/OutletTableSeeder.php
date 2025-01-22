<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('outlet')->insert([
            [
                'name' => 'Main Outlet',
                'location' => '123 Main Street, Colombo',
                'phone' => '0111234567',
                'manager_name' => 'John Doe',
                'status' => 1, // Active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Secondary Outlet',
                'location' => '456 Secondary Road, Kandy',
                'phone' => '0817654321',
                'manager_name' => 'Jane Smith',
                'status' => 0, // Inactive
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
