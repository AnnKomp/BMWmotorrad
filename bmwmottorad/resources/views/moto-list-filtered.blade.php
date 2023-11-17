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
<ul>
@foreach($motos as $moto)
<a href="/moto?id={{ $moto->idmoto }}" @style(['color: black','text-decoration: none'])>
    <div class = 'moto_box'>
        <div @style(['color: red'])>
            {{ $moto->nommoto }}
        </div>
        <div>
            {{ $moto->descriptifmoto }}
        </div>


    </div>


</a>
@endforeach
</ul>

@endsection
