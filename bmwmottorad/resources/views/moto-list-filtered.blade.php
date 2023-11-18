@extends('layouts.menus')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto-list.css')}}"/>

@section('categories')
  <div class = 'header_category'>
        @foreach ($ranges as $range)
            <a href="/motos-filtered?id={{ $range->idgamme }}" class = "categories">
                {{ $range->libellegamme }}
            </a>
        @endforeach
    </div>
@endsection


@section('content')
<div class="moto_display">
@foreach($motos as $moto)
<a href="/moto?id={{ $moto->idmoto }}" class = "moto_lien">
    <div class = 'moto_box' >
        <div class = 'moto_name'>
            {{ $moto->nommoto }}
        </div>
        <img width=100% height=100% src={{$moto->lienmedia}}>


    </div>


</a>
@endforeach
</div>

<img src="blob:https://www.bmw-motorrad.fr/e12f87f5-2647-48d8-b755-60b3b88dea1b">

@endsection
