<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Taille;
use App\Models\Stock;
use App\Models\Coloris;
use App\Models\Equipement;
use App\Models\CategorieEquipement;
use App\Models\Collection;
use Illuminate\Support\Facades\Log;

class EquipementController extends Controller
{

    /**
     * Display the list of all equipements based on the search and filter criteria
     */
    public function index(Request $request)
    {
        // Retrieve search and filter parameters from the request
        $query = $request->input('search');
        $categories = CategorieEquipement::all();
        $collections = Collection::all();
        $categoryId = $request->input('category');
        $collectionId = $request->input('collection');
        $sex = $request->input('sex');
        $tendencies = $request->has('tendencies');
        $priceOrder = request('price') === 'asc' ? 'asc' : 'desc';
        $segment = $request->input('segment');
        $prix_min = $request->input('Min');
        $prix_max = $request->input('Max');

        // Build the equipement query with various conditions according to the filters
        $equipements = DB::table('equipement')
            ->select(
                'equipement.*',
                DB::raw('(SELECT media.lienmedia FROM media
                            WHERE media.idequipement = equipement.idequipement
                            ORDER BY media.idpresentation
                            LIMIT 1) as lienmedia'),
                'categorieequipement.*',
                DB::raw('COALESCE(SUM(stock.quantite), 0) as totalQuantite')
            )
            ->leftJoin('categorieequipement', 'equipement.idcatequipement', '=', 'categorieequipement.idcatequipement')
            ->leftJoin('stock', 'stock.idequipement', '=', 'equipement.idequipement')
            ->leftJoin('collection', 'collection.idcollection', '=', 'equipement.idcollection')
            ->leftJoin('presentation_eq', 'presentation_eq.idequipement', '=', 'equipement.idequipement')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where("nomequipement", 'ilike', '%' . $query . '%')
                    ->orWhere("descriptionequipement", 'ilike', '%' . $query . '%');
            })
            ->when($categoryId, function ($queryBuilder) use ($categoryId) {
                $queryBuilder->where('equipement.idcatequipement', $categoryId);
            })
            ->when($collectionId, function ($queryBuilder) use ($collectionId) {
                $queryBuilder->where('equipement.idcollection', $collectionId);
            })
            ->when($sex, function ($queryBuilder) use ($sex) {
                $queryBuilder->where('equipement.sexeequipement', $sex);
            })
            ->when($segment, function ($queryBuilder) use ($segment) {
                $queryBuilder->where('equipement.segment', $segment);
            })
            ->when(request('tendencies'), function ($queryBuilder) {
                $queryBuilder->where('equipement.tendance', true);
            })
            ->when(request('price'), function ($queryBuilder) use ($priceOrder) {
                $queryBuilder->orderBy('prixequipement', $priceOrder);
            })
            ->when($prix_min, function ($queryBuilder) use ($prix_min) {
                $queryBuilder->where('prixequipement', '>=', $prix_min);
            })
            ->when($prix_max, function ($queryBuilder) use ($prix_max) {
                $queryBuilder->where('prixequipement', '<=', $prix_max);
            })
            ->groupBy('equipement.idequipement', 'categorieequipement.idcatequipement')
            ->distinct()
            ->get();

        // Return the equipement list view with relevant data
        return view("equipement-list", [
            'equipements' => $equipements,
            'categories' => $categories,
            'collections' => $collections
        ]);
    }

    /**
     * Display the details of a specific equipement.
     */
    public function detail(Request $request)
    {
        // Retrieve equipement and coloris information from the request
        $idequipement = $request->input('id');
        $idcoloris = $request->input('idcoloris');

        // Get equipement details
        $equipement = Equipement::select('*')
                ->where('idequipement', $idequipement)
                ->first();

        // Get coloris and taille IDs associated with the equipement
        $colorisIds = Stock::select('idcoloris')
            ->where('idequipement', $idequipement)
            ->pluck('idcoloris')
            ->toArray();

        $tailleIds = Stock::select('idtaille')
            ->where('idequipement', $idequipement)
            ->pluck('idtaille')
            ->toArray();

        // Get coloris and taille options based on IDs
        $colorisOptions = Coloris::select('idcoloris', 'nomcoloris')
            ->whereIn('idcoloris', $colorisIds)
            ->get();

        $tailleOptions = Taille::select('idtaille', 'libelletaille')
            ->whereIn('idtaille', $tailleIds)
            ->get();

        // Set the default coloris if not provided
        if ($idcoloris == null)
            $idcoloris = !empty($colorisIds) ? $colorisIds[0] : null;

        // Get equipement pictures, stock, and other relevant data
        $equipement_pics = $this->getEquipementPhotosData($idequipement, $idcoloris);
        $stock = $this->getEquipementStockData($idequipement, $idcoloris, $tailleOptions->first()->idtaille, $tailleOptions);

        // Return the equipement details view with necessary data
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
            "stock" => $stock,
        ]);
    }

    /**
     * Get the photos of an equipement and coloris.
     */
    public function getEquipementPhotos($idequipement, $idcoloris)
    {
        try {
            $equipement_pics = $this->getEquipementPhotosData($idequipement, $idcoloris);
            return response()->json(['equipement_pics' => $equipement_pics]);
        } catch (\Exception $e) {
            \Log::error('Error fetching equipement photos: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Retrieve equipement photos data.
     */
    private function getEquipementPhotosData($idequipement, $idcoloris)
    {
        return DB::table('presentation_eq')
            ->join('media', 'presentation_eq.idpresentation', '=', 'media.idpresentation')
            ->select('media.lienmedia')
            ->where('presentation_eq.idequipement', $idequipement)
            ->where('presentation_eq.idcoloris', $idcoloris)
            ->get();
    }

    /**
     * Get the stock of the equipement.
     */
    public function getEquipementStock($idequipement, $idcoloris, $idtaille)
    {
        try {
            $tailleOptions = Taille::select('idtaille', 'libelletaille')
                ->where('idtaille', $idtaille)
                ->get();

            $stock = $this->getEquipementStockData($idequipement, $idcoloris, $idtaille, $tailleOptions);
            return response()->json(['stock' => $stock]);
        } catch (\Exception $e) {
            \Log::error('Error fetching equipement stock: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Retrieve equipement stock data.
     */
    private function getEquipementStockData($idequipement, $idcoloris, $idtaille, $tailleOptions)
    {
        return Stock::where('idequipement', $idequipement)
            ->where('idcoloris', $idcoloris)
            ->where('idtaille', $idtaille)
            ->value('quantite');
    }

    /**
     * Fetch equipment photos for a specific equipement and coloris.
     */
    public function fetchEquipmentPhotos(Request $request)
    {
        try {
            $idequipement = $request->input('idequipement');
            $idcoloris = $request->input('idcoloris');

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

            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            Log::error('Error fetching equipment photos' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
