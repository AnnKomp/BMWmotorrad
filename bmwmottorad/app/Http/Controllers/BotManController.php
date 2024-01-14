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
   
        $botman->hears('.*quoi.*thématique.*|.*pourquoi.*thématique.*|.*quoi.*thematique.*|.*pourquoi.*thematique.*', function (BotMan $bot) {
            $response = "Qu'est ce qu'une thématique ? Une thématique est un mot ou une expression permettant de 
            regrouper plusieurs actions qui ont une cause relativement proche. Par exemple la thématique \"ENVIRONNEMENT\" 
            regroupe toutes les actions qui parlent et/ou militent pour une cause environnemental.";

            $bot->reply($response); // 1
        });
        $botman->hears(".*comment.*filtre.*|.*filtre.*", function(BotMan $bot) {
            $response = "Les filtres sont disponibles sur la page d'accueil en cliquant sur le bouton \"filtre\" en haut 
            de la page à côté de la barre de recherche. Les filtres permettent de filtrer les actions en affichant uniquement 
            celles qui correspondent aux critères que vous avez séléctionnés. Il y a des filtres par : thématique, mots-clés, 
            association, ville et date de publication.";

            $bot->reply($response); // 2
        });
        $botman->hears('.*quoi.*mot.*clé.*|.*pourquoi.*mot.*clé.*|.*quoi.*mot.*cle.*|.*pourquoi.*mot.*cle.*', function (BotMan $bot) {
            $response = "Qu'est ce qu'un mot-clé ? Une action possède plusieurs mots-clés qui la définissent. 
            Les mots-clés vous permettent d'effectuer des recherches filtrées et de facilement trouver des actions 
            qui pourraient vous plaires.";

            $bot->reply($response); // 3
        });
        $botman->hears(".*aide.*|.*sos.*", function(BotMan $bot) {
            $response = "Je crois comprendre que vous avez besoin d'aide, vous êtes perdu ? Sur le site vous pourrez voir 
            de temps en temps des petites bulles contenant un point d'intérogation. Si vous passez votre souris dessus, 
            un petit texte s'affichera pour vous aider. Vous pouvez trouver une de ces bulles sur la page d'accueil, en haut, 
            à côté du bouton \"filtre\".";

            $bot->reply($response); // 4
        });
        $botman->hears(".*comment.*s'inscrire.*|.*comment.*se connecter.*|.*problème.*connexion.*|.*problème.*inscription.*", function(BotMan $bot) {
            $response = "Pour vous connecter, vous devrez simplement cliquer sur le bouton \"connexion\" qui se situe 
            en haut à droite sur cette page. Pour vous inscrire vous trouverez un bouton \"Inscription\" sur le formulaire 
            de connexion. Cliquez dessus et vous aurez accès au formulaire d'inscription.";

            $bot->reply($response); // 5
        });
        $botman->hears(".*comment.*proposer.*action.*|.*ajouter.*action.*|.*soumettre.*action.*", function(BotMan $bot) {
            $response = "Pour ajouter une action vous devez d'abord être un représentant d'association ou un membre d'association 
            Une fois connecté accédez à votre tableau de board. Sur celui-ci vous aurez accès à 3 boutons : \"Créer une publication\", 
            \"Créer une collecte de dons\" et \"Créer une demande de bénévolat\". Utilisez un de ces 3 boutons en fonction de ce que 
            vous voulez créer et remplissez le formulaire. Ensuite votre action devra être validée par le service diffusion de notre site 
            avant d'être visible publiquement";

            $bot->reply($response); // 6
        });
        $botman->hears(".*signaler.*problème.*|.*contenu.*inapproprié.*|.*signale.*", function(BotMan $bot) {
            $response = "Les utilisateurs peuvent laisser des commentaires sous les actions. Si vous appercevez 
            un commentaire que vous considérez comme inapproprié vous pouvez le signaler. Dans la bulle de commentaire, 
            en haut à droite, il y a un bouton en forme de drapeau sur lequel vous pouvez cliquer afin de signaler 
            le commentaire. Le service diffusion de notre site étudiera votre signalement et décidera de si oui ou non 
            le commentaire sera supprimé.";

            $bot->reply($response); // 7
        });
        $botman->hears(".*comment.*participe.*action.*|.*inscription.*action.*|.*rejoindre.*action.*", function(BotMan $bot) {
            $response = "Si vous voulez participer à une mission de bénévolat ou faire un don pour une collecte de dons, 
            vous devrez accéder à la page donnant les détails d'une action. Dans la bulle verte donnant les détails de 
            l'action vous trouverez un bouton \"Faire un don\" ou \"Envoyer une demande de participation\" en fonction 
            de ce que vous pouvez faire. Dans le cas d'une demande de participation, votre demande devra être étudiée par 
            l'association et le service bénévolat de notre site avant d'être validée.";

            $bot->reply($response); // 8
        });
        $botman->hears(".*faire.*don.*|.*soutien.*financier.*|.*contribuer.*", function(BotMan $bot) {
            $response = "Si vous voulez participer à une mission de bénévolat ou faire un don pour une collecte de dons, 
            vous devrez accéder à la page donnant les détails d'une action. Dans la bulle verte donnant les détails de 
            l'action vous trouverez un bouton \"Faire un don\" ou \"Envoyer une demande de participation\" en fonction 
            de ce que vous pouvez faire. Vous aurez la possibilité de payer par carte bancaire ou par PayPal. Vous pouvez 
            donner la somme que vous souhaitez.";

            $bot->reply($response); // 9
        });
        $botman->hears(".*partager.*expérience.*|.*témoignage.*action.*|.*feedback.*|.*avis.*", function(BotMan $bot) {
            $response = "Vous pouvez partager votre expérience en laissant un commentaire sous les actions auxquelles vous 
            avez participés. Accédez aux détails d'une action, dans la section \"avis\", il y a un petit forumulaire dans 
            lequel vous pourrez écrire un commentaire et le publier. Vous pouvez également voir les avis des autres et les 
            liker (aimer) ou les signaler si vous trouvez le contenu inapproprié.";

            $bot->reply($response); // 10
        });
        $botman->hears(".*detail.*action|.*détail.*action", function(BotMan $bot) {
            $response = "Pour accéder aux détails d'une action ça se passe sur la page d'acceuil. En haut à droite de chaque 
            bulle d'action, il y a un texte souligné \"Voir plus\". En cliquant dessus vous pourrez accéder à la page de détail 
            de l'action concernée.";

            $bot->reply($response); // 11
        });

        $botman->listen();
    }

    /**
     * Place your BotMan logic here.
     */
    public function askQuestion($botman)
    {
        $botman->ask('Bonjour, comment puis-je vous aider aujourd\'hui ?', function(Answer $answer) {
   
            $question = $answer->getText();
   
            $this->say('Votre question est bien la suivante : '.$question);
        });
    }

}