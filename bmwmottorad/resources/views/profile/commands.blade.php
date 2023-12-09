<x-app-layout>
    <link rel="stylesheet" href="/css/commands-list.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mes Commandes') }}
        </h2>
    </x-slot>

    <table class='oui'>
        <th>Numéro commande</th>
        <th>Date</th>
        <th>Etat de la commande</th>
        <th>Détails</th>
        @foreach ($commands as $date => $command)
            <tr>
                <td>{{ $command[0]->idcommande }}</td>
                <td>{{ $date }}</td>
                @if ( $command[0]->etat == 2)
                    <td>Livrée</td>
                @elseif ( $command[0]->etat == 1)
                    <td>En cours</td>
                @elseif ( $command[0]->etat == 0)
                <td>Annulée</td>
                @endif
                <td><a href="/pack?id=1&idmoto=1"><i class="fa fa-info-circle"></i></a></td>
            </tr>
        @endforeach
    </table>

</x-app-layout>
