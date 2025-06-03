<?php

namespace App\Providers;

use App\Models\Correspondence;
use App\Models\hazmatCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       
        view()->composer('*', function($view)
        {
            if (Auth::check()) {
                $user = auth()->user();
                $currentUserRoleName = $user->roles->first()->name;
                $currentUserRoleLevel  = $user->roles->first()->level;
                if( $currentUserRoleLevel == 2){
                    $count = Correspondence::where('hazmat_companies_id', $user['hazmat_companies_id'])->where('isRead',0)->count();
                    View::share('markasRead', $count);
                }
                View::share('shiptitle', $currentUserRoleName." Dashboard");
                View::share('currentUserRoleLevel', $currentUserRoleLevel);


            }else {
                $view->with('shiptitle', null);
            }
        });
        if (Schema::hasTable('permissions')) {
            $allPermissions = Permission::select('id','group_type','name','is_show','full_name')->get()->toArray();
            // Share permissions with all views
            View::share('allPermissions', $allPermissions);
        }
       

        

    }
}
