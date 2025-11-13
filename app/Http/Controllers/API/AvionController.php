<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Avion;
use Illuminate\Http\Request;

class AvionController extends Controller
{
    // GET /api/avions
    public function index()
    {
        return response()->json(Avion::all());
    }

    // POST /api/avions
    public function store(Request $request)
    {
        $data = $request->validate([
            'modele' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
        ]);

        $avion = Avion::create($data);

        return response()->json($avion, 201);
    }

    // GET /api/avions/{id}
    public function show(int $id)
    {
        $avion = Avion::findOrFail($id);

        return response()->json($avion);
    }

    // PUT /api/avions/{id}
    public function update(Request $request, int $id)
    {
        $avion = Avion::findOrFail($id);

        $data = $request->validate([
            'modele' => 'sometimes|required|string|max:255',
            'capacite' => 'sometimes|required|integer|min:1',
        ]);

        $avion->update($data);

        return response()->json($avion);
    }

    // DELETE /api/avions/{id}
    public function destroy(int $id)
    {
        $avion = Avion::findOrFail($id);
        $avion->delete();

        return response()->json(null, 204);
    }
}
