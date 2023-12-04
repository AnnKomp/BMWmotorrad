<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Moto;
use App\Models\Pack;
use App\Models\Option;
use App\Models\Accessoire;
use App\Models\CategorieEquipement;
use Illuminate\Support\Facades\Log;

class EquipementController extends Controller
{
    public function index(Request $request) {
        $query = $request->input('search');
        $categories = CategorieEquipement::all();
        $categoryId = $request->input('category');
        $sex = $request->input('sex');
        $tendencies = $request->has('tendencies');
        $priceOrder = request('price') === 'asc' ? 'asc' : 'desc';


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
                    ->when($sex, function ($queryBuilder) use ($sex) {
                        $queryBuilder->where('equipement.sexeequipement', $sex);
                    })
                    ->when(request('tendencies'), function ($queryBuilder) {
                        $queryBuilder->where('equipement.tendance', true);
                    })
                    ->whereColumn('idmediapresentation', '=', 'idmedia')
                    ->when(request('price'), function ($queryBuilder) {
                        $priceOrder = request('price') === 'asc' ? 'asc' : 'desc';
                        $queryBuilder->orderBy('prixequipement', $priceOrder);
                    })
                    ->get();
                        return view("equipement-list", ['equipements'=>$equipements, 'categories' => $categories]);
        }






    public function detail(Request $request ) {
        $idequipement = $request->input('id');
        $idcoloris = $request->input('idcoloris');

        $equipement = DB::table('equipement')->select('*')->where('idequipement', $idequipement)->first();

        // rajouter une jointure avec presentation_eq ?
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


        if ($idcoloris == null)
            $idcoloris = !empty($colorisIds) ? $colorisIds[0] : null;



        $equipement_pics = DB::table('presentation_eq')
        ->join('media', 'presentation_eq.idpresentation', '=', 'media.idpresentation')
        ->select('media.lienmedia')
        ->where('presentation_eq.idequipement', $idequipement)
        ->where('presentation_eq.idcoloris', $idcoloris)
        ->get();

        $equipement = DB::table('equipement')
        ->select('*')
        ->where('idequipement', $idequipement)
        ->first();

        $stock = DB::table('stock')
        ->where('idequipement', $idequipement)
        ->where('idcoloris', $idcoloris)
        ->where('idtaille', $tailleOptions->first()->idtaille)
        ->value('quantite');


        return view("equipement", [
            "equipement_pics" => $equipement_pics,
            "idequipement" => $idequipement,
            "colorisOptions" => $colorisOptions,
            "tailleOptions" => $tailleOptions,
            "descriptionequipement" => $equipement->descriptionequipement,
            "nomequipement" => $equipement->nomequipement,
            "prixequipement" => $equipement->prixequipement,
            "selectedColor" => $colorisOptions->first()->idcoloris,
            "selectedTaille" => $tailleOptions->first()->idtaille,
            "equipement" => $equipement,
            "stock" => $stock,""
        ]);
        }


        public function getEquipementPhotos($idequipement, $idcoloris)
        {
            try {
                $equipement_pics = DB::table('presentation_eq')
                    ->join('media', 'presentation_eq.idpresentation', '=', 'media.idpresentation')
                    ->select('media.lienmedia')
                    ->where('presentation_eq.idequipement', $idequipement)
                    ->where('presentation_eq.idcoloris', $idcoloris)
                    ->get();

                return response()->json(['equipement_pics' => $equipement_pics]);
            } catch (\Exception $e) {
                // Log the error for debugging purposes
                \Log::error('Error fetching equipement photos: ' . $e->getMessage());

                // Return an error response
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        }


        public function getEquipementStock($idequipement, $idcoloris, $idtaille)
        {
            try {
                $stock = DB::table('stock')
                    ->where('idequipement', $idequipement)
                    ->where('idcoloris', $idcoloris)
                    ->where('idtaille', $idtaille)
                    ->value('quantite');

                return response()->json(['stock' => $stock]);
            } catch (\Exception $e) {
                // Log the error for debugging purposes
                \Log::error('Error fetching equipement stock: ' . $e->getMessage());

                // Return an error response
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        }












        public function fetchEquipmentPhotos(Request $request)
        {

            try {
                $idequipement = $request->input('idequipement');
                $idcoloris = $request->input('idcoloris');

                // Fetch images based on $idequipement and $idcoloris
                $equipement_pics = DB::table('presentation_eq')
                    ->join('media', 'presentation_eq.idpresentation', '=', 'media.idpresentation')
                    ->select('media.lienmedia')
                    ->where('presentation_eq.idequipement', $idequipement)
                    ->where('presentation_eq.idcoloris', $idcoloris)
                    ->get();

                    $html = '<div class="slider">';
                    foreach ($equipement_pics as $pic) {
                        $html .= '<img src="' . $pic->lienmedia . '">';
                    }
                    $html .= '</div>';

                return response()->json(['html' => $html]); // Return HTML content as JSON
            } catch (\Exception $e) {
                Log::error('Error fetching equipment photos' . $e->getMessage());
                return response()->json(['error' => 'Internal Server Error'], 500);
            }

                    /*
                    try {
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
                } catch (\Exception $e) {
                    Log::error('Error fetching equipment photos'. $e->getMessage());
                    return response()->json(['error' => 'Internal Server Error'], 500);
                }*/

        }
}
