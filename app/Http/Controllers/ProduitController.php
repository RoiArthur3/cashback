<?php

namespace App\Http\Controllers;

use App\Models\Taille;
use App\Models\Magasin;
use App\Models\Produit;
use App\Models\Pointure;
use App\Models\Categorie;
use App\Models\TypeVente;
use App\Models\Fournisseur;
use App\Models\TypeMonture;
use Illuminate\Support\Str;
use App\Models\StatutProduit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Boutique;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $magasin = auth()->user()->boutique;

        $produits = Produit::with('categorie', 'blackFriday')
            ->where('boutique_id', $magasin->id)
            ->latest()
            ->get()
            ->map(function ($produit) {
                // Calculer le prix initial
                if ($produit->blackFriday && $produit->blackFriday->is_active) {
                    $produit->prix_initial = ($produit->prix / (1 - $produit->blackFriday->percentage / 100)) + ($produit->reductionprix ?? 0);
                } else {
                    $produit->prix_initial = $produit->prix + ($produit->reductionprix ?? 0);
                }

                return $produit;
            });

        return view('admin.produit.listeproduit', compact('produits'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $magasin = auth()->user()->boutique;

        $categories = Categorie::where('boutique_id',$magasin->id)->get();

        $tailles = Taille::all();

        $pointures = Pointure::all();

        $statutproduits = StatutProduit::all();

        return view('admin.produit.creerproduit',compact('categories','statutproduits','magasin','tailles','pointures'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $media = $request->file('file'); // Image principale
        $video = $request->file('video'); // Vidéo
        $additionalImages = $request->file('images'); // Images multiples

        $name = null;
        $videoName = null;
        $additionalImagesNames = [];

        $magasin_id = $request->input('boutique_id');
        $boutique = Boutique::findOrFail($magasin_id);
        $boutiqueName = $boutique->nommagasin;
        $boutiqueFolder = Str::slug($boutiqueName, '_');

        // 🔹 Gestion de l'image principale (Sans modification)
        if ($media) {
            $name = $media->hashName();
            $media->storeAs($boutiqueFolder . '/produit', $name, 'public');
        }

        // 🔹 Gestion des images multiples
        if ($additionalImages) {
            foreach ($additionalImages as $img) {
                $imgName = $img->hashName();
                $img->storeAs($boutiqueFolder . '/images', $imgName, 'public');
                $additionalImagesNames[] = $boutiqueFolder . '/images/' . $imgName;
            }
        }

        // 🔹 Gestion de la vidéo (Sans modification)
        if ($video) {
            $videoName = $video->hashName();
            $video->storeAs($boutiqueFolder . '/videos', $videoName, 'public');
        }

        $user_id = Auth::id();

        $produitData = $request->only([
            'nomproduit', 'description', 'prix', 'qty', 'image', 'user_id','categorie_id', 'type_vente_id',
            'statut', 'boutique_id', 'reductionprix','marque','couleur',
        ]);

        $produitData['user_id'] = $user_id;
        $produitData['image'] = $media ? $boutiqueFolder . '/produit/' . $name : null;
        $produitData['video'] = $video ? $boutiqueFolder . '/videos/' . $videoName : null;
        $produitData['images'] = !empty($additionalImagesNames) ? json_encode($additionalImagesNames) : null;

        // 🔹 Calcul du prix après réduction
        if ($request->filled('reductionprix')) {
            $reduction = (float)$request->input('reductionprix');
            $produitData['prix'] = max(0, $produitData['prix'] - $reduction);
        }

        $produitData['en_vedette'] = $request->boolean('en_vedette');
        $produitData['en_vedetteimg'] = $request->boolean('en_vedetteimg');

        if ($request->has('pointure_id')) {
            $produitData['pointure_id'] = json_encode($request->pointure_id);
        }

        if ($request->has('taille_id')) {
            $produitData['taille_id'] = json_encode($request->taille_id);
        }

        $produitData['slug'] = Str::slug($produitData['nomproduit'], '-');

        Produit::create($produitData);

        return redirect()->route('produit.index')->with('success', 'Produit créé avec succès avec essai virtuel et images multiples !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);

        $magasin = auth()->user()->boutique;

        $categories = Categorie::where('boutique_id',$magasin->id)->get();

        $tailles = Taille::all();

        $pointures = Pointure::all();

        $statutproduits = StatutProduit::all();

        return view('admin.produit.editerproduit',compact('produit','categories','magasin','statutproduits','tailles','pointures'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);
        $boutiqueName = $produit->boutique->nommagasin;
        $boutiqueFolder = Str::slug($boutiqueName, '_');

        $videoSelection = $request->input('videoSelection');

        // 🔥 Gestion de l'image principale (Sans modification)
        if ($request->hasFile('file')) {
            $media = $request->file('file');
            $name = $media->hashName();

            // Supprimer l'ancienne image si elle existe
            if ($produit->image) {
                Storage::disk('produit')->delete($produit->image);
            }

            $media->storeAs($boutiqueFolder . '/produit', $name, 'public');
            $produit->image = $boutiqueFolder . '/produit/' . $name;
        }

        // 🔥 Gestion des images multiples
        if ($request->hasFile('images')) {
            $additionalImages = $request->file('images');
            $additionalImagesNames = [];

            // Supprimer les anciennes images si elles existent
            if ($produit->images) {
                $oldImages = json_decode($produit->images, true);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('produit')->delete($oldImage);
                }
            }

            foreach ($additionalImages as $img) {
                $imgName = $img->hashName();
                $img->storeAs($boutiqueFolder . '/images', $imgName, 'public');
                $additionalImagesNames[] = $boutiqueFolder . '/images/' . $imgName;
            }

            $produit->images = json_encode($additionalImagesNames);
        }

        // 🔥 Gestion de la vidéo
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = $video->hashName();

            // Supprimer l'ancienne vidéo si elle existe
            if ($produit->video) {
                Storage::disk('videos')->delete($produit->video);
            }

            $video->storeAs($boutiqueFolder . '/videos', $videoName, 'videos');
            $produit->video = $boutiqueFolder . '/videos/' . $videoName;
        }

        // 🔥 Suppression de la vidéo si sélectionné
        if ($videoSelection === 'delete') {
            if ($produit->video) {
                Storage::disk('videos')->delete($produit->video);
                $produit->video = null;
            }
        }

        // 🔥 Mise à jour des autres champs du produit
        $produit->nomproduit = $request->nomproduit;
        $produit->slug = Str::slug($request->nomproduit, '-');
        $produit->description = $request->description;
        $produit->prix = $request->prix;
        $produit->reductionprix = $request->reductionprix;
        $produit->qty = $request->qty;
        $produit->categorie_id = $request->categorie_id;
        $produit->boutique_id = $request->boutique_id;
        $produit->statut = $request->statut;
        $produit->marque = $request->marque;
        $produit->couleur = $request->couleur;
        $produit->en_vedette = $request->boolean('en_vedette');
        $produit->en_vedetteimg = $request->boolean('en_vedetteimg');

        // 🔥 Mise à jour des tailles et pointures
        $produit->taille_id = $request->has('taille_id') ? json_encode($request->taille_id) : null;
        $produit->pointure_id = $request->has('pointure_id') ? json_encode($request->pointure_id) : null;

        // 🔥 Recalcul du prix après réduction
        if ($request->filled('reductionprix')) {
            $reduction = (float) $request->input('reductionprix');
            $produit->prix = max(0, $produit->prix - $reduction);
        }

        $produit->save();

        return to_route('produit.index')->with('success', 'Produit mis à jour avec succès avec suppression de l’arrière-plan et gestion des images multiples !');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();

        return to_route('produit.index')->with('danger','Produit supprimé avec success');
    }

}
