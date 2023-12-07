<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipement;
use App\Models\User;
use App\Models\Telephone;
use App\Models\Adresse;
use App\Models\Client;
use App\Models\Pays;
use App\Models\Professionnel;
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
            return view('commandecb', compact('equipements', 'cart'));
        }else{
            return view('auth.login');
        }
    }

    public function paycb(Request $request)  : RedirectResponse
    {
        // TODO : VALIDATE 

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
        }

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
