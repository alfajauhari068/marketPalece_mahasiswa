<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardKlienController extends Controller
{
    public function index()
    {
        return view('klien.dashboard-klien');
    }
}
