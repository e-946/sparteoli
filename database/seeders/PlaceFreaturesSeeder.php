<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PlaceFreaturesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('placefreatures')->insert([
            [
                'name' => 'Residencial',
            ],
        ]);
    }
}
