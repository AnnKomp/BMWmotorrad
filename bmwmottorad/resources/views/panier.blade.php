@extends('layouts.menus')

@section('title', 'Panier')

<link rel="stylesheet" type="text/css" href="{{ asset('css/panier.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
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

        <a href="/panier/commandecb">
            <button>Payer par CB</button>
        </a>

        <a href="/panier/commandestripe">
            <button>Payer via Stripe</button>
        </a>
    @else
        <p>Pour le moment, votre panier est vide.</p>
    @endif
@endsection
