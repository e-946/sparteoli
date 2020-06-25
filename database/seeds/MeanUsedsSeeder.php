<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        ]);
    }
}
