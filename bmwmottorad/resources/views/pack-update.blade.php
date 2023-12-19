<x-commapp>
@section('title', 'Modifier Pack')

<link rel="stylesheet" type="text/css" href="{{asset('css/modif-eq.css')}}">

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


    <h2>Modifier Pack</h2>

    <form action="{{ route('updatePack', ['idmoto' => $idmoto, 'idpack' => $idpack]) }}" method="post">
        @csrf

        <label for="packName">Nom de l'Pack :</label>
        <input type="text" name="packName" id="packName" value="{{ $pack->nompack }}" required>
        <br>
        <label for="packPrice">Prix de l'Pack :</label>
        <input type="number" name="packPrice" id="packPrice" value="{{ $pack->prixpack }}" required>

        <br>
        <label for="packDetail">Détail de l'Pack :</label>
        <textarea name="packDetail" id="packDetail" required>{{ $pack->descriptionpack }}</textarea>
        <br>
        <label for="packPhoto">Lien de la Photo :</label>
        <textarea type="text" name="packPhoto" id="packPhoto" required>{{ $pack->photopack }}</textarea>

        <br>
        <button type="submit" name="action" value="update">Mettre à Jour</button>
        <a href="/moto-commercial?id={{ $idmoto }}">
            <button type="button">Annuler</button>
        </a>    </form>

        </div></div></div>

</x-commapp>
