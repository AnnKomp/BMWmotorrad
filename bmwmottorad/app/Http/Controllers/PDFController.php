<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller
{

    public function processOptions(Request $request)
    {
        // Process options and move to the next step
        // ...

        return redirect('pack-selection');
    }

    public function processPacks(Request $request)
    {
        // Process packs and move to the next step
        // ...

        return redirect('accessoire-selection');
    }

    public function processAccessoires(Request $request)
    {
        // Process accessoires and move to the next step
        // ...

        return redirect('moto-config');
    }

    public function showMotoConfig(Request $request)
    {
        //$options = // Retrieve options data;
        //$packs = // Retrieve packs data;
        //$accessoires = // Retrieve accessoires data

        return view('moto_config', compact('options', 'packs', 'accessoires'));
    }


    public function generatePdf(Request $request)
    {
        $idmoto = $request->input('id');

        $moto = Moto::with(['packs','options','accessoires'])
                ->where('idmoto',$idmoto)
                ->first();


        $selectedPacks = session('selectedPacks', []);
        $selectedOptions = session('selectedOptions', []);
        $selectedAccessoires = session('selectedAccessoires', []);


        $pdf = PDF::loadView('pdf.moto-config',  ['selectedPacks' => $moto->packs->whereIn('idpack',$selectedPacks),
        'idmoto' => $idmoto,
        'selectedOptions' => $moto->options->whereIn('idoption',$selectedOptions),
        'selectedAccessoires' => $moto->accessoires->whereIn('idaccessoire',$selectedAccessoires) ]);


        return $pdf->download('moto_config.pdf');
    }
}
