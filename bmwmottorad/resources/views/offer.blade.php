@extends('layouts.menus')
<link rel="stylesheet" href="/css/essai.css">
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('title', 'Motorrad')

@section('content')
<button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Faire une demande d'offre</h2>
        <p>Afin de faire une demande d'offre veuillez remplir le formulaire avec les informations requises et choisir un concessionnaire.</p>
        <img src="/img/guideimages/essaiform.png" alt="" class="popupimg"> 
        <p>Une fois le formulaire remplis, il suffit de cliquer sur le bouton envoyer ma demande. Vous serez redirigé(e) vers une page de confirmation.
             Le concessionnaire prendra ensuite contact avec vous par mail pour planifier la demande
        </p>
        <img src="/img/guideimages/essaibutton.png" alt="" class="popupimg">
    </div>
</div>
<div id="form">
    <form action="{{ route('essaipost') }}" method="POST">
    @csrf
        <div style="display: none;">
            <x-text-input id="idmoto" type="number" name="idmoto" :value="old('idmoto', $idmoto)" />
            {{ $idmoto }}
        </div>

        <!-- Personnal informations part -->
        <div>
            <!-- First name -->
            <div class="mt-4">
                <x-input-label for="firstname" :value="__('Prénom*')" />
                <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
            </div>
            <!-- Last name -->
            <div class="mt-4">
                <x-input-label for="lastname" :value="__('Nom*')" />
                <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
            </div class="mt-4">
            <!-- Email address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Adresse e-mail*')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!-- Birthday -->
            <div class="mt-4">
                <x-input-label for="datenaissance" :value="__('Date de naissance*')" />
                <input type="date" id="datenaissance" name="datenaissance" class="block mt-1 w-full">
                <x-input-error :messages="$errors->get('datenaissance')" class="mt-2" />
            </div>
            <!-- Phone numbers -->
            <div class="mt-4">
                <x-input-label for="telephone" :value="__('Numéro de téléphone*')" />
                <x-text-input minlength="10" maxlength="10" id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')"  autofocus autocomplete="telephone" />
                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="objet" :value="__('Objet de la demande*')" />
                <textarea id="objet" class="block mt-1 w-full" type="text" name="objet" :value="old('objet')" required autofocus></textarea>
                <x-input-error :messages="$errors->get('objet')" class="mt-2" />
            </div class="mt-4">
        </div>

        <!-- Concessionnaire choice part -->
        <div>
            <div>
                <x-input-label for="concessionnaire" :value="__('Concessionnaire*')" />
                <select id="concessionnaire" type="text" name="concessionnaire" :value="old('concessionnaire')" required autofocus class="block mt-1 w-full">
                        @foreach ($concessionnaires as $conce)
                            <option value="{{ $conce->idconcessionnaire}}"> {{$conce->nomconcessionnaire . " | " . $conce->adresse}}</option>
                        @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4">
            <p>* : champ obligatoire</p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Envoyer ma demande') }}
            </x-primary-button>
        </div>
    </form>
</div>
@endsection
