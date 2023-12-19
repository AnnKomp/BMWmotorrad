<x-commapp>

    <link rel="stylesheet" type="text/css" href="{{asset('css/modif-eq.css')}}">


@section('title', 'Ajouter une nouvelle option')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


    <h2>Ajouter une nouvelle option</h2>
    <br>

    <div class="option-form-container">
        <form action="{{ route('addOption') }}" method="post">
            @csrf

            <input type="hidden" name="idmoto" value="{{ $idmoto }}">

            <label for="newOptionName">Nom de la nouvelle option :</label>
            <input type="text" name="newOptionName" id="newOptionName" required>

            <label for="newOptionPrice">Prix de la nouvelle option :</label>
            <input type="number" name="newOptionPrice" id="newOptionPrice" required>

            <br><br>
            <label for="newOptionDetail">Détails de la nouvelle option :</label>
            <textarea name="newOptionDetail" id="newOptionDetail" rows="4" required></textarea>

            <br><br>
            <label for="newOptionPhotoUrl">URL de la photo de la nouvelle option :</label>
            <input type="url" name="newOptionPhotoUrl" id="newOptionPhotoUrl" required>

            <br><br>
            <button type="submit" name="action" value="restart">Ajouter et Redémarrer</button>
            <button type="submit" name="action" value="proceedToAccessories">Ajouter et Passer aux Accessoires</button>
        </form>
    </div>

    <br><br><br>
    <div class="existing-options-container">
        <h3>Options existantes</h3>
        <form action="{{ route('addOption') }}" method="post">
            @csrf

            <br>
            <input type="hidden" name="idmoto" value="{{ $idmoto }}">

            <label for="existingOption">Sélectionner une option existante :</label>
            <select name="existingOption" id="existingOption">
                {{-- Populate options based on your exOptions data --}}
                @foreach ($exOptions as $option)
                    <option value="{{ $option->idoption }}">{{ $option->nomoption }}</option>
                @endforeach
            </select>

            <br><br>
            <button type="submit" name="action" value="restart">Ajouter et Redémarrer</button>
            <button type="submit" name="action" value="proceedToAccessories">Ajouter et Passer aux Accessoires</button>

            <a href="{{ route('showAcc', ['idmoto' => $idmoto]) }}">
                <button type="button">Passer directement à Accessoires</button>
            </a>

            <a href="{{ route('showMotoCommercial', ['id' => $idmoto]) }}">
                <button type="button">Annuler</button>
            </a>
        </form>
    </div>

        </div></div></div>
</x-commapp>
