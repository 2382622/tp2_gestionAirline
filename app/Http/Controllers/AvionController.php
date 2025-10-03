<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        
    $avions = Avion::latest()->paginate(10);
    return view('avions.index', compact('avions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          return view('avions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    // Validation des champs
    $validator = Validator::make($request->all(), [
        'modele'   => 'required|string|max:255',
        'capacite' => 'required|integer|min:1',
    ]);

    // Si échec de validation
    if ($validator->fails()) {
        return redirect()->back()
            ->with('warning', 'Tous les champs sont requis')
            ->withErrors($validator);
    }

    // Création 
    Avion::create($request->all());

    // Redirection avec message de succès
    return redirect()->route('avions.index')->with('success', 'Avion ajouté avec succès');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
             $avion = Avion::findOrFail($id);
        return view('avions.show', compact('avion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $avion = Avion::findOrFail($id);
        return view('avions.edit', compact('avion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $avion = Avion::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'modele'   => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('warning','Tous les champs sont requis')
                ->withErrors($validator);
                        
               
        }

        $avion->update($request->all());
        return redirect()->route('avions.index')->with('success', 'Avion modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $avion = Avion::findOrFail($id);
        $avion->delete();

        return redirect()->route('avions.index')->with('success', 'Avion supprimé avec succès');
    }
}
