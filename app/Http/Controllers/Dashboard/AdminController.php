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
use Illuminate\Support\Facades\Auth;
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

    public function user_update(Request $request, $id)
    {
        $user = User::where(['id' => $id])->firstOrFail();

        $this->validate($request, ['ram' => 'numeric|min:' . ($user->total_ram_balance - $user->ram_balance), 'disk' => 'numeric|min:' . ($user->total_disk_balance - $user->disk_balance), 'cpu' => 'numeric|min:' . ($user->total_cpu_balance - $user->cpu_balance), 'slot' => 'numeric|min:' . ($user->total_slot_balance - $user->slot_balance)]);
        if ($request->ram == $user->ram_balance && $request->disk == $user->disk_balance && $request->cpu == $user->cpu_balance && $request->slot == $user->slot_balance && $request->coin == $user->coin_balance) {
            return back()->with('message', 'No changes were made');
        }

        if ($request->ram != null && $request->ram != $user->ram_balance) {
            $current_total_ram_balance = $user->total_ram_balance;
            $current_ram_balance = $user->ram_balance;
            $user->ram_balance = $request->ram;
            $user->total_ram_balance = ($current_total_ram_balance - $current_ram_balance) + $request->ram;
        }

        if ($request->disk != null && $request->disk != $user->disk_balance) {
            $current_total_disk_balance = $user->total_disk_balance;
            $current_disk_balance = $user->disk_balance;
            $current_total_disk_balance = $user->total_disk_balance;
            $user->disk_balance = $request->disk;
            $user->total_disk_balance = ($current_total_disk_balance - $current_disk_balance) + $request->disk;
        }

        if ($request->cpu != null && $request->cpu != $user->cpu_balance) {
            $current_total_cpu_balance = $user->total_cpu_balance;
            $current_cpu_balance = $user->cpu_balance;
            $current_total_cpu_balance = $user->total_cpu_balance;
            $user->cpu_balance = $request->cpu;
            $user->total_cpu_balance = ($current_total_cpu_balance - $current_cpu_balance) + $request->cpu;
        }

        if ($request->slot != null && $request->slot != $user->slot_balance) {
            $current_total_slot_balance = $user->total_slot_balance;
            $current_slot_balance = $user->slot_balance;
            $current_total_slot_balance = $user->total_slot_balance;
            $user->slot_balance = $request->slot;
            $user->total_slot_balance = ($current_total_slot_balance - $current_slot_balance) + $request->slot;
        }

        if ($request->coin != null && $request->coin != $user->coin_balance) {
            $user->coin_balance = $request->coin;
        }

        $user->save();

        return back()->with('message', 'User updated successfully');
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

    public function node_update(Request $request, $id)
    {
        $node = Node::where(['id' => $id])->firstOrFail();
        $this->validate($request, ['node_name' => 'nullable|string|max:64', 'node_description' => 'nullable|string|max:512', 'node_slots' => 'nullable|integer|gt:' . $node->slots_used]);

        if ($request->node_name == null && $request->node_description == null && $request->node_slots == null) {
            return back()->with('message', 'No changes were made');
        }

        if ($request->node_name != null) {
            $node->name = $request->node_name;
        }
        if ($request->node_description != null) {
            $node->description = $request->node_description;
        }
        if ($request->node_slots != null) {
            $node->slots = $request->node_slots;
        }
        $node->save();
        return back()->with('message', 'Updated Node successfully');
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

    public function nest_resync($id)
    {
        $nest = Nest::where(['id' => $id])->firstOrFail();
        $pterodactyl_information = Pterodactyl::get_nest($nest->nest_id);
        $nest->name = $pterodactyl_information['attributes']['name'];
        $nest->description = Str::limit($pterodactyl_information['attributes']['description'], 512, '...');
        $nest->uuid = $pterodactyl_information['attributes']['uuid'];
        $nest->save();
        return back()->with('message', 'Nest resynced successfully');
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
        $pterodactyl_information = Pterodactyl::get_egg($nest_id, $egg->egg_id);
        $egg->name = $pterodactyl_information['attributes']['name'];
        $egg->description = Str::limit($pterodactyl_information['attributes']['description'], 512, '...');
        $egg->uuid = $pterodactyl_information['attributes']['uuid'];
        $egg->save();
        return back()->with('message', 'Egg resynced successfully');
    }

    public function test_egg($nest_id, $egg_id)
    {
        $node = Node::get()->first();
        $pterodactyl_information = Pterodactyl::create_server(Auth::user()->id, $node->node_id, $egg_id, "Testing egg", 128, 512, 10);
        if (isset($pterodactyl_information['errors'])) {
            $errors = "";
            foreach ($pterodactyl_information['errors'] as $error) {
                $errors = $errors . $error['detail'] . "<code>" . $error['meta']['source_field'] . "</code>(" . $error['meta']['rule'] . ")<br>";
                // $current_env_vars = $egg->env_vars;
                // if ($current_env_vars == null) {
                //     $current_env_vars = [];
                // }
                // $egg->env_vars = array_merge($current_env_vars, [trim($error['meta']['source_field'], 'environment.') => ""]);
            }
            return back()->with('message', $errors);
        }
    }
}
