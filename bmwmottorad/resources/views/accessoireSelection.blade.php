@extends('layouts.menus')


@section('title', 'Equipements moto :')


@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/options.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Choisir des accessoires</h2>
        <p>Dans cette quatrième étape, vous pouvez choisir des accessoires pour votre moto. Il est possible de choisir plusieurs accessoires.</p>
        <p>Chaque accessoire a une image de présentation ainsi que son prix.</p>
        <img src="/img/guideimages/accessoirelist.png" alt="" class="popupimg">
        <p>Vous pouvez cliquer sur le i à droite d'un accessoire pour en savoir plus sur ce qu'il apporte.</p>
        <img src="/img/guideimages/accessoiremoreinfo.png" alt="" class="popupimg">
        <h3>Choisir un accessoire</h3>
        <img src="/img/guideimages/accessoirechose.png" alt="" class="popupimg">
        <p>Pour sélectionner un accessoire, il suffit de cocher la case à gauche de l'image de l'accessoire.</p>
        <img src="/img/guideimages/accessoirechosed.png" alt="" class="popupimg">
        <p>Pour poursuivre la configuration de votre moto, cliquez sur le bouton "Finir la configuration". Pour revenir à l'étape précédente, cliquez sur le bouton "Précédent"</p>
        <img src="/img/guideimages/endconfigbutton.png" alt="" class="popupimg">
        <img src="/img/guideimages/precedentbutton.png" alt="" class="popupimg">
    </div>
</div>

<form action="{{ route('processAccessoires')}}?id={{$idmoto}}" method="post">
@csrf
<h2>Accessoires (installés chez votre Concessionnaire)</h2>
<table>
@foreach ($accessoires as $accessoire)
<tr>
    <td class="option">
        <input class="check" type="checkbox" name="accessoires[]" value="{{$accessoire->idaccessoire}}">
    </td>
    <td class="option"><img src="{{ $accessoire->photoaccessoire }}" ></td>
    <td id="nom">{{ $accessoire->nomaccessoire }}</td>
    <td class="option">{{ $accessoire->prixaccessoire }} €</td>
    <td class="option"><a href="/accessoire?id={{ $accessoire->idaccessoire }}&idmoto={{$idmoto}}">
        <i class="fa fa-info-circle"></i>
    </a></td>

</tr>
  @endforeach

</table>
<br>

<a  id="config" href="{{ url('/options?id=' . $idmoto)}}"> Précédent</a>

<button type="submit" id="config">Finir la configuration</button>

</form>

@endsection


