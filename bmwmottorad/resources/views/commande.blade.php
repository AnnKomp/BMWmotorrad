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

    <form method="POST" action="{{ route('payment') }}">
        @csrf
        <!-- Card number -->
        <div>
            <x-input-label for="numerocarte" :value="__('Numéro de carte bancaire*')" />
            <x-text-input minlength="16" maxlength="16" id="numerocarte" class="block mt-1 w-full" type="tel" name="numerocarte" :value="old('numerocarte')"  autofocus/>
            <x-input-error :messages="$errors->get('numerocarte')" class="mt-2" />
        </div>

        <!-- Card owner -->
        <div>
            <x-input-label for="titulaire" :value="__('Titulaire de la carte*')" />
            <x-text-input id="titulaire" class="block mt-1 w-full" type="text" name="titulaire" :value="old('titulaire')" autofocus/>
            <x-input-error :messages="$errors->get('titulaire')" class="mt-2" />
        </div>

         <!-- Expiration date -->
        <div>
            <x-input-label for="dateexpiration" :value="__('Date d\'expiration*')" />
            <input type="month" id="dateexpiration" name="dateexpiration" class="block mt-1 w-full">
            <x-input-error :messages="$errors->get('dateexpiration')" class="mt-2" />
        </div>

        <!-- CVV -->
        <div>
            <x-input-label for="secret" :value="__('CVV')" />
            <x-text-input minlength="3" maxlength="3" id="secret" class="block mt-1 w-full" type="number" name="secret"  autofocus/>
            <x-input-error :messages="$errors->get('secret')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Payer la commande') }}
            </x-primary-button>
        </div>
    </form>
</body>
</html>