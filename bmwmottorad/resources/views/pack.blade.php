@extends('layouts.menus')

@section('title', 'Game')

<link rel="stylesheet" type="text/css" href="{{asset('css/description-pack.css')}}"/>


@section('content')
<h2>La description du pack :</h2>

@foreach($pack as $thepack)

<p> {{ $thepack->descriptionpack }}</p>
@endforeach

<h2>Les options du pack :</h2>
<table>
  <tr> 
    <th>Nom</th> 
    <th>Detail</th> 
</tr>
   @foreach ($options as $option)
<tr>
<td id="name"><a href="/option?id={{ $option->idoption }}" @style(['color: black','text-decoration: none'])> {{ $option->nomoption }}</td>
     <td>{{ $option->detailoption }}</td>
</tr>
  @endforeach


</table>


@endsection