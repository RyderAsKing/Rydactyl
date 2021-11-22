<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Egg;
use App\Models\Nest;
use App\Models\Node;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        return view('dashboard.users.id.index', ['user' => $user]);
    }

    public function user_toggle($id)
    {
        $user = User::where(['id' => $id])->firstOrFail();
        if ($user->suspended == false) {
            $user->suspended = true;
            $user->suspended_on = Carbon::now();
        } else {
            $user->suspended = false;
            $user->suspended_on = null;
        }
        $user->save();
        return back()->with('message', 'User status toggled successfully');
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
        return view('dashboard.nodes.id.index', ['node' => $node]);
    }

    public function node_toggle($id)
    {
        $node = Node::where(['id' => $id])->firstOrFail();
        if ($node->enabled == false) {
            $node->enabled = true;
        } else {
            $node->enabled = false;
        }
        $node->save();
        return back()->with('message', 'Node status toggled successfully');
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

    public function nest_toggle($id)
    {
        $nest = Nest::where(['id' => $id])->firstOrFail();
        if ($nest->enabled == false) {
            $nest->enabled = true;
        } else {
            $nest->enabled = false;
        }
        $nest->save();
        return back()->with('message', 'Nest status toggled successfully');
    }

    // Eggs
    public function egg_add($nest_id)
    {
        $eggs = Pterodactyl::get_eggs($nest_id)['data'];
        return view('dashboard.nests.id.eggs.add', ['eggs' => $eggs, 'nest_id' => $nest_id]);
    }

    public function egg_add_store($nest_id, Request $request)
    {
        $this->validate($request, ['egg_id' => 'required|numeric|unique:eggs,egg_id']);
        $egg = Pterodactyl::get_egg($nest_id, $request->egg_id);
        Egg::create(['nest_id' => $nest_id, 'egg_id' => $request->egg_id, 'name' => $egg['attributes']['name'], 'description' => Str::limit($egg['attributes']['description'], 512, '...'), 'uuid' => $egg['attributes']['uuid']]);
        return back()->with('message', 'Egg has been added successfully');
    }

    public function egg_manage($nest_id, $id)
    {
        $egg = Egg::where(['id' => $id, 'nest_id' => $nest_id])->firstOrFail();
        return view('dashboard.nests.id.eggs.id.index', ['egg' => $egg]);
    }

    public function egg_update(Request $request, $nest_id, $id)
    {
        $this->validate($request, ['egg_name' => 'nullable|max:64', 'egg_description' => 'nullable|max:256']);
        if ($request->egg_name == null && $request->egg_description == null) {
            return back()->with('message', 'No changes were made');
        }
        $egg = Egg::where(['id' => $id, 'nest_id' => $nest_id])->firstOrFail();

        if ($request->egg_name != null) {
            $egg->name = $request->egg_name;
        }
        if ($request->egg_description != null) {
            $egg->description = $request->egg_description;
        }
        $egg->save();
        return back()->with('message', 'Egg updated successfully');
    }

    public function egg_toggle($nest_id, $id)
    {
        $egg = Egg::where(['id' => $id, 'nest_id' => $nest_id])->firstOrFail();
        if ($egg->enabled == false) {
            $egg->enabled = true;
        } else {
            $egg->enabled = false;
        }
        $egg->save();
        return back()->with('message', 'Egg status toggled successfully');
    }

    public function egg_resync($nest_id, $id)
    {
        $egg = Egg::where(['id' => $id, 'nest_id' => $nest_id])->firstOrFail();
        $pterodactyl_information = Pterodactyl::get_egg($nest_id, $id);
        $egg->name = $pterodactyl_information['attributes']['name'];
        $egg->description = Str::limit($pterodactyl_information['attributes']['description'], 512, '...');
        $egg->uuid = $pterodactyl_information['attributes']['uuid'];
        $egg->save();
        return back()->with('message', 'Egg resynced successfully');
    }
}
