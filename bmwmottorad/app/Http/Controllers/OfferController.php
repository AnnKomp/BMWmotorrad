<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concessionnaire;
use App\Models\DemandeEssai;
use App\Models\ContactInfo;
use Illuminate\Support\Facades\DB;


class OfferController extends Controller
{
    /**
     * Show the view for 'offer'.
     */
    public function create(Request $request)
    {
        try {
            // Retrieve the 'idmoto' from the request
            $idmoto = $request->input('idmoto');

            // Return the 'essai' view with the necessary data
            return view('offer', ['idmoto' => $idmoto, 'concessionnaires' => Concessionnaire::all()]);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Fake store function for offer
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

            // Redirect to a confirmation view
            return redirect('/moto/offer/confirmation');
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the view for offer confirmation.
     */
    public function confirm()
    {
        return view('offerconfirmation');
    }
}
