<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

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
