<x-app-layout>
    <button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

    <div id="popup-overlay" onclick="closePopup()"></div>
    <div id="popup-container">
        <div id="popup-content">
            <span id="close-popup" onclick="closePopup()">&times;</span>
            <h2>La liste des commandes</h2>
            <br>
            <p>Cette section vous donne accès aux commandes que vous avez passé avec votre compte.</p>
            <img src="/img/guideimages/commandliste.png" alt="" class="popupimg">
            <br>
            <p>Pour avoir le détail d'une commande, cliquez sur l'icône d'information de la commande correspondante.</p>
            <img src="/img/guideimages/commandbutton.png" alt="" class="popupimg">
        </div>
    </div>
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
                @elseif ( $command->etat == 2)
                    <td>Annulée</td>
                @else
                    <td>Etat inconnu, contactez un administrateur</td>
                @endif
                @if ( $command->etat != 2)
                    <td><a href="/profile/commands/detail?idcommand={{ $command->idcommande }}"><i class="fa fa-info-circle"></i></td>
                @endif
            </tr>
        @endforeach
    </table>

</x-app-layout>
