@extends('layouts.menus')

@section('title', 'Equipements')

<link rel="stylesheet" type="text/css" href="{{ asset('css/equipement-list.css') }}" />

@section('content')

<script src='js/equipement-list.js' defer></script>


<div class="page">
    <form id="filterForm" action="{{ url('/equipements') }}" method="post">
        @csrf
        <div class="filters">
            <input type="text" name="search" placeholder="Rechercher des équipements" value="{{ old('search', session('search')) }}">

            <select name="category">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->idcatequipement }}" {{ old('category') == $category->idcatequipement ? 'selected' : '' }}>
                        {{ $category->libellecatequipement }}
                    </option>
                @endforeach
            </select>

            <select name="collection">
                <option value="">Toutes les collections</option>
                @foreach($collections as $collection)
                    <option value="{{ $collection->idcollection }}" {{ old('collection') == $collection->idcollection ? 'selected' : '' }}>
                        {{ $collection->nomcollection }}
                    </option>
                @endforeach
            </select>

            <select name="sex">
                <option value="">Tous les sexes</option>
                <option value="h" {{ old('sex') == 'h' ? 'selected' : '' }}>Homme</option>
                <option value="f" {{ old('sex') == 'f' ? 'selected' : '' }}>Femme</option>
                <option value="uni" {{ old('sex') == 'uni' ? 'selected' : '' }}>Unique</option>
            </select>

            <select name="price">
                <option value="">Tous les prix</option>
                <option value="asc" {{ old('price') == 'asc' ? 'selected' : '' }}>Prix croissant</option>
                <option value="desc" {{ old('price') == 'desc' ? 'selected' : '' }}>Prix décroissant</option>
            </select>

            <select name="segment">
                <option value="">Tous les segments</option>
                @foreach(['Adventure', 'Heritage', 'M', 'Roadster', 'Sport', 'Tour', 'Urban Mobility'] as $segment)
                    <option value="{{ $segment }}" {{ old('segment') == $segment ? 'selected' : '' }}>
                        {{ $segment }}
                    </option>
                @endforeach
            </select>

            <div class="tendency">
                <input class="check" type="checkbox" name="tendencies" {{ old('tendencies') || session('tendencies') ? 'checked' : '' }}>
                <p>Tendances</p>
            </div>

            <button type="reset">Réinitialiser</button>
            <button type="submit">Rechercher</button>


            <div class="range_container">
                <div class="sliders_control">
                    <input id="fromSlider" type="range" value="0" min="0" max="2000"/>
                    <input id="toSlider" type="range" value="2000" min="0" max="2000"/>
                </div>
                <div class="form_control">
                    <div class="form_control_container">
                        <div class="form_control_container__time">Min</div>
                        <input class="form_control_container__time__input" name="Min" type="number" id="fromInput" value="0" min="0" max="2000"/>
                    </div>
                    <div class="form_control_container">
                        <div class="form_control_container__time">Max</div>
                        <input class="form_control_container__time__input" name="Max" type="number" id="toInput" value="2000" min="0" max="2000"/>
                    </div>
                </div>
            </div>
        </div>

    </form>






    <div class ='equipement_display'>
        @foreach ($equipements as $equipement)
        {{-- rajouter idcoloris du bon coloris de base--}}
        <a href="/equipement?id={{ $equipement->idequipement }}" class = "equipement_lien">

            <div class = 'equipement_box'>
                <div class = 'equipement_name'>
                {{ $equipement->nomequipement }}
                </div>

                <img src={{$equipement->lienmedia}} width=100% height=100%>

                <div class ='equipement_price'>
                    @if ( $equipement->totalquantite > 0)
                    <p >Stock : {{ 	$equipement->totalquantite}}</p>
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


@endsection
