<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center ">
                    <a href="/">
                        <img src="/img/logobmw.png" alt="logobmw" id="bmwmlogo">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Tableau de bord') }}
                    </x-nav-link>
                    <x-nav-link :href="route('addGammeCom')" :active="request()->routeIs('addGammeCom')">
                        {{ __('Gammes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('addMotoBouton')" :active="request()->routeIs('addMotoBouton')">
                        {{ __('Ajout Moto') }}
                    </x-nav-link>
                    <x-nav-link :href="route('motos-com')" :active="request()->routeIs('motos-com')">
                        {{ __('Motos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('delivering-fees')" :active="request()->routeIs('delivering-fees')">
                        {{ __('Frais de Livraison') }}
                    </x-nav-link>
                    <x-nav-link :href="route('modifequipment')" :active="request()->routeIs('modifequipment')">
                        {{ __('Equipements') }}
                    </x-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Déconnexion') }}
                        </x-dropdown-link>
                    </form>
                </div>
            </div>
</nav>
