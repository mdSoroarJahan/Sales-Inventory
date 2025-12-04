<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function registrationPage()
    {
        return view('pages.auth.registration-page');
    }

    public function loginPage()
    {
        return view('pages.auth.login-page');
    }
}
