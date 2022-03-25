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
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Ut mattis sed dui quis tincidunt. Morbi ligula justo, luctus at nunc a, tincidunt ultrices nisi.
                    Duis ac tellus eleifend velit aliquam egestas. Donec ut rutrum tortor, in fermentum nisl.
                    Morbi et nisl sit amet justo viverra malesuada. Maecenas posuere bibendum tortor ac congue.
                    Aenean venenatis, dui sit amet molestie efficitur, sem dolor iaculis neque, a congue lacus metus eget purus.
                    Suspendisse ut consequat nulla. Duis metus erat, bibendum ac tincidunt ac, aliquet eu ipsum.
                    Aenean lobortis nunc et tellus condimentum, vel lacinia tortor blandit.
                    Ut vitae porttitor justo.',
            ],
            [
                'name' => 'Acidente com embarcações',
                'nature_id' => 4,
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Ut mattis sed dui quis tincidunt. Morbi ligula justo, luctus at nunc a, tincidunt ultrices nisi.
                    Duis ac tellus eleifend velit aliquam egestas. Donec ut rutrum tortor, in fermentum nisl.
                    Morbi et nisl sit amet justo viverra malesuada. Maecenas posuere bibendum tortor ac congue.
                    Aenean venenatis, dui sit amet molestie efficitur, sem dolor iaculis neque, a congue lacus metus eget purus.
                    Suspendisse ut consequat nulla. Duis metus erat, bibendum ac tincidunt ac, aliquet eu ipsum.
                    Aenean lobortis nunc et tellus condimentum, vel lacinia tortor blandit.
                    Ut vitae porttitor justo.',
            ],
            [
                'name' => 'Afogamento com ví­tima fatal',
                'nature_id' => 2,
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Ut mattis sed dui quis tincidunt. Morbi ligula justo, luctus at nunc a, tincidunt ultrices nisi.
                    Duis ac tellus eleifend velit aliquam egestas. Donec ut rutrum tortor, in fermentum nisl.
                    Morbi et nisl sit amet justo viverra malesuada. Maecenas posuere bibendum tortor ac congue.
                    Aenean venenatis, dui sit amet molestie efficitur, sem dolor iaculis neque, a congue lacus metus eget purus.
                    Suspendisse ut consequat nulla. Duis metus erat, bibendum ac tincidunt ac, aliquet eu ipsum.
                    Aenean lobortis nunc et tellus condimentum, vel lacinia tortor blandit.
                    Ut vitae porttitor justo.',
            ],
            [
                'name' => 'Acidente de veículo com vítima',
                'nature_id' => 4,
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Ut mattis sed dui quis tincidunt. Morbi ligula justo, luctus at nunc a, tincidunt ultrices nisi.
                    Duis ac tellus eleifend velit aliquam egestas. Donec ut rutrum tortor, in fermentum nisl.
                    Morbi et nisl sit amet justo viverra malesuada. Maecenas posuere bibendum tortor ac congue.
                    Aenean venenatis, dui sit amet molestie efficitur, sem dolor iaculis neque, a congue lacus metus eget purus.
                    Suspendisse ut consequat nulla. Duis metus erat, bibendum ac tincidunt ac, aliquet eu ipsum.
                    Aenean lobortis nunc et tellus condimentum, vel lacinia tortor blandit.
                    Ut vitae porttitor justo.',
            ],
        ]);
    }
}
