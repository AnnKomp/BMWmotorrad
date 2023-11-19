<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Telephone;
use App\Models\Adresse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $phone = Telephone::where('idclient', '=', $request->user()->idclient)->get();
        $adress = DB::table('adresse')->select('nompays','numrue','rue','ville','codepostal')->join('client', 'adresse.numadresse', '=', 'client.numadresse')->join('users', 'users.idclient', '=', 'client.idclient')->first();
        return view('profile.edit', [
            'user' => $request->user(),
            'adress' => $adress,
            'phones' => $phone,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Update de user's adress information
    public function updateadress(Request $request): RedirectResponse
    {
        $adress = DB::table('adresse')->select('adresse.numadresse')->join('client', 'adresse.numadresse', '=', 'client.numadresse')->join('users', 'users.idclient', '=', 'client.idclient')->first();
        Adresse::where('numadresse', $adress->numadresse)->update([
            'nompays'=>$request->nompays,
            'numrue'=>$request->numrue,
            'rue'=>$request->rue,
            'ville'=>$request->ville,
            'codepostal'=>$request->codepostal,
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
