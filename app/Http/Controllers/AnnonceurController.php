<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AnnonceurController extends Controller
{
    public function index()
    {
        return view('annonceur.dashboard');
    }
    // Gestion des campagnes
    public function create()
    {
        return view('annonceur.create_campaign');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|string',
            'cible' => 'nullable|string',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'budget' => 'nullable|numeric',
        ]);
        $validated['annonceur_id'] = Auth::id();
        $validated['statut'] = 'brouillon';
        \App\Models\Campagne::create($validated);
        return redirect()->route('annonceur.dashboard')->with('success', 'Campagne créée avec succès.');
    }

    public function edit($id)
    {
        $campagne = \App\Models\Campagne::findOrFail($id);
        return view('annonceur.edit_campaign', compact('campagne'));
    }

    public function update(Request $request, $id)
    {
        $campagne = \App\Models\Campagne::findOrFail($id);
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|string',
            'cible' => 'nullable|string',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'budget' => 'nullable|numeric',
            'statut' => 'required|string',
        ]);
        $campagne->update($validated);
        return redirect()->route('annonceur.dashboard')->with('success', 'Campagne modifiée avec succès.');
    }
}
