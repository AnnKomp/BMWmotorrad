<!-- resources/views/fraislivraison.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('FRAIS DE LIVRAISON') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p>Montant actuel des frais de livraison : {{ $fraisLivraison->description }} </p>
                <form action="{{ url('/fraislivraison') }}" method="post">
                    @csrf
                    @method('post')
                    <label for="description">Nouveau montant des frais de livraison :</label>
                    <input type="text" name="description" value="{{ old('description') }}" required>
                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
