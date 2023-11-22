<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Telephone;
use App\Models\Adresse;
use App\Models\Client;
use App\Models\Pays;
use App\Models\Professionnel;
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
        $client = DB::table('client')->select('datenaissanceclient', 'civilite','photoclient')->where('idclient', '=', $user->idclient)->first();
        $company = DB::table('professionnel')->select('nomcompagnie')->where('idclient', '=', $user->idclient)->first();
        $phone = Telephone::where('idclient', '=', $user->idclient)->get();
        $adress = DB::table('adresse')->select('nompays','adresse')->join('client', 'adresse.numadresse', '=', 'client.numadresse')->join('users', 'users.idclient', '=', 'client.idclient')->where('client.idclient', "=", $user->idclient)->first();
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
        $request->validate([
            'civilite' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'datenaissanceclient' => ['required', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
        ]);


        $request->user()->fill($request->validated());


        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        Client::where('idclient', $request->user()->idclient)->update([
            'civilite'=>$request->civilite,
            'nomclient'=>$request->lastname,
            'prenomclient'=>$request->firstname,
            'emailclient'=>$request->email,
            'datenaissanceclient'=>$request->datenaissanceclient,
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Update de user's adress information
    public function updateadress(Request $request): RedirectResponse
    {
        $request->validate([
            'adresse' => ['required', 'string', 'max:100'],
            'telephonepvmb' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepfmb' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepvfx' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
            'telephonepffx' => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^0[1-9]{1}[0-9]{8}$/i'],
        ]);

        $adress = DB::table('adresse')->select('adresse.numadresse')->join('client', 'adresse.numadresse', '=', 'client.numadresse')->join('users', 'users.idclient', '=', 'client.idclient')->where('client.idclient', '=', auth()->user()->idclient)->first();
        Adresse::where('numadresse', $adress->numadresse)->update([
            'nompays'=>$request->nompays,
            'adresse'=>$request->adresse,
        ]);

        if($request->nomcompagnie){
            Professionnel::where('idclient', $request->user()->idclient)->update([
                'nomcompagnie'=>$request->nomcompagnie
            ]);
        }

        if(empty($request->MobilePrivé) && empty($request->MobileProfessionnel) && empty($request->FixePrivé) && empty($request->FixeProfessionnel)){
            return redirect('/profile');
        }


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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
