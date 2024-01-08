<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class AnonController extends Controller
{
    // Function to show the anonymisation view
    public function create(){
        return view('profile.anon');
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

        DB::select("select delete_inactive_clients('".date('Y-m-d', strtotime($request->date))."')");

        return redirect()->route('dpoanon')->with('status', 'data_anonymised');
    }
}
