@extends('layouts.menus')


@section('title', 'Information Option:')



@section('content')
<table>
@foreach ($options as $option)
<ul>
     <h2>Option :</h2>
     <h3 id="nom">{{ $option->nomoption }}</h3>
     <h3>Prix : &#xA0;</h3>
     <li>  {{ $option->prixoption }}  €</li>
     <h3>Description de l'option :</h3>
     <p>{{ $option->detailoption}}</p>
     <h3>Image de l'option :</h3>
     <img src={{ $option->photooption }}>
</ul>
</table>
@endforeach

@if(session('lastUsedView') == 'pack')
    <a href="{{ url('/' . session('lastUsedView') . '?id=' . $idpack)}}">Retour</a>
@endif

@endsection
