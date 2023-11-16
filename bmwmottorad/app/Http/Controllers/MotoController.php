<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Moto;

class MotoController extends Controller
{
    public function index() {
        $gammes = Moto::select('libellegamme')->join('gammemoto','modelemoto.idgamme','=','gammemoto.idgamme')->get();
        $motos = Moto::all();
        return view ("moto-list", ['motos'=>$motos],['gammes'=>$gammes]);
    }
    public function detail(Request $request ) {
        $idmoto = $request->input('id');
        return view ("moto", ['idmoto' => $idmoto ]);
    }
}
