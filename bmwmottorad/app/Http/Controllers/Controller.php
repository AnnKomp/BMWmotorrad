<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * DO NOT SUPPRESS !!!!!!!!!!!
 *
 * IF DELETED, CONTROLLERS STOPS WORKING
*/

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
