<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class AnonController extends Controller
{
    public function create(){
        return view('profile.anon');
    }

    public function execute(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => ['required', 'date', 'before:' . now()->subYears(1)->format('Y-m-d')],
        ]);

        DB::select("select delete_inactive_clients('".date('Y-m-d', strtotime($request->date))."')");

        return redirect()->route('dpoanon')->with('success', 'Comptes anonymisés.');
    }
}
