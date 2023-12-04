<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concessionnaire;
use App\Models\DemandeEssai;
use App\Models\ContactInfo;
use Illuminate\Support\Facades\DB;


class EssaiController extends Controller
{
    public function create(){
        return view("essai", ['concessionnaires' => Concessionnaire::all() ]);
    }

    public function store(Request $request){
        $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150'],
            'datenaissance' => ['required', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
            'telephone' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'objet' => ['required', 'string', 'max:500']
        ]);

        DB::table('contactinfo')->insert(
            array(
                'nomcontact' => $request->lastname,
                'prenomcontact' => $request->firstname,
                'datenaissancecontact' => $request->datenaissance,
                'emailcontact' => $request->email,
                'telcontact' => $request->telephone
            )
        );

        $b = new ContactInfo;
        $b -> nomcontact = $request->lastname;
        $b -> prenomcontact = $request->firstname;
        $b -> datenaissancecontact = $request->datenaissance;
        $b -> emailcontact = $request->email;
        $b -> telcontact = $request->telephone;

        $b -> save();

        $c = new DemandeEssai;
        $c->idconcessionnaire = $request->concessionnaire;
        // TODO : Replace with actual moto id
        $c->idmoto = 1;
        $c->idcontact = $b->idcontact;
        $c->descriptifdemandeessai = $request->objet;

        $c->save();

        return redirect('/motos');
    }
}
