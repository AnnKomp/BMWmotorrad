@extends('layouts.menus')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('title', 'Motorrad')

@section('content')

<link rel="stylesheet" href="/css/essai.css">

<button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Confirmation de la demande d'essai</h2>
        <p>Maintenant que votre demande a été validée, le concessionnaire prendra contact avec vous sous peu par mail afin de continuer la procédure.</p>
    </div>
</div>
<div id="form">

    <H1>Votre demande d'essai a été envoyée avec succès. Le concessionnaire choisi vous contactera sous peu par mail.</H1>

    <a href="/" id="essairedirect">
        <button>Naviguer sur le site</button>
    </a>
</div>

@endsection
