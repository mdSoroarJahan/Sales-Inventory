<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    // Logout
    public function logout()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User logout successful'
        ])->cookie('token', null, -1);
    }

    //Send OTP
    public function sendOTP(Request $request)
    {
        $email = $request->email;
        $otp = rand(1000, 9999);
        $count = User::where('email', $email)->count();

        if ($count === 1) {
            // Send OTP to the email address
            Mail::to($email)->send(new OTPMail($otp));
            // Save OTP to the database
            User::where('email', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP send successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unable to send OTP'
            ], 200);
        }
    }

    //Verify OTP
    public function verifyOTP(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;

        $user = User::where('email', $email)->where('otp', $otp)->first();
        if ($user !== null) {
            // Update OTP to 0
            User::where('email', $email)->update(['otp' => 0]);
            $token = JWTToken::createTokenForResetPassword($email);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully'
            ])->cookie('token', $token, time() + 60 * 60 * 24);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid OTP'
            ]);
        }
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        try {
            // Email is set by TokenVerificationMiddleware from the token
            $email = $request->header('email');
            $password = $request->password;

            // Update password in database
            $updated = User::where('email', $email)->update(['password' => $password]);

            if ($updated) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Password Reset Successful'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unable to reset password: ' . $e->getMessage()
            ], 500);
        }
    }
}
