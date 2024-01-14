<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class RegisterFinishedController extends Controller
{
    /**
     * Display the registerfinished view.
     */
    public function create()
    {
        return view('auth.registerfinished');
    }
}
