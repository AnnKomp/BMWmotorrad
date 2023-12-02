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
                <th id=coloris>xColoris</th>
                <th id=taille>Taille</th>
                <th id=quantity>Quantité</th>
                <th>Supprimer</th>
            </tr>




            @foreach ($equipements as $equipement)
            @foreach ($cart[$equipement->idequipement] as $cartItem)
            <tr>
                <td id=name>{{ $equipement->nomequipement }}</td>
                <td id=price>{{ $equipement->prixequipement }}</td>
                <td id=coloris>{{ isset($cartItem['coloris']) ? $cartItem['coloris'] : '' }}</td>
                <td id=taille>{{ isset($cartItem['taille']) ? $cartItem['taille'] : '' }}</td>
                <td id=quantity>{{ isset($cartItem['quantity']) ? $cartItem['quantity'] : ''}}</td>
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
    @else
        <p>Pour le moment, votre panier est vide.</p>
    @endif
@endsection
