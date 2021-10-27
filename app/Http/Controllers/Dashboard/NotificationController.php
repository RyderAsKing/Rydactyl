<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        return view('dashboard.notifications')->with('notifications', $notifications);
    }
}
