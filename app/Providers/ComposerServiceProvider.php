<?php

namespace vultrui\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider

{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('modals.view-server', 'vultrui\Http\ViewComposers\ViewServerComposer');

        // view()->composer('partials.notifications', 'vultrui\Http\ViewComposers\NotificationsComposer');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
