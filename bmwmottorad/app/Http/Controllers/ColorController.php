<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function processColorsForm(Request $request)
    {

        $idmoto = $request->input('id');

        $selectedColor = $request->input('color',[]);
        session(['selectedColor' => $selectedColor]);
        return redirect('/moto/pack?id=' . $idmoto);
    }
}
