<?php

namespace Database\Seeders;

use DB;
use Hash;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
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
            ],
        ]);
    }
}
