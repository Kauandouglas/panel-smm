<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            [
                'category_id' => 1,
                'api_id' => 1,
                'type_id' => 1,
                'api_service' => 354,
                'status' => 1,
                'name' => 'Seguidores Brasileiros',
                'description' => 'Seguidores Brasileiros',
                'price' => 0.56,
                'quantity_min' => 20,
                'quantity_max' => 50000,
                'refill' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
