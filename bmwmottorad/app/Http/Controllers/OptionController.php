<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;

use  Illuminate\Support\Facades\DB;


class OptionController extends Controller
{
    public function index() {
        return view("optionSelection",['options'=>Option::all() ] );
    }


    public function info(Request $request) {
        $idopion = $request->input('id');

        $option = Option::where('idoption',"=", $idopion)->get();


        return view("option",['options'=>$option ] );
    }

    public function optionSelection(Request $request){

        $idmoto = $request->input('id');

        $options = Option::join('specifie','option.idoption','=','specifie.idoption')
                        ->where('specifie.idmoto','=',$idmoto)
                        ->get();


        return view ("optionSelection", ['options' => $options],['idmoto' => $idmoto ]);
    }

    public function save(Request $request)
    {

        return redirect()->back();
    } 


    public function getOptions($selectedOptions)
    {
        return Option::whereIn('idoption', $selectedOptions)->get();
    }



}



