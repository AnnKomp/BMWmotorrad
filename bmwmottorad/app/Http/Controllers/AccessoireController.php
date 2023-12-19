<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accessoire;
use Illuminate\Support\Facades\DB;

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

        $idmoto = $request->input('idmoto');
        return view("accessoire",['accessoires'=>$accessoire, "idmoto" => $idmoto ] );
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

        return view('accessoireSelection', ['accessoires' => $accessoires],['idmoto' => $idmoto ]);
    }

    public function processAccessoiresForm(Request $request)
    {

        $idmoto = $request->input('id');


        $selectedAccessoires = $request->input('accessoires',[]);
        session(['selectedAccessoires' => $selectedAccessoires]);



        return redirect('/moto-config?id=' . $idmoto);
    }





    public function showAddingAcc(Request $request)
    {
        $idmoto = $request->input('idmoto');
        $catacc = DB::table('categorieaccessoire')
                ->select('*')
                ->get();

        return view('add-accessoire', ['idmoto' => $idmoto, 'catacc' => $catacc]);
    }

    public function addAcc(Request $request)
    {
        try {
            $idmoto = $request->input('idmoto');
            $newAccCat = $request->input('accCat');
            $newAccName = $request->input('accName');
            $newAccPrice = $request->input('accPrice');
            $newAccDetail = $request->input('accDetail');
            $newAccPhoto = $request->input('accPhoto');


            $action = $request->input('action');

            $catacc = DB::table('categorieaccessoire')
                ->select('*')
                ->get();

            DB::insert('INSERT INTO accessoire(idmoto, idcatacc, nomaccessoire, prixaccessoire, detailaccessoire, photoaccessoire)
                VALUES (?,?,?,?,?,?)',
                [$idmoto, $newAccCat, $newAccName, $newAccPrice, $newAccDetail, $newAccPhoto]);

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
