<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GammeController extends Controller
{
    public function index() {
        $gammes = DB::table('gammemoto')
            ->select('*')
            ->get();
        return view ("add-gamme", ['gammes'=>$gammes]);
    }

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

