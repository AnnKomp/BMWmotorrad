@extends('layouts.menus')


@section('title', 'Equipements moto :')


@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/options.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<form action="{{ route('moto-config')}}?id={{$idmoto}}" method="post">
@csrf
<h2>Les accessoires concesionnaire</h2>
<table>
  <tr>
    <th></th>
    <th>Nom</th>
    <th>Prix</th>
</tr>
  @foreach ($accessoires as $accessoire)
  <tr>
     <td><input type="checkbox" name="accessories[]" value="{{$accessoire->idaccessoire}}"></td>
     <td id="nom"> <a href="/accessoire?id={{ $accessoire->idaccessoire }}" @style(['color: black','text-decoration: none'])>
     {{ $accessoire->nomaccessoire }}</a>

     </td>
     <td>{{ $accessoire->prixaccessoire }}</td>
</tr>
  @endforeach

</table>
<br>

<button type="submit">Finir la configuration</button>

</form>

@endsection


