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

    public function salesReport(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'from_date' => 'required|string',
            'to_date' => 'required|string'
        ]);

        try {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));

            $invoices = Invoice::where('user_id', $user_id)
                ->whereDate('created_at', '>=', $from_date)
                ->whereDate('created_at', '<=', $to_date)
                ->with('customer')
                ->get();

            if ($invoices->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No invoices found for the selected date range'
                ], 404);
            }

            $report = [
                'total' => $invoices->sum('total'),
                'vat' => $invoices->sum('vat'),
                'payable' => $invoices->sum('payable'),
                'discount' => $invoices->sum('discount'),
                'invoices' => $invoices,
                'from_date' => $from_date,
                'to_date' => $to_date
            ];

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
