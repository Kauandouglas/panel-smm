<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'id' => 1,
                'name' => 'Seguidores',
            ],
            [
                'id' => 2,
                'name' => 'Curtidas',
            ],
            [
                'id' => 3,
                'name' => 'Comentarios',
            ],
            [
                'id' => 4,
                'name' => 'Visualizações',
            ],
        ]);
    }
}
