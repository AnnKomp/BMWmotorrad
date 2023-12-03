<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipement;

class CommandeController extends Controller
{

    public function create(){
        if(auth()->user()){
            $cart = session()->get('cart', []);
            $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();
            $user = auth()->user();
            $client = DB::table('client')->select('datenaissanceclient', 'civilite','photoclient')->where('idclient', '=', $user->idclient)->first();
            $company = DB::table('professionnel')->select('nomcompagnie')->where('idclient', '=', $user->idclient)->first();
            $phone = Telephone::where('idclient', '=', $user->idclient)->get();
            $adress = DB::table('adresse')->select('nompays','adresse')->join('client', 'adresse.numadresse', '=', 'client.numadresse')->join('users', 'users.idclient', '=', 'client.idclient')->where('client.idclient', "=", $user->idclient)->first();
            return view('commande', compact('equipements', 'cart', 'user', 'client', 'company', 'phone', 'adress'));
        }else{
            return view('auth.login');
        }
    }


}
