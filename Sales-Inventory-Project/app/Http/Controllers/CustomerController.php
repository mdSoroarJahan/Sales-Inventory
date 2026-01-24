<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerPage()
    {
        return view('pages.dashboard.customer-page');
    }

    public function customerCreate(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'name' => 'required|50',
            'email' => 'required|unique',
            'mobile' => 'required|50'
        ]);

        try {
            $customer = Customer::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to create user'
            ]);
        }
    }
}
