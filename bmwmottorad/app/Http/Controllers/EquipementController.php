<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Moto;
use App\Models\Pack;
use App\Models\Option;
use App\Models\Accessoire;
use App\Models\CategorieEquipement;

class EquipementController extends Controller
{
    public function index(Request $request) {
        $query = $request->input('search');
        $categories = CategorieEquipement::all();
        $categoryId = $request->input('category');

        $equipements = DB::table('equipement')
            ->select('*')
            ->join('media', 'media.idequipement', '=', 'equipement.idequipement')
            ->join('categorieequipement','equipement.idcatequipement','=','categorieequipement.idcatequipement')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where("nomequipement", 'ilike', '%' . $query . '%')
                    ->orWhere("descriptionequipement", 'ilike', '%' . $query . '%');
            })
            ->when($categoryId, function ($queryBuilder) use ($categoryId) {
                $queryBuilder->where('equipement.idcatequipement', $categoryId);
            })
            ->whereColumn('idmediapresentation', '=', 'idmedia')
            ->get();

        return view("equipement-list", ['equipements'=>$equipements, 'categories' => $categories]);
    }






    public function detail(Request $request ) {
        $idequipement = $request->input('id');

        $equipement = DB::table('equipement')
                    ->select('*')
                    ->where('idequipement', $idequipement)
                    ->first();

        $colorisIds = DB::table('stock')
                    ->select('idcoloris')
                    ->where('idequipement', $idequipement)
                    ->pluck('idcoloris')
                    ->toArray();
        $tailleIds = DB::table('stock')
                    ->select('idtaille')
                    ->where('idequipement', $idequipement)
                    ->pluck('idtaille')
                    ->toArray();

        //where
        $colorisOptions = DB::table('coloris')
                    ->select('idcoloris', 'nomcoloris')
                    ->whereIn('idcoloris', $colorisIds)
                    ->get();

        $tailleOptions = DB::table('taille')
                    ->select('idtaille', 'libelletaille')
                    ->whereIn('idtaille', $tailleIds)
                    ->get();



        $equipement_pics = DB::table('media')
                    ->select('lienmedia')
                    ->where('idequipement', '=', $idequipement)
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
        }

    public function search(Request $request)
        {
            $query = $request->input('query');

            $equipements = DB::table('equipement')
                        ->select('*')
                        ->join('media', 'media.idequipement','=','equipement.idequipement')
                        ->whereColumn('idmediapresentation','idmedia')
                        ->where('nomequipement', 'like', '%' . $query . '%')
                        ->orWhere('descriptionequipement', 'like', '%' . $query . '%')
                        ->get();

            return view('equipements.search', ['equipments' => $equipments]);
        }

}
