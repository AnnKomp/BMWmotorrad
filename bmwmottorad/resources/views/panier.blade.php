@extends('layouts.menus')

@section('title', 'Panier')

<link rel="stylesheet" type="text/css" href="{{asset('css/panier.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')

<h2>Les équipements dans le panier :</h2>

@if(count($equipements) > 0)
    <table>
        <tr>
            <th>Nom</th>
            <th>Prix</th>
            <th>Plus d'infos</th>
        </tr>

        @foreach($equipements as $equipement)
            <tr>
                <td>{{ $equipement->nomequipement }}</td>
                <td>{{ $equipement->prixequipement }}</td>
                <td>
                    <a href="{{ url('/equipement?id=' . $equipement->idequipement . '&idpanier=' . $idpanier) }}">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </td>
            </tr>
        @endforeach

        <!-- Commander link, displayed only once -->
        <tr>
            <td colspan="3">
                <a href="{{ url('/commander?id=' . $equipements[0]->idequipement . '&idpanier=' . $idpanier) }}">
                    Commander
                </a>
            </td>
        </tr>
    </table>
@else
    <p>Pour le moment, il n'y a rien dans le panier.</p>
@endif

@endsection
