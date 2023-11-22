<section>
    <script src="/js/adresssyntax.js" defer></script>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Adresse enregistrée') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Modifier les informations de votre adresse") }}
        </p>
    </header>

    <form method="post" action="{{ route('adress.update') }}" class="mt-6 space-y-6">
        @csrf

        <!-- Country -->
        <div>
            <x-input-label for="nompays" :value="__('Pays')" />
            <select id="nompays" type="text" name="nompays" :value="$adress->nompays" required autofocus class="block mt-1 w-full" autocomplete="nompays">
                    <!-- Get all the countries for table Pays and put it into the dropdown list -->
                    @foreach ($pays as $pay)
                        <option value="{{ $pay->nompays}}" {{ $pay->nompays == $adress->nompays ? 'selected' : '' }}> {{$pay->nompays}}</option>
                    @endforeach
            </select>
        </div>

        @if(!is_null($company))
        <div>
            <x-input-label for="nomcompagnie" :value="__('Nom de la compagnie')" />
            <x-text-input id="nomcompagnie" name="nomcompagnie" type="text" class="mt-1 block w-full" :value="($company->nomcompagnie)" autofocus autocomplete="nomcompagnie" />
            <x-input-error class="mt-2" :messages="$errors->get('nocompagnie')" />
        </div>
        @endif

        <!-- Address -->
        <div>
            <x-input-label for="adresse" :value="__('Adresse')" />
            <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse', $adress->adresse)" list="adress_list" onkeyup="findAdress()" required autofocus autocomplete="adresse" />
            <datalist id='adress_list'>
            </datalist>
            <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
        </div>

        @foreach ($phones as $phone)
        <div>
            <x-input-label for="{{$phone->type}}{{$phone->fonction}}" :value="('Téléphone ' . $phone->type . ' ' . $phone->fonction)" />
            <x-text-input minlength="10" maxlength="10" id="{{$phone->type}}{{$phone->fonction}}" name="{{$phone->type}}{{$phone->fonction}}" type="tel" class="mt-1 block w-full" :value="($phone->numtelephone)" autofocus autocomplete="{{$phone->type}}{{$phone->fonction}}" />
            <x-input-error class="mt-2" :messages="$errors->get('{{$phone->type}}{{$phone->fonction}}')" />
        </div>
        @endforeach

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
