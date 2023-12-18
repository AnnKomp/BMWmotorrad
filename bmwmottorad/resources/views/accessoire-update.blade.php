<x-commapp>
@section('title', 'Modifier Accessoire')

<link rel="stylesheet" type="text/css" href="{{asset('css/modif-eq.css')}}">

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


    <h2>Modifier Accessoire</h2>

    <form action="{{ route('updateAccessoire', ['idmoto' => $idmoto, 'idaccessoire' => $idaccessoire]) }}" method="post">
        @csrf

        <label for="accName">Nom de l'Accessoire :</label>
        <input type="text" name="accName" id="accName" value="{{ $accessoire->nomaccessoire }}" required>

        <label for="accPrice">Prix de l'Accessoire :</label>
        <input type="number" name="accPrice" id="accPrice" value="{{ $accessoire->prixaccessoire }}" required>

        <br>
        <label for="accDetail">Détail de l'Accessoire :</label>
        <input type="text" name="accDetail" id="accDetail" value="{{ $accessoire->detailaccessoire }}" required>

        <label for="accPhoto">Lien de la Photo :</label>
        <input type="text" name="accPhoto" id="accPhoto" value="{{ $accessoire->photoaccessoire }}" required>

        <br>
        <button type="submit" name="action" value="update">Mettre à Jour</button>
        <a href="/moto-commercial?id={{ $idmoto }}">
            <button type="button">Annuler</button>
        </a>    </form>

        </div></div></div>

</x-commapp>
