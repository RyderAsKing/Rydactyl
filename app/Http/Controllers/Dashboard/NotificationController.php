<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $notifications = Auth::user()->notifications()->get();
        return view('dashboard.notifications')->with('notifications', $notifications);
    }

    public function delete($id)
    {
        Auth::user()->notifications()->where(['id' => $id])->firstOrFail()->delete();
        return back()->with('message', 'Successfully deleted notification ID: ' . $id);
    }

    public function view($id)
    {
        $notification = Auth::user()->notifications()->where(['id' => $id])->firstOrFail();
        return back()->with('message', '<strong>' . $notification->title . '</strong>' . '<br>' . $notification->message);
    }
}
