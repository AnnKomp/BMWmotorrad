@extends('layouts.menus')

@section('title', 'Motos')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto-list.css')}}"/>

@section('categories')
    <div class = 'header_category'>
        <a href="/motos" class="categories">Toutes</a>
        @foreach ($ranges as $range)
            <a href="/motos-filtered?id={{ $range['idgamme'] }}" class="categories">
                {{ $range['libellegamme'] }}
            </a>
        @endforeach
    </div>
@endsection

@section('content')
<button onclick="openPopup()" class="guidebutton"><img src="img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Motos BMW Motorrad</h2>
        <p>Vous vous trouvez sur la page des motos proposées à la .
        </p>
        <h3>Filtrer les motos par gamme</h3>
        <img src="img/guideimages/motofilter.png" alt="" class="popupimg">
        <p>Le bandeau situé en dessous du menu principal contient la liste des différentes gammes de moto vendues. pour n'afficher que les motos d'une gamme, il suffit de cliquer sur le nom de la gamme. appuyer sur Toutes affiche toutes les motos que nous proposons.</p>
        <h3>En savoir plus sur une moto</h3>
        <img src="img/guideimages/motopreview.png" alt="" class="popupimg">
        <p>Chaque moto est représentée par son nom, une image et son prix de départ. Cliquer sur la moto vous redirige vers la page dédiée à ce modèle, contenant davantage d'informations et de fonctionnalitées.</p>
    </div>
</div>
<div class = 'moto_display'>
   @foreach ($motos as $moto)
   <a href="/moto?id={{ $moto->idmoto }}" class = "moto_lien">
   <div class = 'moto_box'>
        <div class = 'moto_name'>
        {{ $moto->nommoto }}
        </div>
        <img src={{$moto->lienmedia}} width=100% height=100%>
        <div class = 'moto_price'>
            <hr NOSHADE ALIGN=CENTER WIDTH="40%" SIZE='5' @style(["margin-block: 5%"])>
            A partir de
            {{ $moto->prixmoto }} €
        </div>


    </div>
   </a>

  @endforeach
</div>
@endsection
