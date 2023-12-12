<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RGPDController extends Controller
{
    public function createcookies(){
        return view('cookies');
    }

    public function createconfidentialite(){
        return view('confidentialite');
    }
}
