<?php

namespace App\Providers;

use App\Models\Egg;
use App\Models\Node;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-content', function (User $user) {
            return $user->type === 1;
        });

        // Gate::define('use-egg', function (User $user, $egg_id) {
        //     $egg = Egg::where(['egg_id' =>  $egg_id])->with('nest')->firstOrFail();

        //     if ($egg->enabled === false || $egg->nest->enabled === false) {
        //         return false;
        //     }

        //     return true;
        // });

        Gate::define('create_server', function (User $user, $node_id, $egg_id) {
            $node = Node::where(['node_id' =>  $node_id])->firstOrFail();
            $egg = Egg::where(['egg_id' =>  $egg_id])->with('nest')->firstOrFail();

            if ($user->suspended == true || $node->disabled == true || $egg->disabled == true || $egg->nest->disabled == true) {
                return false;
            }

            return true;
        });
        //
    }
}
