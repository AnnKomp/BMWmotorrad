@extends('layouts.app')


@section('title', 'Equipements moto :')



@section('content')
<table>
@foreach ($accessoires as $accessoire)
<tr>
     <td id="nom">{{ $accessoire->nomaccessoire }}</td>
     <td>{{ $accessoire->prixaccessoire }}</td>
     <td>{{ $accessoire->detailaccessoire }}</td>
     <td> <img src={{$accessoire->photoaccessoire}} width=100% height=100> </td>
</tr>
</table>
@endforeach

@endsection