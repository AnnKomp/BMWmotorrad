<x-app-layout>
    <button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

    <div id="popup-overlay" onclick="closePopup()"></div>
    <div id="popup-container">
        <div id="popup-content">
            <span id="close-popup" onclick="closePopup()">&times;</span>
            <h2>Le profil</h2>
            <br>
            <h3>Editer le compte</h3>
            <p>Vous pouvez éditer vos informations en modifiant les champs proposés.</p>
            <br>
            <img src="/img/guideimages/profiledit.png" alt="" class="popupimg">
            <br>
            <p>Une fois les informations modifiées, cliquez sur le bouton "Enregistrer" pour sauvegarder les modifications.</p>
            <br>
            <img src="/img/guideimages/profileditbutton.png" alt="" class="popupimg">
            <br>
            <h3>Supprimer/Anonymiser le compte</h3>
            <br>
            <p>Vous pouvez supprimer votre compte en cliquant sur le bouton correspondant. Si vous avez déjà passé au moins une commande, supprimer votre compte n'est pas possible mais il est possible de l'anonymiser.</p>
            <br>
            <img src="/img/guideimages/deleteaccount.png" alt="" class="popupimg">
            <br>
            <p>Entrez le mot de passe de votre compte puis confirmez votre choix en cliquant sur le bouton (ce choix n'est pas réversible).</p>
            <br>
            <img src="/img/guideimages/deletebutton.png" alt="" class="popupimg">
        </div>
    </div>
    <link rel="stylesheet" href="/css/profile.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-adress-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
