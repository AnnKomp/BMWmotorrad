<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\BotMan;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');
   
        $botman->hears(".*tri.*moto.*|.*catégorie.*moto.*|.*tout.*moto.*|.*moto.*", function(BotMan $bot) {
            $response = "Toutes les motos sont disponibles dans la section 'Motos' du site. 
            Cliquer sur une gamme permet de filtrer les motos. 
            Le bouton 'Toutes' permet d'avoir toutes les motos à nouveau.";

            $bot->reply($response); // 1
        });
        $botman->hears(".*tri.*quipement.*|.*recherche.*quipement.*|.*tou.*quipement.*", function (BotMan $bot) {
            $response = "Tous les équipements du motard sont disponibles dans la section 'équipements' du site.
            Une barre de recherche ainsi que divers filtres vous permettent d'afiner la recherche.";

            $bot->reply($response); // 2
        });
        $botman->hears(".*aide.*|.*sos.*|.*help.*|.*perdu.*", function(BotMan $bot) {
            $response = "Je crois comprendre que vous avez besoin d'aide, vous êtes perdu ?
            Vous pourrez trouver de temps en temps des petites bulles contenant un 'i'. 
            Un simple clique dessus permet d'avoir accès à un guide sur l'utilisation.";

            $bot->reply($response); // 3
        });
        $botman->hears(".*inscrire.*|.*inscription.*", function(BotMan $bot) {
            $response = "Vous souhaiter accéder à votre compte ou vous inscrire ?
            Pour vous connecter, vous devrez simplement cliquer sur l'icone de personne qui se situe en haut à droite de cette page. 
            Pour vous inscrire vous trouverez un bouton \"Inscription\" sur le formulaire de connexion. 
            Cliquez dessus et vous aurez accès au formulaire d'inscription.";

            $bot->reply($response); // 4
        });
        $botman->listen();
    }
}