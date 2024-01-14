<x-guest-layout>
    <button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

    <div id="popup-overlay" onclick="closePopup()"></div>
    <div id="popup-container">
        <div id="popup-content">
            <span id="close-popup" onclick="closePopup()">&times;</span>
            <h2>Création de compte</h2>
            <p>Pour créer votre compte, veuillez fournir les informations nécessaires, puis une fois cela fait, cliquez sur "S'INSCRIRE" pour créer votre compte et passer à la seconde partie.</p>
            <img src="/img/guideimages/createbutton.png" alt="" class="popupimg">
            <p>Vous pouvez cliquer sur le logo BMW pour retourner à l'accueil du site.</p>
            <img src="/img/guideimages/registerhomebutton.png" alt="" class="popupimg">
        </div>
    </div>
    <!-- First form for the account creation -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <x-input-error :messages="$errors->get('google')" class="mt-2" />
        <!-- Civilite -->
        <div>
            <x-input-label for="civilite" :value="__('Civilité*')" />
            <select id="civilite" class="bloc mt-1 w-full" type="text" name="civilite" :value="old('civilite')" required autofocus>
                <option value="M">M.</option>
                <option value="Mme">Mme</option>
            </select>
            <x-input-error :messages="$errors->get('civilite')" class="mt-2" />
        </div>

        <!-- First Name -->
        <div>
            <x-input-label for="firstname" :value="__('Prénom*')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <!-- Last name -->
        <div>
            <x-input-label for="lastname" :value="__('Nom*')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Adresse e-mail*')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe*')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer Mot de passe*')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <p>* : champ obligatoire</p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Déjà inscrit?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
