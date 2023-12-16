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


    public function showMotoCommercial($idmoto)
    {
        // Retrieve moto details, caracteristiques, options, and accessoires based on $idmoto
        $motoDetails = DB::table('modelemoto')->where('idmoto', $idmoto)->first();

        $caracteristiques = DB::table('caracteristique as c')
            ->join('categoriecaracteristique as cc', 'c.idcatcaracteristique', '=', 'cc.idcatcaracteristique')
            ->where('c.idmoto', $idmoto)
            ->select('cc.nomcatcaracteristique', 'c.nomcaracteristique', 'c.valeurcaracteristique', 'c.idcaracteristique', 'c.idmoto')
            ->get();

        $options = DB::table('option as o')
            ->join('specifie as s', 'o.idoption', '=', 's.idoption')
            ->where('s.idmoto', $idmoto)
            ->select('o.*', 's.idoption', 's.idmoto')
            ->get();

        $accessoires = DB::table('accessoire')
            ->where('idmoto', $idmoto)
            ->get();

        return view('moto-commercial', [
            'motoName' => $motoDetails->nommoto,
            'caracteristiques' => $caracteristiques,
            'options' => $options,
            'accessoires' => $accessoires,
        ]);
    }




    public function showEditCaracteristique($idmoto, $idcaracteristique)
    {
        // Retrieve the selected caracteristique and its category
        $caracteristique = DB::table('caracteristique')
            ->where('idmoto', $idmoto)
            ->where('idcaracteristique', $idcaracteristique)
            ->first();

        $selectedCatId = $caracteristique->idcatcaracteristique;

        // Retrieve all categories for the dropdown
        $catcarac = DB::table('categoriecaracteristique')
            ->select('*')
            ->get();

        return view('caracteristique', [
            'idmoto' => $idmoto,
            'idcaracteristique' => $idcaracteristique,
            'catcarac' => $catcarac,
            'selectedCatId' => $selectedCatId,
            'caracteristique' => $caracteristique,
        ]);
    }

    public function updateCaracteristique(Request $request, $idmoto, $idcaracteristique)
    {
        try {
            $newCatId = $request->input('carCat');
            $newCarName = $request->input('carName');
            $newCarValue = $request->input('carValue');

            // Update the caracteristique
            DB::table('caracteristique')
                ->where('idmoto', $idmoto)
                ->where('idcaracteristique', $idcaracteristique)
                ->update([
                    'idcatcaracteristique' => $newCatId,
                    'nomcaracteristique' => $newCarName,
                    'valeurcaracteristique' => $newCarValue,
                ]);

            return redirect()->route('showMotoCommercial', ['idmoto' => $idmoto]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

        public function showEditOption($idmoto, $idoption)
    {
        // Retrieve the selected option
        $option = DB::table('option as o')
            ->join('specifie as s', 'o.idoption', '=', 's.idoption')
            ->where('s.idmoto', $idmoto)
            ->where('s.idoption', $idoption)
            ->first();


        return view('option-update', [
            'idmoto' => $idmoto,
            'idoption' => $idoption,
            'option' => $option,
        ]);
    }

    public function updateOption(Request $request, $idmoto, $idoption)
    {
        try {
            $newOptName = $request->input('optName');
            $newOptPrice = $request->input('optPrice');
            $newOptDetail = $request->input('optDetail');
            $newOptPhoto = $request->input('optPhoto');

            // Update the option
            DB::table('option as o')
                ->join('specifie as s', 'o.idoption', '=', 's.idoption')
                ->where('idmoto', $idmoto)
                ->where('s.idoption', $idoption)
                ->update([
                    'nomoption' => $newOptName,
                    'prixoption' => $newOptPrice,
                    'detailoption' => $newOptDetail,
                    'photooption' => $newOptPhoto,
                ]);

            return redirect()->route('showMotoCommercial', ['idmoto' => $idmoto]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



        public function showEditAccessoire($idmoto, $idaccessoire)
    {
        // Retrieve the selected accessoire
        $accessoire = DB::table('accessoire')
            ->where('idmoto', $idmoto)
            ->where('idaccessoire', $idaccessoire)
            ->first();

        return view('accessoire-update', [
            'idmoto' => $idmoto,
            'idaccessoire' => $idaccessoire,
            'accessoire' => $accessoire,
        ]);
    }

    public function updateAccessoire(Request $request, $idmoto, $idaccessoire)
    {
        try {
            $newAccName = $request->input('accName');
            $newAccPrice = $request->input('accPrice');
            $newAccDetail = $request->input('accDetail');
            $newAccPhoto = $request->input('accPhoto');

            // Update the accessoire
            DB::table('accessoire')
                ->where('idmoto', $idmoto)
                ->where('idaccessoire', $idaccessoire)
                ->update([
                    'nomaccessoire' => $newAccName,
                    'prixaccessoire' => $newAccPrice,
                    'detailaccessoire' => $newAccDetail,
                    'photoaccessoire' => $newAccPhoto,
                ]);

            return redirect()->route('showMotoCommercial', ['idmoto' => $idmoto]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}
