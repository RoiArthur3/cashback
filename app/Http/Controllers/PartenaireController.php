<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Boutique;

class PartenaireController extends Controller
{
    // Tableau de bord partenaire
    public function index()
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();
        return view('partenaire.dashboard', compact('boutique'));
    }

    // Formulaire de création ou modification de la boutique
    public function edit()
    {
        $boutique = Boutique::firstOrNew(['user_id' => Auth::id()]);
        return view('partenaire.edit_boutique', compact('boutique'));
    }

    // Enregistrement des infos boutique
    public function update(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        $boutique = Boutique::updateOrCreate(
            ['user_id' => Auth::id()],
            $data + ['user_id' => Auth::id()]
        );
        return redirect()->route('partenaire.dashboard')->with('success', 'Boutique mise à jour !');
    }

    // Suppression de la boutique
    public function destroy()
    {
        $boutique = Boutique::where('user_id', Auth::id())->first();
        if ($boutique) $boutique->delete();
        return redirect()->route('partenaire.dashboard')->with('success', 'Boutique supprimée.');
    }

    // Liste des cashbacks de la boutique du partenaire
    public function cashbacks()
    {
        $boutique = \App\Models\Boutique::where('user_id', Auth::id())->first();
        $cashbacks = $boutique ? $boutique->cashbacks : collect();
        return view('partenaire.cashbacks', compact('cashbacks'));
    }

    // Formulaire d'ajout de cashback
    public function createCashback()
    {
        return view('partenaire.edit_cashback');
    }

    // Enregistrement d'un nouveau cashback
    public function storeCashback(Request $request)
    {
        $boutique = \App\Models\Boutique::where('user_id', Auth::id())->firstOrFail();
        $data = $request->validate([
            'taux' => 'required|numeric|min:0',
            'offre' => 'nullable|string',
        ]);
        $boutique->cashbacks()->create($data);
        return redirect()->route('partenaire.cashbacks')->with('success', 'Cashback ajouté !');
    }


    // Mise à jour d'un cashback
    public function updateCashback(Request $request, $id)
    {
        $cashback = \App\Models\Cashback::findOrFail($id);
        $data = $request->validate([
            'taux' => 'required|numeric|min:0',
            'offre' => 'nullable|string',
        ]);
        $cashback->update($data);
        return redirect()->route('partenaire.cashbacks')->with('success', 'Cashback modifié !');
    }

    // Suppression d'un cashback
    public function deleteCashback($id)
    {
        $cashback = \App\Models\Cashback::findOrFail($id);
        $cashback->delete();
        return redirect()->route('partenaire.cashbacks')->with('success', 'Cashback supprimé.');
    }


    // Formulaire d'ajout de produit
    public function createProduit()
    {
        return view('partenaire.edit_produit');
    }


    // Formulaire d'édition d'un produit
    public function editProduit($id)
    {
        $produit = \App\Models\Produit::findOrFail($id);
        return view('partenaire.edit_produit', compact('produit'));
    }

    // Mise à jour d'un produit
    public function updateProduit(Request $request, $id)
    {
        $produit = \App\Models\Produit::findOrFail($id);
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|string',
        ]);
        $produit->update($data);
        return redirect()->route('partenaire.produits')->with('success', 'Produit modifié !');
    }

    // Suppression d'un produit
    public function deleteProduit($id)
    {
        $produit = \App\Models\Produit::findOrFail($id);
        $produit->delete();
        return redirect()->route('partenaire.produits')->with('success', 'Produit supprimé.');
    }





    // Formulaire d'édition d'un cashback
    public function editCashback($id)
    {
        $cashback = \App\Models\Cashback::findOrFail($id);
        return view('partenaire.edit_cashback', compact('cashback'));
    }

}
