<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller
{



    /**
     *  Generate a PDF of the configuration made by a user
     */
    public function generatePdf(Request $request)
    {
        $idmoto = $request->input('id');

        $selectedPacks = session('selectedPacks', []);
        $selectedOptions = session('selectedOptions', []);
        $selectedAccessoires = session('selectedAccessoires', []);
        $selectedColor = session('selectedColor',[]);
        $selectedStyle = session('selectedStyle',[]);

        $moto = Moto::with(['packs','options','accessoires'])
                ->where('idmoto',$idmoto)
                ->first();


        $totalPrice = $moto->prixmoto;

        $totalPrice += $moto->packs->whereIn('idpack', $selectedPacks)->sum('prixpack');

        $totalPrice += $moto->options->whereIn('idoption', $selectedOptions)->sum('prixoption');

        $totalPrice += $moto->accessoires->whereIn('idaccessoire', $selectedAccessoires)->sum('prixaccessoire');

        $totalPrice += $moto->couleurs->whereIn('idcouleur', $selectedColor)->sum('prixcouleur');

        $totalPrice += $moto->styles->whereIn('idstyle', $selectedStyle)->sum('prixstyle');



        $pdf = PDF::loadView('pdf.moto-config',  [
            'selectedPacks' => $moto->packs->whereIn('idpack',$selectedPacks),
            'idmoto' => $idmoto,
            'moto' => $moto,
            'totalPrice' => $totalPrice,
            'selectedOptions' => $moto->options->whereIn('idoption',$selectedOptions),
            'selectedAccessoires' => $moto->accessoires->whereIn('idaccessoire',$selectedAccessoires),
            'selectedColor' => $moto->couleurs->whereIn('idcouleur',$selectedColor),
            'selectedStyle' => $moto->styles->whereIn('idstyle',$selectedStyle) ]);


        return $pdf->download('moto_config.pdf');
    }

}
