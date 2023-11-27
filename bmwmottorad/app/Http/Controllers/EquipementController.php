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
            ->whereColumn('idmediapresentation','idmedia')
            ->get();


        return view ("equipement-list", ['equipements'=>$equipements]);
    }

    public function detail(Request $request ) {
        $idequipement = $request->input('id');

        $selectedColor = $request->input('idcoloris');

        $equipement = DB::table('equipement')->select('*')->where('idequipement', $idequipement)->first();

        $colorisIds = DB::table('stock')->select('idcoloris')->where('idequipement', $idequipement)->pluck('idcoloris')->toArray();
        $tailleIds = DB::table('stock')->select('idtaille')->where('idequipement', $idequipement)->pluck('idtaille')->toArray();

        //where
        $colorisOptions = DB::table('coloris')->select('idcoloris', 'nomcoloris')->whereIn('idcoloris', $colorisIds)->get();

        $tailleOptions = DB::table('taille')->select('idtaille', 'libelletaille')->whereIn('idtaille', $tailleIds)->get();



        $equipement_pics = DB::table('media')
            ->select('lienmedia')
            ->where('idequipement', '=', $idequipement)
            ->get();

        return view("equipement", [
            "equipement_pics" => $equipement_pics,
            "idequipement" => $idequipement,
            "colorisOptions" => $colorisOptions,
            "tailleOptions" => $tailleOptions,
            "selectedColor" => $selectedColor,
            "descriptionequipement" => $equipement->descriptionequipement,
            "nomequipement" => $equipement->nomequipement,
            "prixequipement" => $equipement->prixequipement,
        ]);
        }

        public function fetchEquipmentPhotos(Request $request)
    {
        $idequipement = $request->input('idequipement');
        $idcoloris = $request->input('idcoloris');

        // Fetch images based on $idequipement and $idcoloris
        $equipement_pics = DB::table('presentation_eq')
            ->join('media', 'presentation_eq.idpresentation', '=', 'media.idpresentation')
            ->select('media.lienmedia')
            ->where('presentation_eq.idequipement', $idequipement)
            ->where('presentation_eq.idcoloris', $idcoloris)
            ->get();

        return view('partial-views.equipment-photos', ['equipement_pics' => $equipement_pics]);
    }

        /*
        public function detail(Request $request)
        {
            $idequipement = $request->input('id');

            $equipement = DB::table('equipement')->select('*')->where('idequipement', $idequipement)->first();

            $colorisIds = DB::table('stock')->select('idcoloris')->where('idequipement', $idequipement)->pluck('idcoloris')->toArray();
            $tailleIds = DB::table('stock')->select('idtaille')->where('idequipement', $idequipement)->pluck('idtaille')->toArray();

            //where
            $colorisOptions = DB::table('coloris')->select('idcoloris', 'nomcoloris')->whereIn('idcoloris', $colorisIds)->get();

            $tailleOptions = DB::table('taille')->select('idtaille', 'libelletaille')->whereIn('idtaille', $tailleIds)->get();

            // Get the selected color from the request
            $selectedColorId = $request->input('coloris');

            // Find the corresponding idpresentation for the selected color
            $idpresentation = DB::table('equipement_presentation')
                ->where('idequipement', $idequipement)
                ->where('idcoloris', $selectedColorId)
                ->value('idpresentation');

            // Get the media for the selected idpresentation
            $equipement_pics = DB::table('media')
                ->select('lienmedia')
                ->where('idpresentation', '=', $idpresentation)
                ->get();

            return view("equipement", [
                "equipement_pics" => $equipement_pics,
                "idequipement" => $idequipement,
                "colorisOptions" => $colorisOptions,
                "tailleOptions" => $tailleOptions,
                "descriptionequipement" => $equipement->descriptionequipement,
                "nomequipement" => $equipement->nomequipement,
                "prixequipement" => $equipement->prixequipement,
            ]);
        }*/




}
