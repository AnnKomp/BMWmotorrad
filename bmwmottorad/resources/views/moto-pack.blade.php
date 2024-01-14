@php
    $motoname = $motos[0]->nommoto;
@endphp

@extends('layouts.menus')

@section('title', 'Moto')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('css/options.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


@section('content')
<button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Le choix des packs</h2>
        <p>Dans cette seconde étape, vous pouvez choisir des packs pour votre moto. 
            Ces packs réunissent plusieures options de la moto. 
            Il est possible de choisir plusieurs packs.</p>
        <p>Chaque pack a une image de présentation ainsi que son prix.</p>
        <img src="/img/guideimages/packlist.png" alt="" class="popupimg">
        <p>Vous pouvez cliquer sur le i à droite d'un pack pour en savoir plus sur son contenu.</p>
        <img src="/img/guideimages/packmoreinfo.png" alt="" class="popupimg">
        <h3>Choisir un pack</h3>
        <img src="/img/guideimages/packchose.png" alt="" class="popupimg">
        <p>Pour sélectionner un pack, il suffit de cocher la case à gauche de l'image du pack.</p>
        <img src="/img/guideimages/packchosed.png" alt="" class="popupimg">
        <p>Pour poursuivre la configuration de votre moto, cliquez sur le bouton "Suivant: option". 
            Pour revenir à l'étape précédente, cliquez sur le bouton "Précédent"</p>
        <img src="/img/guideimages/optionsbutton.png" alt="" class="popupimg">
        <img src="/img/guideimages/precedentbutton.png" alt="" class="popupimg">
    </div>
</div>
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
                <a class="link" href="/pack?id={{ $pack->idpack }}">{{ $pack->nompack }} </a>
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
        <a id="lancerconfig" href="{{ url('/moto/color?idmoto=' . $idmoto) }}" class="link">Précédent</a>

        <button id="lancerconfig" type="submit">Suivant : options</button>

        </form>
</table>

@endsection
