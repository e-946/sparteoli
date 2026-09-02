<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ProblemsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('problems')->insert([
            [
                'name' => 'Cardíaco',
            ],
            [
                'name' => 'Caso clínico',
            ],
            [
                'name' => 'Choque',
            ],
            [
                'name' => 'Coma',
            ],
            [
                'name' => 'Convulsão',
            ],
        ]);
    }
}
