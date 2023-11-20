@extends('layouts.menus')

@section('title', 'Moto')

@section('content')
<h1>Moto configurée/h1>
<h2>*photo moto*</h2>


<h2>Options</h2>
    <ul>
        @foreach($options as $option)
            <li>{{ $option->name }} - {{ $option->price }}</li>
        @endforeach
    </ul>

    <h2>Packs</h2>
    <ul>
        @foreach($packs as $pack)
            <li>{{ $pack->name }} - {{ $pack->price }}</li>
        @endforeach
    </ul>

    <h2>Accessoires</h2>
    <ul>
        @foreach($accessoires as $accessoire)
            <li>{{ $accessoire->nomaccessoire }} - {{ $accessoire->prixaccessoire }}</li>
        @endforeach
    </ul>


<h3>*Pas de style / couleur car pas fait*</h3>


<button>Telecharger la configuration </button>

<p> terminal : "composer require barryvdh/laravel-dompdf"</p>
<p> config/app.php :
    'providers' => [
    // ...
    Barryvdh\DomPDF\ServiceProvider::class,
],

'aliases' => [
    // ...
    'PDF' => Barryvdh\DomPDF\Facade::class,
],</p>

@endsection