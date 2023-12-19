<x-commapp>

@section('title', 'Ajouter un pack')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


    <h2>Ajouter un pack</h2>

    <form action="{{ route('addPack') }}" method="post">
        @csrf

        <input type="hidden" name="idmoto" value="{{ $idmoto }}">

        <label for="accName">Nom du pack :</label>
        <input type="text" name="accName" id="accName" required>
        <br>
        <label for="accPrice">Prix :</label>
        <input type="number" name="accPrice" id="accPrice" required>

        <br>
        <label for="accDetail">Détail pack :</label>
        <textarea rows="4" name="accDetail" id="accDetail" required></textarea>
        <br>
        <label for="accPhoto">Lien photo pack :</label>
        <textarea type="url" name="accPhoto" id="accPhoto" required></textarea>
<br>

        <button  type="submit" name="action" value="proceedAgain">Ajouter et Continuer</button>

        <a href="{{ route('startPage') }}"><button type="button">Annuler</button></a>
    </form>

        </div>
    </div>
</div>

</x-commapp>
