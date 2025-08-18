<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Models\Boutique;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $magasin = auth()->user()->boutique;

        $categories = Categorie::where('boutique_id', $magasin->id)->get();

        return view('admin.categorie.listecategorie',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $magasin = auth()->user()->boutique;

        return view('admin.categorie.creercategorie',compact('magasin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $media = $request->file('file');
        $name = null;

        $magasin_id = $request->input('boutique_id');

        $boutique = Boutique::findOrFail($magasin_id);

        $boutiqueName = $boutique->nommagasin;

        $boutiqueFolder = Str::slug($boutiqueName, '_');

        if ($media) {
            $name = $media->hashName();
            $media->storeAs($boutiqueFolder . '/categorie', $name, 'public');
        }

        $user_id = Auth::id();

        $categorieData = $request->only(['nomcategorie','boutique_id']);
        $categorieData['user_id'] = $user_id;
        $categorieData['image'] = $media ? $boutiqueFolder . '/categorie/' . $name : null;

        // Générer le slug à partir du nom du magasin
        $categorieData['slug'] = Str::slug($categorieData['nomcategorie'], '-');

        Categorie::create($categorieData);

        return redirect()->route('categorie.index')->with('success','Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $magasin = auth()->user()->boutique;

        $categorie = Categorie::findOrFail($id);

        return view('admin.categorie.editercategorie',compact('categorie','magasin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $boutiqueName = $categorie->boutique->nommagasin;

        $boutiqueFolder = Str::slug($boutiqueName, '_');

        if ($request->hasFile('file')) {
            $media = $request->file('file');
            $name = $media->hashName();
            $media->storeAs($boutiqueFolder . '/categorie', $name, 'public');

            // Supprimer l'ancienne image de profil si elle existe
            if ($categorie->image) {
                Storage::disk('categorie')->delete($categorie->image);
            }

            // Mettre à jour les informations du fichier
            $categorie->image = $boutiqueFolder . '/categorie/' . $name;
        }

        // Mettre à jour les autres champs de l'école
        $categorie->nomcategorie = $request->nomcategorie;
        $categorie->slug = Str::slug($request->nomcategorie, '-'); // Génère le slug basé sur le nom de la boutique
        $categorie->boutique_id = $request->boutique_id;

        $categorie->save();

        return to_route('categorie.index')->with('warning','Category has been successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();

        return to_route('categorie.index')->with('danger','Category deleted successfully');
    }
}
