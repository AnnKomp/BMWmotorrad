<!-- resources/views/pdf/moto-config.blade.php -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ public_path('css/pdf.css') }}"/>
    <title>Moto configurée</title>

</head>

<body>

    <h1>Votre configuration de la moto {{ $moto->nommoto }}</h1>

<h2 id=price>Prix total : {{ $totalPrice}} €</h2>


@if ( $selectedPacks->isNotEmpty())

<h2 id=nom>Packs : </h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Prix</th>
        <th>Photo</th>
    </tr>
    @foreach($selectedPacks as $pack)
        <tr>
            <td>{{ $pack->nompack }}</td>
            <td>{{ $pack->prixpack }}</td>
            <td><img src="{{ $pack->photopack }}" alt="{{ $pack->nompack }}"></td>
            </tr>
    @endforeach
</table>

@endif

@if ( $selectedOptions->isNotEmpty())


<h2 id=nom>Options : </h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Prix</th>
        <th>Photo</th>
    </tr>
    @foreach($selectedOptions as $option)
        <tr>
            <td>{{ $option->nomoption }}</td>
            <td>{{ $option->prixoption }}</td>
            <td><img src="{{ $option->photooption }}" alt="{{ $option->nomoption }}"></td>
            </tr>
    @endforeach
</table>

@endif

@if ( $selectedAccessoires->isNotEmpty())

<h2 id=nom>Accessoires : </h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Prix</th>
        <th>Photo</th>
    </tr>
    @foreach($selectedAccessoires as $accessoire)
        <tr>
            <td>{{ $accessoire->nomaccessoire }}</td>
            <td>{{ $accessoire->prixaccessoire }}</td>
            <td><img src="{{ $accessoire->photoaccessoire }}" alt="{{ $accessoire->nomaccessoire }}"></td>
            </tr>
    @endforeach
</table>

@endif

@if ( $selectedColor->isNotEmpty())

    <h2 id=nom>Couleur :
        @foreach($selectedColor as $color)
            <h3 id=nom>{{ $color->nomcouleur }}</h3>


    <div style="text-align: center;">
            <img width="80%" src={{ $color->motocouleur }} >
            </div>
        @endforeach
    </h2>

@endif

@if ( $selectedStyle->isNotEmpty())

    <h2 id=nom>Style :
        @foreach($selectedStyle as $style)
            <h3 id=nom>{{ $style->nomstyle }}</h3>


    <div style="text-align: center;">
            <img width="80%" src={{ $style->photomoto }} >
            </div>
        @endforeach
    </h2>

@endif


</body>
</html>
