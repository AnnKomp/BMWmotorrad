<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipement;
use App\Models\Panier;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{

    public function info(Request $request) {
        $idpanier = $request->input('id');

        //sachant que pour commander il faut un idclient?
        $idclient= $request->input('idclient');

        $panier = Panier::where('idpanier', $idpanier)->first();

        $equipementsIDs = DB::table('contient')
                        ->where('idpanier', $idpanier)
                        ->pluck('idequipement');

        $equipements = Equipement::whereIn('idequipement', $equipementsIDs)->get();

        return view('panier', [
            'idpanier' => $idpanier,
            'panier' => $panier,
            'equipements' => $equipements
        ]);

    }
}
