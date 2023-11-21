@extends('layouts.menus')


@section('title', 'Equipements moto :')


@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/options.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<form action="{{ route('accessories')}}?id={{$idmoto}}" method="post">
@csrf
<h2>Les options usine</h2>
<table>
  <tr>
    <th></th>
    <th>Nom</th>
    <th>Prix</th>
</tr>
   @foreach ($options as $option)
<tr>
     <td><input type="checkbox" name="options[]"></td>
     <td id="nom"> <a href="/option?id={{ $option->idoption }}" @style(['color: black','text-decoration: none'])>
     {{ $option->nomoption }}</a>

     </td>
     <td>{{ $option->prixoption }}</td>
</tr>
  @endforeach

</table>
<br>

<button type="submit">Suivant : accessoires concessionnaire</button>

</form>

@endsection


