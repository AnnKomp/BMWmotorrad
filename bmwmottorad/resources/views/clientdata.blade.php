<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vos données personnelles') }}
        </h2>
</x-slot>

<section class="space-y-6">
    <form action="{{ route('profile.clientdownload') . '?id=' . auth()->user()->idclient }}" method="post">
    @csrf
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Nous mettons à votre disposition la liste des données personnelles vous concernant que nous stockons sous le format d\'un fichier pdf.') }}
        </p>
    <x-primary-button>{{ __('Télécharger le PDF') }}</x-primary-button>
    </form>
</section>
</x-app-layout>