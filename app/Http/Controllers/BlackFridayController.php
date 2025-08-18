<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Produit;
use App\Models\BlackFriday;
use App\Models\Boutique;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlackFridayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Récupérer le magasin de l'administrateur
        $magasin = Auth::user()->boutique;

        if (!$magasin) {
            return redirect()->route('dashboard.commercant')->withErrors('Vous n\'avez pas de magasin associé.');
        }

        // Récupérer les configurations Black Friday pour le magasin
        $blackFridays = BlackFriday::where('boutique_id', $magasin->id)->get();

        return view('admin.blackfriday.index', compact('magasin', 'blackFridays'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $magasin = auth()->user()->boutique;

        $blackFriday = BlackFriday::where('boutique_id', $magasin->id)->first();

        return view('admin.blackfriday.create',compact('magasin','blackFriday'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $media = $request->file('file');

        $name = null;

        $magasin_id = $request->input('boutique_id');
        $boutique = Boutique::findOrFail($magasin_id);
        $boutiqueName = $boutique->nommagasin;
        $boutiqueFolder = Str::slug($boutiqueName, '_');

        if ($media) {
            $name = $media->hashName();
            $media->storeAs($boutiqueFolder . '/blackFriday', $name, 'blackFriday');
        }

        $magasin_id = $request->input('boutique_id');

        if (!$magasin_id) {
            return redirect()->route('black_friday.index')->withErrors('Vous n\'avez pas de magasin associé.');
        }

        BlackFriday::create([
            'boutique_id' => $magasin_id,
            'percentage' => $request->percentage,
            'is_active' => false,
            'image' => $name ? ($boutiqueFolder . '/blackFriday/' . $name) : null,
            'description' => $request->description
        ]);

        return redirect()->route('black_friday.index')->with('success', 'Nouveau Black Friday ajouté.');
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'black_friday_id' => 'required|exists:black_fridays,id',
            'is_active' => 'required|boolean',
        ]);

        $blackFriday = BlackFriday::findOrFail($request->black_friday_id);
        $magasin = Auth::user()->boutique;

        // Vérifier que le Black Friday appartient bien au magasin
        if ($blackFriday->boutique_id !== $magasin->id) {
            return redirect()->route('black_friday.index')->withErrors('Action non autorisée.');
        }

        // Récupérer les produits associés au magasin
        $produits = Produit::where('boutique_id', $magasin->id)->get();

        // Si on active ce coupon
        if ($request->is_active) {
            // Désactiver les autres coupons actifs
            $autresCoupons = BlackFriday::where('boutique_id', $magasin->id)
                ->where('is_active', true)
                ->where('id', '!=', $blackFriday->id)
                ->get();

            foreach ($autresCoupons as $autreCoupon) {
                // Supprimer les réductions des anciens coupons des produits
                foreach ($produits as $produit) {
                    $produit->removeBlackFriday($autreCoupon->percentage);
                }

                // Désactiver le coupon
                $autreCoupon->is_active = false;
                $autreCoupon->save();
            }

            // Appliquer la réduction du nouveau coupon
            foreach ($produits as $produit) {
                $produit->applyBlackFriday($blackFriday->percentage);
            }
        } else {
            // Si on désactive le coupon actuel
            foreach ($produits as $produit) {
                $produit->removeBlackFriday($blackFriday->percentage);
            }
        }

        // Mettre à jour l'état du coupon actuel
        $blackFriday->is_active = $request->is_active;
        $blackFriday->save();

        $message = $request->is_active ? 'Coupon activé avec succès.' : 'Coupon désactivé avec succès.';

        return redirect()->route('black_friday.index')->with('success', $message);
    }




    /**
     * Display the specified resource.
     */
    public function show(BlackFriday $blackFriday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blackFriday = BlackFriday::findOrFail($id);

        $magasin = auth()->user()->boutique;

        return view('admin.blackfriday.edit',compact('blackFriday','magasin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $blackFriday = BlackFriday::findOrFail($id);

        $boutiqueName = $blackFriday->boutique->nommagasin;

        $boutiqueFolder = Str::slug($boutiqueName, '_');

        if ($request->hasFile('file')) {
            $media = $request->file('file');
            $name = $media->hashName();
            $media->storeAs($boutiqueFolder . '/blackFriday', $name, 'public');

            // Supprimer l'ancienne image de profil si elle existe
            if ($blackFriday->image) {
                Storage::disk('blackFriday')->delete($blackFriday->image);
            }

            // Mettre à jour les informations du fichier
            $blackFriday->image = $media ? $boutiqueFolder . '/blackFriday/' . $name : null;
        }

        // Mettre à jour les autres champs de l'école
        $blackFriday->percentage = $request->percentage;
        $blackFriday->boutique_id = $request->boutique_id;
        $blackFriday->description = $request->description;

        $blackFriday->save();

        return redirect()->route('black_friday.index')->with('warning', 'Coupon modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blackFriday = BlackFriday::findOrFail($id);
        $blackFriday->delete();

        return redirect()->route('black_friday.index')->with('danger', 'Coupon supprimé avec success');
    }
}
