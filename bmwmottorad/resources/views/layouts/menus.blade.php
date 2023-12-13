<html lang="{{ app()->getLocale() }}">
    <head>

        <script src="tarteaucitron/tarteaucitron.js"></script>
        <script type="text/javascript">
        tarteaucitron.init({
        "privacyUrl": "/confidentialite", /* Privacy policy url */
        "bodyPosition": "bottom", /* or top to bring it as first element for accessibility */

        "hashtag": "#tarteaucitron", /* Open the panel with this hashtag */
        "cookieName": "tarteaucitron", /* Cookie name */

        "orientation": "bottom", /* Banner position (top - middle -bottom) */

        "groupServices": false, /* Group services by category */
        "showDetailsOnClick": true, /* Click to expand the description */
        "serviceDefaultState": "wait", /* Default state (true - wait - false) */
                        
        "showAlertSmall": false, /* Show the small banner on bottom right */
        "cookieslist": false, /* Show the cookie list */
                        
        "closePopup": false, /* Show a close X on the banner */

        "showIcon": true, /* Show cookie icon to manage cookies */
        //"iconSrc": "", /* Optionnal: URL or base64 encoded image */
        "iconPosition": "BottomRight", /* BottomRight, BottomLeft, TopRight and TopLeft */

        "adblocker": false, /* Show a Warning if an adblocker is detected */
                        
        "DenyAllCta" : true, /* Show the deny all button */
        "AcceptAllCta" : true, /* Show the accept all button when highPrivacy on */
        "highPrivacy": true, /* HIGHLY RECOMMANDED Disable auto consent */
                        
        "handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */

        "removeCredit": false, /* Remove credit link */
        "moreInfoLink": true, /* Show more info link */

        "useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */
        "useExternalJs": false, /* If false, the tarteaucitron.js file will be loaded */

        //"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for multisite */
                        
        "readmoreLink": "", /* Change the default readmore link */

        "mandatory": true, /* Show a message about mandatory cookies */
        "mandatoryCta": true, /* Show the disabled accept button when mandatory on */

        //"customCloserId": "" /* Optional a11y: Custom element ID used to open the panel */
        });

        tarteaucitron.user.googleadsId = 'AW-XXXXXXXXX';
        (tarteaucitron.job = tarteaucitron.job || []).push('googleads');

        (tarteaucitron.job = tarteaucitron.job || []).push('adsense');

        tarteaucitron.user.adobeanalyticskey = 'adobeanalyticskey';
        (tarteaucitron.job = tarteaucitron.job || []).push('adobeanalytics');
        
        </script>
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
