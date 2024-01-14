<x-guest-layout>
    <script src="/js/register_suite_script.js" defer></script>
    <script src="/js/adresssyntax.js" defer></script>
    <link rel="stylesheet" href="/css/register.css">

    <button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

    <div id="popup-overlay" onclick="closePopup()"></div>
    <div id="popup-container">
        <div id="popup-content">
            <span id="close-popup" onclick="closePopup()">&times;</span>
            <h2>Suite de la création de compte</h2>
            <p>Pour finaliser la création de votre compte, davantage d'informations sont requises. Une fois les informations fournies, cliquez sur le bouton "Créer"</p>
            <img src="/img/guideimages/registersuitebutton.png" alt="" class="popupimg">
        </div>
    </div>
    <!-- Second form for the account creation -->
    <form method="POST" action="{{ route('registersuite') }}">
        @csrf

        <!-- Account type -->
        <div>
            <x-input-label for="accounttype" :value="__('Type de Compte*')" />
            <select id="accounttype" type="text" name="accounttype" :value="old('accounttype')" required autofocus class="block mt-1 w-full">
                <option value="private" {{ old('accounttype') == 'private' ? 'selected' : '' }}>Privé</option>
                <option value="professionnal" {{ old('accounttype') == 'professionnal' ? 'selected' : '' }}>Professionnel</option>
            </select>
            <x-input-error :messages="$errors->get('accounttype')" class="mt-2" />
        </div>

        <!-- Company Name -->
        <div id="companynamediv" style="display: none;">
            <x-input-label for="nomcompagnie" :value="__('Nom de la Compagnie*')" />
            <x-text-input id="nomcompagnie" class="block mt-1 w-full" type="text" name="nomcompagnie" :value="old('nomcompagnie')" autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('nomcompagnie')" class="mt-2" />
        </div>

        <!-- Country -->
        <div>
            <x-input-label for="nompays" :value="__('Pays*')" />
            <select id="nompays" type="text" name="nompays" :value="old('nompays')" required autofocus class="block mt-1 w-full">
                    <!-- Get all the countries for table Pays and put it into the dropdown list -->
                    @foreach ($pays as $pay)
                        <option value="{{ $pay->nompays}}" {{ $pay->nompays == old('nompays') ? 'selected' : '' }}> {{$pay->nompays}}</option>
                    @endforeach
            </select>
            <x-input-error :messages="$errors->get('nompays')" class="mt-2" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="adresse" :value="__('Adresse*')" />
            <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse')" list="adress_list" onkeyup="findAdress()" required autofocus autocomplete="adresse" />
            <datalist id='adress_list'>
            
            </datalist>
            <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
        </div>

         <!-- Birthday -->
        <div>
            <x-input-label for="datenaissanceclient" :value="__('Date de naissance*')" />
            <input type="date" id="datenaissanceclient" name="datenaissanceclient" class="block mt-1 w-full">
            <x-input-error :messages="$errors->get('datenaissanceclient')" class="mt-2" />
        </div>


        <!-- Phone numbers -->
        <div>
            <x-input-label for="telephonepvmb" :value="__('Téléphone privé mobile')" />
            <x-text-input minlength="10" maxlength="10" id="telephonepvmb" class="block mt-1 w-full" type="tel" name="telephonepvmb" :value="old('telephonepvmb')"  autofocus autocomplete="telephonepvmb" />
            <x-input-error :messages="$errors->get('telephonepvmb')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="telephonepfmb" :value="__('Téléphone professionnel mobile')" />
            <x-text-input minlength="10" maxlength="10" id="telephonepfmb" class="block mt-1 w-full" type="tel" name="telephonepfmb" :value="old('telephonepfmb')"  autofocus autocomplete="telephonepfmb" />
            <x-input-error :messages="$errors->get('telephonepfmb')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="telephonepvfx" :value="__('Téléphone privé fixe')" />
            <x-text-input minlength="10" maxlength="10" id="telephonepvfx" class="block mt-1 w-full" type="tel" name="telephonepvfx" :value="old('telephonepvfx')"  autofocus autocomplete="telephonepvfx" />
            <x-input-error :messages="$errors->get('telephonepvfx')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="telephonepffx" :value="__('Téléphone professionnel fixe')" />
            <x-text-input minlength="10" maxlength="10" id="telephonepffx" class="block mt-1 w-full" type="tel" name="telephonepffx" :value="old('telephonepffx')"  autofocus autocomplete="telephonepffx" />
            <x-input-error :messages="$errors->get('telephonepffx')" class="mt-2" />
        </div>

        <h2>Merci de fournir au moins un numéro de téléphone</h2>

        <div class="mt-4">
            <p>* : champ obligatoire</p>
        </div>

        <div class="mt-4">
            <input type="checkbox" id="check"><p>En créant un compte My BMW, vous acceptez notre <a href="" id="rgpd">Politique de confidentialité</a></p></input> 
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Créer') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>document.querySelector("#check").required = true</script>