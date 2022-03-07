<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use \App\user;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user) {
            $role = User::find($user->id)->role;
            foreach ($role as $r){
                if($r->id == 1){
                    return true;
                }
            }
            return null;
         });

         Gate::define('isDapur', function($user) {
            $role = User::find($user->id)->role;
            foreach ($role as $r){
                if($r->id == 2){
                    return true;
                }
            }
            return null;
         });

         Gate::define('isKasir', function($user) {
            $role = User::find($user->id)->role;
            foreach ($role as $r){
                if($r->id == 3){
                    return true;
                }
            }
            return null;
         });
    }
}
