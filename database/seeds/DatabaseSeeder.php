<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            NaturesSeeder::class,
            TypesSeeder::class,
            FireProtectionsSeeder::class,
            MeanUsedsSeeder::class,
            PlaceFreaturesSeeder::class,
            PlaceUsesSeeder::class,
            ProblemsSeeder::class,
            RescuersSeeder::class,
            RescuersSeeder::class,
        ]);

    }
}
