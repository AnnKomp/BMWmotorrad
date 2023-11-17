@extends('layouts.app')


@section('title', 'Equipements moto :')



@section('content')
<table>
@foreach ($accessoires as $accessoire)
<tr>
     <td id="nom">{{ $accessoire->nomaccessoire }}</td>
     <td>{{ $accessoire->prixaccessoire }}</td>
     <td>{{ $accessoire->detailaccessoire }}</td>
     <td>{{ $accessoire->photoaccessoire }}</td>
</tr>
</table>
@endforeach

@endsection