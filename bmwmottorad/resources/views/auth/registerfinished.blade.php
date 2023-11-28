<x-guest-layout>
    <link rel="stylesheet" href="/css/register.css">
        
        <!-- Redirection page after creating a new account -->

        <h2>Votre compte BMW Motorrad a été créé avec succès!</h2>

        <div class="flex items-center justify-center mt-4">
            <a class="finishbutton" href="{{ url("/") }}">Continuer la visite du site</a>
            <a class="finishbutton" href="{{ url("/dashboard") }}">Home BMWM Motorrad</a>
        </div>
    </form>
</x-guest-layout>

