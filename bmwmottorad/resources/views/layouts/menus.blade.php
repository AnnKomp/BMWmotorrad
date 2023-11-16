<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>BMW @yield('title')</title>



    </head>


    <body>

    	<header @style ([
            'background-color : #aaa',
            'display: flex',
            'flex-wrap: nowrap',
            'justify-content: space-around',
            'padding: 30px',
            'align-items: center'
            ])>
            <a href="{{ url("/") }}" @style(['color: black','text-decoration: none', 'font-size: 3em','height : 1%', 'font-weight: bolder'])>BMW</a>
            <a href="{{ url("/motos") }} " @style(['color: black','text-decoration: none','font-size: 3em','height : 1%'])>Les motos</a>
            <a href="{{ url("/motos") }} " @style(['color: black','text-decoration: none','font-size: 3em','height : 1%'])>Les équipements</a>
    	</header>

        <div>@yield('categories')</div>

        <div class="container">
            @yield('content')
        </div>

    </body>
</html>
