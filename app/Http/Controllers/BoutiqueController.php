<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\Magasin;
use App\Models\TypeMagasin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBoutiqueRequest;
use App\Http\Requests\UpdateBoutiqueRequest;
use App\Models\Boutique;
use App\Models\TypeBoutique;

class BoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role_id === 1)
        {
            $boutiques = Boutique::with('user')->get();
        }else if(auth()->user()->role_id === 2)
        {
            $boutiques = Boutique::where('user_id',auth()->user()->id);
        }

        return view('admin.boutique.listeboutique',compact('boutiques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* $countries = Pays::all(); */

        $typesmagasins = TypeBoutique::all();

        return view('admin.boutique.creerboutique',compact('typesmagasins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté

        // Étape 1 : Créer le magasin sans les fichiers médias
        $magasinData = $request->only(['nommagasin','type_boutique_id','contact','adresse','pays_id','registrecommerce',
        'email','description','cashback_type','cashback_value','cashback_min_order','cashback_enabled']);
        $magasinData['user_id'] = $user->id;

        // Générer le slug à partir du nom du magasin
        $magasinData['slug'] = Str::slug($magasinData['nommagasin'], '-');

        // Créer le magasin et récupérer l'instance créée
        $magasin = Boutique::create($magasinData);

        // Étape 2 : Maintenant que le magasin est créé, on peut utiliser son nom pour stocker les fichiers
        $boutiqueName = $magasin->nommagasin;
        $boutiqueFolder = Str::slug($boutiqueName, '_');

        $media = $request->file('file');
        $video = $request->file('video');
        $mediaBoutique = $request->file('imgmagasin');

        $name = $nameBoutique = $videoName = null;

        if ($media) {
            $name = $media->hashName();
            $media->storeAs($boutiqueFolder . '/logo', $name, 'public');
        }

        if ($mediaBoutique) {
            $nameBoutique = $mediaBoutique->hashName();
            $mediaBoutique->storeAs($boutiqueFolder . '/boutique', $nameBoutique, 'public');
        }

        if ($video) {
            $videoName = $video->hashName();
            $video->storeAs($boutiqueFolder . '/videosBoutique', $videoName, 'public');
        }

        // Mise à jour du magasin avec les chemins des fichiers
        $magasin->update([
            'image' => $boutiqueFolder . '/logo/' . $name,
            'imgmagasin' => $boutiqueFolder . '/boutique/' . $nameBoutique,
            'video' => $boutiqueFolder . '/videosBoutique/' . $videoName,
        ]);

        // Étape 3 : Mise à jour de l'utilisateur avec l'ID du magasin
        $user->update(['boutique_id' => $magasin->id]);

        return to_route('dashboard.commercant')->with('success', 'Magasin créé avec succès!');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        //

    }

    public function switchChild(Request $request)
    {
        $magasinId = $request->query('magasin_id');
        session(['selected_magasin' => $magasinId]);

        return redirect()->back()->with('success', 'Magasin sélectionné avec succès.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $boutique = Boutique::findOrFail($id);

        /* $countries = Pays::all(); */

        $typesmagasins = TypeBoutique::all();

        return view('admin.boutique.editerboutique',compact('boutique','typesmagasins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $boutique = Boutique::findOrFail($id);

        $boutiqueName = $boutique->nommagasin;

        $boutiqueFolder = Str::slug($boutiqueName, '_');

        if ($request->hasFile('file')) {
            $media = $request->file('file');
            $name = $media->hashName();
            $media->storeAs($boutiqueFolder . '/logo', $name, 'logo');


            // Supprimer l'ancienne image de profil si elle existe
            if ($boutique->image) {
                Storage::disk('logo')->delete($boutique->image);
            }

            // Mettre à jour les informations du fichier
            $boutique->image = $boutiqueFolder . '/logo/' . $name;
        }

        if ($request->hasFile('imgmagasin')) {
            $media = $request->file('imgmagasin');
            $nameBoutique = $media->hashName();
            $media->storeAs($boutiqueFolder . '/boutique', $nameBoutique, 'boutique');

            // Supprimer l'ancienne image de profil si elle existe
            if ($boutique->imgmagasin) {
                Storage::disk('boutique')->delete($boutique->imgmagasin);
            }

            // Mettre à jour les informations du fichier
            $boutique->imgmagasin = $boutiqueFolder . '/boutique/' . $nameBoutique;
        }

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = $video->hashName();
            $video->storeAs($boutiqueFolder . '/videos', $videoName, 'videos');

            // Supprimer l'ancienne vidéo si elle existe
            if ($boutique->video) {
                Storage::disk('videos')->delete($boutique->video);
            }

            // Mettre à jour les informations de la vidéo
            $boutique->video = $boutiqueFolder . '/videos/' . $videoName;
        }

        // Mettre à jour les autres champs de l'école
        $boutique->nommagasin = $request->nommagasin;
        $boutique->slug = Str::slug($request->nommagasin, '-'); // Génère le slug basé sur le nom de la boutique
        $boutique->type_boutique_id = $request->input('type_boutique_id');
        $boutique->contact = $request->contact;
        $boutique->adresse = $request->input('adresse');
        $boutique->registrecommerce = $request->input('registrecommerce');
        $boutique->email = $request->input('email');

        $boutique->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $boutique = Boutique::findOrFail($id);
        $boutique->delete();

        return to_route('user.index')->with('danger','Boutique supprimé avec success');
    }

    public function toggleActive($id)
    {
        $boutique = Boutique::findOrFail($id);

        // Inversez l'état actif
        $boutique->active = !$boutique->active;
        $boutique->save();

        return redirect()->back()->with('success', 'L\'état de la boutique a été mis à jour.');
    }

}
