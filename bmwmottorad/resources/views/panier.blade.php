@extends('layouts.menus')

@section('title', 'Panier')

<link rel="stylesheet" type="text/css" href="{{ asset('css/panier.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
    <button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

    <div id="popup-overlay" onclick="closePopup()"></div>
    <div id="popup-container">
        <div id="popup-content">
            <span id="close-popup" onclick="closePopup()">&times;</span>
            <h2>Le panier</h2>
            <p>Le panier contient tout les équipements que vous avez ajouté.</p>
            <img src="/img/guideimages/basketlist.png" alt="" class="popupimg">
            <h3>Modifier un équipement du panier</h3>
            <p>Vous pouvez modifier la quantite d'un équipement de votre panier en cliquant sur le bouton "+"" pour en ajouter et "-" pour en retirer.</p>
            <img src="/img/guideimages/basketeditqtt.png" alt="" class="popupimg">
            <p>Vous pouvez retirer un équipement de votre panier en appuyer sur le bouton X.</p>
            <img src="/img/guideimages/basketdelete.png" alt="" class="popupimg">
            <p>Pour régler votre panier et passer commande, cliquez sur le bouton correspondant au mode de paiement que vous souhaitez utiliser.</p>
            <img src="/img/guideimages/basketbuttons.png" alt="" class="popupimg">
        </div>
    </div>

    <h2>Le panier :</h2>

    @if (count($equipements) > 0)
        <table>
            <tr>
                <th id=name>Nom</th>
                <th id=price>Prix</th>
                <th id=photo>Photo</th>
                <th id=coloris>Coloris</th>
                <th id=taille>Taille</th>
                <th id=quantity>Quantité</th>
                <th>Supprimer</th>
            </tr>


            @foreach ($equipements as $equipement)
            @foreach ($cart[$equipement->idequipement] as $cartItem)
            <tr>
                <td id=name>{{ $equipement->nomequipement }}</td>
                <td id=price>{{ $equipement->prixequipement * $cartItem['quantity']  }} €</td>
                <td id=photo>
                    <img src="{{ $cartItem['photo'] }}" alt="Equipement Photo" class="equipement-photo">
                </td>

                <td id=coloris>{{ $cartItem['coloris_name'] }}</td>
                <td id=taille>{{ $cartItem['taille_name'] }}</td>
                <td id=quantity>
                    <form action="{{ route ('panier.increment', ['id' => $equipement->idequipement, 'index' => $loop->index])}}" method="post">
                        @csrf
                        <button type="submit" {{ $cartItem['quantity'] >= $cartItem['stock'] ? 'disabled' : '' }}>+</button>
                    </form>
                    {{ isset($cartItem['quantity']) ? $cartItem['quantity'] : ''}}
                    <form action="{{ route('panier.decrement', ['id' => $equipement->idequipement, 'index' => $loop->index])}}" method="post">
                        @csrf
                        <button type="submit" {{ $cartItem['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                    </form>
                </td>



                </td>
                <td>
                    <form action="{{ route('panier.remove-item', ['id' => $equipement->idequipement, 'index' => $loop->index]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fa fa-times"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach

          @endforeach
        </table>
        <a href="/panier/commandecb" class="basketbutton">
            Payer par CB
        </a>

        <a href="/panier/commandestripe" class="basketbutton">
            Payer via Stripe
        </a>
    @else
        <p>Pour le moment, votre panier est vide.</p>
    @endif
@endsection
