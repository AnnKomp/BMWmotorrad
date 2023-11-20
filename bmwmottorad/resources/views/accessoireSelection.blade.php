@extends('layouts.menus')


@section('title', 'Equipements moto :')


@section('content')

<form action="/moto/config?id={{$idmoto}}" method="post">
@csrf
<h2>Les accessoires concesionnaire</h2>
<table>
  <tr> 
    <th></th>
    <th>Nom</th> 
    <th>Prix</th> 
</tr>
  @foreach ($accessoires as $accessoire)
    @if ($idmoto == $accessoire->idmoto )
  <tr>
     <td><input type="checkbox" name="accessories[]" value="{{$accessoire->idaccessoire}}"></td> 
     <td id="nom"> <a href="/accessoire?id={{ $accessoire->idaccessoire }}" @style(['color: black','text-decoration: none'])>
     {{ $accessoire->nomaccessoire }}</a> 
      
     </td>
     <td>{{ $accessoire->prixaccessoire }}</td>
</tr>
    @endif
  @endforeach
  
</table>
<br>

<button type="submit">Finir la configuration</button>

</form>

@endsection


