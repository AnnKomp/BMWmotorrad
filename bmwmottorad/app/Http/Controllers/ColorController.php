<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Save the selected color/style for a motorcycle and proceed to packs selection.
     */
    public function processColorsForm(Request $request): RedirectResponse
    {
        // Retrieving data
        $idmoto = $request->input('id');
        $selectedOption = $request->input('option', []);

        $firstOption = $selectedOption[0];

        // Differentiate between style and color
        if (strpos($firstOption, 'color_') === 0) {
            $index = substr($firstOption, strlen('color_'));
            session(['selectedColor' => $index]);
            session()->forget('selectedStyle');
        } elseif (strpos($firstOption, 'style_') === 0) {
            $index = substr($firstOption, strlen('style_'));
            session(['selectedStyle' => $index]);
            session()->forget('selectedColor');
        }

        return redirect('/moto/pack?id=' . $idmoto);
    }
}
