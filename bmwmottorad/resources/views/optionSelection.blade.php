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
        <h2>Choisir des options</h2>
        <p>Dans cette troisième étape, vous pouvez choisir des options pour votre moto. Ces options permettent de customiser la moto. Il est possible de choisir plusieurs options.</p>
        <p>Chaque option a une image de présentation ainsi que son prix.</p>
        <img src="/img/guideimages/optionlist.png" alt="" class="popupimg">
        <p>Vous pouvez cliquer sur le i à droite d'une option pour en savoir plus sur ce qu'elle apporte.</p>
        <img src="/img/guideimages/optionmoreinfo.png" alt="" class="popupimg">
        <h3>Choisir une option</h3>
        <img src="/img/guideimages/optionchose.png" alt="" class="popupimg">
        <p>Pour sélectionner une option, il suffit de cocher la case à gauche de l'image de l'option.</p>
        <img src="/img/guideimages/optionchosed.png" alt="" class="popupimg">
        <p>Pour poursuivre la configuration de votre moto, cliquez sur le bouton "Suivant: accessoires concessionnaire". Pour revenir à l'étape précédente, cliquez sur le bouton "Précédent"</p>
        <img src="/img/guideimages/accessoirebutton.png" alt="" class="popupimg">
        <img src="/img/guideimages/precedentbutton.png" alt="" class="popupimg">
    </div>
</div>

<form action="{{ route('processOptions')}}?id={{$idmoto}}" method="post">
@csrf
<h2>Options (montées d'usine)</h2>
<table>
   @foreach ($options as $option)
<tr>
    <td class="option">
        <input class="check" type="checkbox" name="options[]" value="{{ $option->idoption }}">
    </td>
    <td class="option">
        <img src="{{ $option->photooption }}">
    </td>
    <td id="nom">{{ $option->nomoption }}</td>
    <td class="option">{{ $option->prixoption }} €</td>
    <td class="option"><a href="{{ url('/option?id=' . $option->idoption . '&idmoto=' . $idmoto . '&route=option')}}" >
        <i class="fa fa-info-circle"></i>
    </a></td>

</tr>
  @endforeach

</table>
<br>

<a id="config" href="{{ url('/moto/pack?id=' . $idmoto) }}">Précedent</a>


<button type="submit" id="config">Suivant : accessoires concessionnaire</button>

</form>

@endsection


