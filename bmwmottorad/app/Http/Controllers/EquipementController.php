<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Moto;
use App\Models\Pack;
use App\Models\Option;
use App\Models\Accessoire;

class EquipementController extends Controller
{
    public function index() {
        $motos = DB::table('equipement')
            ->select('*')
            ->join('media', 'media.idequipement','=','equipement.idequipement')
//            ->whereColumn('idmediapresentation','idmedia')
            ->get();
        return view ("equipement-list", ['motos'=>$motos]);
    }
}
