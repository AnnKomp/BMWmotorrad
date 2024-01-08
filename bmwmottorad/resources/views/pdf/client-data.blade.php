<!-- resources/views/pdf/moto-config.blade.php -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ public_path('css/pdf.css') }}"/>
    <title>Données : {{ $client->nomclient . " " . $client->prenomclient }}</title>

</head>

<body>

<h1>{{ $client->nomclient . " " . $client->prenomclient }} : Données personnelles stockées par BMW Motorrad</h1>

<h2>Informations client</h2>

<table>
    <tr>
        @if($pro)
        <th>Compagnie</th>
        @endif
        <th>Civilité</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Date de naissance</th>
    </tr>
    <tr>
        @if($pro)
        <th>{{ $pro->nomcompagnie }}</th>
        @endif
        <td>{{ $client->civilite }}</td>
        <td>{{ $client->nomclient }}</td>
        <td>{{ $client->prenomclient }}</td>
        <td>{{ $client->emailclient }}</td>
        <td>{{ date('d-m-Y', strtotime($client->datenaissanceclient)) }}</td>
    </tr>
</table>

<h2>Adresse(s)</h2>

<table>
    <tr>
        <th>Adresse</th>
        <th>Pays</th>

    </tr>
    @foreach($adress as $adresse)
    <tr>
        <th>{{ $adresse->adresse }}</th>
        <th>{{ $adresse->nompays }}</th>
    </tr>
    @endforeach
</table>

<h2>Téléphone(s)</h2>

<table>
    <tr>
        <th>Numéro de téléphone</th>
        <th>Type</th>
    </tr>
    @foreach($phones as $phone)
    <tr>
        <th>{{ $phone->numtelephone }}</th>
        <th>{{ $phone->type . " " . $phone->fonction }}</th>
    </tr>
    @endforeach
</table>

@if($cb)
<h2>Informations bancaires</h2>

<table>
    <tr>
        <th>Numéro de carte</th>
        <th>Titulaire</th>
        <th>Date d'expiration</th>
    </tr>
    <tr>
        <th>{{ $cb->numcarte }}</th>
        <th>{{ $cb->titulairecompte }}</th>
        <th>{{ date('m/Y', strtotime($cb->dateexpiration)) }}</th>
    </tr>
</table>
@endif

@if(!empty($orders))
<h2>Commandes</h2>

<table>
    <tr>
        <th>Date de la commande</th>
        <th>Etat de la commande</th>
    </tr>
    @foreach($orders as $order)
    <tr>
        <th>{{ date('d-M-Y', strtotime($order->datecommande)) }}</th>
        <th>@if($order->etat == 1) 
                'Livrée'
            @else
                'En cours'
            @endif
        </th>
    </tr>
    @endforeach
</table>
@endif

</body>
</html>
