<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Moto;
use App\Models\Pack;
use App\Models\Option;
use App\Models\Accessoire;
use App\Models\Color;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MotoController extends Controller
{
    public function index() {
        $ranges = DB::table('modelemoto')
            ->select('*')
            ->join('gammemoto','modelemoto.idgamme','=','gammemoto.idgamme')
            ->get();
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
        $ranges = DB::table('modelemoto')
            ->select('*')->join('gammemoto','modelemoto.idgamme','=','gammemoto.idgamme')
            ->get();
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
        $moto_colors = DB::table('couleur')
            ->select('*')
            ->where('idmoto', '=', $idmoto)
            ->get();
        $motos = DB::table('modelemoto')
            ->select('*')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->where('modelemoto.idmoto', '=', $idmoto)
            ->get();
        $source = DB::table('couleur')
            ->select('motocouleur')
            ->where('idcouleur', '=', $idcouleur)
            ->get();
        return view("moto-color",["moto_colors" => $moto_colors, "idmoto" => $idmoto, "motos" => $motos, "source" => $source,"idcouleur" => $idcouleur]);
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


    //inutile?
    // function config(Request $request) {
    //     $idmoto = $request->input('id');

    //     $moto_pic = DB::table('media')
    //     ->select('*')
    //     ->where('idmoto','=',$idmoto)
    //     ->get();

    //     $packs = Pack::all();
    //     $options = Option::all();
    //     $accessoires = Accessoire::all();

    //     return view ("moto-config", ['packs' => $packs, 'moto'=> $moto_pic, 'idmoto' => $idmoto, "options" => $options, "accessoires" => $accessoires ]);

    // }

/*

    public function downloadPDF(Request $request)
    {
        $idmoto = $request->input('id');

        $selectedPacks = session('selectedPacks', []);
        $selectedOptions = session('selectedOptions', []);
        $selectedAccessoires = session('selectedAccessoires', []);

        $moto = Moto::with(['packs', 'options', 'accessoires'])
            ->where('idmoto', $idmoto)
            ->first();

        PDF::setOptions([
            "defaultFont" => "Courier",
            "defaultPaperSize" => "a4",
            "dpi" => 130
         ]);

        $pdf = PDF::loadView('pdf.moto-config', [
            'selectedPacks' => $moto->packs->whereIn('idpack', $selectedPacks),
            'idmoto' => $idmoto,
            'selectedOptions' => $moto->options->whereIn('idoption', $selectedOptions),
            'selectedAccessoires' => $moto->accessoires->whereIn('idaccessoire', $selectedAccessoires),
        ]);

        return $pdf->download('moto-config.pdf');
    }
*/

    function showMotoConfig(Request $request) {

        $idmoto = $request->input('id');

        $selectedPacks = session('selectedPacks',[]);
        $selectedOptions = session('selectedOptions',[]);
        $selectedAccessoires = session('selectedAccessoires',[]);
        $selectedColor = session('selectedColor',[]);

        $moto = Moto::with(['packs','options','accessoires','couleurs'])
                ->where('idmoto',$idmoto)
                ->first();


        $totalPrice = $moto->prixmoto;

        $totalPrice += $moto->packs->whereIn('idpack', $selectedPacks)->sum('prixpack');

        $totalPrice += $moto->options->whereIn('idoption', $selectedOptions)->sum('prixoption');

        $totalPrice += $moto->accessoires->whereIn('idaccessoire', $selectedAccessoires)->sum('prixaccessoire');

        $totalPrice += $moto->couleurs->whereIn('idcouleur', $selectedColor)->sum('prixcouleur');



        //dd($selectedPacks, $selectedOptions, $selectedAccessoires);

        return view ('moto-config',
            ['selectedPacks' => $moto->packs->whereIn('idpack',$selectedPacks),
            'idmoto' => $idmoto,
            'moto' => $moto,
            'totalPrice' => $totalPrice,
            'selectedOptions' => $moto->options->whereIn('idoption',$selectedOptions),
            'selectedAccessoires' => $moto->accessoires->whereIn('idaccessoire',$selectedAccessoires),
            'selectedColor' => $moto->couleurs->whereIn('idcouleur',$selectedColor) ]);

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
        ->select('*')->join('media', 'media.idmoto','=','modelemoto.idmoto')
        ->whereColumn('idmediapresentation','idmedia')
        ->where('modelemoto.idmoto', '=', $idmoto)
        ->get();

        return view('moto-color', ['colors' => $colors, 'idmoto' => $idmoto, 'motos' => $motos]);
    }



}
