@extends('layouts.menus')

@section('title', 'Equipements')

<link rel="stylesheet" type="text/css" href="{{asset('css/equipement-list.css')}}"/>

@section('content')
<div class = 'equipement_display'>
   @foreach ($motos as $moto)
   <a href="/moto?id={{ $moto->idequipement }}" class = "equipement_lien">
   <div class = 'equipement_box'>
        <div class = 'equipement_name'>
        {{ $moto->nomequipement }}
        </div>
        <img src={{$moto->lienmedia}} width=100% height=100%>
        <div class ='equipement_price'>
            <p>{{ $moto->prixequipement }}  €</p>
        </div>
        <hr NOSHADE WIDTH="80%" ALIGN=CENTER @style(["margin-block: 5%"])>


    </div>
   </a>

  @endforeach
</div>
@endsection
