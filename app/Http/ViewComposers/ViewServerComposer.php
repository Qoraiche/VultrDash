<?php

namespace vultrui\Http\ViewComposers;

use vultrui\VultrLib\Server;
use vultrui\VultrLib\Os;
use vultrui\VultrLib\App as Application;

use Illuminate\View\View;


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
     * @param  View  $view
     * @return void
     */
    
    public function compose( View $view )
    {

        $serverInfo = json_decode( json_encode( $this->servers->list() ), FALSE );

        $os = $this->os;

        $app = $this->app;

        $view->with( compact( 'serverInfo', 'os', 'app' ) );

    }

}