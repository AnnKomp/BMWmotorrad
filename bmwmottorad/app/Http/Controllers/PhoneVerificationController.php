<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Telephone;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;

session_start();

class PhoneVerificationController extends Controller
{

    public function create(){
        $number = Telephone::where('idclient', auth()->user()->idclient)->first();
        $vcode = rand(100000, 999999);
        $_SESSION['vcode'] = $vcode;
        $this->sendMessage("Votre code d\'authentification My BMW est : " . $vcode, "+33" . substr($number->numtelephone, 1));
        return view('auth.phoneverification', [
            'numero' => $number,
        ]);
    }

    public function store(Request $request){

        $number = Telephone::where('idclient', auth()->user()->idclient)->first();
        if($request->code == $_SESSION['vcode']){
            return redirect('/dashboard');
        }else{
            return view('auth.phoneverification', ['numero' => $number])->withErrors(['code'=>'Le code est invalide, merci de fournir le bon code.']);
        }
    }

    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, 
                ['from' => $twilio_number, 'body' => $message] );
    }  
}