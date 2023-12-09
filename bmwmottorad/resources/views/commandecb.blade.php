<?php
    $total = 0;
    foreach($equipements as $equipement){
        foreach($cart[$equipement->idequipement] as $cartItem){
            $total += $equipement->prixequipement * $cartItem['quantity'];
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>BMW Motorrad Paiement Stripe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
      
<div class="container">
      
    <h1>BMW Motorrad - Paiement Stripe</h1>
    
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
                <td id=coloris>{{ $cartItem['coloris_name'] }}</td>
                <td id=taille>{{ $cartItem['taille_name'] }}</td>
                <td id=quantity>{{ isset($cartItem['quantity']) ? $cartItem['quantity'] : ''}}</td>
            </tr>
            @endforeach

        @endforeach
    </table>

    <h1>Total</h1>
    <p name="total">{{ $total}} €</p>
      
    <form method="POST" action="{{ route('paymentcb') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="cardnumber" :value="__('Numéro de carte bancaire*')" />
            <x-text-input minlength="16" maxlength="16" id="cardnumber" class="block mt-1 w-full" type="tel" name="cardnumber" :value="old('cardnumber')" required autofocus autocomplete="cardnumber" />
            <x-input-error :messages="$errors->get('cardnumber')" class="mt-2" />
        </div>

        <!-- Last name -->
        <div>
            <x-input-label for="owner" :value="__('Titulaire de la carte*')" />
            <x-text-input id="owner" class="block mt-1 w-full" type="text" name="owner" :value="old('owner')" required autofocus autocomplete="owner" />
            <x-input-error :messages="$errors->get('owner')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="expiration" :value="__('Date d\'expiration*')" />
            <x-text-input id="expiration" class="block mt-1 w-full" type="month" name="expiration" :value="old('expiration')" required autocomplete="expiration" />
            <x-input-error :messages="$errors->get('expiration')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="cvv" :value="__('CVV*')" />
            <x-text-input minlength="3" maxlength="3" id="cvv" class="block mt-1 w-full" type="tel" name="cvv" required/>
            <x-input-error :messages="$errors->get('cvv')" class="mt-2" />
        </div>

        <div class="mt-4">
            <input type="checkbox">Enregistrer mes informations bancaires pour les futures transactions.</input> 
        </div>

        <div class="mt-4">
            <p>* : champ obligatoire</p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                Payer {{ $total }} €
            </x-primary-button>
        </div>
    </form>
</div>
      
</body>
 
</html>