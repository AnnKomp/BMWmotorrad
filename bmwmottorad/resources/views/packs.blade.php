@extends('layouts.app')


@section('title', 'Equipements moto :')


@section('content')

<form action="packs" method="post">
@csrf
<h2>Les packs</h2>
<table>
  <tr> 
    <th></th>
    <th>Nom</th> 
    <th>Descripion</th> 
</tr>
   @foreach ($packs as $pack)
<tr>
     <td><input type="checkbox" name="packs[]"></td> 
     <td id="nom"><a href="/pack?id={{ $pack->idpack }}" @style(['color: black','text-decoration: none'])>{{ $pack->nompack }} </a>
     </td>
     <td>{{ $pack->descriptionpack }}</td>
     <td> <img src="{{ $pack->photopack }}" width=100% height=100></td>
</tr>
  @endforeach

</table>
<br>

<button type="submit">Finir le choix des packs</button>

</form>

@endsection


