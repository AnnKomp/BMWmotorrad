@extends('layouts.menus')

@section('title', 'Equipements')

@section('content')
<h1>{{$nomequipement}}</h1>

<p> {{$descriptionequipement}}</p>

<p>photo equipement (*la carrousel ser quand plus de photos dans la DB*)</p>
<div class="slider-container">
    <div class = 'slider'>
    @foreach ($equipement_pics as $pic)
        <img src={{$pic->lienmedia}}>
    @endforeach
    </div></div>

<h4> Coloris : {{$nomcoloris}}</h4>
<h3>choix taille</h3>

<h3>choix couleur (voir moto)</h3>

<h3>{{$prixequipement}} €</h3>

<h4>*bouton pour mettre dans le panier*</h4>


@endsection
