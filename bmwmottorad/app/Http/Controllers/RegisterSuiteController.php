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
        $b = Adresse::create([
            'nompays' => $request->nompays,
            'adresse' => $request->adresse
        ]);

        // ---------------------------------------------------- Client creation ----------------------------------------------------------------------
        $c = Client::create([
            'civilite' => $request->user()->civilite,
            'nomclient' => $request->user()->lastname,
            'prenomclient' => $request->user()->firstname,
            'datenaissanceclient' => $request->datenaissanceclient,
            'emailclient' => $request->user()->email,
            'numadresse' => $b->numadresse
        ]);

        // ---------------------------------------------------- Phone number creation ----------------------------------------------------------------------

        Telephone::create([
            'numtelephone' => $request->telephonepvmb,
            'fonction' => 'Privé',
            'type' => 'Mobile',
            'idclient' => $c->idclient
        ]);
        
        Telephone::create([
            'numtelephone' => $request->telephonepfmb,
            'fonction' => 'Professionnel',
            'type' => 'Mobile',
            'idclient' => $c->idclient
        ]);
        
        Telephone::create([
            'numtelephone' => $request->telephonepvfx,
            'fonction' => 'Privé',
            'type' => 'Fixe',
            'idclient' => $c->idclient
        ]);

        
        Telephone::create([
            'numtelephone' => $request->telephonepffx,
            'fonction' => 'Professionnel',
            'type' => 'Fixe',
            'idclient' => $c->idclient
        ]);

        // ---------------------------------------------------- User update ----------------------------------------------------------------------

        User::where('id', auth()->user()->id)->update([
            'idclient'=>$c->idclient,
            'iscomplete'=>true,
        ]);

        // ---------------------------------------------------- Account type linking ----------------------------------------------------------------------
        
        if($request->input("accounttype") == "private"){
            Prive::create([
                'idclient' => $c->idclient
            ]);
        }else{
            Professionnel::create([
                'idclient' => $c->idclient,
                'nomcompagnie' => $request->nomcompagnie,
            ]);
        }

        // Redirect to the registerfinished view
        return redirect('registerfinished');
    }
}
