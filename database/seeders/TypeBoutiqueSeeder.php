<?php

namespace Database\Seeders;

use App\Models\TypeBoutique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeBoutiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeBoutique::create([
            'libtypeboutique' => 'Mode & vêtements',
        ]);

        TypeBoutique::create([
            'libtypeboutique' => 'Télephone & accessoires',
        ]);

        TypeBoutique::create([
            'libtypeboutique' => 'Beauté & cosmétique',
        ]);

        TypeBoutique::create([
            'libtypeboutique' => 'Restaurant & fast-food',
        ]);

        TypeBoutique::create([
            'libtypeboutique' => 'Meubles & décoration',
        ]);

         TypeBoutique::create([
            'libtypeboutique' => 'High-tech',
        ]);
    }
}
