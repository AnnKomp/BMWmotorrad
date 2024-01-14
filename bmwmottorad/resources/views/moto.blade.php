@php
    $categories = [];

    foreach ($infos as $info) {
        $categories[$info->nomcatcaracteristique] = isset($categories[$info->nomcatcaracteristique])
            ? $categories[$info->nomcatcaracteristique] + 1
            : 1;
    }

    $motoname = $infos[0]->nommoto;
    $description = $infos[0]->descriptifmoto;
@endphp

@extends('layouts.menus')

@section('title', 'Moto')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>

@section('categories')
    <div class = 'header_category'>
        <a href="/moto?id={{$idmoto}}" class = "categories">{{ $motoname }}</a>
        <a href="/moto/color?idmoto={{$idmoto}}" class = "categories">Configuration</a>
    </div>
@endsection


@section('content')
<button onclick="openPopup()" class="guidebutton"><img src="img/guideimages/moreinfoicon.png" alt=""></button>

<div id="popup-overlay" onclick="closePopup()"></div>
<div id="popup-container">
    <div id="popup-content">
        <span id="close-popup" onclick="closePopup()">&times;</span>
        <h2>Consulter une moto</h2>
        <p>Sur la page d'une moto, vous trouvez plus d'informations sur la moto tels que sa fiche technique.
        </p>
        <img src="img/guideimages/motoslider.png" alt="" class="popupimg">
        <p>des images donnent un aperçu de la moto. cliquer sur les flèches à droite ou à gauche de l'image permettent de visualiser les différentes photos de la moto.</p>
        <h3>Configurer la moto</h3>
        <img src="img/guideimages/configurationbutton.png" alt="" class="popupimg">
        <p>Si vous souhaitez configurer la moto pour la réserver, cliquer sur le bouton configuration situé en dessous du menu vous redirigera vers le configurateur.</p>
        <h3>Faire une demande d'essai</h3>
        <img src="img/guideimages/essaibutton.png" alt="" class="popupimg">
        <p>Si vous souhaitez essayer la moto chez un concessionnaire, vous pouvez cliquer sur ce bouton situé sous la description de la moto qui vous redirigera vers un formulaire à remplir pour faire votre demande.</p>
    </div>
</div>
<div class="slider-container">
<div class = 'slider'>
@foreach ($moto_pics as $pic)
    <img src={{$pic->lienmedia}}>
@endforeach
</div></div>

{{-- Beginning of the part for the slider --}}
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    $(document).ready(function(){
        $('.slider').slick({
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
        });
    });
</script>

{{-- End of the part for the slider --}}

<h1>La BMW {{ $motoname }}</h1>
<p style="margin: auto 5%"> {{ $description }}</p>


<p><hr NOSHADE  ALIGN=CENTER WIDTH="40%" SIZE='5'></p>


<div id="essaibutton">
    <a href="/moto/essai?idmoto={{$idmoto}}" class="essai">
        <button>Demander un essai</button>
    </a>
</div>



<h1>Fiche technique</h1>
<table>
    <tr style='border: solid'>
        <th class='top_caracteristics'>Catégorie</th>
        <th class='top_caracteristics'>Caractéristique</th>
        <th class='top_caracteristics'>Description</th>
    </tr>

    @php
        $groupedCategories = collect($infos)->groupBy('nomcatcaracteristique');
    @endphp

    @foreach ($groupedCategories as $category => $categoryInfos)
        @php
            $rowspan = count($categoryInfos);
        @endphp

        @foreach ($categoryInfos as $index => $info)
            <tr>
                @if ($index === 0)
                    <td class='category_caracteristics' rowspan="{{ $rowspan }}">
                        {{ $category }}
                    </td>
                @endif

                <td class='caracteristics_name'>{{ $info->nomcaracteristique }}</td>
                <td class='caracteristics'>{{ $info->valeurcaracteristique }}</td>
            </tr>
        @endforeach
    @endforeach
</table>




<p><hr NOSHADE  ALIGN=CENTER WIDTH="40%" SIZE='5'></p>

<h1>Les options</h1>
<table class = "options">
@foreach ($moto_options as $option)
<tr>
    <td class='caracteristics_name'>{{ $option->nomoption }}</td>
    <td class='caracteristics'>{{ $option->detailoption }}</td>
</tr>
@endforeach
</table>

@endsection
