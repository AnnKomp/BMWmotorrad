@extends('layouts.menus')

@section('title', 'Game')

<link rel="stylesheet" type="text/css" href="{{asset('css/description-pack.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



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
    <th>Plus d'infos</th>
</tr>
   @foreach ($options as $option)
<tr>
    <td id="name">{{ $option->nomoption }}</td>
    <td>{{ $option->detailoption }}</td>
    <td><a href="/option?id={{ $option->idoption }}"><i class="fa fa-info-circle"></i></a></td>
</tr>
  @endforeach


</table>


@endsection
