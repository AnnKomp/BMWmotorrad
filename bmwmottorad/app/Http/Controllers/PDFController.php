<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller
{



    public function generatePdf(Request $request)
    {
        $idmoto = $request->input('id');

        $selectedPacks = session('selectedPacks', []);
        $selectedOptions = session('selectedOptions', []);
        $selectedAccessoires = session('selectedAccessoires', []);
        $selectedColor = session('selectedColor',[]);

        $moto = Moto::with(['packs','options','accessoires'])
                ->where('idmoto',$idmoto)
                ->first();


        $totalPrice = $moto->prixmoto;

        $totalPrice += $moto->packs->whereIn('idpack', $selectedPacks)->sum('prixpack');

        $totalPrice += $moto->options->whereIn('idoption', $selectedOptions)->sum('prixoption');

        $totalPrice += $moto->accessoires->whereIn('idaccessoire', $selectedAccessoires)->sum('prixaccessoire');

        $totalPrice += $moto->couleurs->whereIn('idcouleur', $selectedColor)->sum('prixcouleur');



        $pdf = PDF::loadView('pdf.moto-config',  [
            'selectedPacks' => $moto->packs->whereIn('idpack',$selectedPacks),
            'idmoto' => $idmoto,
            'moto' => $moto,
            'totalPrice' => $totalPrice,
            'selectedOptions' => $moto->options->whereIn('idoption',$selectedOptions),
            'selectedAccessoires' => $moto->accessoires->whereIn('idaccessoire',$selectedAccessoires),
            'selectedColor' => $moto->couleurs->whereIn('idcouleur',$selectedColor) ]);


        return $pdf->download('moto_config.pdf');
    }
}
