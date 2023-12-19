<x-commapp>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('MODIFICATION EQUIPEMENT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p>Prix actuel : {{ $prixDeBase }} </p>
                <form action="{{ route('equipment.update') }}" method="post">
                    @csrf
                    @method('post')
                    <input type="hidden" name="idequipement" value="{{ $identifiantEquipment }}">
                    <label for="prix">Prix de l'équipement :</label>
                    <input type="number" name="prix" value="{{ old('prix', $prixDeBase) }}" required>
                    @error('prix')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <button type="submit" style="background-color: #bbbbbb">Mettre à jour</button>
                </form>
            </div>
            <br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p>Coloris actuels :</p>
                <table>
                    @foreach ($colorisOptions as $colori)
                        <li>{{ $colori->nomcoloris }}</li>
                    @endforeach
                </table>

                <br>

                <form action="{{ route('equipement.coloris.add') }}" method="post">
                    @csrf
                    @method('post')
                    <input type="hidden" name="idequipement" value="{{ $identifiantEquipment }}">
                    <h3>Ajouter couleur :</h3>
                    <select name="idcoloris" id="idcoloris">
                        @foreach($coloris as $couleur)
                            @if (!in_array($couleur->idcoloris, $colorisOptions->pluck('idcoloris')->toArray()))
                                <option value="{{ $couleur->idcoloris }}">{{ $couleur->nomcoloris }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" style="background-color: #bbbbbb">Ajouter coloris</button>
                </form>

            </div>
        </div>
    </div>
</x-commapp>
