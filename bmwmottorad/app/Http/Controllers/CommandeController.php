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
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class CommandeController extends Controller
{
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    }
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

    public function pay(Request $request)
    {

        $request->validate([
            'numerocarte' => ['required', 'min:16', 'max:16'],
            'titulaire' => ['required', 'string'],
            'dateexpiration' => ['required', 'date'],
            'secret' => ['required', 'min:3', 'max:3'],
        ]);

        $month = date("m",strtotime($request->dateexpiration));
        $year = date("y",strtotime($request->dateexpiration));

        $cardData = [
            'numerocarte' => $request->numerocarte,
            'month' => $month,
            'year' => $year,
            'cvv' => $request->secret
        ];

        // $token = $this->createToken($cardData);
        // if (!empty($token['error'])) {
        //     return view('motos');
        // }
        // if (empty($token['id'])) {
        //     return view('equipements');
        // }



        // $charge = $this->createCharge($token['id'], 2000);
        // if (!empty($charge) && $charge['status'] == 'succeeded') {
        //     $request->session()->flash('success', 'Payment completed.');
        // } else {
        //     $request->session()->flash('danger', 'Payment failed.');
        // }

            $this->stripe->charges->create([
                'amount' => 10000,
                'currency' => 'eur',
                'source' => 'tok_amex',
  
            ]);

        return redirect('/login');
    }

    private function createToken($cardData)
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['numerocarte'],
                    'exp_month' => $cardData['month'],
                    'exp_year' => $cardData['year'],
                    'cvc' => $cardData['cvv']
                ]
            ]);
        } catch (CardException $e) {
            dd($token['error'] = $e->getError()->message);
        } catch (Exception $e) {
            dd($token['error'] = $e->getMessage());
        }
        return $token;
    }

    private function createCharge($tokenId, $amount)
    {
        $charge = null;
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount,
                'currency' => 'eur',
                'source' => $tokenId,
                'description' => 'My first payment'
            ]);
        } catch (Exception $e) {
            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }
}
