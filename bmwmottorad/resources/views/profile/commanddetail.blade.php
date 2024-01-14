<x-app-layout>
    <button onclick="openPopup()" class="guidebutton"><img src="/img/guideimages/moreinfoicon.png" alt=""></button>

    <div id="popup-overlay" onclick="closePopup()"></div>
    <div id="popup-container">
        <div id="popup-content">
            <span id="close-popup" onclick="closePopup()">&times;</span>
            <h2>Détail d'une commande</h2>
            <p>Cette section vous permet de voir le détail d'une commande passée.</p>
            <img src="/img/guideimages/commanddetail.png" alt="" class="popupimg">
            <p>Si la commande est toujours en cours, il vous est possible d'annuler des articles en cliquant sur la flêche rouge correspondante.
                Vous serez alors remboursé du montant correspondant au prix de l'article annulé. Si vous annulez tout les articles, la commande sera annulée et vous serez intégralement remboursé(e).
            </p>
            <img src="/img/guideimages/commandcancel.png" alt="" class="popupimg">
        </div>
    </div>
    <link rel="stylesheet" href="/css/command-detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détail de la commande') }}
        </h2>
    </x-slot>

    <!-- Afficher le message de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Afficher le message d'erreur -->
    @if(session('error'))
        <div class="alert">
            {{ session('error') }}
        </div>
    @endif

    <table>
        <th>Photo</th>
        <th>Nom équipement</th>
        <th>Quantité</th>
        <th>Taille</th>
        <th>Couleur</th>
        @foreach ($command as $article)
        <tr>
            <td class="photo-cell"><img src="{{ $article->lienmedia }}" alt="Photo"></td>
            <td>{{ $article->nomequipement }}</td>
            <td>{{ $article->quantite }}</td>
            <td>{{ $article->libelletaille }}/{{ $article->desctaille }}</td>
            <td>{{ $article->nomcoloris }}</td>
            @if ($article->etat == 0)
            <td>
                <form action="{{ route('annuler_commande', ['id_commande' => $article->idcommande, 'id_equipement' => $article->idequipement, 'id_taille' => $article->idtaille, 'id_coloris' => $article->idcoloris, 'quantite' => $article->quantite ]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" title="Supprimer l'article"><i class="fa fa-close" style="color:red"></i></button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </table>
</x-app-layout>
