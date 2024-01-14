<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gamme;
use Illuminate\Support\Facades\DB;

class GammeController extends Controller
{
    /**
     * Show the view to add a new gamme.
     */
    public function index()
    {
        try {
            // Retrieve all existing gammes
            $gammes = Gamme::all();

            // Return the view with gammes data
            return view("add-gamme", ['gammes' => $gammes]);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Add a new gamme to the database.
     */
    public function addGamme(Request $request)
    {
        try {
            // Retrieve the new gamme name from the request
            $newGammeName = $request->input('gammeName');

            // Insert the new gamme into the 'gammemoto' table
            DB::insert('INSERT INTO gammemoto(libellegamme) VALUES (?)', [$newGammeName]);

            // Return a success message
            return response()->json(['message' => 'Gamme added']);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

