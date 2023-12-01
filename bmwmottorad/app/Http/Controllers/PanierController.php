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

        $cart[$id] = isset($cart[$id]) ? $cart[$id] + $request->input('quantity') : $request->input('quantity',1);

        $request->session()->put('cart', $cart);

        return redirect()->back()->with('succes', 'Equipement ajouté');

    }


}
