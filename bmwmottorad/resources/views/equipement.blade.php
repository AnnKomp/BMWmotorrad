@extends('layouts.menus')

@section('title', 'Equipements')

<link rel="stylesheet" type="text/css" href="{{asset('css/equipement.css')}}"/>

@section('content')
<h1>{{$nomequipement}}</h1>

<div class="description"> {{$descriptionequipement}}</div>

<div class="slider-container">
    <div class = 'slider'>
    @foreach ($equipement_pics as $pic)
        <img src={{$pic->lienmedia}}>
    @endforeach
    </div>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    $(document).ready(function(){
        $('.slider').slick({
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
        });


// Add this section for fetching equipment photos dynamically
        $('#coloris').change(function () {
            var selectedColor = $(this).val();
            console.log(selectedColor);

            /*
            var currentUrl = window.location.href;
            var separator = currentUrl.includes('?') ? '&' : '?';
            var newUrl = currentUrl + separator + 'idcoloris=' + selectedColor;

            // Redirect to the updated URL
            window.location.href = newUrl;
            */

            $.ajax({
                url: '{{ route('fetch-equipment-photos') }}',
                method: 'POST',
                data: {
                    idequipement: {{ $idequipement }},
                    idcoloris: selectedColor
                    },
                success: function (data) {
                    $('#equipment-photos').html(data);
                    },
                error: function () {
                    console.error('Error fetching equipment photos.');
                    }
                });

            });


    });


</script>


<div class="options-container">
    <div class="option-section">
        <h3>Choix taille</h3>
        <select name="taille" id="taille">
            @foreach ($tailleOptions as $tailleOption)
                <option value="{{ $tailleOption->idtaille }}">{{ $tailleOption->libelletaille }}</option>
            @endforeach
        </select>
    </div>

    <div class="option-section">
        <h3>Choix coloris</h3>
        <select name="coloris" id="coloris">
            @foreach ($colorisOptions as $colorisOption)
                <option value="{{ $colorisOption->idcoloris }}">{{ $colorisOption->nomcoloris }}</option>
            @endforeach
        </select>
    </div>


</div>

<h3>Prix : {{$prixequipement}} €</h3>


<div id="equipment-photos-partial">
    @include('partial-views.equipment-photos' , ['equipement_pics' => $equipement_pics])
</div>


<h4>*bouton pour mettre dans le panier*</h4>


@endsection
