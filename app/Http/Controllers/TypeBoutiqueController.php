<?php

namespace App\Http\Controllers;

use App\Models\TypeBoutique;
use App\Http\Requests\StoreTypeMagasinRequest;
use App\Http\Requests\UpdateTypeMagasinRequest;
use Illuminate\Http\Request;

class TypeBoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeboutiques = TypeBoutique::all();

        return view('admin.typemagasin.listetypemagasin',compact('typeboutiques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.typemagasin.creertypemagasin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TypeBoutique::create([
            'libtypeboutique' => $request->libtypeboutique
        ]);

        return to_route('typeboutique.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeBoutique $typeMagasin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $typemagasin = TypeBoutique::findOrFail($id);

        return view('admin.typemagasin.editertypemagasin',compact('typemagasin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $typemagasin = TypeBoutique::findOrFail($id);

        $typemagasin->libtypeboutique = $request->libtypeboutique;

        $typemagasin->save();

        return to_route('typeboutique.index')->with('warning','Type Shop a été modifié avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeBoutique $typeMagasin)
    {
        //
    }
}
