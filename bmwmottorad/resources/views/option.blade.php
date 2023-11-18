@extends('layouts.app')


@section('title', 'Information Option:')



@section('content')
<table>
@foreach ($options as $option)
<tr>
     <td id="nom">{{ $option->nomoption }}</td>
     <td>{{ $option->prixoption }}</td>
     <td>{{ $option->detailoption}}</td>
     <td>{{ $option->photoopion }}</td>
</tr>
</table>
@endforeach

@endsection