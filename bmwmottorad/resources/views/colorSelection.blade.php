@extends('layouts.menus')


@section('title', 'Equipements moto :')


@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/options.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="couleur">
    @if ($idcouleur == 0 )
    <img class="moto_color" src="{{ $motos[0]->lienmedia }}">
    @else
    <img class="moto_color" src="{{ $source[0]->motocouleur }}">
    @endif
    <table class="couleur">
        @foreach ($moto_colors as $color)
        <tr>
            <td class="couleur"><a href="/moto/color?idmoto={{$idmoto}}&idcouleur={{ $color->idcouleur }}"><img src="{{$color->photocouleur}}"></a></td>
            <td class="couleur">{{ $color->nomcouleur }}</td>
            <td class="pack">{{ $color->prixcouleur }} €</td>
            <td class="couleur"><a href="/color?idmoto={{$idmoto}}&idcouleur={{ $color->idcouleur }}" style="font-size:24px"><i class="fa fa-info-circle"></i></a></td>
        </tr>
        @endforeach

    </table>
</div>



@endsection
