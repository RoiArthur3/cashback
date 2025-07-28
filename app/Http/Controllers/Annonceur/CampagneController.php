<?php

namespace App\Http\Controllers\Annonceur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campagne;
use App\Models\CampagneCiblage;
use App\Models\CampagneStat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CampagneController extends Controller
{
    // Affiche le dashboard des campagnes
    public function index()
    {
        $campagnes = Campagne::with('stats')->where('user_id', Auth::id())->get();
        return view('annonceur.campagnes.dashboard', compact('campagnes'));
    }

    // Formulaire de création
    public function create()
    {
        return view('annonceur.campagnes.create');
    }

    // Enregistrement d'une campagne
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp',
            'lien' => 'required|url',
            'texte_accroche' => 'nullable|string|max:255',
            'volume' => 'required|integer|min:1000',
        ]);
        $data['user_id'] = Auth::id();
        $data['budget'] = $this->calculerBudget($request);
        $data['cout_unitaire'] = $this->calculerCoutUnitaire($request);
        if ($request->hasFile('media')) {
            $data['media'] = $request->file('media')->store('campagnes', 'public');
        }
        $campagne = Campagne::create($data);
        // Enregistrer le ciblage
        if ($request->has('ciblage')) {
            foreach ($request->input('ciblage') as $critere => $valeur) {
                if ($valeur) {
                    CampagneCiblage::create([
                        'campagne_id' => $campagne->id,
                        'critere' => $critere,
                        'valeur' => $valeur,
                    ]);
                }
            }
        }
        // Créer stats initiales
        CampagneStat::create(['campagne_id' => $campagne->id]);
        return redirect()->route('annonceur.campagnes.index')->with('success', 'Campagne créée !');
    }

    // Affichage d'une campagne
    public function show(Campagne $campagne)
    {
        $this->authorize('view', $campagne);
        $campagne->load('ciblages', 'stats');
        return view('annonceur.campagnes.show', compact('campagne'));
    }

    // Formulaire d'édition
    public function edit(Campagne $campagne)
    {
        $this->authorize('update', $campagne);
        $campagne->load('ciblages');
        return view('annonceur.campagnes.edit', compact('campagne'));
    }

    // Mise à jour
    public function update(Request $request, Campagne $campagne)
    {
        $this->authorize('update', $campagne);
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp',
            'lien' => 'required|url',
            'texte_accroche' => 'nullable|string|max:255',
            'volume' => 'required|integer|min:1000',
        ]);
        $data['budget'] = $this->calculerBudget($request);
        $data['cout_unitaire'] = $this->calculerCoutUnitaire($request);
        if ($request->hasFile('media')) {
            $data['media'] = $request->file('media')->store('campagnes', 'public');
        }
        $campagne->update($data);
        // Mettre à jour le ciblage
        $campagne->ciblages()->delete();
        if ($request->has('ciblage')) {
            foreach ($request->input('ciblage') as $critere => $valeur) {
                if ($valeur) {
                    CampagneCiblage::create([
                        'campagne_id' => $campagne->id,
                        'critere' => $critere,
                        'valeur' => $valeur,
                    ]);
                }
            }
        }
        return redirect()->route('annonceur.campagnes.index')->with('success', 'Campagne modifiée !');
    }

    // Suppression
    public function destroy(Campagne $campagne)
    {
        $this->authorize('delete', $campagne);
        $campagne->delete();
        return back()->with('success', 'Campagne supprimée.');
    }

    // Calcul du coût unitaire selon le ciblage
    private function calculerCoutUnitaire(Request $request)
    {
        $base = 100; // 100 FCFA pour 1000 impressions
        $coeff = 1.0;
        $ciblage = $request->input('ciblage', []);
        $precis = 0;
        foreach ($ciblage as $critere => $valeur) {
            if ($valeur) $precis++;
        }
        if ($precis > 1) {
            $coeff += ($precis - 1) * 0.1; // +10% par critère précis au-delà du premier
        }
        return $base * $coeff;
    }

    // Calcul du budget total
    private function calculerBudget(Request $request)
    {
        $cout = $this->calculerCoutUnitaire($request);
        $volume = max(1000, (int)$request->input('volume', 1000));
        return ($cout * $volume) / 1000;
    }
}
