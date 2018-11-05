<?php

namespace vultrui\Providers;
use vultrui\VultrLib\Account;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot( Account $account)
    {

        // View::share( 'accountInfo', $account->info() );
        
        // View::share( 'accountAuth', $account->AuthInfo() );

        // Blade::component('components.alert', 'alert');
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    
    public function register()
    {
        
    }
    
}
