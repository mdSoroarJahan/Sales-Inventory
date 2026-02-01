<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

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
            $request->validate([
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email',
                'mobile' => 'required|string|max:20',
                'password' => 'required|string|min:6'
            ]);

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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Login
    public function userLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            $user = User::where('email', $request->email)->first();

            if ($user && ($request->password === $user->password)) {
                $token = JWTToken::createToken($request->email, $user->id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User login successful'
                ], 200)->withCookie(cookie('token', $token, time() + 60 * 60 * 24));
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid email or password'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Logout
    public function logout()
    {
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'User logout successful'
        // ])->withCookie(cookie()->forget('token'));

        return redirect('/userLogin')->withCookie(cookie()->forget('token'));
    }

    //Send OTP
    public function sendOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = $request->email;
            $user = User::where('email', $email)->first();

            if ($user) {
                $otp = rand(1000, 9999);
                Mail::to($email)->send(new OTPMail($otp));
                User::where('email', $email)->update(['otp' => $otp]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP sent successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    //Verify OTP
    public function verifyOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|numeric'
            ]);

            $email = $request->email;
            $otp = $request->otp;

            $user = User::where('email', $email)->where('otp', $otp)->first();
            if ($user !== null) {
                User::where('email', $email)->update(['otp' => 0]);
                $token = JWTToken::createTokenForResetPassword($email);
                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP verified successfully'
                ], 200)->withCookie(cookie('token', $token, time() + 60 * 60 * 24));
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid OTP'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:6|confirmed'
            ]);

            $email = $request->header('email');
            $password = Hash::make($request->password);

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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Get user profile
    public function userProfile(Request $request)
    {
        $email = $request->header('email');
        try {
            $user = User::where('email', $email)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'User Profile',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Profile update
    public function updateUserProfile(Request $request)
    {
        $email = $request->header('email');

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:20',
            'password' => 'required|string|min:6'
        ]);

        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not found'
                ], 404);
            }

            // Verify current password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Current password is incorrect'
                ], 401);
            }

            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'mobile' => $request->input('mobile')
            ]);

            $updatedUser = User::where('email', $email)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successful',
                'data' => $updatedUser
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
