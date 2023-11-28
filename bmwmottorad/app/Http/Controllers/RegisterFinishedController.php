<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class RegisterFinishedController extends Controller
{
    public function create(): View{
        // Return the registerfinished view
        return view('auth.registerfinished');
    }
}
