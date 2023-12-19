<x-commapp>

@section('title', 'Ajouter une nouvelle moto')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


    <h2>Ajouter une nouvelle moto</h2>

    <form action="{{ route('addMoto') }}" method="post">
        @csrf

        <label for="motoGamme">Gamme :</label>
        <select name="motoGamme" id="motoGamme">
            {{-- Populate options based on your gamme data --}}
            @foreach ($gammes as $gamme)
                <option value="{{ $gamme->idgamme }}">{{ $gamme->libellegamme }}</option>
            @endforeach
        </select>

        <label for="motoName">Nom de la moto :</label>
        <input type="text" name="motoName" id="motoName" required>

        <label for="motoDesc">Descriptif :</label>
        <textarea name="motoDesc" id="motoDesc" rows="4" required></textarea>

        <label for="motoPrice">Prix :</label>
        <input type="number" name="motoPrice" id="motoPrice" min=1 required>

        <label for="mediaPresentation">Lien photo de présentation :</label>
        <input type="text" name="mediaPresentation" id="mediaPresentation" required>

        <button type="submit">Continuer la création</button>
        <button type="submit" name="action" value="finishLater">Finir la création plus tard</button>
    </form>

        </div></div></div>
</x-commapp>
