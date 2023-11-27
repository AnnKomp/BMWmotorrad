@extends('layouts.menus')

@section('title', 'Equipements')

<link rel="stylesheet" type="text/css" href="{{asset('css/equipement.css')}}"/>
{{--
<meta name="csrf-token" content="{{ csrf_token() }}">
--}}

@section('content')
<h1>{{$nomequipement}}</h1>

<div class="description"> {{$descriptionequipement}}</div>

<div class="slider-container" data-idequipement="{{ $idequipement }}">
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

    });

// Add this section for fetching equipment photos dynamically
        $('#coloris').change(function () {
            var selectedColor = $(this).val();
            var idequipement = $('.slider-container').data('idequipement');

            console.log((selectedColor));

            $.ajax({
                url: '{{ route('fetch-equipment-photos') }}',
                method: 'POST',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    idequipement: {{ $idequipement }},
                    idcoloris: selectedColor
                    },
                success: function (data) {
                    $('.slider').slick('unslick');
                    $('.slider').html(data);
                    $('.slider').slick({
                        prevArrow: '<button type="button" class="slick-prev"></button>',
                        nextArrow: '<button type="button" class="slick-next"></button>',
                    });
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    console.log ($idequipement);
                    console.error('Error fetching equipment photos.', textStatus, errorThrown);
                    }
                });

            });

/*
            16 equipement:124:21
XHRPOST
http://51.83.36.122:1705/fetch-equipment-photos
[HTTP/1.1 419 unknown status 75ms]

Uncaught ReferenceError: $idequipement is not defined
    error http://51.83.36.122:1705/equipement?id=1:146
    jQuery 6
        c
        fireWith
        l
        o
        send
        ajax
    <anonymous> http://51.83.36.122:1705/equipement?id=1:126
    jQuery 2
        dispatch
        handle
equipement:146:21
*/


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
                <option value="{{ $colorisOption->idcoloris }}" {{ $colorisOption->idcoloris == $selectedColor ? 'selected' : '' }}>
                    {{ $colorisOption->nomcoloris }}
                </option>
            @endforeach
        </select>
    </div>


</div>

<h3>Prix : {{$prixequipement}} €</h3>

{{--
<div id="equipment-photos-partial">
    @include('partial-views.equipment-photos' , ['equipement_pics' => $equipement_pics])
</div>
--}}

<h4>*bouton pour mettre dans le panier*</h4>







@endsection
