<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Infocb;
use App\Models\Professionnel;
use App\Models\Prive;
use App\Models\Telephone;
use App\Models\Client;

class AnonController extends Controller
{
    // Function to show the anonymisation view
    public function create(){
        return view('profile.anon');
    }

    public function generateRandMail(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
    
        for ($i = 0; $i < 50; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        $string .= '@xx.xx';

        return $string;
    }

    /*
     Function that executes an sql function to anonymize all clients who have not connected since the date given in the requets form.
     The date has to be at least one year old from today
     */
    public function execute(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => ['required', 'date', 'before:' . now()->subYears(1)->format('Y-m-d')],
        ]);

        User::where('lastconnected', '<', date('Y-m-d', strtotime($request->date)))->delete();

        $clientids = User::pluck('idclient');

        Infocb::whereNotIn('idclient', $clientids)->delete();

        DB::table('adresse')
            ->whereIn('numadresse', function ($query) {
                $query->select('numadresse')
                    ->from('client')
                    ->whereNotIn('idclient', function ($subquery) {
                        $subquery->select('idclient')
                            ->from('users');
                    });
        })->update(['adresse' => 'x']);

        Telephone::whereNotIn('idclient', $clientids)->delete();

        Professionnel::whereNotIn('idclient', $clientids)->delete();

        Prive::whereNotIn('idclient', $clientids)->delete();

        $clients = Client::whereNotIn('idclient', $clientids)->pluck('idclient');

        for($i = 0; $i < count($clients); $i++){
            Client::where('idclient', $clients[$i])->update([
                'civilite' => 'x',
                'nomclient' => 'x',
                'prenomclient' => 'x',
                'emailclient' => $this->generateRandMail()
            ]);
        }

        return redirect()->route('dpoanon')->with('status', 'data_anonymised');
    }
}
