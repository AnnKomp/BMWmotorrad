<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Telephone;
use App\Models\Adresse;
use App\Models\Client;
use App\Models\Pays;
use App\Models\Professionnel;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        //Getting Necessary data from the table
        $user = auth()->user();
        $client = DB::table('client')->select('datenaissanceclient', 'civilite'
        )->where('idclient', '=', $user->idclient)->first();
        $company = DB::table('professionnel')->select('nomcompagnie')->where('idclient', '=', $user->idclient)->first();
        $phone = Telephone::where('idclient', '=', $user->idclient)->get();
        $adress = DB::table('adresse')->select('nompays','adresse')->join('client', 'adresse.numadresse', '=', 'client.numadresse')->join('users', 'users.idclient', '=', 'client.idclient')->where('client.idclient', "=", $user->idclient)->first();
        // Return the edit view with the necessary data in parameter
        return view('profile.edit', [
            'user' => $user,
            'company' => $company,
            'adress' => $adress,
            'phones' => $phone,
            'client' => $client,
            'pays' => Pays::all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // The email format is checked only if it was modifie because of the unique clause
        if($request->email != $request->user()->email){
            $request->validate([
                'email' => ['required', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            ]);
        }

        // Check if the format of the new data is valid
        $request->validate([
            'civilite' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'datenaissanceclient' => ['required', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
        ]);


        $request->user()->fill($request->validated());


        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Save the data
        $request->user()->save();

        // Reflecting the data update on the client table (TODO: Remove the client table and make the users table the new client table)
        Client::where('idclient', $request->user()->idclient)->update([
            'civilite'=>$request->civilite,
            'nomclient'=>$request->lastname,
            'prenomclient'=>$request->firstname,
            'emailclient'=>$request->email,
            'datenaissanceclient'=>$request->datenaissanceclient,
        ]);

        // Redirect to the same view with a status update
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Update de user's adress information
    public function updateadress(Request $request): RedirectResponse
    {
        // Validating the data format
        $request->validate([
            'adresse' => ['required', 'string', 'max:100'],
            'telephonepvmb' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepfmb' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepvfx' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepffx' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
        ]);

        // ---------------------------------------------------- Adress update ----------------------------------------------------------------------

        // Updating the Adress
        $adress = DB::table('adresse')->select('adresse.numadresse')->join('client', 'adresse.numadresse', '=', 'client.numadresse')->join('users', 'users.idclient', '=', 'client.idclient')->where('client.idclient', '=', auth()->user()->idclient)->first();
        Adresse::where('numadresse', $adress->numadresse)->update([
            'nompays'=>$request->nompays,
            'adresse'=>$request->adresse,
        ]);

        // Updating the company name of the account
        if($request->nomcompagnie){
            Professionnel::where('idclient', $request->user()->idclient)->update([
                'nomcompagnie'=>$request->nomcompagnie
            ]);
        }

        // ---------------------------------------------------- Phone number update ----------------------------------------------------------------------

        // Make sure that there is at least one phone number
        if(empty($request->MobilePrivé) && empty($request->MobileProfessionnel) && empty($request->FixePrivé) && empty($request->FixeProfessionnel)){
            return redirect('/profile');
        }
        // Update the phone numbers
        Telephone::where('idclient', $request->user()->idclient)->where('type', 'Mobile')->where('fonction', 'Privé')->update([
            'numtelephone' => $request->MobilePrivé
        ]);
        Telephone::where('idclient', $request->user()->idclient)->where('type', 'Mobile')->where('fonction', 'Professionnel')->update([
            'numtelephone' => $request->MobileProfessionnel
        ]);
        Telephone::where('idclient', $request->user()->idclient)->where('type', 'Fixe')->where('fonction', 'Privé')->update([
            'numtelephone' => $request->FixePrivé
        ]);
        Telephone::where('idclient', $request->user()->idclient)->where('type', 'Fixe')->where('fonction', 'Professionnel')->update([
            'numtelephone' => $request->FixeProfessionnel
        ]);
        // Redirect to the same view with a status update
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $commandes = Commande::where('idclient', '=', $user->idclient)->first();

        if($commandes){
            return redirect('/profile')->withErrors(['commande'=>'Vous avez passé une ou plusieures commandes avec ce compte, nous ne pouvons donc pas le supprimer pour le moment.']);
        }else{
            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/');
        }
    }


    public function commands(): View
    {
        $idclient = auth()->user()->idclient;
        $commands = DB::table('commande')
                    ->select('*')
                    ->where('idclient', $idclient)
                    ->orderBy('datecommande') // Assurez-vous de trier par date avant de regrouper
                    ->get();

        //dd($commands);
        return view('profile.commands', [
            'idclient' => $idclient,
            'commands' => $commands
        ]);
    }

    public function command_detail(Request $request): View
    {
        $idcommand = $request->input('idcommand');
        $command = DB::table('contenucommande')
                ->select(
                    'contenucommande.idcommande',
                    'contenucommande.idequipement',
                    'contenucommande.quantite',
                    'taille.idtaille',
                    'taille.libelletaille',
                    'taille.desctaille',
                    'coloris.idcoloris',
                    'coloris.nomcoloris',
                    'equipement.nomequipement',
                    'commande.etat'
                )
                ->join('taille', 'contenucommande.idtaille', '=', 'taille.idtaille')
                ->join('coloris', 'contenucommande.idcoloris', '=', 'coloris.idcoloris')
                ->join('equipement', 'contenucommande.idequipement', '=', 'equipement.idequipement')
                ->join('commande','contenucommande.idcommande','=','commande.idcommande')
                ->where('contenucommande.idcommande', $idcommand)
                ->get();

        //dd($command);

        return view('profile.commanddetail', [
            'command' => $command
        ]);
    }

    public function annulerCommande($idcommande, $idequipement, $idtaille, $idcoloris)
    {
        // Récupérez le nombre total d'articles pour la commande
        $nombreTotalArticles = DB::table('contenucommande')
            ->where('idcommande', $idcommande)
            ->count();

        // Récupérez l'article
        $contenuCommande = DB::table('contenucommande')
            ->where('idcommande', $idcommande)
            ->where('idequipement', $idequipement)
            ->where('idtaille', $idtaille)
            ->where('idcoloris', $idcoloris)
            ->first();

        // Si l'article existe
        if ($contenuCommande) {
            // Supprimez l'article
            DB::table('contenucommande')
                ->where('idcommande', $idcommande)
                ->where('idequipement', $idequipement)
                ->where('idtaille', $idtaille)
                ->where('idcoloris', $idcoloris)
                ->delete();

            // Si le nombre total d'articles est devenu zéro, supprimez la commande
            if ($nombreTotalArticles - 1 === 0) {
                DB::table('commande')
                    ->where('idcommande', $idcommande)
                    ->delete();

                return redirect()->route('profile.commands');

            }

            return redirect()->route('profile.commands.detail', ['idcommand' => $idcommande])
                ->with('success', 'Article annulé avec succès.');
        }

        return redirect()->route('profile.commands.detail', ['idcommand' => $idcommande])
            ->with('error', 'L\'article n\'existe pas ou a déjà été annulé.');
    }

}

