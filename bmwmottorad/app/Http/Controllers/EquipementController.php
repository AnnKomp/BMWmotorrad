<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipementController extends Controller
{

    public function info(Request $request) {
        $idequipement = $request->input('id');

        //vu pas encore créé
        return view("equipement",['idequipement'=>$idequipement]);
    }
}
