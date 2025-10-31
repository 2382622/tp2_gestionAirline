<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Vol;
use App\Models\User;

class AdminTicketController extends Controller
{
    /**
     * Liste des tickets (admin).
     */
    public function index()
    {
        // Admin voit tout, avec relations chargées
        $tickets = Ticket::with(['vol', 'user'])
            ->latest()
            ->paginate(15);

        // Réutilise ta vue publique (ok si tu veux un seul jeu de vues)
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $vols  = Vol::orderBy('id')->get(['id', 'origine', 'destination', 'date_depart']);
        $users = User::orderBy('name')->get(['id', 'name']); // admin choisit le user

        return view('tickets.create', compact('vols', 'users'));
    }

    /**
     * Enregistrement d’un ticket.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vol_id'   => 'required|integer|exists:vols,id',
            'user_id'  => 'required|integer|exists:users,id',
            'quantite' => 'required|integer|min:1',
        ]);

        // Assure-toi que Ticket::$fillable contient bien ['vol_id','user_id','quantite']
        Ticket::create($data);

        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Ticket créé.');
    }

    /**
     * Affichage d’un ticket.
     */
    public function show($id)
    {
        $ticket = Ticket::with(['vol', 'user'])->findOrFail($id);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Formulaire d’édition.
     */
    public function edit($id)
    {
        $ticket = Ticket::with(['vol', 'user'])->findOrFail($id);
        $vols   = Vol::orderBy('id')->get(['id', 'origine', 'destination', 'date_depart']);
        $users  = User::orderBy('name')->get(['id', 'name']);

        return view('tickets.edit', compact('ticket', 'vols', 'users'));
    }

    /**
     * Mise à jour d’un ticket.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'vol_id'   => 'required|integer|exists:vols,id',
            'user_id'  => 'required|integer|exists:users,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);

        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Ticket modifié.');
    }

    /**
     * Suppression d’un ticket.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Ticket supprimé.');
    }
}
