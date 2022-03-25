<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
