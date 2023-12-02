@extends('layouts.menus')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('title', 'Motorrad')

@section('content')

<form action="" method="POSṡ">
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
            <x-input-label for="datenaissanceclient" :value="__('Date de naissance*')" />
            <input type="date" id="datenaissanceclient" name="datenaissanceclient" class="block mt-1 w-full">
            <x-input-error :messages="$errors->get('datenaissanceclient')" class="mt-2" />
        </div>
        <!-- Phone numbers -->
        <div class="mt-4">
            <x-input-label for="telephonepvmb" :value="__('Téléphone privé mobile')" />
            <x-text-input minlength="10" maxlength="10" id="telephonepvmb" class="block mt-1 w-full" type="tel" name="telephonepvmb" :value="old('telephonepvmb')"  autofocus autocomplete="telephonepvmb" />
            <x-input-error :messages="$errors->get('telephonepvmb')" class="mt-2" />
        </div>
    </div>

    <!-- Concessionnaire choice part -->
    <div>
        
    </div>
</form>

@endsection
