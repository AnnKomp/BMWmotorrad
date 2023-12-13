@extends('layouts.menus')
{{-- Other layout setup --}}

@section('title', 'Ajouter une nouvelle caractéristique')

@section('content')

    <h2>Ajouter une nouvelle caractéristique</h2>

    <form action="{{ route('addCaracteristic') }}" method="post">
        @csrf

        <input type="hidden" name="idmoto" value="{{ $idmoto }}">


        <label for="carCat">Catégorie de caractéristique :</label>
        <select name="carCat" id="carCat">
            {{-- Populate options based on your categoieCaracteristique data --}}
            @foreach ($catcarac as $categorie)
                <option value="{{ $categorie->idcatcaracteristique }}">{{ $categorie->nomcatcaracteristique }}</option>
            @endforeach
        </select>


        <label for="carName">Nom de la caractéristique :</label>
        <input type="text" name="carName" id="carName" required>

        <label for="carVal">Valeur de la caractéristique :</label>
        <input type="text" name="carVal" id="carVal" required>

        <button type="submit" name="action" value="proceedAgain">Ajouter et Continuer</button>
        <button type="submit" name="action" value="next">Ajouter et Passer ensuite</button>
        <a href="{{ route('startPage') }}"><button type="button">Annuler</button></a>
    </form>

@endsection
