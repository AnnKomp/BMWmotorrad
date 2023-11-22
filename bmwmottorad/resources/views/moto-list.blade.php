@extends('layouts.menus')

@section('title', 'Motos')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto-list.css')}}"/>

@section('categories')
    <div class = 'header_category'>
        <a href="/motos" class="categories">Voir tout</a>
        @foreach ($ranges as $range)
            <a href="/motos-filtered?id={{ $range->idgamme }}" class="categories">
                {{ $range->libellegamme }}
            </a>
        @endforeach
    </div>
@endsection

@section('content')
<div class = 'moto_display'>
   @foreach ($motos as $moto)
   <a href="/moto?id={{ $moto->idmoto }}" class = "moto_lien">
   <div class = 'moto_box'>
        <div class = 'moto_name'>
        {{ $moto->nommoto }}
        </div>
        <img src={{$moto->lienmedia}} width=100% height=100%>


    </div>
   </a>

  @endforeach
</div>
@endsection
