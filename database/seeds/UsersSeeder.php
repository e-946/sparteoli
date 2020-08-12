<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Daniel de Assis Ferreira',
                'register' => '0123456789',
                'password' => Hash::make('0123456789'),
                'admin' => true,
            ],
            [
                'name' => 'João Pinheiro Souza',
                'register' => '9876543210',
                'password' => Hash::make('9876543210'),
                'admin' => false,
            ]
        ]);
    }
}
