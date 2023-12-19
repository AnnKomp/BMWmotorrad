<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pack;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class PackController extends Controller
{

    public function info(Request $request) {
        $idpack = $request->input('id');

        $idmoto = Pack::select('idmoto')->where('idpack', $idpack)->first();
        $idmotoValue = $idmoto ? $idmoto->idmoto : null;

        $pack = Pack::where('idpack','=',$idpack)->get();


        session(['lastUsedView' => 'pack']);

        $options = Option::join('secompose','option.idoption','=','secompose.idoption')
                                ->where('secompose.idpack',"=", $idpack)->get();


        return view("pack",['options'=>$options,'pack'=>$pack, 'idmoto'=>$idmotoValue, 'idpack' => $idpack]);
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


/// inutile?
    // public function selectedOptions(Request $request)
    // {
    //     $idmoto = $request->input('id');

    //     $selectedPacks = $request->input('packs',[]);

    //     $options = Option::join('specifie','option.idoption','=','specifie.idoption')
    //                     ->where('specifie.idmoto','=',$idmoto)
    //                     ->get();


    //     return view('optionSelection', ['selectedPacks'=> $selectedPacks,
    //                                     'idmoto'=>$idmoto,
    //                                     'options'=>$options]);
    // }


    public function showPacksForm(Request $request)
    {
        $idmoto = $request->input('id');

        $packs = Pack::select('*')->where('idmoto',"=", $idmoto)->get();

        return view('moto-pack', ['packs' => $packs,'idmoto' => $idmoto ]);
    }

    public function processPacksForm(Request $request)
    {

        $idmoto = $request->input('id');

        $selectedPacks = $request->input('packs',[]);
        session(['selectedPacks' => $selectedPacks]);
        return redirect('/options?id=' . $idmoto);
    }

    public function showAddingPack(Request $request)
    {
        $idmoto = $request->input('idmoto');

        return view('add-pack', ['idmoto' => $idmoto]);
    }

    public function addPack(Request $request)
    {
        try{
        $idmoto = $request->input('idmoto');

        $pack = new Pack([
            'idmoto' => $idmoto,
            'nompack' => $request->input('nompack'),
            'descriptionpack' => $request->input('descriptionpack'),
            'photopack' => $request->input('photopack'),
            'prixpack' => $request->input('prixpack'),
        ]);

        $pack->save();

        return redirect()->route('update.result',['result' => 'negative']);
    }
    catch (\Exception $e) {
        return redirect()->route('update.result', ['result' => 'pack-nom']);
    }}

}
