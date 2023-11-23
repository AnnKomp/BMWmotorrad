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


<h4> Coloris : {{$nomcoloris}}</h4>

<h3>choix taille</h3>
{{-- select -> option ->  --}}

<h3>choix couleur (voir moto)</h3>

<h3>{{$prixequipement}} €</h3>

<h4>*bouton pour mettre dans le panier*</h4>


@endsection
