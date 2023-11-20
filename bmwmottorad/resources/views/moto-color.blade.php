@php
    $motoname = $motos[0]->nommoto;
@endphp

@extends('layouts.menus')

@section('title', 'Moto')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>

@section('categories')
    <div class = 'header_category'>
        <a href="/moto?id={{$idmoto}}" class = "categories">{{ $motoname }}</a>
        <a href="/moto/color?id={{$idmoto}}" class = "categories">Couleurs</a>
        <a href="/moto/pack?id={{$idmoto}}" class = "categories">Packs</a>
    </div>
@endsection


@section('content')
<div class="couleur">
    <img class="moto_color" src="https://www.bmw-motorrad.fr/content/dam/bmwmotorradnsc/common/images/models/sport/s1000rr/2022/softconfigurator/S1000RR-P0N3H-softconfigurator.jpg.asset.1661501925748.jpg">
    <table class="couleur">
        <tr style='border: solid'>
            <th  class='top_caracteristics'>Check</th>
            <th  class='top_caracteristics'>Image</th>
            <th  class='top_caracteristics'>Nom Couleur</th>
            <th class='top_caracteristics'>Bouton info</th>
        </tr>


    </table>
</div>
@endsection
