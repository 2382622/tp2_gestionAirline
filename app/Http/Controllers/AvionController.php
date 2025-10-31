<?php

namespace App\Http\Controllers;

use App\Models\Avion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $avions = Avion::latest()->paginate(10);
        return view('avions.index', compact('avions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('avions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modele' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('warning', 'Tous les champs sont requis')
                ->withErrors($validator)
                ->withInput();
        }

        Avion::create($validator->validated());

        return redirect()->route('avions.index')->with('success', 'Avion ajoute avec succes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
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
     * @return \Illuminate\Contracts\View\View
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $avion = Avion::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'modele' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('warning', 'Tous les champs sont requis')
                ->withErrors($validator)
                ->withInput();
        }

        $avion->update($validator->validated());

        return redirect()->route('avions.index')->with('success', 'Avion modifie avec succes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $avion = Avion::findOrFail($id);
        $avion->delete();

        return redirect()->route('avions.index')->with('success', 'Avion supprime avec succes');
    }
}
