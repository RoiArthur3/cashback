<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        $clientRole = Role::where('name', 'client')->first();
        if ($clientRole) {
            User::doesntHave('roles')->each(function($user) use ($clientRole) {
                $user->roles()->attach($clientRole->id);
            });
        }
    }
}
