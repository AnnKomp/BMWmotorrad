<x-commapp>

@section('title', 'Rajout gamme :')
<link rel="stylesheet" href="{{asset('css/add-gamme.css')}}">


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

    <div id=left-side>
        <h3>Gammes </h3>
        <table>
            @foreach ($gammes as $gamme)
                <tr>
                    <p> {{ $gamme->libellegamme }} </p>
                </tr>
            @endforeach
        </table>
    </div>

    <div id=right-side>
        <h3>Ajouter une nouvelle gamme</h3>
        <input type="text" id="newGammeName" placeholder="Nom de la nouvelle gamme">
        <br>
        <button onclick="addNewGamme()">Ajouter</button>
        <button onclick="cancelAdd()"> Annuler</button>

    </div>
</div>
</div>
</div>

    <script>

        function addNewGamme() {
            var newGammeName = document.getElementById('newGammeName').value;

            if(newGammeName.trim() !== '') {
                fetch('/add-gamme', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ gammeName: newGammeName }),
                })
                .then(response => {
                    console.log('Server raw response:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Server response:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                console.log('Error: New game name cant be empty')
            }


            console.log('Adding new gamme : ' + newGammeName)
        }


        function cancelAdd() {
            document.getElementById('newGammeName').value = '';
            console.log('Canceled adding new game');

        }



    </script>

</x-commapp>
