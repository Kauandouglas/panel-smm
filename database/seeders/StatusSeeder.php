<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'id' => 1,
                'name' => 'Pendente',
            ],
            [
                'id' => 2,
                'name' => 'Em Processamento',
            ],
            [
                'id' => 3,
                'name' => 'Em Progresso',
            ],
            [
                'id' => 4,
                'name' => 'Concluído',
            ],
            [
                'id' => 5,
                'name' => 'Reembolsado Parcial'
            ],
            [
                'id' => 6,
                'name' => 'Reembolsado',
            ],
            [
                'id' => 7,
                'name' => 'Rejeitado',
            ],
        ]);
    }
}
