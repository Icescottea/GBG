<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeliveriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('deliveries')->insert([
            [
                'outlet_id' => 1,
                'scheduled_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'delivered_date' => null, // Pending delivery
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'outlet_id' => 2,
                'scheduled_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'delivered_date' => Carbon::now()->format('Y-m-d'), // Completed delivery
                'status' => 'completed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
