<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipement;
use App\Models\User;
use App\Models\Commande;
use App\Models\Infocb;
use App\Models\Parametres;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Stripe;

class CommandeController extends Controller
{
    // ====================================== CARD PART =================================================================================

    /*
    * Client pays using credit/debit card
    */
    public function createcb(){
        // Get cart data and equipments
        $cart = session()->get('cart', []);
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))
                ->get();
        foreach ($equipements as $equipement) {
            foreach ($cart[$equipement->idequipement] as &$cartItem) {
                // Check if coloris key exists
                $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';
                     // Check if taille key exists
                $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';
                     // Check if quantity key exists
                $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] : '';
                $cartItem['photo'] = $this->getEquipementPhotos($equipement->idequipement, $cartItem['coloris']);
            }
        };
        // Get CB informations if client has saved one
        $cb = Infocb::firstWhere('idclient', auth()->user()->idclient);
        if($cb){
            // Decrypting if the client has a saved Credit Card
            $cb->numcarte = Crypt::decrypt($cb->numcarte);
            $cb->titulairecompte = Crypt::decrypt($cb->titulairecompte);
            $cb->dateexpiration = Crypt::decrypt($cb->dateexpiration);
        }

        // Calculating the total
        $total = 0;
        foreach($equipements as $equipement){
            foreach($cart[$equipement->idequipement] as $cartItem){
                $total += $equipement->prixequipement * $cartItem['quantity'];
            }
        }

        // Get the amounts in the 'parametres' table
        $fee = Parametres::find('fraislivraison')->description;
        $feelimit = Parametres::find('montantfraislivraison')->description;

        // If total is inferior to the needed minimal price, fee is applied to the total, else fee is 0
        if($feelimit > $total){
            $total += $fee ;
        }
        else { $fee = 0; }

        return view('commandecb', compact('equipements', 'cart', 'cb', 'total', 'fee'));
    }

    /**
     * Process payment via credit card.
     */
    public function paycb(Request $request): RedirectResponse
    {
        // Verify all the required fields are filled
        $request->validate([
            'cardnumber' => ['required', 'string', 'min:16', 'max:16', 'regex:/^[3-5]{1}[0-9]{15}$/i'],
            'owner' => ['required', 'string'],
            'expiration' => ['required', 'date', 'after:' . now()->format('m/y')],
            'cvv' => ['required', 'string', 'min:3', 'max:3', 'regex:/^[0-9]{3}$/i'],
        ]);

        // If the client saved their info, auto-fill
        if ($request->saveinfo) {
            if (Infocb::where('idclient', auth()->user()->idclient)->first()) {
                Infocb::where('idclient', auth()->user()->idclient)
                    ->update([
                        'numcarte' => Crypt::encrypt($request->cardnumber),
                        'titulairecompte' => Crypt::encrypt($request->owner),
                        'dateexpiration' => Crypt::encrypt($request->expiration),
                    ]);
            } else {
                Infocb::insert([
                    'idclient' => auth()->user()->idclient,
                    'numcarte' => Crypt::encrypt($request->cardnumber),
                    'titulairecompte' => Crypt::encrypt($request->owner),
                    'dateexpiration' => Crypt::encrypt($request->expiration),
                ]);
            }
        }

        $this->createOrder('CB');

        // Redirect to the order summary page
        return redirect('/panier/commande/success');
    }

    //  ===================================== STRIPE PART ===============================================================================

    /**
    * The client pays using Stripe
    */
    public function createstripe(){
        // Get cart data and equipments
        $cart = session()->get('cart', []);
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))
                ->get();
        foreach ($equipements as $equipement) {
            foreach ($cart[$equipement->idequipement] as &$cartItem) {
                // Check if coloris key exists
                $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';

                // Check if taille key exists
                $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';

                // Check if quantity key exists
                $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] : '';
                $cartItem['photo'] = $this->getEquipementPhotos($equipement->idequipement, $cartItem['coloris']);
            }
        };

        // Calculating the total
        $total = 0;
        foreach($equipements as $equipement){
            foreach($cart[$equipement->idequipement] as $cartItem){
                $total += $equipement->prixequipement * $cartItem['quantity'];
            }
        }

        // Get the amounts in the 'parametres' table
        $fee = Parametres::find('fraislivraison')->description;
        $feelimit = Parametres::find('montantfraislivraison')->description;

        // If total is inferior to the needed minimal price, fee is applied to the total, else fee is 0
        if($feelimit > $total){
            $total += $fee;
        }
        else {  $fee = 0;   }

        return view('commandestripe', compact('equipements', 'cart', 'total', 'fee'));
    }


    /**
     * Process payment via Stripe.
     */
    public function paystripe(Request $request): RedirectResponse
    {
        // Calculate the total
        $total = 0;
        $cart = session()->get('cart', []);
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();

        foreach ($equipements as $equipement) {
            foreach ($cart[$equipement->idequipement] as $cartItem) {
                $total += $equipement->prixequipement * $cartItem['quantity'];
            }
        }

        // Connect to Stripe's API
        $sourceToken = $request->stripeToken;

        Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        Stripe\Charge::create([
            "amount" => $total * 100,
            "currency" => "eur",
            "source" => $sourceToken,
            "description" => "Payment for BMW Motorrad equipment order",
        ]);

        $this->createOrder('stripe');

        // Redirect to the order summary page
        return redirect('/panier/commande/success');
    }

    /**
     * Display the order success view.
     */
    public function success()
    {
        // Get necessary data
        $cart = session()->get('cart', []);
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();

        foreach ($equipements as $equipement) {
            foreach ($cart[$equipement->idequipement] as &$cartItem) {
                // Check if coloris key exists
                $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';

                // Check if taille key exists
                $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';
            }
        }

        session()->forget('cart');

        return view('commandesuccess', compact('equipements', 'cart'));
    }

    /**
    *   Create an order from the cart
    */
    private function createOrder($type){
        // Get necessary data
        $cart = session()->get('cart', []);
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();

        // Create the new order and save it in the database
        $order = new Commande;
        $order->idclient = auth()->user()->idclient;
        $order->datecommande = date('m/d/y');
        $order->etat = 0;

        $order->save();

        $total = 0;

        // Insert into 'contenucommande' the items in the order and update the available stock
        foreach($cart as $item){
            DB::table('contenucommande')->insert([
                'idcommande' => $order->idcommande,
                'idequipement' => $item[0]['id'],
                'quantite' => $item[0]['quantity'],
                'idcoloris' => $item[0]['coloris'],
                'idtaille' => $item[0]['taille'],
            ]);
            DB::table('stock')
            ->where('idequipement', '=', $item[0]['id'])
            ->where('idtaille', '=', $item[0]['taille'])
            ->where('idcoloris', '=', $item[0]['coloris'])
            ->decrement('quantite', $item[0]['quantity']);
        }


        foreach($equipements as $equipement){
            foreach($cart[$equipement->idequipement] as $cartItem){
                $total += $equipement->prixequipement * $cartItem['quantity'];
            }
        }

        // Get the amounts in the 'parametres' table
        $fee = Parametres::find('fraislivraison')->description;
        $feelimit = Parametres::find('montantfraislivraison')->description;

        // If total is inferior to the needed minimal price, fee is applied to the total, else fee is 0
        if($feelimit > $total){
            $total += $fee;
        }
        else{   $fee = 0;    }

        // Add a new transaction into the 'transaction' table
        DB::table('transaction')->insert([
            'idcommande' => $order->idcommande,
            'type' => $type,
            'montant' => $total
        ]);
    }

    // ==================================== GETTERS ===========================================================

    /**
     * Retrieve the coloris name based on its ID.
     */
    private function getColorisName($colorisId): string
    {
        // Retrieve coloris name based on ID
        return DB::table('coloris')->where('idcoloris', $colorisId)->value('nomcoloris') ?? '';
    }

    /**
     * Retrieve the taille name based on its ID.
     *
     * @param int $tailleId
     * @return string
     */
    private function getTailleName($tailleId): string
    {
        // Retrieve taille name based on ID
        return DB::table('taille')->where('idtaille', $tailleId)->value('libelletaille') ?? '';
    }

    /**
     * Get the link to the media for a color of an equipment.
     */
    private function getEquipementPhotos($equipementId, $colorisId): string
    {
        // Get the id of the presentation image
        $idpresentation = DB::table('presentation_eq')
            ->select('idpresentation')
            ->where('idequipement', $equipementId)
            ->where('idcoloris', $colorisId)
            ->value('idpresentation');

        if ($idpresentation) {
            $lienmedia = DB::table('media')
                ->select('lienmedia')
                ->where('idpresentation', $idpresentation)
                ->value('lienmedia');

            return $lienmedia ?? '';
        }

        return '';
    }
}
