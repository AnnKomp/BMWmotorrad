<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concessionnaire;
use App\Models\DemandeEssai;
use App\Models\ContactInfo;
use Illuminate\Support\Facades\DB;


class EssaiController extends Controller
{
    public function create(Request $request){
        $idmoto = $request->input('idmoto');
        return view("essai", ['idmoto' => $idmoto, 'concessionnaires' => Concessionnaire::all() ]);
    }

    /**
     * Store a new trial request
     */
    public function store(Request $request){
        /**
         * Check that form was filled correctly
         */
        $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150'],
            'datenaissance' => ['required', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
            'telephone' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'objet' => ['required', 'string', 'max:500']
        ]);

        /**
         * Create the new contact information
         */
        $b = ContactInfo::Create([
            'nomcontact' => $request->lastname,
            'prenomcontact' => $request->firstname,
            'datenaissancecontact' => $request->datenaissance,
            'emailcontact' => $request->email,
            'telcontact' => $request->telephone
        ]);

        /**
         * Create the new trial request
         */
        DemandeEssai::Create([
            'idconcessionnaire' => $request->concessionnaire,
            'idmoto' => $request->idmoto,
            'idcontact' => $b->idcontact,
            'descriptifdemandeessai' => $request->objet
        ]);

        /**
         * Redirect to a simple view to confirm the request has been sent
         */
        return redirect('/moto/essai/confirmation');
    }

    public function confirm(){
        return view('essaiconfirmation');
    }
}
