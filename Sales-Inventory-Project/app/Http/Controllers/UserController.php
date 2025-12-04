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

    public function resetpasswordPage()
    {
        return view('pages.auth.reset-pass-page');
    }

    public function sendotpPage()
    {
        return view('pages.auth.send-otp-page');
    }

    public function verifyotpPage()
    {
        return view('pages.auth.verify-otp-page');
    }
}
