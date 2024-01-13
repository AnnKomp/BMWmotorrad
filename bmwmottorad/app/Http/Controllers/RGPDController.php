<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RGPDController extends Controller
{
    /**
     * Controller method for displaying the cookies view.
     */
    public function createCookies()
    {
        // Return view 'cookies'
        return view('cookies');
    }

    /**
     * Controller method for displaying the confidentiality view.
     */
    public function createConfidentialite()
    {
        // Return view 'confidentialite'
        return view('confidentialite');
    }

}
