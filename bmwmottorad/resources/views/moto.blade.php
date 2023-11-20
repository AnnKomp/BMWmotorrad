@php
    $categories = [];

    // Compter le nombre de lignes par catégorie
    foreach ($infos as $info) {
        $categories[$info->nomcatcaracteristique] = isset($categories[$info->nomcatcaracteristique])
            ? $categories[$info->nomcatcaracteristique] + 1
            : 1;
    }
@endphp

@extends('layouts.menus')

@section('title', 'Moto')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>


@section('content')

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

@if (!empty($infos))
    <?php $motoname = $infos[0]->nommoto; ?>
    <h1>La BMW {{ $motoname }}</h1>
@endif


<p><hr NOSHADE  ALIGN=CENTER WIDTH="40%" SIZE='5'></p>


<h1>Fiche technique</h1>
<table>
<tr style='border: solid'>
    <th class='top_caracteristics'>Catégorie </th>
    <th  class='top_caracteristics'>Caractéristique</th>
    <th class='top_caracteristics'>Description</th>
</tr>

@foreach ($infos as $info)
    <tr >
        @if ($categories[$info->nomcatcaracteristique] > 0)
            <td class='category_caracteristics' rowspan="{{ $categories[$info->nomcatcaracteristique] }}">
                {{ $info->nomcatcaracteristique }}
            </td>
            @php
                $categories[$info->nomcatcaracteristique] = 0;
            @endphp
        @endif
        <td class='caracteristics_name'>{{ $info->nomcaracteristique }}</td>
        <td class='caracteristics'>{{ $info->valeurcaracteristique }}</td>
    </tr>
@endforeach
</table>


<table>
@foreach ($moto_options as $option)
<tr>
    <td class='caracteristics_name'>{{ $option->nomoption }}</td>
    <td class='caracteristics'>{{ $option->detailoption }}</td>
</tr>
@endforeach
</table>

@endsection
