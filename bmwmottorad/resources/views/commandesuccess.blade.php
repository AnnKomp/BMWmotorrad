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

        <h2>Votre commande a été validée avec succès!</h2>
        <h3>Récapitulatif de votre commande : </h3>

        <table>
            <tr>
                <th id=name>Nom</th>
                <th id=coloris>Coloris</th>
                <th id=taille>Taille</th>
                <th id=quantity>Quantité</th>
                <th id=price>Prix</th>
            </tr>




        @foreach ($equipements as $equipement)
            @foreach ($cart[$equipement->idequipement] as $cartItem)
            <tr>
                <td id=name>{{ $equipement->nomequipement }}</td>
                <td id=coloris>{{ $cartItem['coloris_name'] }}</td>
                <td id=taille>{{ $cartItem['taille_name'] }}</td>
                <td id=quantity>{{ isset($cartItem['quantity']) ? $cartItem['quantity'] : ''}}</td>
                <td id=price>{{ $equipement->prixequipement * $cartItem['quantity'] }} €</td>
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
