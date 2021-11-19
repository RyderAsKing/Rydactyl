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
        $nests = Nest::with('egg')->get();
        return view('dashboard.nests.index', ['nests' => $nests]);
    }

    public function nest_add()
    {
        $nests = Pterodactyl::get_nests()['data'];
        return view('dashboard.nests.add', ['nests' => $nests]);
    }

    public function nest_add_store(Request $request)
    {
        $this->validate($request, ['nest_id' => 'required|numeric|unique:nests,nest_id']);
        $nest = Pterodactyl::get_nest($request->nest_id);
        Nest::create(['nest_id' => $request->nest_id, 'name' => $nest['attributes']['name'], 'description' => $nest['attributes']['description'], 'uuid' => $nest['attributes']['uuid']]);
        return redirect()->route("dashboard.nests.add")->with('message', 'Nest has been added successfully');
    }

    public function nest_manage($id)
    {
        $nest = Nest::where(['id' => $id])->with('egg')->firstOrFail();
        return view('dashboard.nests.id.index', ['nest' => $nest]);
    }


    // Eggs
    public function eggs()
    {
        $eggs = Egg::all();
        return view('dashboard.eggs.index', ['eggs' => $eggs]);
    }

    public function egg_add($nest_id)
    {
        $eggs = Pterodactyl::get_eggs($nest_id)['data'];
        return view('dashboard.nests.id.eggs.add', ['eggs' => $eggs, 'nest_id' => $nest_id]);
    }

    public function egg_add_store($nest_id, Request $request)
    {
        $this->validate($request, ['egg_id' => 'required|numeric|unique:eggs,egg_id']);
        $egg = Pterodactyl::get_egg($nest_id, $request->egg_id);
        Egg::create(['nest_id' => $nest_id, 'egg_id' => $request->egg_id, 'name' => $egg['attributes']['name'], 'description' => $egg['attributes']['description'], 'uuid' => $egg['attributes']['uuid']]);
        return back()->with('message', 'Egg has been added successfully');
    }

    public function egg_manage($id)
    {
        $egg = Egg::where(['id' => $id])->firstOrFail();
        return view('dashboard.eggs.manage', ['egg' => $egg]);
    }
}
