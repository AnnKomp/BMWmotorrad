@extends('layouts.menus')

@section('title', 'Accueil')


@section('content')
<h1>Bienvenue chez BMW Mottorad</h1>
@endsection




<script>
    var botmanWidget = {
        aboutText: '',
        introMessage: "Bienvenue dans notre site web"
    };
</script>

<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
