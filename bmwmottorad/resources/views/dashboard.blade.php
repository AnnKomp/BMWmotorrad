<x-app-layout>
    <button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

    <div id="popup-overlay" onclick="closePopup()"></div>
    <div id="popup-container">
        <div id="popup-content">
            <span id="close-popup" onclick="closePopup()">&times;</span>
            <h2>Votre home BMW Motorrad</h2>
            <p>L'espace de votre compte vous donne accès à plusieurs pages pour contrôler votre compte.</p>
            <img src="/img/guideimages/accountmenu.png" alt="" class="popupimg">
            <h3>Informations du compte</h3>
            <img src="/img/guideimages/profile.png" alt="" class="popupimg">
            <p>"Profil" permet d'accéder aux informations de votre compte et de les éditer. Vous pouvez aussi supprimer votre compte via cette section.</p>
            <h3>Commandes du compte</h3>
            <img src="/img/guideimages/orders.png" alt="" class="popupimg">
            <p>"Mes commandes" sert à gérer vos commandes.</p>
            <h3>Copies des données</h3>
            <img src="/img/guideimages/data.png" alt="" class="popupimg">
            <p>"Données" sert à l'obtention d'une copie des données que nous stockons vous concernant.</p>
            <h3>Déconnexion</h3>
            <img src="/img/guideimages/logout.png" alt="" class="popupimg">
            <p>"Déconnexion" sert à vous déconnecter de votre compte.</p>
        </div>
    </div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('MY BMW MOTORRAD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Bienvenue sur votre home BMW Motorrad !") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
