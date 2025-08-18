<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if(auth()->user()->role_id == 1){
            $users = User::with('boutique')
            ->get();
        }elseif(auth()->user()->role_id ==3){
            $users = User::with('succursales')
            ->where('role_id', '!=', 1)
            ->where('magasin_id', $user->magasin_id)
            ->get();
        }

        return view('admin.user.listeuser', compact('users'));
    }
}
