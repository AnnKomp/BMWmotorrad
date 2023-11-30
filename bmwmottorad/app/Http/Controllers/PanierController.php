<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipement;
use App\Models\Panier;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller
{
    public function index(Request $request){
        $cart = $request->session()->get('cart', []);

        $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();

        return view('panier', compact('equipements','cart'));

    }

    public function addToCart(Request $request, $id){
        $cart = $request->session()->get('cart', []);

        $cart[$id] = isset($cart[$id]) ? $cart[$id] +1 : 1;

        $request->session()->put('cart', $cart);

        return redirect()->back()->with('succes', 'Equipement');

    }


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
