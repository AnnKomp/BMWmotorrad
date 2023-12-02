@extends('layouts.menus')

@section('title', 'Equipements')

<link rel="stylesheet" type="text/css" href="{{ asset('css/equipement-list.css') }}" />

@section('content')

<div class="page">
    <form id="filterForm" action="{{ url('/equipements') }}" method="post">
        @csrf
        <table class="filters">
            <tr><input type="text" name="search" placeholder="Rechercher des équipements" value="{{ old('search', session('search')) }}"></tr>
            <tr><select name="category">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->idcatequipement }}" {{ old('category') == $category->idcatequipement ? 'selected' : '' }}>
                        {{ $category->libellecatequipement }}
                    </option>
                @endforeach
            </select></tr>
            <tr><select name="sex">
                <option value="">Tous les sexes</option>
                <option value="h" {{ old('sex') == 'h' ? 'selected' : '' }}>Homme</option>
                <option value="f" {{ old('sex') == 'f' ? 'selected' : '' }}>Femme</option>
                <option value="uni" {{ old('sex') == 'uni' ? 'selected' : '' }}>Unique</option>
            </select></tr>
            <tr><input class="check" type="checkbox"><p>Tendances</p></tr>
            <tr><button type="submit">Rechercher</button></tr>
        </table>
    </form>

    <script>
        // Restaure les valeurs du formulaire depuis le stockage local lors du chargement de la page
        window.onload = function() {
            var form = document.getElementById('filterForm');
            var inputs = form.getElementsByTagName('select');

            for (var i = 0; i < inputs.length; i++) {
                var name = inputs[i].name;
                var value = localStorage.getItem(name);

                if (value !== null) {
                    inputs[i].value = value;
                }
            }
        };

        // Sauvegarde les valeurs du formulaire dans le stockage local lorsqu'il est soumis
        document.getElementById('filterForm').addEventListener('submit', function() {
            var inputs = this.getElementsByTagName('select');

            for (var i = 0; i < inputs.length; i++) {
                localStorage.setItem(inputs[i].name, inputs[i].value);
            }
        });
    </script>


<div class = 'equipement_display'>
   @foreach ($equipements as $equipement)
   {{-- rajouter idcoloris du bon coloris de base--}}
   <a href="/equipement?id={{ $equipement->idequipement }}" class = "equipement_lien">

    <div class = 'equipement_box'>
        <div class = 'equipement_name'>
        {{ $equipement->nomequipement }}
        </div>

        <img src={{$equipement->lienmedia}} width=100% height=100%>

        <div class ='equipement_price'>
            @if ( $equipement->stockequipement > 0)
            <p >Stock : {{ 	$equipement->stockequipement}}</p>
            @else
            <p class='notavailable'>Actuellement indisponible</p>
            @endif
            <p>{{ $equipement->prixequipement }}  €</p>
        </div>

        <hr NOSHADE WIDTH="80%" ALIGN=CENTER @style(["margin-block: 5%"])>


    </div>
   </a>

  @endforeach
</div>
</div>
@endsection


{{--<script src="{{ asset('js/equipement-list.js') }}"></script>--}}

