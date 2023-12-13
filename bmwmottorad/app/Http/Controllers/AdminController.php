<?php

namespace App\Http\Controllers;

use App\Models\FraisLivraison;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function deliveringFees()
    {
        $fraisLivraison = FraisLivraison::firstOrFail(); // Récupère le premier enregistrement ou crée un nouveau

        return view("fraislivraison", compact('fraisLivraison'));
    }

    public function updateDeliveringFees(Request $request)
    {
        $request->validate([
            'description' => 'required|numeric',
        ]);

        $fraisLivraison = FraisLivraison::firstOrFail();
        $fraisLivraison->update(['description' => $request->input('description')]);

        return redirect()->route('delivering-fees')->with('success', 'Montant des frais de livraison mis à jour avec succès.');
    }
}

