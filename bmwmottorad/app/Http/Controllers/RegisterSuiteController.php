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
    /**
     * Controller method for displaying the second part of the account registration form.
     */
    public function create(): View
    {
        // Load the view for the second part of the account registration
        return view('auth.registersuite', ['pays' => Pays::all()]);
    }


    /**
     * Store method for processing and storing user registration data.
     */
    public function store(): RedirectResponse
    {
        // Check if at least one phone number was given
        if (empty(request('telephonepvmb')) && empty(request('telephonepvfx')) && empty(request('telephonepfmb')) && empty(request('telephonepffx'))) {
            return redirect('registersuite');
        }

        // Check the data format
        request()->validate([
            'adresse' => ['required', 'string', 'max:100'],
            'nomcompagnie' => ['required_if:accounttype,professionnal'],
            'datenaissanceclient' => ['required', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
            'telephonepvmb' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepfmb' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepvfx' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepffx' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
        ]);

        // Adress creation
        $adresse = Adresse::create([
            'nompays' => request('nompays'),
            'adresse' => request('adresse'),
        ]);

        // Client creation
        $client = Client::create([
            'civilite' => auth()->user()->civilite,
            'nomclient' => auth()->user()->lastname,
            'prenomclient' => auth()->user()->firstname,
            'datenaissanceclient' => request('datenaissanceclient'),
            'emailclient' => auth()->user()->email,
            'numadresse' => $adresse->numadresse,
        ]);

        // Phone number creation
        Telephone::create([
            'numtelephone' => request('telephonepvmb'),
            'fonction' => 'Privé',
            'type' => 'Mobile',
            'idclient' => $client->idclient,
        ]);

        Telephone::create([
            'numtelephone' => request('telephonepfmb'),
            'fonction' => 'Professionnel',
            'type' => 'Mobile',
            'idclient' => $client->idclient,
        ]);

        Telephone::create([
            'numtelephone' => request('telephonepvfx'),
            'fonction' => 'Privé',
            'type' => 'Fixe',
            'idclient' => $client->idclient,
        ]);

        Telephone::create([
            'numtelephone' => request('telephonepffx'),
            'fonction' => 'Professionnel',
            'type' => 'Fixe',
            'idclient' => $client->idclient,
        ]);

        // User update
        User::where('id', auth()->user()->id)->update([
            'idclient' => $client->idclient,
            'iscomplete' => true,
        ]);

        // Account type linking
        if (request('accounttype') == 'private') {
            Prive::create([
                'idclient' => $client->idclient,
            ]);
        } else {
            Professionnel::create([
                'idclient' => $client->idclient,
                'nomcompagnie' => request('nomcompagnie'),
            ]);
        }

        // Redirect to the registerfinished view
        return redirect('registerfinished');
    }

}
