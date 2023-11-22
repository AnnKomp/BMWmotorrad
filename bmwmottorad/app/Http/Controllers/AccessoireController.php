<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accessoire;

class AccessoireController extends Controller
{

    //faire en sorte qu'il prenne que les accessoires d'une moto précisé (pas All ?)
    public function index() {
        return view("accessoireSelection",['accessoires'=>Accessoire::all() ] );
    }


    //faire en sorte qu'il prenne que les trucs d'un acc précisé
    public function info(Request $request) {
        $idaccessoire = $request->input('id');

        $accessoire = Accessoire::where('idaccessoire',"=", $idaccessoire)->get();

        return view("accessoire",['accessoires'=>$accessoire ] );
    }

    public function store(Request $request){
        $idmoto = $request->input('id');

        $accessoires=  Accessoire::where('idmoto',"=", $idmoto)->get();

        return view ("accessoireSelection", ['accessoires' => $accessoires],['idmoto' => $idmoto ]);
    }


    public function detail (Request $request) {
        $idmoto = $request->input('id');

       /// $accessories = DB:table('accessoire');

        return view ("accessoireSelection", ['accessoires' => Accessoire::all() ]);
    }

    public function getAccessoires($selectedAccessoires)
    {
        return Accessoire::whereIn('idaccessoire', $selectedAccessoires)->get();
    }

    public function displayMotoConfig(Request $request)
    {

        $idmoto = $request->input('id');
        $selectedAccessories = $request->input('selectedPacks',[]);

        return view('moto-config', [
            'selectedPacks'=> $request->input('selectedPacks',[]),
            'selectedOptions'=> $request->input('selectedOptions', []),
            'selectedAccessories'=> $selectedAccessories,
            'idmoto' => $idmoto
        ]);

    }


    public function showAccessoiresForm(Request $request)
    {
        $idmoto = $request->input('id');


        $accessoires=  Accessoire::where('idmoto',"=", $idmoto)->get();

        return view('accessoires', ['accessoires' => $accessoires],['idmoto' => $idmoto ]);
    }

    public function processAccessoiresForm(Request $request)
    {

        $idmoto = $request->input('id');


        $selectedAccessoires = $request->input('accessoires',[]);
        session(['selectedPacks' => $selectedAccessoires]);



        return redirect('/moto-config?id=' . $idmoto);
    }


}
