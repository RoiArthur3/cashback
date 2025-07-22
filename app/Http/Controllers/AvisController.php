<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boutique;
use App\Models\Avis;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    public function store(Request $request, $boutiqueId)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|max:1000',
        ]);
        Avis::create([
            'user_id' => Auth::id(),
            'boutique_id' => $boutiqueId,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);
        return redirect()->back()->with('success', 'Merci pour votre avis !');
    }
}
