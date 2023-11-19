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

<p><hr NOSHADE  ALIGN=CENTER WIDTH="40%" SIZE='5'></p>


<h1>Fiche technique</h1>
<table>
<tr style='border: solid'>
    <th class='category_caracteristics'>Catégorie </th>
    <th style="font-size: 2em; border: solid; text-align= center">Caractéristique</th>
    <th class='caracteristics'>Description</th>
</tr>
@foreach ($infos as $info)
<tr>
<td class='category_caracteristics'>{{ $info->nomcatcaracteristique }}</td>
<td class='caracteristics_name'>{{ $info->nomcaracteristique }}</td>
<td class='caracteristics'>{{  $info->valeurcaracteristique }}</td>
</tr>
@endforeach
</table>

@endsection
