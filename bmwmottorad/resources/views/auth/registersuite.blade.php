<x-guest-layout>
    <script src="/js/registerdropdown.js" defer></script>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Civilite -->
        <div>
            <x-input-label for="civilite" :value="__('Type de Compte')" />
            <select id="typedropdown" type="text" name="civilite" :value="old('civilite')" required autofocus>
                <option value="private">Privé</option>
                <option value="professionnal">Professionnel</option>
            </select>
            <x-input-error :messages="$errors->get('civilite')" class="mt-2" />
        </div>

        <!-- First Name -->
        <div id="companynamediv" style="display: none;">
            <x-input-label for="firstname" :value="__('Nom de la Compagnie')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <!-- First Name -->
        <div id="companynamediv">
            <x-input-label for="firstname" :value="__('Code Postal')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        
        <!-- First Name -->
        <div id="companynamediv">
            <x-input-label for="firstname" :value="__('Ville')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        
        <!-- First Name -->
        <div id="companynamediv">
            <x-input-label for="firstname" :value="__('Rue')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        
        <!-- First Name -->
        <div id="companynamediv">
            <x-input-label for="firstname" :value="__('Numéro de Rue')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
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
