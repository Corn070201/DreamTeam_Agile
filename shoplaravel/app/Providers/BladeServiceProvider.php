<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasrole',function($expression){
            if(Auth::user()){
                //phân quyền nhiều users
                //if(Auth::user()->hasAnyRoles($expression)){
                //phân quyền cho 1 user
                if(Auth::user()->hasRole($expression)){
                    return true;
                }
            }
            return false;
        });
    }
}
