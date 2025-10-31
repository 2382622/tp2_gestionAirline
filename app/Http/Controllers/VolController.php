<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vol;
use App\Models\Avion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        // 1) Validation
        $validator = Validator::make($request->all(), [
            'id'          => 'required|string|unique:vols,id',
            'origine'     => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'date_arrive' => 'required|date|after:date_depart',
            'prix'        => 'required|numeric|min:0',
            'avion_id'    => 'required|exists:avions,id',
            'photo'       => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('warning', 'Tous les champs sont requis');
        }

        // 2) Upload de la photo 
        $fileName = null;
        if ($request->file('photo') && $request->file('photo')->isValid()) {
            $image = $request->file('photo');
            $storedPath = $image->store('images/upload', 'public');
            $fileName = basename($storedPath);
        }

        // 3) Création du vol
        Vol::create([
            'id'          => $request->input('id'),
            'origine'     => $request->input('origine'),
            'destination' => $request->input('destination'),
            'date_depart' => $request->input('date_depart'),
            'date_arrive' => $request->input('date_arrive'),
            'prix'        => $request->input('prix'),
            'avion_id'    => $request->input('avion_id'),
            'efface'      => $request->boolean('efface'),
            'photo'       => $fileName, 
        ]);

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
        // 1) Validation
        $validator = Validator::make($request->all(), [
            'origine'     => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'date_arrive' => 'required|date|after:date_depart',
            'prix'        => 'required|numeric|min:0',
            'avion_id'    => 'required|exists:avions,id',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('warning', 'Tous les champs sont requis');
        }

        // 2) Récupération
        $vol = Vol::findOrFail($id);

        // 3) Mise à jour des champs simples
        $vol->origine     = $request->input('origine');
        $vol->destination = $request->input('destination');
        $vol->date_depart = $request->input('date_depart');
        $vol->date_arrive = $request->input('date_arrive');
        $vol->prix        = $request->input('prix');
        $vol->avion_id    = $request->input('avion_id');
        $vol->efface      = $request->boolean('efface');

        // 4) Si une nouvelle photo est fournie, on remplace l’ancienne
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // supprime l’ancienne si elle existe dans storage/app/public/images/upload
            if (!empty($vol->photo) && Storage::disk('public')->exists('images/upload/'.$vol->photo)) {
                Storage::disk('public')->delete('images/upload/'.$vol->photo);
            }

            $image = $request->file('photo');
            $storedPath = $image->store('images/upload', 'public');
            $vol->photo = basename($storedPath);
        }

        // 5) Sauvegarde
        $vol->save();

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
public function autocomplete(Request $request)
{
    $search = $request->search;

    $vols = Vol::orderBy('id', 'asc')
        ->select('id', 'origine', 'destination', 'date_depart')
        ->where('id', 'LIKE', '%' . $search . '%')
        ->orWhere('origine', 'LIKE', '%' . $search . '%')
        ->orWhere('destination', 'LIKE', '%' . $search . '%')
        ->get();

    $response = array();

    foreach ($vols as $vol) {
        $response[] = array(
            'value' => $vol->id,
            'label' => $vol->id . ' - ' . $vol->origine . ' → ' . $vol->destination . ' (' . $vol->date_depart . ')'
        );
    }

    return response()->json($response);
}

    
}
