<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RGPDController extends Controller
{
    public function createcookies(){
        // Return view 'cookies'
        return view('cookies');
    }

    public function createconfidentialite(){
        // Return view 'confidentialite'
        return view('confidentialite');
    }
}
