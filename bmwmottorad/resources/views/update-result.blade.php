<x-commapp>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('UPDATE RESULT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($result === 'success')
                    <p>Équipement mis à jour avec succès!</p>
                @elseif($result === 'not_found')
                    <p>Équipement introuvable.</p>
                @elseif($result === 'negative')
                    <p>Le prix doit être positif et non null.</p>
                @elseif($result === 'add-success')
                    <p>Coloris ajouté avec succès !</p>
                @else
                    <p>Une erreur s'est produite lors de la mise à jour.</p>
                @endif
            </div>
        </div>
    </div>
</x-commapp>
