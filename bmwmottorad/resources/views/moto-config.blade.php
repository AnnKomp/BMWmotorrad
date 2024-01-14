@extends('layouts.menus')

@section('title', 'Moto')


<link rel="stylesheet" type="text/css" href="{{asset('css/moto-config.css')}}"/>


@section('content')
<button onclick="openPopup()" class="guidebutton"><img src="img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Votre configuration</h2>
        <p>Une fois la configuration terminée, vous pouvez télécharger le pdf de votre configuration.
        </p>
        <img src="img/guideimages/pdfdl.png" alt="" class="popupimg">
        <h3>Acheter la moto</h3>
        <p>Les motos ne sont pas directement vendues sur le site, si vous souhaitez l'acquérier, cliquez sur "Faire une demande d'offre" afin de faire une demande auprès d'un concessionnaire.</p>
        <img src="img/guideimages/offerask.png" alt="" class="popupimg">
        <p>La suite se déroulera alors avec le concessionnaire qui prendra contact avec vous.</p>
    </div>
</div>

<h1>Votre configuration de la moto {{ $moto->nommoto }}</h1>

<h2 id=price>Prix total : {{ $totalPrice}} €</h2>


@if ( $selectedPacks->isNotEmpty())

<h2 id=nom>Packs : </h2>
<table>
    <tr>
        <th id=name>Nom</th>
        <th id=price>Prix</th>
        <th id=photo>Photo</th>
    </tr>
    @foreach($selectedPacks as $pack)
        <tr>
            <td id=name>{{ $pack->nompack }}</td>
            <td id=price>{{ $pack->prixpack }}</td>
            <td id=photo><img src="{{ $pack->photopack }}" alt="{{ $pack->nompack }}"></td>
        </tr>
    @endforeach
</table>

@endif

@if ( $selectedOptions->isNotEmpty())


<h2 id=nom>Options : </h2>
<table>
    <tr>
        <th id=name>Nom</th>
        <th id=price>Prix</th>
        <th id=photo>Photo</th>
    </tr>
    @foreach($selectedOptions as $option)
        <tr>
            <td>{{ $option->nomoption }}</td>
            <td>{{ $option->prixoption }}</td>
            <td><img src="{{ $option->photooption }}" alt="{{ $option->nomoption }}"></td>
        </tr>
    @endforeach
</table>

@endif

@if ( $selectedAccessoires->isNotEmpty())

<h2 id=nom>Accessoires : </h2>
<table>
    <tr>
        <th id=name>Nom</th>
        <th id=price>Prix</th>
        <th id=photo>Photo</th>
    </tr>
    @foreach($selectedAccessoires as $accessoire)
        <tr>
            <td>{{ $accessoire->nomaccessoire }}</td>
            <td>{{ $accessoire->prixaccessoire }}</td>
            <td><img src="{{ $accessoire->photoaccessoire }}" alt="{{ $accessoire->nomaccessoire }}"></td>
        </tr>
    @endforeach
</table>

@endif

@if ( $selectedColor->isNotEmpty())

    <h2 id=nom>Couleur :
        @foreach($selectedColor as $color)
            <h3 id=nom>{{ $color->nomcouleur }}</h3>


    <div style="text-align: center;">
            <img width="80%" src={{ $color->motocouleur }} >
            </div>
        @endforeach
    </h2>

@endif

@if ( $selectedStyle->isNotEmpty())

    <h2 id=nom>Style :
        @foreach($selectedStyle as $style)
            <h3 id=nom>{{ $style->nomstyle }}</h3>


    <div style="text-align: center;" id="photomoto">
            <img width="80%" src={{ $style->photomoto }} >
    </div>
        @endforeach
    </h2>

@endif

<a href="/moto/offer?idmoto={{$idmoto}}" class='menus' id="offerbutton">Faire une demande d'offre</a>

<form action="{{ route('pdf-download') . '?id=' . $idmoto }}" method="post">
    @csrf
    <button type="submit" class="pdfbutton">Télécharger PDF</button>
</form>


@endsection
