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
        $this->verifierAdmin($request);

        $data = $request->validate([
            'modele' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
        ]);

        $avion = new Avion();
        $avion->modele = $data['modele'];
        $avion->capacite = $data['capacite'];

        $avion->save();

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
        $this->verifierAdmin($request);

        $avion = Avion::findOrFail($id);

        $data = $request->validate([
            'modele' => 'sometimes|required|string|max:255',
            'capacite' => 'sometimes|required|integer|min:1',
        ]);

        if (isset($data['modele'])) {
            $avion->modele = $data['modele'];
        }
        if (isset($data['capacite'])) {
            $avion->capacite = $data['capacite'];
        }

        $avion->save();

        return response()->json($avion);
    }

    // DELETE /api/avions/{id}
    public function destroy(int $id)
    {
        $this->verifierAdmin(request());

        $avion = Avion::findOrFail($id);
        $avion->delete();

        return response()->json(null, 204);
    }

    private function verifierAdmin(Request $request): void
    {
        $user = $request->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }
    }
}
