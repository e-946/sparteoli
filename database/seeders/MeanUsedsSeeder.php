<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

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
