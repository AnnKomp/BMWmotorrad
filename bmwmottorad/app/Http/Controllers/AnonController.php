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
    /**
     * Show the anonymization view.
     */
    public function create(): View
    {
        return view('profile.anon');
    }

    /**
     * Generate a random email for anonymization.
     */
    public function generateRandMail(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < 50; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        $string .= '@xx.xx';

        return $string;
    }

    /**
     * Execute an SQL function to anonymize clients who haven't connected since the specified date.
     * The date must be at least one year old from today.
     */
    public function execute(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => ['required', 'date', 'before:' . now()->subYears(1)->format('Y-m-d')],
        ]);

        // Delete users who haven't connected since the specified date
        User::where('lastconnected', '<', date('Y-m-d', strtotime($request->date)))->delete();

        // Get client IDs and delete related records in other tables
        $clientids = User::pluck('idclient');

        Infocb::whereNotIn('idclient', $clientids)->delete();

        DB::table('adresse')
            ->whereIn('numadresse', function ($query) use ($clientids) {
                $query->select('numadresse')
                    ->from('client')
                    ->whereNotIn('idclient', $clientids);
            })->update(['adresse' => 'x']);

        Telephone::whereNotIn('idclient', $clientids)->delete();
        Professionnel::whereNotIn('idclient', $clientids)->delete();
        Prive::whereNotIn('idclient', $clientids)->delete();

        // Anonymize client information
        $clients = Client::whereNotIn('idclient', $clientids)->pluck('idclient');

        for ($i = 0; $i < count($clients); $i++) {
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
