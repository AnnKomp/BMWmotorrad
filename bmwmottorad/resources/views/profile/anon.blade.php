<x-dpoapp>
    <link rel="stylesheet" href="/css/profile.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Anonymisation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                <section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Choisir une date d\'anonymisation') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Les changements effectués par la fonction d'anonymisation ne sont pas réversibles, une fois l'anonymisation terminée, il sera impossible de récupérer les comptes en cas de problème.") }}
        </p>
    </header>

    <form method="post" action="{{ route('anon.execute') }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label for="date" :value="__('Date d\'anonymisation ')" />
            <input type="date" id="date" name="date" class="block mt-1 w-full" value="old(date)">
            <x-input-error class="mt-2" :messages="$errors->get('date')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Anonymiser') }}</x-primary-button>
            @if (session('status') === 'data_anonymised')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Comptes anonymisés avec succès.') }}</p>
            @endif
        </div>
    </form>
</section>

                </div>
            </div>
        </div>
    </div>
</x-dpoapp>
