<x-commapp>

@section('title', 'Modifier Option')

<link rel="stylesheet" type="text/css" href="{{asset('css/modif-eq.css')}}">

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


    <h2>Modifier Option</h2>

    <form action="{{ route('updateOption', ['idmoto' => $idmoto, 'idoption' => $idoption]) }}" method="post">
        @csrf

        <label for="optName">Nom de l'Option :</label>
        <input type="text" name="optName" id="optName" value="{{ $option->nomoption }}" required>

        <label for="optPrice">Prix de l'Option :</label>
        <input type="number" name="optPrice" id="optPrice" value="{{ $option->prixoption }}" required>

        <br>
        <label for="optDetail">Détail de l'Option :</label>
        <input type="text" name="optDetail" id="optDetail" value="{{ $option->detailoption }}" required>

        <label for="optPhoto">Lien de la Photo :</label>
        <input type="text" name="optPhoto" id="optPhoto" value="{{ $option->photooption }}" required>

        <br>
        <button type="submit" name="action" value="update">Mettre à Jour</button>
        <a href="/moto-commercial?id={{ $idmoto }}">
            <button type="button">Annuler</button>
        </a>    </form>

        </div></div></div>

</x-commapp>
