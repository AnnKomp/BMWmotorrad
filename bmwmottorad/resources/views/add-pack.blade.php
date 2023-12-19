<x-commapp>

@section('title', 'Ajouter un pack')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <link rel="stylesheet" type="text/css" href="{{asset('css/modif-eq.css')}}">


    <h2>Ajouter un pack</h2>

    <form action="{{ route('addPack') }}" method="post">
        @csrf

        <input type="hidden" name="idmoto" value="{{ $idmoto }}">

        <label for="nompack">Nom du pack :</label>
        <input type="text" name="nompack" id="nompack" required>
        <label for="nompack" style="color: red">Attention ! Une moto ne peut pas avoir plusieurs packs avec le même nom !</label>
        <br>
        <label for="prixpack">Prix :</label>
        <input type="number" name="prixpack" id="prixpack" required>

        <br>
        <label for="descriptionpack">Détail pack :</label>
        <textarea rows="4" name="descriptionpack" id="descriptionpack" required></textarea>
        <br>
        <label for="photopack">Lien photo pack :</label>
        <textarea type="url" name="photopack" id="photopack" required></textarea>
        <br>

        <button  type="submit" name="action" value="proceedAgain">Ajouter</button>

        <a href="{{ route('startPage') }}"><button type="button">Annuler</button></a>
    </form>

        </div>
    </div>
</div>



</x-commapp>
