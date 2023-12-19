<x-commapp>
    <link rel="stylesheet" type="text/css" href="{{asset('css/modif-eq.css')}}">

    @section('title', 'Ajouter une nouvelle caractéristique')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h2>Ajouter une nouvelle caractéristique</h2>
                <br>

                <form action="{{ route('addCaracteristic') }}" method="post">
                    @csrf

                    <input type="hidden" name="idmoto" value="{{ $idmoto }}">

                    <label for="carCat">Catégorie de caractéristique :</label>
                    <select name="carCat" id="carCat">
                        @foreach ($catcarac as $categorie)
                            <option value="{{ $categorie->idcatcaracteristique }}">{{ $categorie->nomcatcaracteristique }}</option>
                        @endforeach
                    </select>

                    <br><br>

                    <label for="carName">Nom de la caractéristique :</label>
                    <input type="text" name="carName" id="carName" required>

                    <label for="carVal">Valeur de la caractéristique :</label>
                    <input type="text" name="carVal" id="carVal" required>


                    <br><br>
                    <button type="submit" name="action" value="proceedAgain">Ajouter et Continuer</button>
                    <button type="submit" name="action" value="next">Ajouter et Passer ensuite</button>

                    <a href="{{ route('showOption', ['idmoto' => $idmoto]) }}">
                        <button type="button">Passer directement à Options</button>
                    </a>

                    <a href="{{ route('showMotoCommercial', ['id' => $idmoto]) }}">
                        <button type="button">Annuler</button>
                    </a>
                </form>

            </div>
        </div>
    </div>
</x-commapp>
