<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipement;
use App\Models\User;
use App\Models\Commande;
use App\Models\Infocb;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Stripe;

class CommandeController extends Controller
{
    // ====================================== CARD PART =================================================================================
    
    public function createcb(){
        if(auth()->user()){
            $cart = session()->get('cart', []);
            $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();
            foreach ($equipements as $equipement) {
                foreach ($cart[$equipement->idequipement] as &$cartItem) {
                    // Check if coloris key exists
                    $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';
        
                    // Check if taille key exists
                    $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';
        
                    // Check if quantity key exists
                    $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] : '';
                }
            };
            $cb = Infocb::where('idclient', auth()->user()->idclient)->first();
            return view('commandecb', compact('equipements', 'cart', 'cb'));
        }else{
            return view('auth.login');
        }
    }

    public function paycb(Request $request)  : RedirectResponse
    {
        $request->validate([
            'cardnumber' => ['required', 'string', 'min:16' ,'max:16', 'regex:/^[3-5]{1}[0-9]{15}$/i'],
            'owner' => ['required', 'string'],
            'expiration' => ['required', 'date', 'after:' . date('m-y')],
            'cvv' => ['required', 'string', 'min:3', 'max:3', 'regex:/^[0-9]{3}$/i'],
        ]);

        if($request->saveinfo){
            if(Infocb::where('idclient', auth()->user()->idclient)->first()){
                Infocb::where('idclient', auth()->user()->idclient)->update([
                   'numcarte' => $request->cardnumber,
                   'titulairecompte' => $request->owner,
                   'dateexpiration' => $request->expiration
                ]);
            }else{
                Infocb::insert([
                    'idclient' => auth()->user()->idclient,
                    'numcarte' => $request->cardnumber,
                    'titulairecompte' => $request->owner,
                    'dateexpiration' => $request->expiration
                ]);
            }
        }

        return redirect('/panier/commande/success');
    }



    //  ===================================== STRIPE PART ===============================================================================
    public function createstripe(){
        if(auth()->user()){
            $cart = session()->get('cart', []);
            $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();
            foreach ($equipements as $equipement) {
                foreach ($cart[$equipement->idequipement] as &$cartItem) {
                    // Check if coloris key exists
                    $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';
        
                    // Check if taille key exists
                    $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';
        
                    // Check if quantity key exists
                    $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] : '';
                }
            };
            return view('commandestripe', compact('equipements', 'cart'));
        }else{
            return view('auth.login');
        }
    }

    public function paystripe(Request $request)  : RedirectResponse
    {

        $total = 0;
        $cart = session()->get('cart', []);
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();
        foreach($equipements as $equipement){
            foreach($cart[$equipement->idequipement] as $cartItem){
                $total += $equipement->prixequipement * $cartItem['quantity'];
            }
        }

        $sourceToken = $request->stripeToken;

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
            "amount" => $total * 100,
            "currency" => "eur",
            "source" => $sourceToken,
            "description" => "Paiement commande equipement BMW Motorrad"
        ]);

        return redirect('/panier/commandestripe/success');
    }
 
    public function success(){
        // Get necessary data
        $cart = session()->get('cart', []);
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();

        // Create the new order and save it in the database
        $order = new Commande;
        $order->idclient = auth()->user()->idclient;
        $order->datecommande = date('m/d/y');
        $order->etat = 1;

        $order->save();

        foreach($cart as $item){
            DB::table('contenucommande')->insert([
                'idcommande' => $order->idcommande,
                'idequipement' => $item[0]['id'],
                'quantite' => $item[0]['quantity']
            ]);
        }

        // Useless ? 
        // foreach ($equipements as $equipement) {
        //     foreach ($cart[$equipement->idequipement] as &$cartItem) {
        //         // Check if coloris key exists
        //         $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';
    
        //         // Check if taille key exists
        //         $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';
    
        //         // Check if quantity key exists
        //         $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] : '';
        //     }
        // }

        session()->forget('cart');
        return view('commandesuccess', compact('equipements', 'cart'));
    }

    // ==================================== GETTERS ===========================================================
    private function getColorisName($colorisId)
    {
        // Retrieve coloris name based on ID
        return DB::table('coloris')->where('idcoloris', $colorisId)->value('nomcoloris');
    }

    private function getTailleName($tailleId)
    {
        // Retrieve taille name based on ID
        return DB::table('taille')->where('idtaille', $tailleId)->value('libelletaille');
    }
}
