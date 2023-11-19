<x-guest-layout>
    <script src="/js/registerdropdown.js" defer></script>
    <link rel="stylesheet" href="/css/registersuite.css">
    <form method="POST" action="{{ route('registersuite') }}">
        @csrf

        <!-- Account type -->
        <div>
            <x-input-label for="accounttype" :value="__('Type de Compte')" />
            <select id="accounttype" type="text" name="accounttype" :value="old('accounttype')" required autofocus class="block mt-1 w-full">
                <option value="private">Privé</option>
                <option value="professionnal">Professionnel</option>
            </select>
        </div>

        <!-- Company Name -->
        <div id="companynamediv" style="display: none;">
            <x-input-label for="nomcompagnie" :value="__('Nom de la Compagnie')" />
            <x-text-input id="nomcompagnie" class="block mt-1 w-full" type="text" name="nomcompagnie" :value="old('nomcompagnie')" autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('nomcompagnie')" class="mt-2" />
        </div>

        <!-- Country -->
        <div>
            <x-input-label for="nompays" :value="__('Pays')" />
            <select id="nompays" type="text" name="nompays" :value="old('nompays')" required autofocus class="block mt-1 w-full">
                    <!-- Get all the countries for table Pays and put it into the dropdown list -->
                    @foreach ($pays as $pay)
                        <option value="{{ $pay->nompays}}"> {{$pay->nompays}}</option>
                    @endforeach
            </select>
        </div>

        <!-- Postal Code -->
        <div>
            <x-input-label for="codepostal" :value="__('Code Postal')" />
            <x-text-input id="codepostal" class="block mt-1 w-full" type="number" name="codepostal" :value="old('codepostal')" required autofocus autocomplete="codepostal" />
            <x-input-error :messages="$errors->get('codepostal')" class="mt-2" />
        </div>

        
        <!-- City -->
        <div>
            <x-input-label for="ville" :value="__('Ville')" />
            <x-text-input id="ville" class="block mt-1 w-full" type="text" name="ville" :value="old('ville')" required autofocus autocomplete="ville" />
            <x-input-error :messages="$errors->get('ville')" class="mt-2" />
        </div>

        
        <!-- Rue -->
        <div>
            <x-input-label for="rue" :value="__('Rue')" />
            <x-text-input id="rue" class="block mt-1 w-full" type="text" name="rue" :value="old('rue')" required autofocus autocomplete="rue" />
            <x-input-error :messages="$errors->get('rue')" class="mt-2" />
        </div>

        
        <!-- Numéro Rue -->
        <div>
            <x-input-label for="numrue" :value="__('Numéro de Rue')" />
            <x-text-input id="numrue" class="block mt-1 w-full" type="number" name="numrue" :value="old('numrue')" required autofocus autocomplete="numrue" />
            <x-input-error :messages="$errors->get('numrue')" class="mt-2" />
        </div>

         <!-- Birthday -->
        <div>
            <x-input-label for="datenaissanceclient" :value="__('Date de naissance')" />
            <input type="date" id="datenaissanceclient" name="datenaissanceclient" class="block mt-1 w-full">
            <x-input-error :messages="$errors->get('datenaissanceclient')" class="mt-2" />
        </div>

        <!-- Account Phone number -->
        <div>
            <div id="phonenumber">
                <!-- Phone number -->
                <div>
                    <x-input-label for="numtelephone" :value="__('Numéro de Rue')" />
                    <x-text-input id="numtelephone" class="block mt-1 w-full" type="tel" name="numtelephone" :value="old('numtelephone')" required autofocus autocomplete="firstname" />
                    <x-input-error :messages="$errors->get('numtelephone')" class="mt-2" />
                </div>
                <!-- Phone number type -->
                <div>
                    <x-input-label for="numbertype" :value="__('Type de Numéro')" />
                    <div id="numbertype">
                        <!-- Number Type -->
                        <select id="typedropdown" type="text" name="type" :value="old('type')" required autofocus class="block mt-1 w-full">
                            <option value="Fixe">Fixe</option>
                            <option value="Mobile">Mobile</option>
                        </select>
                        <!-- Number Function -->
                        <select id="typedropdown" type="text" name="fonction" :value="old('fonction')" required autofocus class="block mt-1 w-full">
                            <option value="Privé">Privé</option>
                            <option value="Professionnel">Professionnel</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>



        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
