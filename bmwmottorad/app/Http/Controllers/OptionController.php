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
        $idmoto = $request->input('idmoto');
        $idpack = $request->input('idpack');

        $route = $request->input('route');

        $option = Option::where('idoption', $idoption)->get();

        return view("option", ['options' => $option, 'idmoto' => $idmoto, 'idpack' => $idpack, 'route'=> $route ] );
    }

    public function optionSelection(Request $request){

        $idmoto = $request->input('id');

        $options = Option::join('specifie','option.idoption','=','specifie.idoption')
                        ->where('specifie.idmoto','=',$idmoto)
                        ->get();

        return view ("optionSelection", ['options' => $options,'idmoto' => $idmoto ]);
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



    public function showAddingOptions(Request $request)
    {
    $idmoto = $request->input('idmoto');

    $exOptions = Option::select('*')
    ->get();

    return view('add-option', ['idmoto' => $idmoto, 'exOptions' => $exOptions]);
    }


    public function addOption(Request $request)
    {
        try {
            $idmoto = $request->input('idmoto');
            $action = $request->input('action');

            if ($action === 'restart' || $action === 'proceedToAccessories') {
                $idoption = null;

                if ($request->has('newOptionName')) {
                    // Adding a new option
                    $newOptionName = $request->input('newOptionName');
                    $newOptionPrice = $request->input('newOptionPrice');
                    $newOptionDetail = $request->input('newOptionDetail');
                    $newOptionPhotoUrl = $request->input('newOptionPhotoUrl');

                    // Insert into the 'option' table
                    /*$idoption = DB::table('option')->insertGetId([
                        'nomoption' => $newOptionName,
                        'prixoption' => $newOptionPrice,
                        'detailoption' => $newOptionDetail,
                        'photooption' => $newOptionPhotoUrl,
                    ]);*/

                    DB::insert('INSERT INTO option(nomoption, prixoption,detailoption,photooption) values (?,?,?,?)',
                     [$newOptionName, $newOptionPrice, $newOptionDetail, $newOptionPhotoUrl]);


                    $idoption = DB::getPdo()->lastInsertId();



                } elseif ($request->has('existingOption')) {
                    // Adding an existing option
                    $idoption = $request->input('existingOption');
                }

                // Insert into the 'specifie' table
                DB::table('specifie')->insert([
                    'idmoto' => $idmoto,
                    'idoption' => $idoption,
                ]);

                if ($action === 'restart') {

                    return redirect()->route('showOption', ['idmoto' => $idmoto]);

                } elseif ($action === 'proceedToAccessories') {
                    // Redirect to the accessories view or add logic as needed
                    return redirect()->route('showAcc', ['idmoto' => $idmoto]);
                }
            } else {
                return redirect()->route('startPage');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




}



