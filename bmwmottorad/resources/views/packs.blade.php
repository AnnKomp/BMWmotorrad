@extends('layouts.menus')


@section('title', 'Equipements moto :')


@section('content')

<form action="packs" method="post">
@csrf
<h2>Les packs</h2>
<table>
  <tr> 
    <th>Chack</th>
    <th>Image</th> 
    <th>Nom</th> 
    <th>Plus d'info</th> 
</tr>
   @foreach ($packs as $pack)
<tr>
     <td><input type="checkbox" name="packs[]"></td> 
     <td> <img src="{{ $pack->photopack }}" width=100% height=100></td>
     <td id="nom"><a href="/pack?id={{ $pack->idpack }}" @style(['color: black','text-decoration: none'])>{{ $pack->nompack }} </a></td>
     <td id="nom"><a href="/pack?id={{ $pack->idpack }}" @style(['color: black','text-decoration: none','text-align: center'])> ? </a></td>
</tr>
  @endforeach

</table>
<br>

<button type="submit">Continuer la configuration</button>

</form>

@endsection


