@extends('layouts.menus')
{{-- Other layout setup --}}

@section('title', 'Ajouter une nouvelle option')

@section('content')

    <h2>Ajouter une nouvelle option</h2>

    <div class="option-form-container">
        <form action="{{ route('addOption') }}" method="post">
            @csrf

            <input type="hidden" name="idmoto" value="{{ $idmoto }}">

            <label for="newOptionName">Nom de la nouvelle option :</label>
            <input type="text" name="newOptionName" id="newOptionName" required>

            <label for="newOptionPrice">Prix de la nouvelle option :</label>
            <input type="number" name="newOptionPrice" id="newOptionPrice" required>

            <label for="newOptionDetail">Détails de la nouvelle option :</label>
            <textarea name="newOptionDetail" id="newOptionDetail" rows="4" required></textarea>

            <label for="newOptionPhotoUrl">URL de la photo de la nouvelle option :</label>
            <input type="url" name="newOptionPhotoUrl" id="newOptionPhotoUrl" required>

            <button type="submit" name="action" value="restart">Ajouter et Redémarrer</button>
            <button type="submit" name="action" value="proceedToAccessories">Ajouter et Passer aux Accessoires</button>
        </form>
    </div>

    <div class="existing-options-container">
        <h3>Options existantes</h3>
        <form action="{{ route('addOption') }}" method="post">
            @csrf

            <input type="hidden" name="idmoto" value="{{ $idmoto }}">

            <label for="existingOption">Sélectionner une option existante :</label>
            <select name="existingOption" id="existingOption">
                {{-- Populate options based on your exOptions data --}}
                @foreach ($exOptions as $option)
                    <option value="{{ $option->idoption }}">{{ $option->nomoption }}</option>
                @endforeach
            </select>

            <button type="submit" name="action" value="restart">Ajouter et Redémarrer</button>
            <button type="submit" name="action" value="proceedToAccessories">Ajouter et Passer aux Accessoires</button>
            <a href="{{ route('startPage') }}"><button type="button">Annuler</button></a>
        </form>
    </div>

@endsection