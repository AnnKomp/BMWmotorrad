<x-commapp>

    <link rel="stylesheet" type="text/css" href="{{asset('css/modif-eq.css')}}">


@section('title', 'Ajouter un accessoire')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


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

        <br>
        <label for="accDetail">Détail :</label>
        <textarea rows="4" name="accDetail" id="accDetail" required></textarea>

        <label for="accPhoto">Lien photo :</label>
        <input type="url" name="accPhoto" id="accPhoto" required>
<br>

        <button type="submit" name="action" value="proceedAgain">Ajouter et Continuer</button>
        <button type="submit" name="action" value="next">Ajouter et Finir</button>

        <a href="{{ route('showMotoCommercial', ['id' => $idmoto]) }}">
            <button type="button">Finir</button>
        </a>
    </form>

        </div>
    </div>
</div>

</x-commapp>
