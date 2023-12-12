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
            <a href="{{ url("/") }}" class=logo>
                <img class="header-image" src="https://www.bmw-motorrad.fr/content/dam/bmwmotorradnsc/common/mnm/graphics/bmw_motorrad_logo.svg.asset.1585209612412.svg">
            </a>
            <a href="{{ url("/motos") }}" class='menus'>MOTOS</a>
            <a href="{{ url("/equipements") }}" class='menus'>ÉQUIPEMENTS</a>

            <a href="{{ url("/panier")}}" class=logo>
                <img src="https://cdn-icons-png.flaticon.com/512/25/25619.png" class="cart">
            </a>

            <a href="{{ route('login') }}" class=logo>
                <img class="login" src="https://www.bmw-motorrad.fr/etc.clientlibs/mnm/mnmnsc/clientlibs/global/resources/images/new/customer-portal-login.svg">
            </a>
    	</header>

        <div>@yield('categories')</div>

        <div id="content">@yield('content')</div>

        <footer>
        <a href="/confidentialite">Confidentialité</a>
        <a href="/cookies">Cookies</a>
    </footer>
    </body>
</html>
