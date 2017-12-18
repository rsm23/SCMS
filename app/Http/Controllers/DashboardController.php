<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        auth()->user()->authorizeRoles(['admin']);

        return view('dashboard.index');
    }
}
