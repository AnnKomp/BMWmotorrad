<x-guest-layout>
    <link rel="stylesheet" href="/css/login.css">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('phoneverification') }}">
        @csrf


        <H1>Un code d'authentification' a été envoyé au : {{ $numero->numtelephone }}</H1>

        <div>
            <x-input-label for="code" :value="__('Code d\'authentification')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" minlength="6" maxlength="6" required autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button class="ms-3">
                {{ __('Valider le code') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>