<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('web.auth.login');
    }

    public function register()
    {
        return view('web.auth.register');
    }
}
