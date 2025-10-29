<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Vol;
use App\Models\User;

class AdminTicketController extends Controller
{
    public function index()
    {
        // Admin voit tout
        $tickets = Ticket::with(['vol','user'])->latest()->paginate(15);
        return view('tickets.index', compact('tickets')); // réutilise ta vue existante
    }

    public function create()
    {
        $vols  = Vol::orderBy('id')->get(['id','origine','destination','date_depart']);
        $users = User::orderBy('name')->get(['id','name']); // admin peut choisir le user
        return view('tickets.create', compact('vols','users')); // réutilise
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vol_id'   => 'required|string|exists:vols,id',
            'user_id'  => 'required|exists:users,id',
            'quantite' => 'required|integer|min:1',
        ]);

        Ticket::create($data);
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket créé.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['vol','user']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $vols  = Vol::orderBy('id')->get(['id','origine','destination','date_depart']);
        $users = User::orderBy('name')->get(['id','name']);
        return view('tickets.edit', compact('ticket','vols','users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'vol_id'   => 'required|string|exists:vols,id',
            'user_id'  => 'required|exists:users,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $ticket->update($data);
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket modifié.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket supprimé.');
    }
}
