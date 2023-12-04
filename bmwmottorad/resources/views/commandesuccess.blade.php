<?php
    $total = 0;
    foreach($equipements as $equipement){
        foreach($cart[$equipement->idequipement] as $cartItem){
            $total += $equipement->prixequipement * $cartItem['quantity'];
        }
    }

?>

<x-guest-layout>
    <link rel="stylesheet" href="/css/register.css">
        
        <!-- Redirection page after creating a new account -->

        <h2>Votre commande a été validée avec succès!</h2>
        <h3>Récapitulatif de votre commande : </h3>

        <table>
            <tr>
                <th id=name>Nom</th>
                <th id=price>Prix</th>
                <th id=coloris>xColoris</th>
                <th id=taille>Taille</th>
                <th id=quantity>Quantité</th>
            </tr>




        @foreach ($equipements as $equipement)
            @foreach ($cart[$equipement->idequipement] as $cartItem)
            <tr>
                <td id=name>{{ $equipement->nomequipement }}</td>
                <!-- Make the price equal to the unitary price times the quantity -->
                <td id=price>{{ $equipement->prixequipement * $cartItem['quantity'] }} €</td>
                <td id=coloris>{{ isset($cartItem['coloris']) ? $cartItem['coloris'] : '' }}</td>
                <td id=taille>{{ isset($cartItem['taille']) ? $cartItem['taille'] : '' }}</td>
                <td id=quantity>{{ isset($cartItem['quantity']) ? $cartItem['quantity'] : ''}}</td>
            </tr>
            @endforeach

        @endforeach
        </table>

        <h1>Total</h1>
        <p name="total">{{ $total}} €</p>

        <div class="flex items-center justify-center mt-4">
            <a class="finishbutton" href="{{ url("/") }}">Continuer la visite du site</a>
            <a class="finishbutton" href="{{ url("/dashboard") }}">Home BMW Motorrad</a>
        </div>
    </form>
</x-guest-layout>
