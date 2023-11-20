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
        return view ("accessoireSelection", ['accessoires' => Accessoire::all()],['idmoto' => $idmoto ]);
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




}
