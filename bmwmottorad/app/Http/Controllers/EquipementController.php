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
        $equipements = DB::table('equipement')
            ->select('*')
            ->join('media', 'media.idequipement','=','equipement.idequipement')
//            ->whereColumn('idmediapresentation','idmedia')
            ->get();
        return view ("equipement-list", ['equipements'=>$equipements]);
    }

    public function detail(Request $request ) {
        $idequipement = $request->input('id');
        // $equipement_infos = DB::table('equipement')
        //     ->select('*')
        //     ->join('caracteristique','caracteristique.idmoto','=','modelemoto.idmoto')
        //     ->join('categoriecaracteristique', 'categoriecaracteristique.idcatcaracteristique','=','caracteristique.idcatcaracteristique')
        //     ->where('caracteristique.idequipement','=',$idequipement)
        //     ->get();

        $equipement=DB::table('equipement')->select('*')->where('idequipement',$idequipement)->first();

        $coloris = DB::table('coloris')
        ->select('nomcoloris')
        ->where('idcoloris','=',$equipement->idcoloris)
        ->value('nomcoloris');

        $equipement_pics = DB::table('media')
            ->select('lienmedia')
            ->where('idequipement','=',$idequipement)
            ->get();

        return view ("equipement", [
            "equipement_pics" => $equipement_pics,
            "idequipement" => $idequipement,
            "nomcoloris" => $coloris,
            "descriptionequipement" => $equipement->descriptionequipement,
            "nomequipement" => $equipement->nomequipement,
            "prixequipement" => $equipement->prixequipement,
        ]);
    }
}
