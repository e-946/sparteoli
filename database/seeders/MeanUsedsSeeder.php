<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MeanUsedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
