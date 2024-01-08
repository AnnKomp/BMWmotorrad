<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accessoire;
use App\Models\CategorieAccessoire;
use Illuminate\Support\Facades\DB;

class AccessoireController extends Controller
{

    //function to show the view for the accessory
    public function info(Request $request) {
        $idaccessoire = $request->input('id');

        $accessoire = Accessoire::where('idaccessoire',"=", $idaccessoire)->get();

        $idmoto = $request->input('idmoto');
        return view("accessoire",['accessoires'=>$accessoire, "idmoto" => $idmoto ] );
    }


    // function to get information for all selected accessories from the DB
    public function getAccessoires($selectedAccessoires)
    {
        return Accessoire::whereIn('idaccessoire', $selectedAccessoires)->get();
    }

    // show the configurated moto after the accessory selection
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

    //show the selection of accessories for the moto
    public function showAccessoiresForm(Request $request)
    {
        $idmoto = $request->input('id');

        $accessoires=  Accessoire::where('idmoto',"=", $idmoto)->get();

        return view('accessoireSelection', ['accessoires' => $accessoires],['idmoto' => $idmoto ]);
    }

    // add the selected accessoires into the session variable and redirect into configurated moto view
    public function processAccessoiresForm(Request $request)
    {

        $idmoto = $request->input('id');

        $selectedAccessoires = $request->input('accessoires',[]);
        session(['selectedAccessoires' => $selectedAccessoires]);

        return redirect('/moto-config?id=' . $idmoto);
    }


    // show the view for adding a new accessory
    public function showAddingAcc(Request $request)
    {
        $idmoto = $request->input('idmoto');
        $catacc = CategorieAccessoire::All();

        return view('add-accessoire', ['idmoto' => $idmoto, 'catacc' => $catacc]);
    }

    // Function to insert the new accessory into the DB
    public function addAcc(Request $request)
    {
        try {
            //retrieve the data
            $idmoto = $request->input('idmoto');
            $newAccCat = $request->input('accCat');
            $newAccName = $request->input('accName');
            $newAccPrice = $request->input('accPrice');
            $newAccDetail = $request->input('accDetail');
            $newAccPhoto = $request->input('accPhoto');


            $action = $request->input('action');

            $catacc = CategorieAccessoire::All();

            //insert the new accessory into the DB
            DB::insert('INSERT INTO accessoire(idmoto, idcatacc, nomaccessoire, prixaccessoire, detailaccessoire, photoaccessoire)
                VALUES (?,?,?,?,?,?)',
                [$idmoto, $newAccCat, $newAccName, $newAccPrice, $newAccDetail, $newAccPhoto]);

            //different redirect for different button
            if ($action === 'proceedAgain') {
                return redirect()->route('showAcc', ['idmoto' => $idmoto])->with('catacc', $catacc);
            } elseif ($action === 'next') {
                return redirect()->route('showMotoCommercial', ['id' => $idmoto]);
            } else {
                return redirect()->route('startPage');
            }

        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
            }
        }



}
