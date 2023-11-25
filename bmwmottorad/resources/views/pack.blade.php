@extends('layouts.menus')

@section('title', 'Game')

<link rel="stylesheet" type="text/css" href="{{asset('css/description-pack.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



@section('content')
<h2>La description du pack :</h2>

@foreach($pack as $thepack)

<p> {{ $thepack->descriptionpack }}</p>
@endforeach

<h2>Les options du pack :</h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Detail</th>
        <th>Plus d'infos</th>
    </tr>
</table>

@forelse($options as $option)

<table>

   {{-- @foreach ($options as $option) --}}
<tr>
    <td id="name">{{ $option->nomoption }}</td>
    <td>{{ $option->detailoption }}</td>
    <td><img src="{{ $option->photooption }}"></td>
    <td>
        <a href="{{ url('/option?id=' . $option->idoption . '&idpack=' . $idpack) . '&route=pack'}}">
            <i class="fa fa-info-circle"></i>
        </a>
    </td>
</tr>
  {{-- @endforeach --}}

</table>
@empty
<p>Ce pack ne comporte pas d'options ou ils n'etaient pas encore spécifiés</p>
@endforelse




<h2>Les options du pack :</h2>

@if(count($options) > 0)
    <table>
        <tr>
            <th>Nom</th>
            <th>Detail</th>
            <th>Photo</th>
            <th>Plus d'infos</th>
        </tr>

        @foreach ($options as $option)
            <tr>
                <td id="name">{{ $option->nomoption }}</td>
                <td>{{ $option->detailoption }}</td>
                <td><img src="{{ $option->photooption }}"></td>
                <td>
                    <a href="{{ url('/option?id=' . $option->idoption . '&idpack=' . $idpack) . '&route=pack'}}">
                        <i class="fa fa-info-circle"></i>
                    </a>
                </td>
            </tr>
        @endforeach

    </table>
@else
    <p>Ce pack ne comporte pas d'options ou ils n'étaient pas encore spécifiés</p>
@endif




<a  id="config" href="{{ url('/moto/pack?id=' . $idmoto) .'&idmoto=' . $idmoto}}"> Retour</a>





@endsection
