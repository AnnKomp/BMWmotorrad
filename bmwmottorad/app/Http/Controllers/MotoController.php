<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Moto;
use App\Models\Pack;
use App\Models\Option;
use App\Models\Accessoire;
use App\Models\Color;
use App\Models\Gamme;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MotoController extends Controller
{
    public function index() {
        $ranges = Gamme::all();
        $motos = DB::table('modelemoto')
            ->select('*')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->whereColumn('idmediapresentation','idmedia')
            ->get();
        return view ("moto-list", ['motos'=>$motos, 'ranges'=>$ranges]);
    }

    public function detail(Request $request ) {
        $idmoto = $request->input('id');
        $moto_infos = DB::table('modelemoto')
            ->select('*')
            ->join('caracteristique','caracteristique.idmoto','=','modelemoto.idmoto')
            ->join('categoriecaracteristique', 'categoriecaracteristique.idcatcaracteristique','=','caracteristique.idcatcaracteristique')
            ->where('caracteristique.idmoto','=',$idmoto)
            ->get();
        $moto_pics = DB::table('media')
            ->select('lienmedia')
            ->where('idmoto','=',$idmoto)
            ->get();
        $moto_options = DB::table('specifie')
            ->select('*')
            ->join('option','option.idoption','=','specifie.idoption')
            ->where('specifie.idmoto','=',$idmoto)
            ->get();
        return view ("moto", ["infos" => $moto_infos, "moto_pics" => $moto_pics,"moto_options" => $moto_options, "idmoto" => $idmoto]);
    }

    public function filter(Request $request) {
        $moto_range = $request->input('id');
        $ranges = Gamme::all();
        $motos = DB::table('modelemoto')
            ->select('*')->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->whereColumn('idmediapresentation','idmedia')
            ->where('modelemoto.idgamme', '=', $moto_range)
            ->get();
        return view("moto-list-filtered", ["motos" => $motos, 'ranges'=>$ranges]);
    }

    function color(Request $request) {
        $idmoto = $request->input('idmoto');
        $idcouleur = $request->input('idcouleur');
        $typeselec = $request->input('type');
        $moto_colors = DB::table('couleur')
            ->select('*')
            ->where('idmoto', '=', $idmoto)
            ->get();
        $motos = DB::table('modelemoto')
            ->select('*')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->where('modelemoto.idmoto', '=', $idmoto)
            ->get();
        if ($typeselec != "style") {
            $source = DB::table('couleur')
                ->select('motocouleur')
                ->where('idcouleur', '=', $idcouleur)
                ->get();
        }
        else{
            $source = DB::table('style')
                ->select('*')
                ->where('idstyle', '=', $idcouleur)
                ->get();
        }
        $styles = DB::table('style')
            ->select('*')
            ->where('idmoto','=',$idmoto)
            ->get();
        return view("moto-color",["moto_colors" => $moto_colors, "idmoto" => $idmoto, "motos" => $motos, "source" => $source,"idcouleur" => $idcouleur,"styles" => $styles,"type" => $typeselec ]);
    }

    function pack(Request $request) {
        $idmoto = $request->input('id');
        $packs = Pack::select('*')->where('idmoto',"=", $idmoto)->get();
        $motos = DB::table('modelemoto')
            ->select('*')->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->whereColumn('idmediapresentation','idmedia')
            ->where('modelemoto.idmoto', '=', $idmoto)
            ->get();
        return view ("moto-pack", ['packs' => $packs, 'idmoto' => $idmoto, "motos" => $motos ]);
    }


    function showMotoConfig(Request $request) {

        $idmoto = $request->input('id');

        $selectedPacks = session('selectedPacks',[]);
        $selectedOptions = session('selectedOptions',[]);
        $selectedAccessoires = session('selectedAccessoires',[]);
        $selectedColor = session('selectedColor',[]);
        $selectedStyle = session('selectedStyle',[]);

        $moto = Moto::with(['packs','options','accessoires','couleurs','styles'])
                ->where('idmoto',$idmoto)
                ->first();


        $totalPrice = $moto->prixmoto;

        $totalPrice += $moto->packs->whereIn('idpack', $selectedPacks)->sum('prixpack');

        $totalPrice += $moto->options->whereIn('idoption', $selectedOptions)->sum('prixoption');

        $totalPrice += $moto->accessoires->whereIn('idaccessoire', $selectedAccessoires)->sum('prixaccessoire');

        $totalPrice += $moto->couleurs->whereIn('idcouleur', $selectedColor)->sum('prixcouleur');

        $totalPrice += $moto->styles->whereIn('idstyle', $selectedStyle)->sum('prixstyle');


        return view ('moto-config',
            ['selectedPacks' => $moto->packs->whereIn('idpack',$selectedPacks),
            'idmoto' => $idmoto,
            'moto' => $moto,
            'totalPrice' => $totalPrice,
            'selectedOptions' => $moto->options->whereIn('idoption',$selectedOptions),
            'selectedAccessoires' => $moto->accessoires->whereIn('idaccessoire',$selectedAccessoires),
            'selectedColor' => $moto->couleurs->whereIn('idcouleur',$selectedColor),
            'selectedStyle' => $moto->styles->whereIn('idstyle',$selectedStyle) ]);

    }


    public function showPacksForm(Request $request)
    {
        $idmoto = $request->input('id');
        $packs = Pack::where('idmoto', $idmoto)->get();

        // Assuming you have the necessary data for $motos
        $motos = DB::table('modelemoto')
        ->select('*')->join('media', 'media.idmoto','=','modelemoto.idmoto')
        ->whereColumn('idmediapresentation','idmedia')
        ->where('modelemoto.idmoto', '=', $idmoto)
        ->get();

        return view('moto-pack', ['packs' => $packs, 'idmoto' => $idmoto, 'motos' => $motos]);
    }

    public function showColorsForm(Request $request)
    {
        $idmoto = $request->input('id');
        $colors = Color::where('idmoto', $idmoto)->get();

        // Assuming you have the necessary data for $motos
        $motos = DB::table('modelemoto')
            ->select('*')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->whereColumn('idmediapresentation','idmedia')
            ->where('modelemoto.idmoto', '=', $idmoto)
            ->get();

        return view('moto-color', ['colors' => $colors, 'idmoto' => $idmoto, 'motos' => $motos]);
    }

    public function motoAdd() {
        $gammes = DB::table('gammemoto')
        ->select('*')
        ->get();
        return view ("add-moto", ['gammes'=>$gammes]);
    }

    public function addMoto(Request $request) {
        try {
            /*
        $newMotoGamme = $request->input('motoGamme');
        $newMotoName = $request->input('motoName');
        $newMotoDesc = $request->input('motoDesc');
        $newMotoPrice = $request->input('motoPrice');
        $newMediaLien = $request->input('mediaPresentation');

        DB::insert('INSERT INTO modelemoto(idgamme, nommoto, descriptifmoto, prixmoto) VALUES (?,?,?,?)' ,
        [$newMotoGamme, $newMotoName, $newMotoDesc, $newMotoPrice]);

        $idmoto = DB::getPdo()->lastInsertId();

        DB::insert('INSERT INTO media(idmoto, lienmedia) values (?,?)', [$idmoto, $newMediaLien]);

        $idmedia = DB::getPdo()->lastInsertId();

        DB::update('UPDATE MODELEMOTO SET idmediapresentation = ' .$idmedia. 'where idmoto = ' .$idmoto);
*/
            $idmoto=13;

            $catcarac = DB::table('categoriecaracteristique')
            ->select('*')
            ->get();

            return redirect()->route('showCarac', ['idmoto' => $idmoto])->with('catcarac', $catcarac);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
