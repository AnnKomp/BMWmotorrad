<!-- resources/views/pdf/moto-config.blade.php -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/pdf.css')}}"/> --}}
    <title>Moto configurée</title>
</head>
<body>

    <h1>Votre configuration de la moto {{ $moto->nommoto }}</h1>

    <h2 id=price>Prix total : {{ $totalPrice}} €</h2>

    <h2>Packs</h2>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Photo</th>
        </tr>
        @foreach($selectedPacks as $pack)
            <tr>
                <td>{{ $pack->nompack }}</td>
                <td>{{ $pack->descriptionpack }}</td>
                <td>{{ $pack->prixpack }}</td>
                <td><img src="{{ $pack->photopack }}" alt="Pack Photo" width="100"></td>
            </tr>
        @endforeach
    </table>

    <h2>Options</h2>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Photo</th>
        </tr>
        @foreach($selectedOptions as $option)
            <tr>
                <td>{{ $option->nomoption }}</td>
                <td>{{ $option->detailoption }}</td>
                <td>{{ $option->prixoption }}</td>
                <td><img src="{{ $option->photooption }}" alt="Pack Photo" width="100"></td>
            </tr>
        @endforeach
    </table>

    <h2>Accessoires</h2>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Photo</th>
        </tr>
        @foreach($selectedAccessoires as $accessoire)
            <tr>
                <td>{{ $accessoire->nomaccessoire }}</td>
                <td>{{ $accessoire->detailaccessoire }}</td>
                <td>{{ $accessoire->prixaccessoire }}</td>
                <td><img src="{{ $accessoire->photoaccessoire }}" alt="Pack Photo" width="100"></td>
            </tr>
        @endforeach
    </table>


    <h2 id=nom>Couleur :
        @foreach($selectedColor as $color)
            <h3>{{ $color->nomcouleur }}</h3>
            <img width="80%" src={{ $color->motocouleur }} >
        @endforeach
    </h2>


</body>
</html>
