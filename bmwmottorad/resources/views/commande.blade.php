<?php
    $total = 0;
    foreach($equipements as $equipement){
        foreach($cart[$equipement->idequipement] as $cartItem){
            $total += $equipement->prixequipement * $cartItem['quantity'];
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                <td id=price>{{ $equipement->prixequipement * $cartItem['quantity'] }}</td>
                <td id=coloris>{{ isset($cartItem['coloris']) ? $cartItem['coloris'] : '' }}</td>
                <td id=taille>{{ isset($cartItem['taille']) ? $cartItem['taille'] : '' }}</td>
                <td id=quantity>{{ isset($cartItem['quantity']) ? $cartItem['quantity'] : ''}}</td>
            </tr>
            @endforeach

        @endforeach
    </table>

    <h1>Total</h1>
    <p>{{ $total}}</p>
</body>
</html>