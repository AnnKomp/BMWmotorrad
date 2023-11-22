@extends('layouts.menus')


@section('title', 'Equipements moto :')


@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/options.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<form action="{{ route('moto-config')}}?id={{$idmoto}}" method="post">
@csrf
<h2>Accessoires (installés chez votre Concessionnaire)</h2>
<table>
  <tr>
    <th> </th>
    <th> Photo</th>
    <th> Nom</th>
    <th> Prix</th>
    <th> Info </th>
</tr>
@foreach ($accessoires as $accessoire)
<tr>
    <td class="option"><input class="check" type="checkbox" name="accessories[]" value="{{$accessoire->idaccessoire}}"></td>
    <td class="option"><img src="{{ $accessoire->photoaccessoire }}" ></td>
    <td id="nom">{{ $accessoire->nomaccessoire }}</td>
    <td class="option">{{ $accessoire->prixaccessoire }} €</td>
    <td class="option"><a href="/accessoire?id={{ $accessoire->idaccessoire }}">
        <i class="fa fa-info-circle"></i>
    </a></td>

</tr>
  @endforeach

</table>
<br>

<a  id="config" href="{{ url('/options?id=' . $idmoto)}}"> Précédent</a>

<button type="submit" id="config">Finir la configuration</button>

</form>

@endsection


