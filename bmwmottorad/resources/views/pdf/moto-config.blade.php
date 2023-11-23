<!-- resources/views/pdf/moto-config.blade.php -->

@extends('layouts.menus')

@section('title', 'Moto Configurée')

@section('content')
    <h1>Moto configurée</h1>

    <h2>Packs</h2>
    <ul>
        @foreach($packs as $pack)
            <li>{{ $pack->nompack }} - {{ $pack->prixpack }}</li>
        @endforeach
    </ul>

    <h2>Options</h2>
    <ul>
        @foreach($options as $option)
            <li>{{ $option->nomoption }} - {{ $option->prixoption }}</li>
        @endforeach
    </ul>

    <h2>Accessoires</h2>
    <ul>
        @foreach($accessoires as $accessoire)
            <li>{{ $accessoire->nomaccessoire }} - {{ $accessoire->prixaccessoire }}</li>
        @endforeach
    </ul>

    <h3>*Pas de style / couleur car pas fait*</h3>
@endsection
