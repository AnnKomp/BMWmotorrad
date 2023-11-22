@extends('layouts.menus')


@section('title', 'Equipements moto :')


@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/options.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<form action="{{ route('accessories')}}?id={{$idmoto}}" method="post">
@csrf
<h2>Option (montées d'usine)</h2>
<table>
  <tr>
    <th> </th>
    <th> Photo </th>
    <th> Nom </th>
    <th> Prix </th>
    <th> Info </th>
</tr>
   @foreach ($options as $option)
<tr>
    <td class="option"><input class="check" type="checkbox" name="options[]"></td>
    <td class="option"><img src="{{ $option->photooption }}"></td>
    <td id="nom">{{ $option->nomoption }}</td>
    <td class="option">{{ $option->prixoption }} €</td>
    <td class="option"><a href="/option?id={{ $option->idoption }}" >
        <i class="fa fa-info-circle"></i>
    </a></td>

</tr>
  @endforeach

</table>
<br>

<a id="config" href="{{ url('/moto/pack?id=' . $idmoto)}}"> Précedent</a>

<button type="submit" id="config">Suivant : accessoires concessionnaire</button>

</form>

@endsection


