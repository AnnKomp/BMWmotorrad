@extends('layouts.menus')
{{-- Other layout setup --}}

@section('title', 'Détails de la Moto')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/moto.css')}}"/>

    <h2>Détails de la Moto</h2>

    <h4>{{ $motoName }}</h4>

    <h3>Caractéristiques</h3>
    <table>
        <thead>
            <tr>
                <th>Catégorie</th>
                <th>Nom</th>
                <th>Valeur</th>
                <th>  xxxxx  </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($caracteristiques as $caracteristique)
                <tr>
                    <td>{{ $caracteristique->nomcatcaracteristique }}</td>
                    <td>{{ $caracteristique->nomcaracteristique }}</td>
                    <td>{{ $caracteristique->valeurcaracteristique }}</td>
                    <td><a href="{{ route('editCaracteristic', ['idmoto' => $caracteristique->idmoto, 'idcaracteristique' => $caracteristique->idcaracteristique]) }}">M</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Options</h3>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Détail</th>
                <th>Photo</th>
                <th></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($options as $option)
                <tr>
                    <td>{{ $option->nomoption }}</td>
                    <td>{{ $option->prixoption }}</td>
                    <td>{{ $option->detailoption }}</td>
                    <td><img src={{$option->photooption}}></td>

                    <td><a href="{{ route('editOption', ['idmoto' => $option->idmoto, 'idoption' => $option->idoption]) }}">M</a></td>
                    <td><a href="{{ route('deleteOption', ['idmoto' => $option->idmoto, 'idoption' => $option->idoption]) }}">X</a></td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Accessoires</h3>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Détail</th>
                <th>Photo</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accessoires as $accessoire)
                <tr>
                    <td>{{ $accessoire->nomaccessoire }}</td>
                    <td>{{ $accessoire->prixaccessoire }}</td>
                    <td>{{ $accessoire->detailaccessoire }}</td>
                    <td><img src={{$accessoire->photoaccessoire }}></td>
                    <td><a href="{{ route('editAccessoire', ['idmoto' => $accessoire->idmoto, 'idaccessoire' => $accessoire->idaccessoire]) }}">M</a></td>
                    <td><a href="{{ route('deleteAccessoire', ['idmoto' => $accessoire->idmoto, 'idaccessoire' => $accessoire->idaccessoire]) }}">X</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
