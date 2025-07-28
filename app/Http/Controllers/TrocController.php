<?php

namespace App\Http\Controllers;

use App\Models\Troc;
use App\Models\TrocOffre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrocController extends Controller
{
    // Liste des trocs
    public function index()
    {
        $trocs = Troc::with('user')->latest()->paginate(12);
        return view('trocs.index', compact('trocs'));
    }

    // Formulaire de création
    public function create()
    {
        return view('trocs.create');
    }

    // Enregistrement d'un troc
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        $data['user_id'] = Auth::id();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trocs', 'public');
        }
        $troc = Troc::create($data);
        return redirect()->route('trocs.show', $troc)->with('success', 'Troc créé !');
    }

    // Affichage d'un troc
    public function show(Troc $troc)
    {
        $troc->load('user', 'offres.user');
        return view('trocs.show', compact('troc'));
    }

    // Formulaire d'édition
    public function edit(Troc $troc)
    {
        $this->authorize('update', $troc);
        return view('trocs.edit', compact('troc'));
    }

    // Mise à jour
    public function update(Request $request, Troc $troc)
    {
        $this->authorize('update', $troc);
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trocs', 'public');
        }
        $troc->update($data);
        return redirect()->route('trocs.show', $troc)->with('success', 'Troc modifié !');
    }

    // Suppression
    public function destroy(Troc $troc)
    {
        $this->authorize('delete', $troc);
        $troc->delete();
        return redirect()->route('trocs.index')->with('success', 'Troc supprimé.');
    }

    // Proposer une offre
    public function proposerOffre(Request $request, Troc $troc)
    {
        $request->validate([
            'description_offre' => 'required|string|max:1000',
        ]);
        // Un utilisateur ne peut pas proposer plusieurs fois la même offre
        $existe = $troc->offres()->where('user_id', Auth::id())->where('description_offre', $request->description_offre)->exists();
        if ($existe) {
            return back()->withErrors(['description_offre' => 'Vous avez déjà proposé cette offre.']);
        }
        $troc->offres()->create([
            'user_id' => Auth::id(),
            'description_offre' => $request->description_offre,
        ]);
        return back()->with('success', 'Offre envoyée !');
    }

    // Accepter une offre
    public function accepterOffre(Troc $troc, TrocOffre $offre)
    {
        $this->authorize('update', $troc);
        $offre->update(['statut' => 'accepte']);
        $troc->update(['statut' => 'termine']);
        // Refuser les autres offres
        $troc->offres()->where('id', '!=', $offre->id)->update(['statut' => 'refuse']);
        return back()->with('success', 'Offre acceptée, troc terminé.');
    }

    // Refuser une offre
    public function refuserOffre(Troc $troc, TrocOffre $offre)
    {
        $this->authorize('update', $troc);
        $offre->update(['statut' => 'refuse']);
        return back()->with('success', 'Offre refusée.');
    }
}
