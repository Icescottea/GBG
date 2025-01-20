<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TokenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tokens')->truncate(); // Clear the table before seeding

        DB::table('tokens')->insert([
            [
                'token_code' => Str::uuid(),
                'user_id' => 1,
                'status' => 'active',
                'expires_at' => now()->addDays(7),
                'created_at' => now(),
            ],
            [
                'token_code' => Str::uuid(),
                'user_id' => 2,
                'status' => 'expired',
                'expires_at' => now()->subDays(1),
                'created_at' => now(),
            ],
        ]);
    }
}
