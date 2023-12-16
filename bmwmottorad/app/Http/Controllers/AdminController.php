<?php

namespace App\Http\Controllers;

use App\Models\FraisLivraison;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function deliveringFees()
    {
        $fraisLivraison = FraisLivraison::where('nomparametre', 'montantfraislivraison')->firstOrFail();

        return view("fraislivraison", compact('fraisLivraison'));
    }

    public function updateDeliveringFees(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
        ], [
            'required' => 'Le :attribute est requis.',
            'numeric' => 'Le :attribute doit être un nombre.',
            'min' => 'Le :attribute doit être supérieur ou égal à :min.',
        ]);

        $fraisLivraison = FraisLivraison::where('nomparametre', 'montantfraislivraison')->firstOrFail();
        $fraisLivraison->update(['description' => $request->input('montant')]);

        return redirect()->route('delivering-fees')->with('success', 'Montant des frais de livraison mis à jour avec succès.');
    }
}

