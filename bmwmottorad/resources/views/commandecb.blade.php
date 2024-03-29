<!DOCTYPE html>
<html>
<head>
    <title>BMW Motorrad Paiement CB</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/panier.css">
    <link rel="stylesheet" href="/css/commandecb.css">
    <script src="/js/popup.js"></script>
    <link rel="stylesheet" href="/css/popup.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    

<div class="container">
<button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Paiement par CB</h2>
        <p>Afin de payer votre commande, vous devez renseigner vos informations bancaires.</p>
        <img src="/img/guideimages/cb.png" alt="" class="popupimg">
        <p>Nous n'enregistrons pas automatiquement vos informations bancaires.Cependant, si vous souhaitez le faire afin de simplifier vos futurs achats vous pouvez cocher la case correspondante.</p>
        <img src="/img/guideimages/cbregister.png" alt="" class="popupimg">
        <p>Pour valider la commande cliquez sur "Payer".</p>
        <img src="/img/guideimages/cbbutton.png" alt="" class="popupimg">
    </div>
</div>
<h1>Paiement par CB</h1>

<form method="POST" action="{{ route('paymentcb') }}">
        @csrf

        @if($cb)
        <div class=fielddiv>
            <x-input-label for="cardnumber" :value="__('Numéro de carte bancaire*')" />
            <x-text-input class=field minlength="16" maxlength="16" id="cardnumber" type="tel" name="cardnumber" :value="old('cardnumber', $cb->numcarte)" required autofocus autocomplete="cardnumber" />
            <x-input-error :messages="$errors->get('cardnumber')" class="error" />
        </div>


        <div class=fielddiv>
            <x-input-label for="owner" :value="__('Titulaire de la carte*')" />
            <x-text-input class=field id="owner" type="text" name="owner" :value="old('owner', $cb->titulairecompte)" required autofocus autocomplete="owner" />
            <x-input-error :messages="$errors->get('owner')" class="error" />
        </div>


        <div class=fielddiv>
            <x-input-label for="expiration" :value="__('Date d\'expiration*')" />
            <x-text-input id="expiration" class=field type="month" name="expiration" :value="old('expiration', $cb->dateexpiration)" required autocomplete="expiration" />
            <x-input-error :messages="$errors->get('expiration')" class="error" />
        </div>


        <div class=fielddiv>
            <x-input-label for="cvv" :value="__('CVV*')" />
            <x-text-input minlength="3" maxlength="3" id="cvv" class=field type="tel" name="cvv" required/>
            <x-input-error :messages="$errors->get('cvv')" class="error" />
        </div>
        @else
        <div class=fielddiv>
            <x-input-label for="cardnumber" :value="__('Numéro de carte bancaire*')" />
            <x-text-input class=field minlength="16" maxlength="16" id="cardnumber" type="tel" name="cardnumber" :value="old('cardnumber')" required autofocus autocomplete="cardnumber" />
            <x-input-error :messages="$errors->get('cardnumber')" class="error" />
        </div>


        <div class=fielddiv>
            <x-input-label for="owner" :value="__('Titulaire de la carte*')" />
            <x-text-input class=field id="owner" type="text" name="owner" :value="old('owner')" required autofocus autocomplete="owner" />
            <x-input-error :messages="$errors->get('owner')" class="error" />
        </div>


        <div class=fielddiv>
            <x-input-label for="expiration" :value="__('Date d\'expiration*')" />
            <x-text-input id="expiration" class=field type="month" name="expiration" :value="old('expiration')" required autocomplete="expiration" />
            <x-input-error :messages="$errors->get('expiration')" class="error" />
        </div>


        <div class=fielddiv>
            <x-input-label for="cvv" :value="__('CVV*')" />
            <x-text-input minlength="3" maxlength="3" id="cvv" class=field type="tel" name="cvv" required/>
            <x-input-error :messages="$errors->get('cvv')" class="error" />
        </div>
        @endif
        <div>
            <input type="checkbox" name="saveinfo" value="selected">Enregistrer mes informations bancaires afin de simplifier mes prochaines transactions.</input> 
        </div>

        <div>
            <p>* : champ obligatoire</p>
        </div>

        <div>
            <x-primary-button class="ms-4">
                Payer {{ $total }} €
            </x-primary-button>
        </div>
    </form>
    
    <h2>Contenu de la commande</h2>

    <table>
            <tr>
                <th id=name>Nom</th>
                <th id=photo>Photo</th>
                <th id=coloris>Coloris</th>
                <th id=taille>Taille</th>
                <th id=quantity>Quantité</th>
                <th id=price>Prix</th>
            </tr>




        @foreach ($equipements as $equipement)
            @foreach ($cart[$equipement->idequipement] as $cartItem)
            <tr>
                <td id=name>{{ $equipement->nomequipement }}</td>

                <td id=photo>
                    <img src="{{ $cartItem['photo']->lienmedia }}" alt="Equipement Photo" class="equipement-photo">
                </td>

                <td id=coloris>{{ $cartItem['coloris_name'] }}</td>
                <td id=taille>{{ $cartItem['taille_name'] }}</td>
                <td id=quantity>{{ isset($cartItem['quantity']) ? $cartItem['quantity'] : ''}}</td>
                <td id=price>{{ $equipement->prixequipement * $cartItem['quantity'] }} €</td>
            </tr>
            @endforeach

        @endforeach
    </table>

    <p>Frais de livraison : {{ $fee }} €</p>
    <h3>Total : {{ $total }} €</h3>
</div>
      
</body>
 
</html>