<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoicePage()
    {
        return view('pages.dashboard.invoice-page');
    }
}
