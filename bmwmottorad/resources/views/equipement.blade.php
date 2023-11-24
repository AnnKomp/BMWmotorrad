@extends('layouts.menus')

@section('title', 'Equipements')

<link rel="stylesheet" type="text/css" href="{{asset('css/equipement.css')}}"/>

@section('content')
<h1>{{$nomequipement}}</h1>

<div class="description"> {{$descriptionequipement}}</div>

<div class="slider-container">
    <div class = 'slider'>
    @foreach ($equipement_pics as $pic)
        <img src={{$pic->lienmedia}}>
    @endforeach
    </div></div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    $(document).ready(function(){
        $('.slider').slick({
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
        });
    });
</script>


{{-- select -> option ->  --}}
<h3>choix taille</h3>
<section>
    <h3>Choix taille</h3>
    <select name="taille" id="taille">
        @foreach ($tailleOptions as $tailleOption)
            <option value="{{ $tailleOption->idtaille }}">{{ $tailleOption->libelletaille }}</option>
        @endforeach
    </select>
</section>

{{-- select -> option -> --}}
<h3>choix coloris (voir moto)</h3>
<section>
    <h3>Choix coloris (voir moto)</h3>
    <select name="coloris" id="coloris">
        @foreach ($colorisOptions as $colorisOption)
            <option value="{{ $colorisOption->idcoloris }}">{{ $colorisOption->nomcoloris }}</option>
        @endforeach
    </select>
</section>

<h3>Prix : {{$prixequipement}} €</h3>

<h4>*bouton pour mettre dans le panier*</h4>


@endsection
