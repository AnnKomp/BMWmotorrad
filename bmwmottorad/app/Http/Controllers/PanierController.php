<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Equipement;

class PanierController extends Controller
{
    /**
     * Display the 'panier' view.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // Retrieve the 'cart' data from the session or an empty array if it doesn't exist
        $cart = $request->session()->get('cart', []);

        // Retrieve equipements based on the keys (idequipement) present in the cart array
        $equipements = Equipement::whereIn('idequipement', array_keys($cart))->get();

        // Iterate through each equipement in the result set
        foreach ($equipements as $equipement) {
            foreach ($cart[$equipement->idequipement] as &$cartItem) {  // Use &$cartItem to modify the original array
                $cartItem['coloris_name'] = isset($cartItem['coloris']) ? $this->getColorisName($cartItem['coloris']) : '';
                $cartItem['taille_name'] = isset($cartItem['taille']) ? $this->getTailleName($cartItem['taille']) : '';
                $cartItem['quantity'] = isset($cartItem['quantity']) ? $cartItem['quantity'] : '';
                $cartItem['photo'] = $this->getEquipementPhotos($equipement->idequipement, $cartItem['coloris']);
                $cartItem['stock'] = $this->getStock($equipement->idequipement, $cartItem['coloris'], $cartItem['taille']);
            }
        }

        // Update the original $cart array with the modified $cartItem values
        $request->session()->put('cart', $cart);

        // Pass the equipements and cart data to the 'panier' view
        return view('panier', compact('equipements', 'cart'));
    }


    /**
    *   Retrieve the name of the coloris based on the given colorisId
    */
    private function getColorisName($colorisId)
    {
        // Use the DB facade to query the 'coloris' table and retrieve the 'nomcoloris' column
        return DB::table('coloris')->where('idcoloris', $colorisId)->value('nomcoloris');
    }

    /**
    *   Retrieve the name of the taille based on the given tailleId
    */
    private function getTailleName($tailleId)
    {
        // Use the DB facade to query the 'taille' table and retrieve the 'libelletaille' column
        return DB::table('taille')->where('idtaille', $tailleId)->value('libelletaille');
    }


    /**
    *   Retrieve the media link for the given equipement and coloris
    */
    private function getEquipementPhotos($equipementId, $colorisId)
    {
        // Query the 'presentation_eq' table to get the 'idpresentation' based on equipementId and colorisId
        $idpresentation = DB::table('presentation_eq')
            ->select('idpresentation')
            ->where('idequipement', $equipementId)
            ->where('idcoloris', $colorisId)
            ->get();

        // Check if the result set is not empty
        if ($idpresentation->isNotEmpty()) {
            // Extract the 'idpresentation' from the result set
            $idpresentation = $idpresentation[0]->idpresentation;

            // Query the 'media' table to get the 'lienmedia' based on the extracted 'idpresentation'
            $lienmedia = DB::table('media')
                ->select('lienmedia')
                ->where('idpresentation', $idpresentation)
                ->first();

            // Check if a valid 'lienmedia' is found
            if ($lienmedia) {
                // Return the found 'lienmedia'
                return $lienmedia->lienmedia;
            }
        }

        // Return an empty string if no valid 'lienmedia' is found
        return '';
    }


    /**
     * Add an equipement to the shopping cart.
     */
    public function addToCart(Request $request, $id)
    {
        // Retrieve the current cart from the session or create an empty array if it doesn't exist
        $cart = $request->session()->get('cart', []);

        // Create a new cart item with the provided equipement id, quantity, coloris, and taille
        $cartItem = [
            'id' => $id,
            'quantity' => $request->input('quantity', 1),
            'coloris' => $request->input('coloris'),
            'taille' => $request->input('taille'),
        ];

        // Get the available stock for the equipement with the specified coloris and taille
        $stock = $this->getStock($id, $cartItem['coloris'], $cartItem['taille']);

        // Check if it's possible to add the specified quantity to the cart based on available stock
        if (!$this->canAddToCart($cartItem, $stock)) {
            return response()->json(['success' => false, 'message' => 'Cannot add more items than available in stock']);
        }

        // Check if the equipement with the same id, coloris, and taille already exists in the cart
        $existingItemIndex = $this->findCartItemIndex($cart, $id, $cartItem['coloris'], $cartItem['taille']);

        // If the equipement already exists in the cart, update its quantity
        if ($existingItemIndex !== null) {
            $cart[$id][$existingItemIndex]['quantity'] += $cartItem['quantity'];
        } else {
            // If the equipement is not in the cart, add a new entry for it
            $cart[$id][] = $cartItem;
        }

        // Update the cart in the session
        $request->session()->put('cart', $cart);

        // Return a JSON response indicating success and a message
        return response()->json(['success' => true, 'message' => 'Equipement ajouté au panier']);
    }



    /**
    *   Check if the specified quantity of an equipement can be added to the cart based on available stock
    */
    private function canAddToCart($cartItem, $stock)
    {
        // Extract the requested quantity from the cart item
        $requestedQuantity = $cartItem['quantity'];

        // Check if the available stock is greater than or equal to the requested quantity
        return $stock >= $requestedQuantity;
    }

    /**
    *   Retrieve the available stock for a specific equipement, coloris, and taille combination
    */
    private function getStock($equipementId, $colorisId, $tailleId)
    {
        // Use the DB facade to query the 'stock' table and retrieve the 'quantite' column
        return DB::table('stock')
            ->where('idequipement', $equipementId)
            ->where('idcoloris', $colorisId)
            ->where('idtaille', $tailleId)
            ->value('quantite');
    }




    /**
    *   Increment the quantity of a specific item in the cart
    */
    public function incrementQuantity(Request $request, $id, $index)
    {
        // Retrieve the current cart from the session or create an empty array if it doesn't exist
        $cart = $request->session()->get('cart', []);

        // Check if the quantity index exists in the specified cart item
        if (isset($cart[$id][$index]['quantity'])) {
            // Check if it's possible to increment the quantity based on available stock
            if ($this->canIncrement($id, $cart[$id][$index]['coloris'], $cart[$id][$index]['taille'])) {
                // Increment the quantity of the specified cart item
                $cart[$id][$index]['quantity']++;

                // Update the cart in the session
                $request->session()->put('cart', $cart);
            } else {
                // Redirect back with an error message if it's not possible to increment beyond stock
                return redirect()->back()->with('error', 'Cannot increment beyond stock.');
            }
        }

        // Redirect back if the quantity index doesn't exist in the specified cart item
        return redirect()->back();
    }


    /**
     * Decrement the quantity of a specific item in the cart.
     */
    public function decrementQuantity(Request $request, $id, $index)
    {
        // Retrieve the current cart from the session or create an empty array if it doesn't exist
        $cart = $request->session()->get('cart', []);

        // Check if the specified cart item and its quantity index exist, and the quantity is greater than 1
        if (isset($cart[$id][$index]) && $cart[$id][$index]['quantity'] > 1) {
            // Decrement the quantity of the specified cart item
            $cart[$id][$index]['quantity']--;

            // Update the cart in the session
            $request->session()->put('cart', $cart);
        }

        // Redirect back
        return redirect()->back();
    }


    /**
     * Check if it's possible to increment the quantity of an item in the cart based on available stock.
     */
    private function canIncrement($equipementId, $coloris, $taille, $requestedQuantity = 1)
    {
        // Use the DB facade to query the 'stock' table and retrieve the 'quantite' column
        $stock = DB::table('stock')
            ->where('idequipement', $equipementId)
            ->where('idcoloris', $coloris)
            ->where('idtaille', $taille)
            ->value('quantite');

        // Check if the available stock is greater than the requested quantity
        return $stock > $requestedQuantity;
    }



    /**
     * Find the index of a specific cart item in the cart array based on equipement id, coloris, and taille.
     */
    private function findCartItemIndex(array $cart, int $id, int $coloris, int $taille)
    {
        // Check if the equipement id exists in the cart
        if (isset($cart[$id])) {
            // Iterate through each item for the specified equipement id in the cart
            foreach ($cart[$id] as $index => $item) {
                // Check if the item has the same coloris and taille as specified
                if (
                    isset($item['coloris']) && $item['coloris'] == $coloris
                    && isset($item['taille']) && $item['taille'] == $taille
                ) {
                    // Return the index of the matching item
                    return $index;
                }
            }
        }

        // Return null if no matching item is found
        return null;
    }

    /**
     * Get the first coloris option for a specific equipement.
     */
    private function getFirstColorisOptionForEquipement(int $equipementId)
    {
        // Use the DB facade to query the 'coloris' table and retrieve the first coloris id
        return DB::table('coloris')
            ->select('coloris.idcoloris')
            ->join('stock', 'stock.idcoloris', '=', 'coloris.idcoloris')
            ->where('idequipement', $equipementId)
            ->first();
    }

    /**
     * Remove a specific item from the cart based on equipement id and index.
     */
    public function removeItem(Request $request, int $id, int $index)
    {
        // Retrieve the current cart from the session or create an empty array if it doesn't exist
        $cart = $request->session()->get('cart', []);

        // Check if the specified cart item exists
        if (isset($cart[$id][$index])) {
            // Remove the specified cart item
            unset($cart[$id][$index]);

            // Check if the equipement id in the cart is now empty, and remove it if so
            if (empty($cart[$id])) {
                unset($cart[$id]);
            }

            // Update the cart in the session
            $request->session()->put('cart', $cart);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Équipement retiré du panier');
        }

        // Redirect back with an error message if the specified cart item is not found
        return redirect()->back()->with('error', 'Équipement non trouvé dans le panier');
    }
}
