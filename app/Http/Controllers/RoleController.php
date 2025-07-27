<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {
    public function index() {
        // Récupérer tous les rôles
        $roles = Role::all();
        return response()->json($roles);
    }

    public function store(Request $request) {
        // Valider la requête
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Créer un nouveau rôle
        $role = Role::create($request->all());
        return response()->json($role, 201);
    }
}
