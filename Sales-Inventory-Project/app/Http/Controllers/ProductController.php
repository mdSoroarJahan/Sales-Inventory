<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productPage()
    {
        return view('pages.dashboard.product-page');
    }
}
