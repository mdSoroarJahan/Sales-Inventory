<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function dashboardPage()
    {
        return view('pages.dashboard.dashboard-page');
    }
}
