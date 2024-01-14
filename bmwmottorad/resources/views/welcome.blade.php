@extends('layouts.menus')

@section('title', 'Accueil')


@section('content')
<<<<<<< HEAD


<button onclick="openPopup()" class="guidebutton">Besoin d'aide ?</button>
=======
<button onclick="openPopup()" class="guidebutton"><img src="img/guideimages/moreinfoicon.png" alt=""></button>
>>>>>>> d4ebc4ce2aff9e9df3add4482271ddb6274b9ca9

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Bienvenue sur BMW Motorrad !</h2>
        <p>Vous trouverez au cours de votre visite plusieurs boutons pouvant ouvrir des fenêtres contextuelles comme ici. Ces fenêtres ont pour but
            de vous guider dans votre utilisation du site en cas de besoin.
        </p>
        <h3>Le menu de navigation</h3>
        <img src="img/guideimages/navbar.png" alt="" class="popupimg">
        <p> Le menu de navigation présente 5 boutons cliquables, chacun vous menant vers une page différente.</p>
        <h4>Bouton BMW Motorrad</h4>
        <img src="img/guideimages/bmwbutton.png" alt="" class="popupimg">
        <p>Ce bouton vous redirigera vers la page d'acceuil du site BMW Motorrad.</p>
        <h4>Bouton Motos</h4>
        <img src="img/guideimages/motobutton.png" alt="" class="popupimg">
        <p>Ce bouton vous redirigera vers la section des motos du site BMW Motorrad.</p>
        <h4>Bouton Equipements</h4>
        <img src="img/guideimages/equipbutton.png" alt="" class="popupimg">
        <p>Ce bouton vous redirigera vers la section des équipements de motard du site BMW Motorrad.</p>
        <h4>Bouton Panier</h4>
        <img src="img/guideimages/panierbutton.png" alt="" class="popupimg">
        <p>Ce bouton vous permet d'accéder à votre panier afin de visualiser les équipements que vous avez ajouté au panier et pouvoir les commander.</p>
        <h4>Bouton Compte</h4>
        <img src="img/guideimages/accountbutton.png" alt="" class="popupimg">
        <p>Ce bouton vous permet d'accéder à votre compte client. Si vous n'êtes pas connecté, vous serez redirigé vers le formulaire de connexion du site.</p>

        <h3>La gestion des cookies</h3>
        <img src="/img/guideimages/cookiesband.png" alt="" class="popupimg">
        <p>Lors de votre première visite de notre site, nous vous demandons de nous fournir vos choix sur la gestion des cookies. vous pouvez au choix accepter tout les cookies, les refuser ou bien les configurer.</p>
        <img src="/img/guideimages/cookieslogo.png" alt="" class="popupimg">
        <p>Si vous souhaitez modifier vos préférences sur les cookies plus tard, vous pouvez cliquer sur ce petit logo situé en bas à droite de l'écran.</p>
        <img src="/img/guideimages/cookiesconfig.png" alt="" class="popupimg">
        <p>vous pouvez ensuite individuellement accepter ou refuser les différents cookies utilisés.</p>

        <h3>Politique de confidentialité</h3>
        <img src="/img/guideimages/footerimg.png" alt="" class="popupimg">
        <p>En pied de page vous pouvez si le souhaiter cliquer sur confidentialité pour accéder à notre politique de confidentialité ou sur cookies pour accéder à notre politique sur les cookies.</p>
    </div>
</div>

<h1>Bienvenue chez BMW Mottorad</h1>
@endsection

<script>
    var botmanWidget = {
        aboutText: '',
        introMessage: "Bienvenue dans notre site web"
    };
</script>

<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
