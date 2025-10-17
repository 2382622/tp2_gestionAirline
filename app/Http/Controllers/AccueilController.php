<?php

namespace App\Http\Controllers;

use App\Models\Vol;

class AccueilController extends Controller
{
    public function index()
    {
        // Récupère 4 vols où Montréal est soit l'origine, soit la destination
        $vols = Vol::where('origine', 'Montréal')
                    ->orWhere('destination', 'Montréal')
                    ->inRandomOrder()
                    ->take(4)
                    ->get();

        return view('accueil.index', compact('vols'));
    }
}
