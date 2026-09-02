<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class RescuersSeeder extends Seeder
{
    public function run(): void
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
            ],
        ]);
    }
}
