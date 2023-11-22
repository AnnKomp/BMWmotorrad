<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Accessoire;

use  Illuminate\Support\Facades\DB;


class OptionController extends Controller
{
    public function index() {
        return view("optionSelection",['options'=>Option::all() ] );
    }


    public function info(Request $request) {
        $idoption = $request->input('id');

        $option = Option::where('idoption',"=", $idoption)->get();


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


    public function selectedAccessories(Request $request)
    {
        $idmoto = $request->input('id');
        $selectedOptions = $request->input('options', []);

        $accessoires=  Accessoire::where('idmoto',"=", $idmoto)->get();


        return view('accessoireSelection',[
                                    'selectedOptions'=> $selectedOptions,
                                    'idmoto' => $idmoto,
                                    'accessoires' => $accessoires ]);
    }


    public function showOptionsForm(Request $request)
    {
        $idmoto = $request->input('id');

        $options = Option::join('specifie','option.idoption','=','specifie.idoption')
                        ->where('specifie.idmoto','=',$idmoto)
                        ->get();

        return view('optionSelection', ['options' => $options],['idmoto' => $idmoto ]);
    }

    public function processOptionsForm(Request $request)
{
    $idmoto = $request->input('id');
    $selectedOptions = $request->input('options',[]);
    session(['selectedOptions' => $selectedOptions]);

    return redirect('/accessoires?id=' . $idmoto);
}


}



