@extends('layouts.menus')

@section('title', 'Motos')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto-list.css')}}"/>

<h1>Hello</h1>

@section('categories')
  <div @style ([
        'background-color : grey',
        'display: flex',
        'flex-wrap: nowrap',
        'justify-content: space-around',
        'padding: auto',
        'align-items: center',
        ])>
        @foreach ($ranges as $range)
            <a href="/motos-filtered?id={{ $range->idgamme }}" class="categories">
                {{ $range->libellegamme }}
            </a>
        @endforeach
    </div>
@endsection

@section('content')
<h2>Les motos</h2>
<ul>
   @foreach ($motos as $moto)
   <a href="/moto?id={{ $moto->idmoto }}" @style(['color: black','text-decoration: none'])>
   <div
   @style([
        'background: #FAFAFA',
        'border-radius: 1rem',
        'box-shadow: 0 0 5px #0000001c',
        'padding: 2em',
        'border : solid'
        ])>
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
