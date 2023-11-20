@extends('layouts.menus')


@section('title', 'Information Option:')



@section('content')
<table>
@foreach ($options as $option)
<tr>
     <td id="nom">{{ $option->nomoption }}</td>
     <td>{{ $option->prixoption }}</td>
     <td>{{ $option->detailoption}}</td>
     <td> <img src={{ $option->photooption }} width=100% height=100> </td>
</tr>
</table>
@endforeach

@endsection