@extends('layouts.menus')

@section('title', 'Moto')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>


@section('content')

<h1>Fiche technique</h1>
<table>
@foreach ($infos as $info)
<tr>
<td class='category_caracteristics'>{{ $info->nomcatcaracteristique }}</td>
<td class='caracteristics_name'>{{ $info->nomcaracteristique }}</td>
<td class='caracteristics'>{{  $info->valeurcaracteristique }}</td>
</tr>
@endforeach
</table>

@endsection
