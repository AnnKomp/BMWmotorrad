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
    console.log('Script is running !');


    $(document).ready(function(){

        $('.slider').slick({
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
        });

        var urlParams = new URLSearchParams(window.location.search);
        var selectedColorFromUrl = urlParams.get('idcoloris');

        $('#coloris').val(selectedColorFromUrl);


        $('#coloris').change(function () {
            var selectedColor = $(this).val();
            var idequipement = $('.slider-container').data('idequipement');

            console.log((selectedColor));

            var newUrl = window.location.href.split('?')[0] + '?id=' + idequipement + '&idcoloris=' +selectedColor;
            history.replaceState(null,null,newUrl);


            location.reload();


        });



    });

// Add this section for fetching equipment photos dynamically
/*
        $('#coloris').change(function () {
            console.log("we are alse in here ! ");
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
                    idequipement: idequipement,
                    idcoloris: selectedColor
                    },
                success: function (data) {
                    $('.slider').slick('unslick');
                    $('.slider').html(data.html);
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
