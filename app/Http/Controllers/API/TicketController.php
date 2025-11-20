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
        return response()->json(Ticket::all());
    }

    // POST /api/tickets
    public function store(Request $request)
    {
        $data = $request->validate([
            'vol_id' => 'required|exists:vols,id',
            'user_id' => 'required|exists:users,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::create($data);

        return response()->json($ticket, 201);
    }

    // GET /api/tickets/{id}
    public function show(int $id)
    {
        $ticket = Ticket::findOrFail($id);
        return response()->json($ticket);
    }

    // PUT /api/tickets/{id}
    public function update(Request $request, int $id)
    {
        $ticket = Ticket::findOrFail($id);

        $data = $request->validate([
            'vol_id' => 'sometimes|required|exists:vols,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'quantite' => 'sometimes|required|integer|min:1',
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
