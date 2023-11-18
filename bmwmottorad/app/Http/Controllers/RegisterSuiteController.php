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
        $b = new Adresse;
        $b->nompays = $request->input("nompays");
        $b->codepostal = $request->input("codepostal");
        $b->ville = $request->input("ville");
        $b->rue = $request->input("rue");
        $b->numrue = $request->input("numrue");

        $b->save();

        $c = new Client;
        $c->civilite = $request->user()->civilite;
        $c->mdpclient = $request->user()->password;
        $c->nomclient = $request->user()->lastname;
        $c->prenomclient = $request->user()->firstname;
        $c->datenaissanceclient = $request->input("datenaissanceclient");
        $c->emailclient = $request->user()->email;
        $c->numadresse = $b->numadresse;

        $c->save();

        $t = new Telephone;
        $t->numtelephone = $request->numtelephone;
        $t->type = $request->type;
        $t->fonction = $request->fonction;
        $t->idclient = $c->idclient;

        $t->save();

        User::where('id', auth()->user()->id)->update([
            'idclient'=>$c->idclient,
        ]);

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
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
