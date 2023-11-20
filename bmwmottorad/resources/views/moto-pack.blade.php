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
        <a href="/moto/color?idmoto={{$idmoto}}&idcouleur=0" class = "categories">Couleurs</a>
        <a href="/moto/pack?id={{$idmoto}}" class = "categories">Packs</a>
    </div>
@endsection

@section('content')

<table>

    <form action="{{ route('options')}}?id={{$idmoto}}" method="post">
        @csrf
           @foreach ($packs as $pack)
        <tr>
            <td class="pack"><input class="check" type="checkbox" name="packs[]"></td>
            <td lass="pack"><img src="{{ $pack->photopack }}" width=auto height=200px></td>
            <td id="nom"><a href="/pack?id={{ $pack->idpack }}" @style(['color: black','text-decoration: none'])>{{ $pack->nompack }} </a></td>
            @if ( $pack->prixpack =="")
                <td class="pack">0.00 €</td>
            @else
                <td class="pack">{{ $pack->prixpack }} €</td>
            @endif
            <td class="pack"><a href="/pack?id={{ $pack->idpack }}"><i class="fa fa-info-circle"></i></a></td>

        </tr>
          @endforeach


        <br>
        </table>

        <button type="submit">Lancer la configuration</button>

        </form>
</table>

@endsection
