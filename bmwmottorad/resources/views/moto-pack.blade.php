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

<table>
    <tr style='border: solid'>
        <th  class='top_caracteristics'>Check</th>
        <th  class='top_caracteristics'>Image</th>
        <th  class='top_caracteristics'>Nom</th>
        <th  class='top_caracteristics'>Prix</th>
        <th class='top_caracteristics'>Bouton info</th>
    </tr>

    <form action="/options?id={{$idmoto}}" method="post">
        @csrf
           @foreach ($packs as $pack)
        <tr>
            <td><input type="checkbox" name="packs[]"></td>
            <td> <img src="{{ $pack->photopack }}" width=100% height=100></td>
            <td id="nom"><a href="/pack?id={{ $pack->idpack }}" @style(['color: black','text-decoration: none'])>{{ $pack->nompack }} </a></td>
            @if ( $pack->prixpack =="")
                <td>0.00</td>
            @else
                <td>{{ $pack->prixpack }}</td>
            @endif
            <td><a href="/pack?id={{ $pack->idpack }}" style="font-size:24px"><i class="fa fa-info-circle"></i></a></td>

        </tr>
          @endforeach


        <br>
        </table>

        <button type="submit" >Lancer la configuration</button>

        </form>
</table>

@endsection
