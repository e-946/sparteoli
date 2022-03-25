<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RescuersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rescuers')->insert([
            [
                'name' => 'Bombeiro militar',
            ],
            [
                'name' => 'Samu',
            ],
            [
                'name' => 'Popular',
            ],
            [
                'name' => 'Brigadista',
            ]
        ]);
    }
}
