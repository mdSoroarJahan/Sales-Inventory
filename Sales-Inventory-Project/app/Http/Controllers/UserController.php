<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
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

    public function profilePage()
    {
        return view('pages.dashboard.profile-page');
    }

    // Registration
    public function userRegistration(Request $request)
    {
        try {
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => $request->password
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successful'
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed'
            ], 200);
        }
    }

    // Login
    public function userLogin(Request $request)
    {
        $user_id = User::where([
            'email' => $request->email,
            'password' => $request->password
        ])->select('id')->first();

        if ($user_id !== null) {
            //user login
            $token = JWTToken::createToken($request->email, $user_id);
            return response()->json([
                'status' => 'success',
                'message' => 'User login successful'
            ], 200)->cookie('token', $token, time() + 60 * 60 * 24);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Login Failed'
            ]);
        }
    }
}
