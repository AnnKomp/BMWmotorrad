<?php

namespace App\Http\Controllers;

use App\Models\CategorieCaracteristique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaracteristiqueController extends Controller
{

    // Function to show the add caracteristic for a moto form
    public function showAddingCarac(Request $request)
{
    $idmoto = $request->input('idmoto');
    $catcarac = CategorieCaracteristique::all();

    return view('add-caracteristique', ['idmoto' => $idmoto, 'catcarac' => $catcarac]);
}

    // Function to proceed the insertion of the caracteristic into the DB
    public function addCarac(Request $request)
    {
        try {
            //retrieving data
            $idmoto = $request->input('idmoto');
            $newCarCat = $request->input('carCat');
            $newCarName = $request->input('carName');
            $newCarVal = $request->input('carVal');
            $action = $request->input('action');

            $catcarac = CategorieCaracteristique::all();


            //insertion
            DB::insert('INSERT INTO caracteristique(idmoto, idcatcaracteristique, nomcaracteristique, valeurcaracteristique)
                VALUES (?,?,?,?)',
                [$idmoto, $newCarCat, $newCarName, $newCarVal]);


            if ($action === 'proceedAgain') {
                return redirect()->route('showCarac', ['idmoto' => $idmoto])->with('catcarac', $catcarac);

            } elseif ($action === 'next') {
                return redirect()->route('showOption', ['idmoto' => $idmoto]);
            } else {
                return redirect()->route('startPage');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
