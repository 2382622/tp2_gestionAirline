<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $vols = Vol::with('avion')->latest()->paginate(10);
        return view('vols.index', compact('vols'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $validator = Validator::make($request->all(), [
            'id'          => 'required|string|unique:vols,id',
            'origine'     => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'date_arrive' => 'required|date|after:date_depart',
            'prix'        => 'required|numeric|min:0',
            'avion_id'    => 'required|exists:avions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', 'Tous les champs sont requis');
        }

        Vol::create($request->all());
        return redirect()->route('vols.index')->with('success', 'Vol ajouté avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return view('vols.show', compact('vol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $avions = Avion::all();
        return view('vols.edit', compact('vol', 'avions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $vol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vol)
    {
        $validator = Validator::make($request->all(), [
            'origine'     => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'date_arrive' => 'required|date|after:date_depart',
            'prix'        => 'required|numeric|min:0',
            'avion_id'    => 'required|exists:avions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', 'Tous les champs sont requis');
        }

        $vol->update($request->all());
        return redirect()->route('vols.index')->with('success', 'Vol modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $ivol
     * @return \Illuminate\Http\Response
     */
    public function destroy($vol)
    {
         $vol->delete();
        return redirect()->route('vols.index')->with('success', 'Vol supprimé avec succès');
    }
}
