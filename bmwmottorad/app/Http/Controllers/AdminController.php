<?php

namespace App\Http\Controllers;

use App\Models\FraisLivraison;
use App\Models\Equipement;
use Illuminate\Http\Request;
use App\Models\Gamme;
use App\Models\Coloris;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    /**
     * Display the delivering fees view.
     */
    public function deliveringFees()
    {
        $fraisLivraison = FraisLivraison::where('nomparametre', 'montantfraislivraison')->firstOrFail();

        return view("fraislivraison", compact('fraisLivraison'));
    }

    /**
     * Update the threshold for delivering fees.
     */
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

    /**
     * Show all equipements.
     */
    public function modifequipment()
    {
        $equipements = Equipement::all();

        return view("modifequipement", compact('equipements'));
    }


    /**
     * Show the information of the equipement to update.
     */
    public function showEquipmentModificationForm(Request $request)
    {
        // Getting the data
        $identifiantEquipment = $request->input('equipement');

        $prix = Equipement::where('idequipement', '=', $identifiantEquipment)
                    ->first('prixequipement');

        $colorisIds = Stock::where('idequipement', $identifiantEquipment)
                    ->pluck('idcoloris')
                    ->toArray('idcoloris');

        $colorisOptions = Coloris::select('idcoloris', 'nomcoloris')
                    ->whereIn('idcoloris', $colorisIds)
                    ->get();

        $prixDeBase = $prix->prixequipement;

        $coloris = Coloris::all();

        return view('modify-equipment-form', ['identifiantEquipment' => $identifiantEquipment, 'prixDeBase' => $prixDeBase, 'colorisOptions' => $colorisOptions, 'coloris' => $coloris]);
    }

    /**
     * Proceed to the update of the equipement in the DB.
     */
    public function updateEquipment(Request $request)
    {
        // Retrieve the equipment to update
        $equipement = Equipement::where('idequipement', (int) $request->input('idequipement'))->first();

        if ($equipement && $request->input('prix') > 0) {
            // Update the price of the equipment
            $equipement->update([
                'prixequipement' => $request->input('prix'),
            ]);

            \Log::info('Equipment after update: ' . json_encode($equipement));

            // Redirect the user to the result page with a success message
            return redirect()->route('update.result', ['result' => 'success']);
        } elseif ($request->input('prix') <= 0) {
            return redirect()->route('update.result', ['result' => 'negative']);
        } else {
            // Equipment not found
            \Log::warning('Equipment not found for idequipement: ' . $request->input('identifiant_equipment'));
            return redirect()->route('update.result', ['result' => 'not_found']);
        }
    }

   /**
     * Add a new coloris for the equipement and the stock for it.
     */
    public function addColorisEquipement(Request $request)
    {
        $colorisId = (int) $request->input('idcoloris');
        $equipementId = (int) $request->input('idequipement');
        $tailleId = 0;
        $quantite = null;

        // Create a new Stock record
        $stock = new Stock([
            'idequipement' => $equipementId,
            'idtaille' => $tailleId,
            'idcoloris' => $colorisId,
            'quantite' => $quantite,
        ]);

        // Save the new Stock record
        $stock->save();

        return view('update-result', ['result' => 'add-success']);
    }

    /**
     * Show the result of the equipement update.
     */
    public function showUpdateResult($result)
    {
        return view('update-result', ['result' => $result]);
    }

    /**
     * Show the list of all motos.
     */
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

