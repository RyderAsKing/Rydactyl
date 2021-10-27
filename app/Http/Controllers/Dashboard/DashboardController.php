<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('dashboard.index')->with('pterodactyl_information', Session::get('pterodactyl_information'));
    }
}
