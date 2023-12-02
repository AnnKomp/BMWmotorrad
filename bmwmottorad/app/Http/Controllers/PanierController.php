<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipement;

class PanierController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();

        return view('panier', compact('equipements', 'cart'));
    }




    public function addToCart(Request $request, $id)
{
    $cart = $request->session()->get('cart', []);

    $cartItem = [
        'quantity' => $request->input('quantity', 1),
        'coloris' => $request->input('coloris'),
        'taille' => $request->input('taille'),
    ];

    $cart[$id][] = $cartItem;

    $request->session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Equipement ajouté');
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
