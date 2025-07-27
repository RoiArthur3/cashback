<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Créer ou récupérer le rôle admin
        $adminRole = Role::firstOrCreate([
            'name' => 'admin'
        ], [
            'description' => 'Administrateur du système'
        ]);

        // Créer le compte administrateur
        $admin = User::firstOrCreate([
            'email' => 'admin@cashbackmarket.com'
        ], [
            'name' => 'Administrateur',
            'prenom' => 'Cashback Market',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Attacher le rôle admin
        if (!$admin->roles()->where('role_id', $adminRole->id)->exists()) {
            $admin->roles()->attach($adminRole->id);
        }

        $this->command->info('Compte administrateur créé avec succès !');
        $this->command->info('Email: admin@cashbackmarket.com');
        $this->command->info('Mot de passe: admin123');
    }
}
