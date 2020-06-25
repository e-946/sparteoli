<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FireProtectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fireprotections')->insert([
            [
                'name' => 'Extintor de incêndio',
            ],
            [
                'name' => 'Sistema de hidrantes',
            ],
            [
                'name' => 'Sistema de alarme manual',
            ],
        ]);
    }
}
