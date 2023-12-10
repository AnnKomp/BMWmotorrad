<x-app-layout>
    <link rel="stylesheet" href="/css/command-detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détail de la commande') }}
        </h2>
    </x-slot>

    <table>
        <th>Nom équipement</th>
        <th>Photo équipement</th>
        <th>Quantité</th>
    @foreach ($command as $article)
        <tr>
            <td>Equipement n°{{ $article->idequipement }}</td>
            <td>Quantitée : {{ $article->quantite }}</td>
        </tr>
    @endforeach
    </table>

    <a class="cancel" href="">Annuler la commande</a>
</x-app-layout>
