<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concessionnaire;
use App\Models\DemandeEssai;
use App\Models\ContactInfo;
use Illuminate\Support\Facades\DB;


class EssaiController extends Controller
{

    /**
     * Show the view for 'essai'.
     */
    public function create(Request $request)
    {
        try {
            // Retrieve the 'idmoto' from the request
            $idmoto = $request->input('idmoto');

            // Return the 'essai' view with the necessary data
            return view("essai", ['idmoto' => $idmoto, 'concessionnaires' => Concessionnaire::all()]);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a new trial request.
     */
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $request->validate([
                'firstname' => ['required', 'string', 'max:100'],
                'lastname' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:150'],
                'datenaissance' => ['required', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
                'telephone' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
                'objet' => ['required', 'string', 'max:500']
            ]);

            // Create new contact information
            $contactInfo = ContactInfo::create([
                'nomcontact' => $request->lastname,
                'prenomcontact' => $request->firstname,
                'datenaissancecontact' => $request->datenaissance,
                'emailcontact' => $request->email,
                'telcontact' => $request->telephone
            ]);

            // Create a new trial request
            DemandeEssai::create([
                'idconcessionnaire' => $request->concessionnaire,
                'idmoto' => $request->idmoto,
                'idcontact' => $contactInfo->idcontact,
                'descriptifdemandeessai' => $request->objet
            ]);

            // Redirect to a confirmation view
            return redirect('/moto/essai/confirmation');
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the view for trial confirmation.
     */
    public function confirm()
    {
        return view('essaiconfirmation');
    }

}
