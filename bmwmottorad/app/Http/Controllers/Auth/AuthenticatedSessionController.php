<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();

        $request->session()->regenerate();

        if($request->user()->iscomplete == false){
            return redirect('registersuite');
        }

        return redirect('/login/phoneverification');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    // -------------------------- GOOGLE AUTHENTIFICATION ------------------

    /**
     * Display the google authentification view
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the google authentification request
     */
    public function handleGoogleCallback()
    {

        $user = Socialite::driver('google')->user();

        //to get a google user data : $user->getId(), $user->getName(), $user->getEmail(), etc.

        // Check if an account with the google account email exists
        $current_user = User::where('email', '=' ,$user->getEmail())->first();

        if($current_user){

            // If a user corresponds, the user is logged in
            Auth::login($current_user);

            return redirect()->intended(RouteServiceProvider::HOME);

        }else{

            // If no user corresponds, redirects to the register page to create an account with an error message
            return view('auth.register')->withErrors(['google'=>'L\'authentification google requiert un compte créé avec l\'adresse du compte']);
        }
    }
}
