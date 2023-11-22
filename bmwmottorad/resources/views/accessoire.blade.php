@extends('layouts.menus')


@section('title', 'Equipements moto :')



@section('content')
<table>
@foreach ($accessoires as $accessoire)
<ul>
    <h2>Option :</h2>
    <h3 id="nom"> {{ $accessoire->nomaccessoire }} </h3>
    <h3>Prix : &#xA0;</h3>
    <li>  {{ $accessoire->prixaccessoire }}  €</li>
    <h3>Description de l'option :</h3>
    <p> {{ $accessoire->detailaccessoire }} </p>
    <h3>Image de l'option :</h3>
    <img src={{$accessoire->photoaccessoire}} >
</ul>
@endforeach
</table>


@endsection
