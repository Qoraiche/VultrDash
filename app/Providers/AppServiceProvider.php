<?php

namespace vultrui\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use vultrui\VultrLib\Account;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Account $account)
    {
        Blade::component('components.alert', 'alert');
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
