<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function categoryPage()
    {
        return view('pages.dashboard.catagory-page');
    }
}
