<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Dashboard untuk Admin
        return view('admin.dashboard');
    }
}
