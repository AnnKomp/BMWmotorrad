<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pack;
use App\Models\Option;

class PackController extends Controller
{

    public function info(Request $request) {
        $idpack = $request->input('id');

        $pack = Pack::where('idpack','=',$idpack)->get();

        $options = Option::join('secompose','option.idoption','=','secompose.idoption')
                                ->where('secompose.idpack',"=", $idpack)->get();


        return view("pack",['options'=>$options ],['pack'=>$pack ]);
    }

    public function index() {
        return view("packs",['packs'=>Pack::all() ] );
    }

    public function store(Request $request) {
        $idmoto = $request->input('id');

        $packs = Pack::select('*')->where('idmoto',"=", $idmoto)->get();


        return view ("packs", ['packs' => $packs],['idmoto' => $idmoto ]);
    
    }


    public function getPacks($selectedPacks)
    {
        return Pack::whereIn('idpack', $selectedPacks)->get();
    }
}
