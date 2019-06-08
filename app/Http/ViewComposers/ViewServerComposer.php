<?php

namespace vultrui\Http\ViewComposers;

use Illuminate\View\View;
use vultrui\VultrLib\App as Application;
use vultrui\VultrLib\Os;
use vultrui\VultrLib\Server;

class ViewServerComposer
{
    protected $servers;

    public function __construct(Server $server, Os $os, Application $app)
    {
        $this->servers = $server;
        $this->os = $os;
        $this->app = $app;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $serverInfo = json_decode(json_encode($this->servers->list()), false);

        $os = $this->os;

        $app = $this->app;

        $view->with(compact('serverInfo', 'os', 'app'));
    }
}
