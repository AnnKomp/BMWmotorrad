<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $selectedOptions = $request->input('options', []);
        $selectedPacks = $request->input('packs', []);
        $selectedAccessoires = $request->input('accessoires', []);

        $options = app(OptionController::class)->getOptions($selectedOptions);
        $packs = app(PackController::class)->getPacks($selectedPacks);
        $accessoires = app(AccessoireController::class)->getAccessoires($selectedAccessoires);

        $pdf = PDF::loadView('pdf.moto_config', compact('options', 'packs', 'accessoires'));

        return $pdf->download('moto_config.pdf');
    }
}
