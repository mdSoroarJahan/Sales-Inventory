<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function invoicePage()
    {
        return view('pages.dashboard.invoice-page');
    }
    // Create invoice
    public function invoiceCreate(Request $request)
    {
        DB::beginTransaction();

        try {
            $user_id = $request->header('user_id');

            $request->validate([
                'total' => 'required|numeric|max:999999999',
                'discount' => 'required|numeric|max:999999999',
                'vat' => 'required|numeric|max:999999999',
                'payable' => 'required|numeric|max:999999999',
                'customer_id' => 'required|integer',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|integer',
                'products.*.qty' => 'required|integer|min:1',
                'products.*.sale_price' => 'required|numeric|min:0'
            ]);
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'user_id' => $user_id,
                'customer_id' => $customer_id
            ]);
            $invoiceId = $invoice->id;
            $products = $request->input('products');

            foreach ($products as $eachProduct) {
                InvoiceProduct::create([
                    'invoice_id' => $invoiceId,
                    'user_id' => $user_id,
                    'product_id' => $eachProduct['product_id'],
                    'qty' => $eachProduct['qty'],
                    'sale_price' => $eachProduct['sale_price'],
                ]);
            }

            DB::commit();

            $createdInvoice = Invoice::with('customer')
                ->where('id', $invoiceId)
                ->first();

            $invoiceProducts = InvoiceProduct::where('invoice_id', $invoiceId)
                ->with('product')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Invoice created successfully',
                'data' => [
                    'invoice' => $createdInvoice,
                    'products' => $invoiceProducts
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to create invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Select Invoice
    public function invoiceSelect(Request $request)
    {
        $user_id = $request->header('user_id');
        try {
            $invoices = Invoice::where('user_id', $user_id)
                ->with('customer')
                ->get();

            if ($invoices->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No invoices found'
                ], 404);
            }

            // Load invoice products for each invoice
            $invoices->load('invoiceProducts.product');

            return response()->json([
                'status' => 'success',
                'message' => 'Invoices retrieved successfully',
                'data' => $invoices
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve invoices',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
