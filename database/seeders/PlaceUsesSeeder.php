<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PlaceUsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('placeuses')->insert([
            [
                'name' => 'Particular',
            ],
            [
                'name' => 'Misto',
            ],
            [
                'name' => 'Público',
            ],
        ]);
    }
}
