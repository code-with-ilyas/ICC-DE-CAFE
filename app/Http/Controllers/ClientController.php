<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard()
    {
        return view('client.dashboard');
    }

    public function reports()
    {
        return view('client.reports');
    }
}

