<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informations du compte') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Modifier les informations de votre compte") }}
        </p>
    </header>

    <form method="post" action="{{ route('adress.update') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="nompays" :value="__('Pays')" />
            <x-text-input id="nompays" name="nompays" type="text" class="mt-1 block w-full" :value="$adress->nompays" required autofocus autocomplete="nompays" />
            <x-input-error class="mt-2" :messages="$errors->get('nompays')" />
        </div>

        <div>
            <x-input-label for="numrue" :value="__('Numéro de Rue')" />
            <x-text-input id="numrue" name="numrue" type="text" class="mt-1 block w-full" :value="$adress->numrue" required autofocus autocomplete="numrue" />
            <x-input-error class="mt-2" :messages="$errors->get('numrue')" />
        </div>

        <div>
            <x-input-label for="rue" :value="__('Rue')" />
            <x-text-input id="rue" name="rue" type="text" class="mt-1 block w-full" :value="$adress->rue" required autofocus autocomplete="rue" />
            <x-input-error class="mt-2" :messages="$errors->get('rue')" />
        </div>

        <div>
            <x-input-label for="ville" :value="__('Ville')" />
            <x-text-input id="ville" name="ville" type="text" class="mt-1 block w-full" :value="$adress->ville" required autofocus autocomplete="ville" />
            <x-input-error class="mt-2" :messages="$errors->get('ville')" />
        </div>

        <div>
            <x-input-label for="codepostal" :value="__('Code Postal')" />
            <x-text-input id="codepostal" name="codepostal" type="number" class="mt-1 block w-full" :value="$adress->codepostal" required autofocus autocomplete="codepostal" />
            <x-input-error class="mt-2" :messages="$errors->get('codepostal')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
