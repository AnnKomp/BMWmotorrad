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
    </div>
@endsection

@section('content')
<button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Choisir la couleur de la moto</h2>
        <p>Dans cette première étape de la configuration, vous devez choisir la couleur/style de votre moto
            (Vous ne pouvez en choisir qu'une seule).
            A droite se trouve la liste des couleurs disponibles pour le modèle de moto choisi ainsi que le prix de chaque couleur de moto.
        </p>
        <img src="/img/guideimages/colorlist.png" alt="" class="popupimg">
        <p>Il vous est possible de cliquer sur l'image de la couleur pour avoir un aperçu de la moto.</p>
        <img src="/img/guideimages/colorpreview.png" alt="" class="popupimg">
        <h3>Choisir la couleur</h3>
        <img src="/img/guideimages/colorchoice.png" alt="" class="popupimg">
        <p>Une fois votre choix fait, il suffit de cocher le bouton situé à gauche de l'image de la couleur.</p>
        <img src="/img/guideimages/colorchosed.png" alt="" class="popupimg">
        <p>Pour poursuivre la configuration de votre moto, cliquez sur le bouton "Lancer la configuration".</p>
        <img src="/img/guideimages/startconfig.png" alt="" class="popupimg">
    </div>
</div>
<form action="{{ route('processColors')}}?id={{$idmoto}}" method="post" >
    @csrf
    <div class="couleur">
        <table class="lanceconfig">
            <tr><td class="lanceconfig"><div>
            @if ($idcouleur == 0 )
                <img class="moto_color" src="{{ $motos[0]->lienmedia }}">
            @elseif ( $type != "style")
                <img class="moto_color" src="{{ $source[0]->motocouleur }}">
            @else
                <img class="moto_color" src="{{ $source[0]->photomoto }}">
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
                <td><input type="radio" name="option[]" value="{!! 'color_' . $color->idcouleur !!}" checked @if(in_array("color_{$color->idcouleur}", session('selectedOption', []))) checked @endif></td>
                <td class="couleur"><a href="/moto/color?idmoto={{$idmoto}}&idcouleur={{ $color->idcouleur }}"><img src="{{$color->photocouleur}}"></a></td>
                <td class="couleur">{{ $color->nomcouleur }}</td>
                <td class="pack">{{ $color->prixcouleur }} €</td>
                </tr>
            @endforeach
            <tr><td><h3>Styles</h3></td></tr>
            @foreach ($styles as $style)
            <tr>
                <td><input type="radio" name="option[]" value="{!! 'style_' . $style->idstyle !!}" checked @if(in_array("style_{$style->idstyle}", session('selectedOption', []))) checked @endif></td>
                <td class="couleur"><a href="/moto/color?idmoto={{$idmoto}}&idcouleur={{ $style->idstyle }}&type=style"><img src="{{$style->photostyle}}"></a></td>
                <td class="couleur">{{ $style->nomstyle }}</td>
                <td class="pack">{{ $style->prixstyle }} €</td>
            </tr>
            @endforeach
        </table>



    </div>
</form>


@endsection
