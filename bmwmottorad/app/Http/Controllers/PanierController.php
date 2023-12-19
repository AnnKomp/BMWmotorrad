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

    foreach ($equipements as $equipement) {
        foreach ($cart[$equipement->idequipement] as &$cartItem) {
            $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';

            $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';

            $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] : '';

            $cartItem['photo'] = $this->getEquipementPhotos($equipement->idequipement, $cartItem['coloris']);

            // Add stock information to the cart item
            $cartItem['stock'] = $this->getStock($equipement->idequipement, $cartItem['coloris'], $cartItem['taille']);
        }
    }

    return view('panier', compact('equipements', 'cart'));
}


    private function getColorisName($colorisId)
    {
        return DB::table('coloris')->where('idcoloris', $colorisId)->value('nomcoloris');
    }

    private function getTailleName($tailleId)
    {
        return DB::table('taille')->where('idtaille', $tailleId)->value('libelletaille');
    }


    private function getEquipementPhotos($equipementId, $colorisId)
    {
        $idpresentation = DB::table('presentation_eq')
            ->select('idpresentation')
            ->where('idequipement', $equipementId)
            ->where('idcoloris', $colorisId)
            ->get();

        if ($idpresentation->isNotEmpty()) {
            $idpresentation = $idpresentation[0]->idpresentation;

            $lienmedia = DB::table('media')
                ->select('lienmedia')
                ->where('idpresentation', $idpresentation)
                ->first();

            if ($lienmedia) {
                return $lienmedia->lienmedia;
            }
        }

        return '';
    }

    public function addToCart(Request $request, $id)
{
    $cart = $request->session()->get('cart', []);

    $cartItem = [
        'id' => $id,
        'quantity' => $request->input('quantity', 1),
        'coloris' => $request->input('coloris'),
        'taille' => $request->input('taille'),
    ];

    $stock = $this->getStock($id, $cartItem['coloris'], $cartItem['taille']);

    if (!$this->canAddToCart($cartItem, $stock)) {
        return response()->json(['success' => false, 'message' => 'Cannot add more items than available in stock']);
    }

    $existingItemIndex = $this->findCartItemIndex($cart, $id, $cartItem['coloris'], $cartItem['taille']);

    if ($existingItemIndex !== null) {
        $cart[$id][$existingItemIndex]['quantity'] += $cartItem['quantity'];
    } else {
        $cart[$id][] = $cartItem;
    }

    $request->session()->put('cart', $cart);

    return response()->json(['success' => true, 'message' => 'Equipement ajouté au panier']);
}

private function canAddToCart($cartItem, $stock)
{
    $requestedQuantity = $cartItem['quantity'];

    return $stock >= $requestedQuantity;
}



private function getStock($equipementId, $colorisId, $tailleId)
{
    return DB::table('stock')
        ->where('idequipement', $equipementId)
        ->where('idcoloris', $colorisId)
        ->where('idtaille', $tailleId)
        ->value('quantite');
}



public function incrementQuantity(Request $request, $id, $index)
{
    $cart = $request->session()->get('cart', []);

    if (isset($cart[$id][$index]['quantity'])) {
        if ($this->canIncrement($id, $cart[$id][$index]['coloris'], $cart[$id][$index]['taille'])) {
            $cart[$id][$index]['quantity']++;
            $request->session()->put('cart', $cart);
        } else {
            return redirect()->back()->with('error', 'Cannot increment beyond stock.');
        }
    }

    return redirect()->back();
}

public function decrementQuantity(Request $request, $id, $index)
{
    $cart = $request->session()->get('cart', []);

    if (isset($cart[$id][$index]) && $cart[$id][$index]['quantity'] > 1) {
        $cart[$id][$index]['quantity']--;
        $request->session()->put('cart', $cart);
    }

    return redirect()->back();
}

private function canIncrement($equipementId, $coloris, $taille, $requestedQuantity = 1)
{
    $stock = DB::table('stock')
        ->where('idequipement', $equipementId)
        ->where('idcoloris', $coloris)
        ->where('idtaille', $taille)
        ->value('quantite');

    return $stock > $requestedQuantity;
}

    private function findCartItemIndex($cart, $id, $coloris, $taille)
    {
        if (isset($cart[$id])) {
            foreach ($cart[$id] as $index => $item) {
                if (
                    isset($item['coloris']) && $item['coloris'] == $coloris
                    && isset($item['taille']) && $item['taille'] == $taille
                ) {
                    return $index;
                }
            }
        }

        return null;
    }


    private function getFirstColorisOptionForEquipement($equipementId)
    {
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

    if (isset($cart[$id][$index])) {
        unset($cart[$id][$index]);

            if (empty($cart[$id])) {
            unset($cart[$id]);
        }

        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Équipement retiré du panier');
    }

    return redirect()->back()->with('error', 'Équipement non trouvé dans le panier');
}

}
