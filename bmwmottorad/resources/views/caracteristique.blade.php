@extends('layouts.menus')
{{-- Other layout setup --}}

@section('title', 'Modifier Caractéristique')

@section('content')

    <h2>Modifier Caractéristique</h2>

    <form action="{{ route('updateCaracteristique', ['idmoto' => $idmoto, 'idcaracteristique' => $idcaracteristique]) }}" method="post">
        @csrf

        <label for="carCat">Catégorie de Caractéristique :</label>
        <select name="carCat" id="carCat">
            {{-- Populate options based on your categoieCaracteristique data --}}
            @foreach ($catcarac as $categorie)
                <option value="{{ $categorie->idcatcaracteristique }}" {{ $categorie->idcatcaracteristique == $selectedCatId ? 'selected' : '' }}>{{ $categorie->nomcatcaracteristique }}</option>
            @endforeach
        </select>

        <label for="carName">Nom de la Caractéristique :</label>
        <input type="text" name="carName" id="carName" value="{{ $caracteristique->nomcaracteristique }}" required>

        <label for="carValue">Valeur de la Caractéristique :</label>
        <input type="text" name="carValue" id="carValue" value="{{ $caracteristique->valeurcaracteristique }}" required>

        <button type="submit" name="action" value="update">Mettre à Jour</button>
        <a href="{{ route('showMotoCommercial', ['idmoto' => $idmoto]) }}"><button type="button">Annuler</button></a>
    </form>

@endsection
