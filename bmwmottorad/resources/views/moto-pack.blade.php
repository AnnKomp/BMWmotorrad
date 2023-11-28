@php
    $motoname = $motos[0]->nommoto;
@endphp

@extends('layouts.menus')

@section('title', 'Moto')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


@section('content')


<h2>Packs</h2>
<table>

    <form action="{{ route('processPacks')}}?id={{$idmoto}}" method="post" >
        @csrf
           @foreach ($packs as $pack)
        <tr>
            <td class="pack">
                <input class="check" type="checkbox" name="packs[]" value="{{ $pack->idpack }}" @if(in_array($pack->idpack, session('selectedPacks', []))) checked @endif>
            </td>
            <td class="pack">
                <img src="{{ $pack->photopack }}" width=auto height=200px>
            </td>
            <td id="nom">
                <a href="/pack?id={{ $pack->idpack }}">{{ $pack->nompack }} </a>
            </td>
            @if ( $pack->prixpack =="")
                <td class="pack">0.00 €</td>
            @else
                <td class="pack">{{ $pack->prixpack }} €</td>
            @endif

            <td class="pack"><a href="/pack?id={{ $pack->idpack }}&idmoto={{$idmoto}}"><i class="fa fa-info-circle"></i></a></td>

        </tr>
          @endforeach


        <br>
        </table>
        <a id="lancerconfig" href="{{ url('/moto/color?idmoto=' . $idmoto) }}">Précedent</a>

        <button id="lancerconfig" type="submit">Suivant : options</button>

        </form>
</table>

@endsection
