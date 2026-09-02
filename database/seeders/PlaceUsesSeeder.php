<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PlaceUsesSeeder extends Seeder
{
    public function run(): void
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
