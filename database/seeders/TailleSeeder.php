<?php

namespace Database\Seeders;

use App\Models\Taille;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TailleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Taille::create([
            'libtaille' => 'XS',
        ]);

        Taille::create([
            'libtaille' => 'S',
        ]);

        Taille::create([
            'libtaille' => 'M',
        ]);

        Taille::create([
            'libtaille' => 'L',
        ]);

        Taille::create([
            'libtaille' => 'XL',
        ]);

        Taille::create([
            'libtaille' => 'XXL',
        ]);

        Taille::create([
            'libtaille' => 'XXXL',
        ]);
    }
}
