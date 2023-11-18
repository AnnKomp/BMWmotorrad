@extends('layouts.app')


@section('title', 'Equipements moto :')


@section('content')

<form action="choice_accessories" method="post"></form>

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

<button type="submit">Finir la configuration des accessoires</button>

</form>

@endsection


