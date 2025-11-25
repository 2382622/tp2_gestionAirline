<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // GET /api/tickets
    public function index(Request $request)
    {
        $tickets = $this->ticketsSelonRole($request->user())->get();

        return response()->json($tickets);
    }

    // POST /api/tickets
    public function store(Request $request)
    {
        $user = $request->user();

        $rules = [
            'vol_id' => 'required|exists:vols,id',
            'quantite' => 'required|integer|min:1',
        ];

        // Seul un admin peut choisir le user
        if ($user->role === 'admin') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $data = $request->validate($rules);

        $ticket = Ticket::create([
            'vol_id' => $data['vol_id'],
            'quantite' => $data['quantite'],
            'user_id' => $user->role === 'admin' ? $data['user_id'] : $user->id,
        ]);

        return response()->json($ticket, 201);
    }

    // GET /api/tickets/{id}
    public function show(Request $request, int $id)
    {
        $ticket = $this->ticketsSelonRole($request->user())->findOrFail($id);
        return response()->json($ticket);
    }

    // PUT /api/tickets/{id}
    public function update(Request $request, int $id)
    {
        $user = $request->user();
        $ticket = $this->ticketsSelonRole($user)->findOrFail($id);

        $rules = [
            'vol_id' => 'sometimes|required|exists:vols,id',
            'quantite' => 'sometimes|required|integer|min:1',
        ];

        if ($user->role === 'admin') {
            $rules['user_id'] = 'sometimes|required|exists:users,id';
        }

        $data = $request->validate($rules);

        if (isset($data['vol_id'])) {
            $ticket->vol_id = $data['vol_id'];
        }
        if (isset($data['quantite'])) {
            $ticket->quantite = $data['quantite'];
        }
        if ($user->role === 'admin' && isset($data['user_id'])) {
            $ticket->user_id = $data['user_id'];
        }

        $ticket->save();

        return response()->json($ticket);
    }

    // DELETE /api/tickets/{id}
    public function destroy(Request $request, int $id)
    {
        $ticket = $this->ticketsSelonRole($request->user())->findOrFail($id);
        $ticket->delete();

        return response()->json(null, 204);
    }

    /**
     * Copie les tickets selon le rôle : admin voit tout, sinon uniquement ses billets.
     */
    private function ticketsSelonRole($user)
    {
        $query = Ticket::with(['vol', 'user'])->latest();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        return $query;
    }
}
