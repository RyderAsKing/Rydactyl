<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Node;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Custom\Functions\Pterodactyl;

class AdminController extends Controller
{
    //
    public function users()
    {
        $users = User::all();
        return view('dashboard.users.index', ['users' => $users]);
    }

    public function user_manage($id)
    {
        $user = User::where(['id' => $id])->firstOrFail();
        return view('dashboard.users.manage', ['user' => $user]);
    }

    public function nodes()
    {
        $nodes = Node::all();
        return view('dashboard.nodes.index', ['nodes' => $nodes]);
    }

    public function node_add()
    {
        $nodes = Pterodactyl::get_nodes();
        return view('dashboard.nodes.add', $nodes);
    }

    public function node_add_store(Request $request)
    {
        $this->validate($request, ['node_name' => 'required|max:128', 'node_description' => 'required|max:256', 'node_id' => 'required|numeric|unique:nodes,node_id', 'node_slots' => 'required|numeric|min:0']);
        $node = Pterodactyl::get_node($request->node_id); // TODO: add into database
        return back();
    }
    public function node_manage($id)
    {
        $node = Node::where(['id' => $id])->firstOrFail();
        return view('dashboard.nodes.manage', ['node' => $node]);
    }
}
