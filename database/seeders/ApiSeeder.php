<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('apis')->insert([
            'id' => 1,
            'name' => 'Provedor Brasil',
            'url' => 'https://provedorbrasil.com/api/v2',
            'token' => 'e3be0b4e2adabb39255c33cd14e8f0f2',
            'coin' => 'BRL',
            'balance' => '0.00',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
