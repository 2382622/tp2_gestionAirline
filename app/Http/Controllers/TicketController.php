<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Vol;

class TicketController extends Controller
{
    public function __construct()
    {
        // Empêche les invités d'accéder aux tickets
        $this->middleware('auth');
    }

    /**
     * Affiche uniquement les tickets de l'utilisateur connecté
     */
    public function index()
    {
        $tickets = Ticket::with(['vol', 'user'])
            ->where('user_id', Auth::id()) // Filtrage
            ->latest()
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Formulaire de création : pas de choix d'utilisateur
     */
    public function create()
    {
        $vols = Vol::orderBy('id')->get(['id', 'origine', 'destination', 'date_depart']);
        return view('tickets.create', compact('vols'));
    }

    /**
     * Enregistrement : user_id = utilisateur connecté
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vol_id'   => 'required|string|exists:vols,id',
            'quantite' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('warning', 'Tous les champs sont requis');
        }

        Ticket::create([
            'vol_id'   => $request->input('vol_id'),
            'user_id'  => Auth::id(), // Fixé automatiquement
            'quantite' => (int) $request->input('quantite'),
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket acheté avec succès');
    }

    /**
     * Afficher un ticket si c'est celui de l'utilisateur
     */
    public function show(int $id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->with(['vol', 'user'])->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Formulaire d'édition, uniquement si c'est son ticket
     */
    public function edit(int $id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);
        $vols   = Vol::orderBy('id')->get(['id', 'origine', 'destination', 'date_depart']);
        return view('tickets.edit', compact('ticket', 'vols'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'vol_id'   => 'required|string|exists:vols,id',
            'quantite' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('warning', 'Tous les champs sont requis');
        }

        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);
        $ticket->vol_id   = $request->input('vol_id');
        $ticket->quantite = (int) $request->input('quantite');
        $ticket->save();

        return redirect()->route('tickets.index')->with('success', 'Ticket modifié avec succès');
    }

    /**
     * Suppression
     */
    public function destroy(int $id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé avec succès');
    }
}
