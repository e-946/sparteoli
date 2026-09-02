<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

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
            ],
        ]);
    }
}
