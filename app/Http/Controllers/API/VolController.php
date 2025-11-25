<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vol;
use Illuminate\Support\Facades\Storage;

class VolController extends Controller
{
    // GET /api/vols
    public function index()
    {
        $user = request()->user();

        $query = Vol::with('avion');

        if ($user) {
            $query->withCount([
                'tickets as has_ticket' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                },
            ]);
        }

        $vols = $query->get();

        return response()->json($vols);
    }

    // POST /api/vols
    public function store(Request $request)
    {
        $this->verifierAdmin($request);

        $data = $request->validate([
            'id' => 'required|string|unique:vols,id',
            'origine' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'date_arrive' => 'required|date|after:date_depart',
            'prix' => 'required|numeric|min:0',
            'avion_id' => 'required|exists:avions,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $vol = new Vol($data);

        if ($request->hasFile('photo')) {
            $vol->photo = $request->file('photo')->store('vols', 'public');
        }

        $vol->save();

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
        $this->verifierAdmin($request);

        $vol = Vol::findOrFail($id);

        $data = $request->validate([
            'origine' => 'sometimes|required|string|max:255',
            'destination' => 'sometimes|required|string|max:255',
            'date_depart' => 'sometimes|required|date',
            'date_arrive' => 'sometimes|required|date|after:date_depart',
            'prix' => 'sometimes|required|numeric|min:0',
            'avion_id' => 'sometimes|required|exists:avions,id',
            'photo' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $vol->fill($data);

        if ($request->hasFile('photo')) {
            if ($vol->photo) {
                Storage::disk('public')->delete($vol->photo);
            }
            $vol->photo = $request->file('photo')->store('vols', 'public');
        }

        $vol->save();

        return response()->json($vol);
    }

    // DELETE /api/vols/{id}
    public function destroy(string $id)
    {
        $this->verifierAdmin(request());

        $vol = Vol::findOrFail($id);
        if ($vol->photo) {
            Storage::disk('public')->delete($vol->photo);
        }
        $vol->delete();

        return response()->json(null, 204);
    }

    // GET /api/vols-home
    public function homeRandom()
    {
        $vols = Vol::with('avion')
            ->where(function ($query) {
                $query->where('origine', 'LIKE', '%Montréal%')
                    ->orWhere('origine', 'LIKE', '%Montreal%')
                    ->orWhere('destination', 'LIKE', '%Montréal%')
                    ->orWhere('destination', 'LIKE', '%Montreal%');
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return response()->json($vols);
    }

    // GET /api/vols-search?q=
    public function search(Request $request)
    {
        $q = $request->query('q', '');

        $vols = Vol::with('avion')
            ->where(function ($query) use ($q) {
                $query->where('origine', 'like', "%{$q}%")
                    ->orWhere('destination', 'like', "%{$q}%")
                    ->orWhere('id', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get();

        return response()->json($vols);
    }

    private function verifierAdmin(Request $request): void
    {
        $user = $request->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }
    }
}
