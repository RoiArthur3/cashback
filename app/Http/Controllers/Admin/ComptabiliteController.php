<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comptabilite;
use Illuminate\Http\Request;

class ComptabiliteController extends Controller
{
    public function index()
    {
        $mouvements = Comptabilite::with(['user', 'boutique', 'cashback'])
            ->orderByDesc('created_at')
            ->paginate(30);
        return view('admin.comptabilite.index', compact('mouvements'));
    }
}
