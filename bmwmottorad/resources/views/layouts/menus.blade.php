<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{asset('css/layout-menu.css')}}"/>


        <title>BMW @yield('title')</title>



    </head>


    <body>

    	<header>
            <a href="{{ url("/") }}" class='menus'>
                <img class="header-image" src="https://www.bmw-motorrad.fr/content/dam/bmwmotorradnsc/common/mnm/graphics/bmw_motorrad_logo.svg.asset.1585209612412.svg">
            </a>
            <a href="{{ url("/motos") }}" class='menus'>Les motos</a>
            <a href="{{ url("/motos") }}" class='menus'>Les équipements</a>
            <a href="{{ url("/login") }}" class='menus'>
                <img class="login" src="https://www.bmw-motorrad.fr/etc.clientlibs/mnm/mnmnsc/clientlibs/global/resources/images/new/customer-portal-login.svg">
            </a>
    	</header>

        <div>@yield('categories')</div>

        <div class="container">
            @yield('content')


        </div>
    </body>
</html>
