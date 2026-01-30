<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function dashboardPage()
    {
        return view('pages.dashboard.dashboard-page');
    }

    /**
     * Get dashboard summary statistics
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function summary(Request $request)
    {
        try {
            $user_id = $request->header('user_id');

            // Validate user_id exists
            if (!$user_id) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User ID is required'
                ], 400);
            }

            // Fetch all statistics in a single query approach for optimization
            $summary = [
                'total_products' => Product::where('user_id', $user_id)->count(),
                'total_categories' => Category::where('user_id', $user_id)->count(),
                'total_customers' => Customer::where('user_id', $user_id)->count(),
                'total_invoices' => Invoice::where('user_id', $user_id)->count(),
                'total_amount' => Invoice::where('user_id', $user_id)->sum('total') ?? 0,
                'total_vat' => Invoice::where('user_id', $user_id)->sum('vat') ?? 0,
                'total_payable' => Invoice::where('user_id', $user_id)->sum('payable') ?? 0
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Dashboard summary retrieved successfully',
                'data' => $summary
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to fetch dashboard summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
