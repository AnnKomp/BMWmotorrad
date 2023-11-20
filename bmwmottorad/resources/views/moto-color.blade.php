@php
    $motoname = $motos[0]->nommoto;
@endphp

@extends('layouts.menus')

@section('title', 'Moto')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('categories')
    <div class = 'header_category'>
        <a href="/moto?id={{$idmoto}}" class = "categories">{{ $motoname }}</a>
        <a href="/moto/color?id={{$idmoto}}" class = "categories">Couleurs</a>
        <a href="/moto/pack?id={{$idmoto}}" class = "categories">Packs</a>
    </div>
@endsection


@section('content')
<div class="couleur">
    <img class="moto_color" src="{{ $source[0]->motocouleur }}">
    <table class="couleur">
        @foreach ($moto_colors as $color)
        <tr>
            <td class="couleur"><a href="/moto/color?idmoto={{$idmoto}}&idcouleur={{ $color->idcouleur }}"><img src="{{$color->photocouleur}}"></a></td>
            <td class="couleur">{{ $color->nomcouleur }}</td>
            <td class="couleur"><a href="/color?idmoto={{$idmoto}}&idcouleur={{ $color->idcouleur }}" style="font-size:24px"><i class="fa fa-info-circle"></i></a></td>
        </tr>
        @endforeach

    </table>
</div>
@endsection
