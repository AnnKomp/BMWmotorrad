<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gamme;
use Illuminate\Support\Facades\DB;

class GammeController extends Controller
{
    // Function to show the view to add a new gamme
    public function index() {
        $gammes = Gamme::all();
        return view ("add-gamme", ['gammes'=>$gammes]);
    }


    //Function to add the new gamme in the DB
    public function addGamme(Request $request) {
        try {
        $newGammeName = $request->input('gammeName');

        DB::insert('INSERT INTO gammemoto(libellegamme) VALUES (?)' , [$newGammeName]);

        return response()->json(['message' => 'gamme added']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    }

