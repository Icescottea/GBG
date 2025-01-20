<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class GasRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        Schema::disableForeignKeyConstraints();

        // Clear the table to avoid duplicates
        DB::table('gas_requests')->truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Insert sample data into the gas_requests table
        DB::table('gas_requests')->insert([
            [
                'user_id' => 1,
                'outlet_id' => 1,
                'token_id' => 1, // Token ID referencing the tokens table
                'status' => 'pending',
                'requested_date' => Carbon::now()->format('Y-m-d'),
                'scheduled_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'outlet_id' => 2,
                'token_id' => 2,
                'status' => 'confirmed',
                'requested_date' => Carbon::now()->format('Y-m-d'),
                'scheduled_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
