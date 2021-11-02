<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('dashboard.users.index', ['users' => $users]);
    }

    public function manage($id)
    {
        $user = User::where(['id' => $id])->firstOrFail();
        return view('dashboard.users.manage', ['user' => $user]);
    }
}
