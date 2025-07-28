<?php

namespace App\Http\Controllers;

use App\Models\ListeMariage;
use App\Models\Cagnotte;
use App\Models\CagnotteContribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CagnotteController extends Controller
{
    // Afficher la cagnotte d'une liste de mariage
    public function show($listeId)
    {
        $liste = ListeMariage::findOrFail($listeId);
        $cagnotte = $liste->cagnotte;
        $contributions = $cagnotte ? $cagnotte->contributions()->latest()->get() : collect();
        return view('liste_mariage.cagnotte', compact('liste', 'cagnotte', 'contributions'));
    }

    // Contribuer à la cagnotte
    public function contribute(Request $request, $listeId)
    {
        $liste = ListeMariage::findOrFail($listeId);
        $cagnotte = $liste->cagnotte ?? Cagnotte::create(['liste_mariage_id' => $liste->id]);
        $data = $request->validate([
            'montant' => 'required|numeric|min:1',
            'nom_contributeur' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:255',
        ]);
        $data['user_id'] = Auth::id();
        $data['cagnotte_id'] = $cagnotte->id;
        CagnotteContribution::create($data);
        $cagnotte->montant_total += $data['montant'];
        $cagnotte->save();
        return redirect()->back()->with('success', 'Merci pour votre contribution !');
    }
}
