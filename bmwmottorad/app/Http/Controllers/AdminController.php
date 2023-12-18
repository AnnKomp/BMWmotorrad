<?php

namespace App\Http\Controllers;

use App\Models\FraisLivraison;
use App\Models\Equipement;
use Illuminate\Http\Request;
use App\Models\Gamme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB;

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

    public function modifequipment()
    {
        $equipements = Equipement::all(); // Fetch all equipements

        return view("modifequipement", compact('equipements'));
    }

    public function showEquipmentModificationForm(Request $request)
    {
        //dd($request);
        // Votre logique pour afficher le formulaire de modification avec le prix de base
        $identifiantEquipment = $request->input('equipement');
        $prix = DB::table("equipement")
                    ->select('prixequipement')
                    ->where('idequipement','=',$identifiantEquipment)
                    ->first();

        $prixDeBase = $prix->prixequipement;

        return view('modify-equipment-form', ['identifiantEquipment' => $identifiantEquipment, 'prixDeBase' => $prixDeBase]);
    }

    public function updateEquipment(Request $request)
    {
        // Retrieve the equipment to update
        $equipement = Equipement::where('idequipement', (int) $request->input('idequipement'))->first();

        if ($equipement && $request->input('prix')>0) {
            // Update the price of the equipment
            $equipement->update([
                'prixequipement' => $request->input('prix'),
            ]);

            \Log::info('Equipment after update: ' . json_encode($equipement));

            // Redirect the user to the result page with a success message
            return redirect()->route('update.result', ['result' => 'success']);
        }
        elseif ($request->input('prix') <= 0) {
            return redirect()->route('update.result', ['result' => 'negative']);
        }
        else {
            // Equipment not found
            \Log::warning('Equipment not found for idequipement: ' . $request->input('identifiant_equipment'));
            return redirect()->route('update.result', ['result' => 'not_found']);
        }
    }




    public function showUpdateResult($result)
    {
        return view('update-result', ['result' => $result]);
    }




    public function motolistCom()
    {
        $ranges = Gamme::all();
        $motos = DB::table('modelemoto')
            ->select('*')
            ->join('media', 'media.idmoto', '=', 'modelemoto.idmoto')
            ->whereColumn('idmediapresentation', 'idmedia')
            ->get();

        return view("motos-com", ['motos' => $motos, 'ranges' => $ranges]);
    }
}

