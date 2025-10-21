<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vol;
use App\Models\Avion;
use Illuminate\Support\Facades\Validator;

class VolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupère les vols + leur avion, triés par plus récent
        $vols = Vol::with('avion')->latest()->paginate(10);

        // Envoie à la vue index
        return view('vols.index', compact('vols'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupère la liste des avions pour le <select>
        $avions = Avion::all();

        return view('vols.create', compact('avions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valide les champs soumis
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|unique:vols,id',
            'origine' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'date_arrive' => 'required|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'avion_id' => 'required|exists:avions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', 'Tous les champs sont requis');
        }

        // Crée l’enregistrement
        Vol::create($request->all());

        return redirect()->route('vols.index')->with('success', 'Vol ajouté avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        // Cherche le vol par ID (404 si introuvable)
        $vol = Vol::with('avion')->findOrFail($id);

        return view('vols.show', compact('vol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        // Récupère le vol et la liste des avions
        $vol = Vol::findOrFail($id);
        $avions = Avion::all();

        return view('vols.edit', compact('vol', 'avions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        // Valide les champs
        $validator = Validator::make($request->all(), [
            'origine' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'date_arrive' => 'required|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'avion_id' => 'required|exists:avions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', 'Tous les champs sont requis');
        }

        // Charge le vol puis met à jour
        $vol = Vol::findOrFail($id);
        $vol->update($request->all());

        return redirect()->route('vols.index')->with('success', 'Vol modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Supprime le vol ciblé
        $vol = Vol::findOrFail($id);
        $vol->delete();

        return redirect()->route('vols.index')->with('success', 'Vol supprimé avec succès');
    }
}
