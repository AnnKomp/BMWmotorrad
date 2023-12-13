@extends('layouts.menus')
{{-- Other layout setup --}}

@section('title', 'Ajouter un accessoire')

@section('content')

    <h2>Ajouter un accessoire</h2>

    <form action="{{ route('addAccessoire') }}" method="post">
        @csrf

        <input type="hidden" name="idmoto" value="{{ $idmoto }}">

        <label for="accCat">Catégorie de caractéristique :</label>
        <select name="accCat" id="carCat">
            {{-- Populate options based on your categoieCaracteristique data --}}
            @foreach ($catacc as $categorie)
                <option value="{{ $categorie->idcatacc }}">{{ $categorie->nomcatacc }}</option>
            @endforeach
        </select>

        <label for="accName">Nom de l'accessoire :</label>
        <input type="text" name="accName" id="accName" required>

        <label for="accPrice">Prix :</label>
        <input type="number" name="accPrice" id="accPrice" required>

        <label for="accDetail">Détail :</label>
        <textarea rows="4" name="accDetail" id="accDetail" required></textarea>

        <label for="accPhoto">Lien photo :</label>
        <input type="url" name="accPhoto" id="accPhoto" required>


        <button type="submit" name="action" value="proceedAgain">Ajouter et Continuer</button>
        <button type="submit" name="action" value="next">Ajouter et Passer ensuite</button>
        <a href="{{ route('startPage') }}"><button type="button">Annuler</button></a>
    </form>

@endsection
