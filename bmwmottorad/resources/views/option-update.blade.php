@extends('layouts.menus')
{{-- Other layout setup --}}

@section('title', 'Modifier Option')

@section('content')

    <h2>Modifier Option</h2>

    <form action="{{ route('updateOption', ['idmoto' => $idmoto, 'idoption' => $idoption]) }}" method="post">
        @csrf

        <label for="optName">Nom de l'Option :</label>
        <input type="text" name="optName" id="optName" value="{{ $option->nomoption }}" required>

        <label for="optPrice">Prix de l'Option :</label>
        <input type="number" name="optPrice" id="optPrice" value="{{ $option->prixoption }}" required>

        <label for="optDetail">Détail de l'Option :</label>
        <input type="text" name="optDetail" id="optDetail" value="{{ $option->detailoption }}" required>

        <label for="optPhoto">Lien de la Photo :</label>
        <input type="text" name="optPhoto" id="optPhoto" value="{{ $option->photooption }}" required>

        <button type="submit" name="action" value="update">Mettre à Jour</button>
        <a href="{{ route('showMotoCommercial', ['idmoto' => $idmoto]) }}"><button type="button">Annuler</button></a>
    </form>

@endsection
