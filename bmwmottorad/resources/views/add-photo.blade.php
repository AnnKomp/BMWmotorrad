<x-commapp>

@section('title', 'Ajouter une nouvelle moto')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


    <h2>Ajouter une nouvelle photo</h2>

    <form action="{{ route('addPhoto') }}" method="post">
        @csrf
        <input type="hidden" name="idmoto" value="{{ $idmoto }}">
        <label for="lien">Lien de la photo :</label>
        <input type="text" name="lienmedia" id="lienmedia" required>

        <button type="submit">Suivant</button>
    </form>

        </div></div></div>
</x-commapp>
