<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vol;
use App\Models\Avion;

class VolController extends Controller
{
    // GET /api/vols
    public function index()
    {
        return response()->json(Vol::with('avion')->get());
    }

    // POST /api/vols
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|unique:vols,id',
            'origine' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'date_arrive' => 'required|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'avion_id' => 'required|exists:avions,id',
            // ici l’API attend juste le nom éventuel du fichier
            'photo' => 'nullable|string|max:255',
        ]);

        $vol = Vol::create($data);

        return response()->json($vol, 201);
    }

    // GET /api/vols/{id}
    public function show(string $id)
    {
        $vol = Vol::with('avion')->findOrFail($id);
        return response()->json($vol);
    }

    // PUT /api/vols/{id}
    public function update(Request $request, string $id)
    {
        $vol = Vol::findOrFail($id);

        $data = $request->validate([
            'origine' => 'sometimes|required|string|max:255',
            'destination' => 'sometimes|required|string|max:255',
            'date_depart' => 'sometimes|required|date',
            'date_arrive' => 'sometimes|required|date|after:date_depart',
            'prix' => 'sometimes|required|numeric|min:0',
            'avion_id' => 'sometimes|required|exists:avions,id',
            'photo' => 'sometimes|nullable|string|max:255',
        ]);

        $vol->update($data);

        return response()->json($vol);
    }

    // DELETE /api/vols/{id}
    public function destroy(string $id)
    {
        $vol = Vol::findOrFail($id);
        $vol->delete();

        return response()->json(null, 204);
    }
}
