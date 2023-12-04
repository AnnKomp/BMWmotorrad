@extends('layouts.menus')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('title', 'Motorrad')

@section('content')

<link rel="stylesheet" href="/css/essai.css">

<div id="form">
    <form action="{{ route('essaipost') }}" method="POST">
    @csrf

    <H1>Votre demande d'essai a été envoyée avec succès. Le concessionnaire choisi vous contactera sous peu.</H1>

    <a href="/motos">
        <button>Retourner à la navigation</button>
    </a>

</div>

@endsection
