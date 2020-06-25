<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('natures')->insert([
            [
                'name' => 'Incêndio',
            ],
            [
                'name' => 'Busca e salvamento',
            ],
            [
                'name' => 'Prestação de serviço',
            ],
            [
                'name' => 'Socorrismo',
            ],
            [
                'name' => 'Prevenção de acidentes',
            ],
        ]);
    }
}
