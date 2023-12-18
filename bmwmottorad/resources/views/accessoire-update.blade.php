@extends('layouts.menus')
{{-- Other layout setup --}}

@section('title', 'Modifier Accessoire')

@section('content')

    <h2>Modifier Accessoire</h2>

    <form action="{{ route('updateAccessoire', ['idmoto' => $idmoto, 'idaccessoire' => $idaccessoire]) }}" method="post">
        @csrf

        <label for="accName">Nom de l'Accessoire :</label>
        <input type="text" name="accName" id="accName" value="{{ $accessoire->nomaccessoire }}" required>

        <label for="accPrice">Prix de l'Accessoire :</label>
        <input type="number" name="accPrice" id="accPrice" value="{{ $accessoire->prixaccessoire }}" required>

        <label for="accDetail">Détail de l'Accessoire :</label>
        <input type="text" name="accDetail" id="accDetail" value="{{ $accessoire->detailaccessoire }}" required>

        <label for="accPhoto">Lien de la Photo :</label>
        <input type="text" name="accPhoto" id="accPhoto" value="{{ $accessoire->photoaccessoire }}" required>

        <button type="submit" name="action" value="update">Mettre à Jour</button>
        <a href="{{ route('showMotoCommercial', ['idmoto' => $idmoto]) }}"><button type="button">Annuler</button></a>
    </form>

@endsection
