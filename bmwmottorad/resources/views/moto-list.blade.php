@extends('layouts.menus')

@section('title', 'Motos')

@section('categories')
  <div @style ([
        'background-color : grey',
        'display: flex',
        'flex-wrap: nowrap',
        'justify-content: space-around',
        'padding: auto',
        'align-items: center',
        ])>

        @foreach ($gammes as $gamme)
            <a @style(['color: black','text-decoration: none','font-size: 2em','height : 1%'])>{{ $gamme->libellegamme }}</a>
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
        'padding: 2em'
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
