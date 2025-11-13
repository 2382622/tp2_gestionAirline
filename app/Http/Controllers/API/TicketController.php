<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // GET /api/tickets
    public function index()
    {

        $tickets = Ticket::with('user')->get();

        return response()->json($tickets);
    }

    // POST /api/tickets
    public function store(Request $request)
    {
        // Validation des données reçues en JSON
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|string|max:50',
            'priorite' => 'nullable|string|max:50',
            'user_id' => 'nullable|exists:users,id',
            'vol_id' => 'nullable|exists:vols,id',
        ]);

        $ticket = Ticket::create($data);

        return response()->json($ticket, 201);
    }

    // GET /api/tickets/{id}
    public function show(int $id)
    {
        $ticket = Ticket::with('user')->findOrFail($id);

        return response()->json($ticket);
    }

    // PUT /api/tickets/{id}
    public function update(Request $request, int $id)
    {
        $ticket = Ticket::findOrFail($id);

        $data = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'statut' => 'sometimes|required|string|max:50',
            'priorite' => 'sometimes|nullable|string|max:50',
            'user_id' => 'sometimes|nullable|exists:users,id',
            'vol_id' => 'sometimes|nullable|exists:vols,id',
        ]);

        $ticket->update($data);

        return response()->json($ticket);
    }

    // DELETE /api/tickets/{id}
    public function destroy(int $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json(null, 204);
    }
}
