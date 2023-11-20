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

<table>
    <tr style='border: solid'>
        <th  class='top_caracteristics'>Check</th>
        <th  class='top_caracteristics'>Image</th>
        <th  class='top_caracteristics'>Nom Option</th>
        <th class='top_caracteristics'>Bouton info</th>
    </tr>
</table>

@endsection
