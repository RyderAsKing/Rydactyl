<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Egg;
use App\Models\Nest;
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

    // Nodes
    public function nodes()
    {
        $nodes = Node::all();
        return view('dashboard.nodes.index', ['nodes' => $nodes]);
    }

    public function node_add()
    {
        $nodes = Pterodactyl::get_nodes()['data'];
        return view('dashboard.nodes.add', ['nodes' => $nodes]);
    }

    public function node_add_store(Request $request)
    {
        $this->validate($request, ['node_name' => 'required|max:128', 'node_description' => 'required|max:256', 'node_id' => 'required|numeric|unique:nodes,node_id', 'node_slots' => 'required|numeric|min:0']);
        $node = Pterodactyl::get_node($request->node_id);
        Node::create(['name' => $request->node_name, 'description' => $request->node_description, 'slots' => $request->node_slots, 'slots_used' => 0, 'type' => 0, 'panel_fqdn' => env('PTERODACTYL_FQDN'), 'node_id' => $node['attributes']['id'], 'uuid' => $node['attributes']['uuid'], 'memory_allocated' => 0, 'disk_allocated' => 0, 'node_fqdn' => $node['attributes']['fqdn']]);
        return redirect()->route("dashboard.nodes.add")->with('message', 'Node has been added successfully');
    }
    public function node_manage($id)
    {
        $node = Node::where(['id' => $id])->firstOrFail();
        return view('dashboard.nodes.manage', ['node' => $node]);
    }


    // Nests
    public function nests()
    {
        $nests = Nest::all();
        return view('dashboard.nests.index', ['nests' => $nests]);
    }

    public function nest_add()
    {
        $nests = Pterodactyl::nests()['data'];
        return view('dashboard.nests.add', ['nests' => $nests]);
    }

    public function nest_add_store(Request $request)
    {
        $this->validate($request, ['nest_name' => 'required|max:128', 'nest_description' => 'required|max:256', 'nest_id' => 'required|numeric|unique:nests,nest_id', 'nest_slots' => 'required|numeric|min:0']);
        $nest = Pterodactyl::get_nest($request->nest_id);
        Nest::create(['name' => $request->nest_name, 'description' => $request->nest_description, 'slots' => $request->nest_slots, 'slots_used' => 0, 'type' => 0, 'panel_fqdn' => env('PTERODACTYL_FQDN'), 'nest_id' => $nest['attributes']['id'], 'uuid' => $nest['attributes']['uuid'], 'memory_allocated' => 0, 'disk_allocated' => 0, 'nest_fqdn' => $nest['attributes']['fqdn']]);
        return redirect()->route("dashboard.nests.add")->with('message', 'Nest haas been added successfully');
    }
    public function nest_manage($id)
    {
        $nest = Nest::where(['id' => $id])->firstOrFail();
        return view('dashboard.nests.manage', ['nest' => $nest]);
    }


    // Eggs
    public function eggs()
    {
        $eggs = Egg::all();
        return view('dashboard.eggs.index', ['eggs' => $eggs]);
    }

    public function egg_add()
    {
        $eggs = Pterodactyl::get_eggs()['data'];
        return view('dashboard.eggs.add', ['eggs' => $eggs]);
    }

    public function egg_add_store(Request $request)
    {
        $this->validate($request, ['egg_name' => 'required|max:128', 'egg_description' => 'required|max:256', 'egg_id' => 'required|numeric|unique:eggs,egg_id', 'egg_slots' => 'required|numeric|min:0']);
        $egg = Pterodactyl::get_egg($request->egg_id);
        Egg::create(['name' => $request->egg_name, 'description' => $request->egg_description, 'slots' => $request->egg_slots, 'slots_used' => 0, 'type' => 0, 'panel_fqdn' => env('PTERODACTYL_FQDN'), 'egg_id' => $egg['attributes']['id'], 'uuid' => $egg['attributes']['uuid'], 'memory_allocated' => 0, 'disk_allocated' => 0, 'egg_fqdn' => $egg['attributes']['fqdn']]);
        return redirect()->route("dashboard.eggs.add")->with('message', 'Egg haas been added successfully');
    }
    public function egg_manage($id)
    {
        $egg = Egg::where(['id' => $id])->firstOrFail();
        return view('dashboard.eggs.manage', ['egg' => $egg]);
    }
}
