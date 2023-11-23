@extends('layouts.menus')

@section('title', 'Equipements')

<link rel="stylesheet" type="text/css" href="{{asset('css/equipement-list.css')}}"/>

@section('content')
<div class = 'equipement_display'>
   @foreach ($equipements as $equipement)
   <a href="/equipement?id={{ $equipement->idequipement }}" class = "equipement_lien">
   <div class = 'equipement_box'>
        <div class = 'equipement_name'>
        {{ $equipement->nomequipement }}
        </div>
        <img src={{$equipement->lienmedia}} width=100% height=100%>
        <div class ='equipement_price'>
            <p>{{ $equipement->prixequipement }}  €</p>
        </div>
        <hr NOSHADE WIDTH="80%" ALIGN=CENTER @style(["margin-block: 5%"])>


    </div>
   </a>

  @endforeach
</div>
@endsection
