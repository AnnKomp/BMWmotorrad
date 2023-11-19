@extends('layouts.menus')

@section('title', 'Moto')

<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>


@section('content')

<div class = 'slider'>
@foreach ($moto_pics as $pic)
    <img src={{$pic->lienmedia}}>
@endforeach
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
</script>

<style>

/* I don't know why but this code do not work in the CSS sheet so I must put it here */
.slider {
    max-width: 50%;
    margin: 0 auto;
    position: relative;
}

.slider img {
    width: 100%;
    height: auto;
}
.slick-prev,
.slick-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    color: white;
    background-color: #333;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 1;
}
.slick-prev {
    left: 0;
}

.slick-next {
    right: 0;
}

.slick-prev::before,
.slick-next::before {
    content: '\2190'; /* Code Unicode pour une flèche vers la gauche */
    font-family: 'Arial', sans-serif; /* Utilisez une police qui prend en charge le symbole */
}

.slick-next::before {
    content: '\2192'; /* Code Unicode pour une flèche vers la droite */
}
</style>


<br>
<p><hr NOSHADE  ALIGN=CENTER WIDTH="50%"></p>


<h1>Fiche technique</h1>
<table>
@foreach ($infos as $info)
<tr>
<td class='category_caracteristics'>{{ $info->nomcatcaracteristique }}</td>
<td class='caracteristics_name'>{{ $info->nomcaracteristique }}</td>
<td class='caracteristics'>{{  $info->valeurcaracteristique }}</td>
</tr>
@endforeach
</table>

@endsection
