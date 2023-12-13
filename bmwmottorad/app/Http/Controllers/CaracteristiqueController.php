<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaracteristiqueController extends Controller
{

    public function showAddingCarac(Request $request)
    {
        $idmoto = $request->input('idmoto');
        $catcarac = $request->session()->get('catcarac'); // Change this line to the following

        return view('add-caracteristique', ['idmoto' => $idmoto, 'catcarac' => $catcarac]);
    }

    public function addCarac(Request $request)
    {
        try {
            $idmoto = $request->input('idmoto');
            $newCarCat = $request->input('carCat');
            $newCarName = $request->input('carName');
            $newCarVal = $request->input('carVal');
            $action = $request->input('action');

            $catcarac = DB::table('categoriecaracteristique')
                ->select('*')
                ->get();

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
