<x-app-layout>
    <link rel="stylesheet" href="/css/commands-list.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mes Commandes') }}
        </h2>
    </x-slot>

    <table>
        <th>Numéro commande</th>
        <th>Date</th>
        <th>Etat de la commande</th>
        <th>Détails</th>
        @foreach ($commands as $date => $command)
            <tr>
                <td>{{ $command->idcommande }}</td>
                <td>{{ date('d-M-Y', strtotime($command->datecommande)) }}</td>
                @if ( $command->etat == 0)
                    <td>En cours</td>
                @elseif ( $command->etat == 1)
                    <td>Livrée</td>
                @endif
                <td><a href="/profile/commands/detail?idcommand={{ $command->idcommande }}"><i class="fa fa-info-circle"></i></a></td>
            </tr>
        @endforeach
    </table>

</x-app-layout>
