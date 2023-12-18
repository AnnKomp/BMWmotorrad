<x-commapp>

@section('title', 'Modifier Caractéristique')

<link rel="stylesheet" type="text/css" href="{{asset('css/modif-eq.css')}}">

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

    <h2>Modifier Caractéristique</h2>

    <form action="{{ route('update-caracteristique', ['idmoto' => $idmoto, 'idcaracteristique' => $idcaracteristique]) }}" method="post">
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

        <br>
        <label for="carValue">Valeur de la Caractéristique :</label>
        <input type="text" name="carValue" id="carValue" value="{{ $caracteristique->valeurcaracteristique }}" required>

        <br>
        <button type="submit" name="action" value="update">Mettre à Jour</button>
        <a href="/moto-commercial?id={{ $idmoto }}">
            <button type="button">Annuler</button>
        </a>

    </form>

        </div></div></div>

</x-commapp>
