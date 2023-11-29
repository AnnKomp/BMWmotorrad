<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use App\Models\Adresse;
use App\Models\Client;
use App\Models\Telephone;
use App\Models\Professionnel;
use App\Models\Prive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class RegisterSuiteController extends Controller
{
    public function create(): View{
        //load the view for the second part of the account register
        return view('auth.registersuite', ['pays'=>Pays::all() ]);
    }

    public function store(Request $request): RedirectResponse{

        // Check if at least one phone number was given 
        if(empty($request->telephonepvmb) && empty($request->telephonepvfx) && empty($request->telephonepfmb) && empty($request->telephonepffx)){
            return redirect('registersuite');
        }

        // Check the data format
        $request->validate([
            'adresse' => ['required', 'string', 'max:100'],
            'nomcompagnie' => ['required_if:accounttype,professionnal'],
            'datenaissanceclient' => ['required', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
            'telephonepvmb' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepfmb' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepvfx' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepffx' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
        ]);

        // ---------------------------------------------------- Adress creation  ----------------------------------------------------------------------
        // Creating the adress for the new user

        $b = new Adresse;
        $b->nompays = $request->input("nompays");
        $b->adresse = $request->input("adresse");

        $b->save();

        // ---------------------------------------------------- Client creation ----------------------------------------------------------------------
        // Creating a new client for the new user (TODO : Remove client table and replace by users table)
        $c = new Client;
        $c->civilite = $request->user()->civilite;
        $c->mdpclient = $request->user()->password;
        $c->nomclient = $request->user()->lastname;
        $c->prenomclient = $request->user()->firstname;
        $c->datenaissanceclient = $request->input("datenaissanceclient");
        $c->emailclient = $request->user()->email;
        $c->numadresse = $b->numadresse;
        $c->photoclient = '/img/null.png';

        $c->save();


        // ---------------------------------------------------- Phone number creation ----------------------------------------------------------------------
        // Creating the four phone numbers for the new user
        $t = new Telephone;
        $t->numtelephone = $request->telephonepvmb;
        $t->fonction = 'Privé';
        $t->type = 'Mobile';
        $t->idclient = $c->idclient;

        $t->save();

        $t = new Telephone;
        $t->numtelephone = $request->telephonepfmb;
        $t->fonction = 'Professionnel';
        $t->type = 'Mobile';
        $t->idclient = $c->idclient;

        $t->save();

        $t = new Telephone;
        $t->numtelephone = $request->telephonepvfx;
        $t->fonction = 'Privé';
        $t->type = 'Fixe';
        $t->idclient = $c->idclient;

        $t->save();

        $t = new Telephone;
        $t->numtelephone = $request->telephonepffx;
        $t->fonction = 'Professionnel';
        $t->type = 'Fixe';
        $t->idclient = $c->idclient;

        $t->save();

        // ---------------------------------------------------- User update ----------------------------------------------------------------------
        // Linking user and client table (To be removed)
        User::where('id', auth()->user()->id)->update([
            'idclient'=>$c->idclient,
            'iscomplete'=>true,
        ]);

        // ---------------------------------------------------- Account type linking ----------------------------------------------------------------------
        if($request->input("accounttype") == "private"){
            $p = new Prive;
            $p->idclient = $c->idclient;
            $p->save();
        }else{
            $p = new Professionnel;
            $p->idclient = $c->idclient;
            $p->nomcompagnie = $request->input("nomcompagnie");
            $p->save();
        }

        // Redirect to the registerfinished view
        return redirect('registerfinished');
    }
}
