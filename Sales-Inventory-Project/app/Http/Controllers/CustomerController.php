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
    // Create customer
    public function customerCreate(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:customers,email',
            'mobile' => 'required|string|max:50'
        ]);

        try {
            $customer = Customer::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'user_id' => $user_id
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Customer created successfully',
                'data' => $customer
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to create customer'
            ], 500);
        }
    }

    // Get all customer
    public function customerList(Request $request)
    {
        $user_id = $request->header('user_id');

        try {
            $customers = Customer::where('user_id', $user_id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Here is the list of customers',
                'data' => $customers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve customers'
            ], 500);
        }
    }

    // Customer Delete
    public function customerDelete(Request $request)
    {
        $user_id = $request->header('user_id');

        $request->validate([
            'id' => 'required|integer'
        ]);

        $customer_id = $request->input('id');

        try {
            $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->first();
            if (!$customer) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Customer not found'
                ], 404);
            }

            $customer->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Customer deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to delete customer'
            ], 500);
        }
    }

    // Find customer by id
    public function customerById(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'id' => 'required|integer'
        ]);
        $customer_id = $request->input('id');

        try {
            $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->first();
            if (!$customer) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Customer not found'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Customer found successfully',
                'data' => $customer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to find customer'
            ], 500);
        }
    }

    // customer update
    public function customerUpdate(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'id' => 'required|integer'
        ]);

        $customer_id = $request->input('id');
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:customers,email,' . $customer_id,
            'mobile' => 'required|string|max:50'
        ]);

        try {
            $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->first();
            if (!$customer) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Customer not found'
                ], 404);
            }
            $customer->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile')
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Customer updated successfully',
                'data' => $customer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to update customer'
            ], 500);
        }
    }
}
