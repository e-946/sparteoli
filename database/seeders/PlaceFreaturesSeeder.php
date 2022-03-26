<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PlaceFreaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('placefreatures')->insert([
            [
                'name' => 'Residencial',
            ],
        ]);
    }
}
