<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RescuersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rescuers')->insert([
            [
                'name' => 'Bombeiro militar',
            ],
            [
                'name' => 'Samu',
            ],
            [
                'name' => 'Popular',
            ],
            [
                'name' => 'Brigadista',
            ]
        ]);
    }
}
