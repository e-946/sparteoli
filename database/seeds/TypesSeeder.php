<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'name' => 'Abastecimento de água',
                'nature_id' => 3,
            ],
            [
                'name' => 'Acidente com embarcações',
                'nature_id' => 4,
            ],
            [
                'name' => 'Afogamento com ví­tima fatal',
                'nature_id' => 2,
            ],
            [
                'name' => 'Acidente de veículo com vítima',
                'nature_id' => 4,
            ],
        ]);
    }
}
