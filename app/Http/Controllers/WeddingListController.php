<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeddingListController extends Controller
{
    // Affiche la liste des listes de mariage de l'utilisateur
    public function index()
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect('http://cbm.test/login');
        }
        $lists = \Illuminate\Support\Facades\Auth::user()->weddingLists ?? collect();
        return view('account.wedding-lists.index', compact('lists'));
    }
}
