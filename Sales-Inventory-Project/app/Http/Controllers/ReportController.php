<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportPage()
    {
        return view('pages.dashboard.report-page');
    }

    public function salesReport(Request $request, $FromDate, $ToDate)
    {
        $user_id = $request->header('user_id');

        try {
            // Validate dates format
            if (empty($FromDate) || empty($ToDate)) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Date range is required'
                ], 400);
            }

            // Convert dates to proper format
            $from_date = date('Y-m-d', strtotime($FromDate));
            $to_date = date('Y-m-d', strtotime($ToDate));

            // Validate date range
            if ($from_date > $to_date) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'From date cannot be greater than To date'
                ], 400);
            }

            // Get invoices for the date range
            $invoices = Invoice::where('user_id', $user_id)
                ->whereDate('created_at', '>=', $from_date)
                ->whereDate('created_at', '<=', $to_date)
                ->with('customer')
                ->get();

            // Prepare report data (even if invoices are empty)
            $report = [
                'total' => $invoices->sum('total') ?? 0,
                'vat' => $invoices->sum('vat') ?? 0,
                'payable' => $invoices->sum('payable') ?? 0,
                'discount' => $invoices->sum('discount') ?? 0,
                'list' => $invoices,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'is_empty' => $invoices->isEmpty()
            ];

            // Generate and download PDF (with or without invoices)
            $pdf = Pdf::loadView('report.sales_report', $report);
            return $pdf->download('sales_report_' . date('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to generate PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
