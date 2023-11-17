@extends('layouts.menus')


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
            <a href="/motos-filtered?id={{ $range->idgamme }}"
            @style(['color: black',
            'text-decoration: none',
            'font-size: 2em',
            'height : 1%'])>
                {{ $range->libellegamme }}
            </a>
        @endforeach
    </div>
@endsection


@section('content')
<ul>
@foreach($motos as $moto)
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
