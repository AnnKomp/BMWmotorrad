<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Equipement;

class PanierController extends Controller
{
    public function index(Request $request)
{
    $cart = $request->session()->get('cart', []);
    $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();

    // Retrieve coloris, taille, and quantity names based on their IDs
    foreach ($equipements as $equipement) {
        foreach ($cart[$equipement->idequipement] as &$cartItem) {
            // Check if coloris key exists
            $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';

            // Check if taille key exists
            $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';

            // Check if quantity key exists
            $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] : '';
        }
    }

    return view('panier', compact('equipements', 'cart'));
}

    private function getColorisName($colorisId)
    {
        // Retrieve coloris name based on ID
        return DB::table('coloris')->where('idcoloris', $colorisId)->value('nomcoloris');
    }

    private function getTailleName($tailleId)
    {
        // Retrieve taille name based on ID
        return DB::table('taille')->where('idtaille', $tailleId)->value('libelletaille');
    }



/*
    public function addToCart(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);

        $cartItem = [
            'quantity' => $request->input('quantity', 1),
            'coloris' => $request->input('coloris'),
            'taille' => $request->input('taille'),
        ];

        // Check if coloris is not selected, then get the first coloris option as the default
        if (empty($cartItem['coloris'])) {
            $firstColorisOption = $this->getFirstColorisOptionForEquipement($id);

            if ($firstColorisOption !== null) {
                $cartItem['coloris'] = $firstColorisOption->idcoloris;
            }
        }

        // Ensure each item in the cart is an array
        $cart[$id][] = [$cartItem];

        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Equipement ajouté');
    }
*/

    public function addToCart(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);

        $cartItem = [
            'quantity' => $request->input('quantity', 1),
            'coloris' => $request->input('coloris'),
            'taille' => $request->input('taille'),
        ];

        // Check if the item already exists in the cart with the same coloris and taille
        $existingItemIndex = $this->findCartItemIndex($cart, $id, $cartItem['coloris'], $cartItem['taille']);

        if ($existingItemIndex !== null) {
            // Update the quantity if the item with the same coloris and taille already exists
            $cart[$id][$existingItemIndex][0]['quantity'] += $cartItem['quantity'];
        } else {
            // Ensure each item in the cart is an array
            $cart[$id][] = $cartItem; // No need for an additional array here
        }

        $request->session()->put('cart', $cart);

        // You can return a response if needed
        return response()->json(['success' => true, 'message' => 'Equipement ajouté au panier']);
    }




    private function findCartItemIndex($cart, $id, $coloris, $taille)
    {
        // Find the index of the item in the cart with the same coloris and taille
        if (isset($cart[$id])) {
            foreach ($cart[$id] as $index => $item) {
                if (
                    isset($item[0]['coloris']) && $item[0]['coloris'] == $coloris
                    && isset($item[0]['taille']) && $item[0]['taille'] == $taille
                ) {
                    return $index;
                }
            }
        }

        return null;
    }


    private function getFirstColorisOptionForEquipement($equipementId)
    {
        // Retrieve the first coloris option for the equipement         MANQUE LE JOIN
        return DB::table('coloris')
            ->select('coloris.idcoloris')
            ->join('stock','stock.idcoloris','=','coloris.idcoloris')
            ->where('idequipement', $equipementId)
            //->orderBy('idcoloris')
            ->first();
    }






    public function removeItem(Request $request, $id, $index)
{
    $cart = $request->session()->get('cart', []);

    // Remove the item at the specified index
    if (isset($cart[$id][$index])) {
        unset($cart[$id][$index]);

        // If the item array is empty, remove the whole entry
        if (empty($cart[$id])) {
            unset($cart[$id]);
        }

        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Équipement retiré du panier');
    }

    return redirect()->back()->with('error', 'Équipement non trouvé dans le panier');
}

}
