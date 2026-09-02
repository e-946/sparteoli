<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MeanUsedsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('meanuseds')->insert([
            [
                'name' => 'Linha Direta',
            ],
            [
                'name' => 'CICOM',
            ],
        ]);
    }
}
