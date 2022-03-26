<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ProblemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
