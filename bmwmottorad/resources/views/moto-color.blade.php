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
        <a href="/moto/color?idmoto={{$idmoto}}&idcouleur={{$idcouleur}}" class = "categories">Configuration</a>
{{--        <a href="/moto/pack?id={{$idmoto}}" class = "categories">Packs</a>--}}
    </div>
@endsection


@section('content')

<form action="{{ route('processColors')}}?id={{$idmoto}}" method="post" >
    @csrf
    <div class="couleur">
        <table class="lanceconfig">
            <tr><td class="lanceconfig"><div>
            @if ( $type == "style")
                <img class="moto_color" src="{{ $motos[0]->lienmedia }}">
            @else
                @if ($idcouleur == 0 )
                    <img class="moto_color" src="{{ $motos[0]->lienmedia }}">
                @else
                <img class="moto_color" src="{{ $source[0]->motocouleur }}">
                @endif
            @endif
            </div>
                <div>
                    <button id="lancerconfig" type="submit">Lancer la configuration</button>
                </div>
            </td></tr>
        </table>
        <table class="couleur">
            <tr><td><h3>Couleurs</h3></td></tr>
            @foreach ($moto_colors as $color)
            <tr>
                <td><input type="radio" id="option1" name="color[]" value={{ $color->idcouleur }} checked @if(in_array($color->idcouleur, session('selectedColor', []))) checked @endif></td>
                <td class="couleur"><a href="/moto/color?idmoto={{$idmoto}}&idcouleur={{ $color->idcouleur }}"><img src="{{$color->photocouleur}}"></a></td>
                <td class="couleur">{{ $color->nomcouleur }}</td>
                <td class="pack">{{ $color->prixcouleur }} €</td>
                <td class="couleur"><a href="/color?idmoto={{$idmoto}}&idcouleur={{ $color->idcouleur }}" style="font-size:24px"><i class="fa fa-info-circle"></i></a></td>
            </tr>
            @endforeach
            <tr><td><h3>Styles</h3></td></tr>
            @foreach ($styles as $style)
          <tr>
                <td><input type="radio" id="option1" name="color[]" value={{ $style->idstyle }} checked @if(in_array($style->idstyle, session('selectedColor', []))) checked @endif></td>
                <td class="couleur"><a href="/moto/color?idmoto={{$idmoto}}&idcouleur={{ $style->idstyle }}&type=style"><img src="{{$style->photostyle}}"></a></td>
                <td class="couleur">{{ $style->nomstyle }}</td>
                <td class="pack">{{ $style->prixstyle }} €</td>
                <td class="couleur"><a href="/color?idmoto={{$idmoto}}&idcouleur={{ $style->idstyle }}" style="font-size:24px"><i class="fa fa-info-circle"></i></a></td>
            </tr>
            @endforeach

        </table>


    </div>
</form>


@endsection
