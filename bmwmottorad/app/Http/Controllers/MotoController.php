<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Moto;

class MotoController extends Controller
{
    public function index() {
        $ranges = DB::table('modelemoto')->select('*')->join('gammemoto','modelemoto.idgamme','=','gammemoto.idgamme')->get();
        $motos = DB::table('modelemoto')->select('*')->join('media', 'media.idmoto','=','modelemoto.idmoto')->whereColumn('idmediapresentation','idmedia')->get();
        return view ("moto-list", ['motos'=>$motos],['ranges'=>$ranges]);
    }

    public function detail(Request $request ) {
        $idmoto = $request->input('id');
        $moto_infos = DB::table('caracteristique')->select('*')->join('categoriecaracteristique', 'categoriecaracteristique.idcatcaracteristique','=','caracteristique.idcatcaracteristique')->where('idbrochure','=',$idmoto)->get();
        $moto_pics = DB::table('media')->select('lienmedia')->where('idmoto','=',$idmoto)->get();
        return view ("moto", ["infos" => $moto_infos], ["moto_pics" => $moto_pics]);
    }

    public function filter(Request $request) {
        $moto_range = $request->input('id');
        $ranges = DB::table('modelemoto')->select('*')->join('gammemoto','modelemoto.idgamme','=','gammemoto.idgamme')->get();
        $motos = DB::table('modelemoto')->select('*')->join('gammemoto','modelemoto.idgamme','=','gammemoto.idgamme')->join('media', 'media.idmoto','=','modelemoto.idmoto')->where('modelemoto.idgamme', '=', $moto_range)->get();
        return view("moto-list-filtered", ["motos" => $motos], ['ranges'=>$ranges]);
    }


}
