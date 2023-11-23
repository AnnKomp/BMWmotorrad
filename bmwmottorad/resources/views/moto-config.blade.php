@extends('layouts.menus')

@section('title', 'Moto')

@section('content')
<h1>Moto configurée</h1>

<h2>*genre photo*</h2>

<h2>Packs</h2>
    <ul>
        @foreach($selectedPacks as $pack)
            <li>{{ $pack->nompack }} - {{ $pack->prixpack }}</li>
        @endforeach
    </ul>

<h2>Options</h2>
    <ul>
        @foreach($selectedOptions as $option)
            <li>{{ $option->nomoption }} - {{ $option->prixoption }}</li>
        @endforeach
    </ul>

    <h2>Accessoires</h2>
    <ul>
        @foreach($selectedAccessoires as $accessoire)
            <li>{{ $accessoire->nomaccessoire }} - {{ $accessoire->prixaccessoire }}</li>
        @endforeach
    </ul>


<h3>*Pas de style / couleur car pas fait*</h3>


<form action="{{ route('pdf-download') . '?id=' . $idmoto }}" method="post">
    @csrf
    <button type="submit">Télécharger PDF</button>
</form>


@endsection
