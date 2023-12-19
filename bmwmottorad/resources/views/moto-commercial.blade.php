<x-commapp>

<link rel="stylesheet" type="text/css" href="{{asset('css/moto-com.css')}}"/>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

    <h2>Détails de la Moto</h2>

    <h4>{{ $motoName }}</h4>

    <h3>Caractéristiques</h3>

    <table>
        <tr style='border: solid'>
            <th class='top_caracteristics'>Catégorie</th>
            <th class='top_caracteristics'>Caractéristique</th>
            <th class='top_caracteristics'>Description</th>
            <th class='top_caracteristics'>Modifier</th>
        </tr>

        @php
            $groupedCategories = collect($caracteristiques)->groupBy('nomcatcaracteristique');
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
                    <td>
                        <a href="/edit-caracteristique?idmoto={{ $idmoto }}&idcaracteristique={{ $info->idcaracteristique }}">M</a>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </table>


    <h3>Options</h3>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Détail</th>
                <th>Photo</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($options as $option)
                <tr>
                    <td>{{ $option->nomoption }}</td>
                    <td>{{ $option->prixoption }}</td>
                    <td>{{ $option->detailoption }}</td>
                    <td id=photo><img id=eq src={{$option->photooption}}></td>
                    <td><a href="/edit-option?idmoto={{$idmoto}}&idoption={{$option->idoption}} ">M</a></td>
                    <td><a href="delete-option?idmoto={{$idmoto}}&idoption={{$option->idoption}} ">X</a></td>

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
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accessoires as $accessoire)
                <tr>
                    <td>{{ $accessoire->nomaccessoire }}</td>
                    <td>{{ $accessoire->prixaccessoire }}</td>
                    <td>{{ $accessoire->detailaccessoire }}</td>
                    <td id=photo><img id=eq src={{$accessoire->photoaccessoire }}></td>
                    <td><a href="/edit-accessoire?idmoto={{$idmoto}}&idaccessoire={{$accessoire->idaccessoire}} ">M</a></td>
                    <td><a href="/delete-accessoire?idmoto={{$idmoto}}&idaccessoire={{$accessoire->idaccessoire}} ">X</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Détail</th>
                <th>Photo</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packs as $pack)
                <tr>
                    <td>{{ $pack->nompack }}</td>
                    <td>{{ $pack->prixpack }}</td>
                    <td>{{ $pack->descriptionpack }}</td>
                    <td id=photo><img id=eq src={{$pack->photopack }}></td>
                    <td><a href="/edit-pack?idmoto={{$idmoto}}&idpack={{$pack->idpack}} ">M</a></td>
                    <td><a href="/delete-pack?idmoto={{$idmoto}}&idpack={{$pack->idpack}} ">X</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="photos"><a class="photos" href="/add/photo?idmoto={{$idmoto}}">Ajouter photos</a></h3>
    <h3 class="photos"><a class="photos" href="/add/moto/characteristic?idmoto={{$idmoto}}">Ajouter caracteristiques</a></h3>
    <h3 class="photos"><a class="photos" href="/add/moto/option?idmoto={{$idmoto}}">Ajouter options</a></h3>
    <h3 class="photos"><a class="photos" href="/add/moto/accessoire?idmoto={{$idmoto}}">Ajouter accessoires</a></h3>
    <h3 class="photos"><a class="photos" href="/add/moto/pack?idmoto={{$idmoto}}">Ajouter Packs</a></h3>
        </div>
    </div>
</div>

</x-commapp>

