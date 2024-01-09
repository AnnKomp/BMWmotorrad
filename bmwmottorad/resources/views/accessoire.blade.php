@extends('layouts.menus')


@section('title', 'Equipements moto :')

<link rel="stylesheet" type="text/css" href="{{asset('css/option.css')}}"/>


@section('content')
<table>
@foreach ($accessoires as $accessoire)
<ul>
    <h2>Accessoire : {{ $accessoire->nomaccessoire }}</h2>
    <h3>Prix :  {{ $accessoire->prixaccessoire }}  €</h3>
    <h3>Description de l'accessoire :</h3>
    <p id=desc> {{ $accessoire->detailaccessoire }} </p>
    <h3>Image de l'accessoire :</h3>
    <img src={{$accessoire->photoaccessoire}} >
</ul>
@endforeach
</table>


<a  id="retour" href="{{ url('/accessoires?id=' . $idmoto)}}"> Retour</a>



@endsection
