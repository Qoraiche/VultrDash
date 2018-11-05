<?php

namespace vultrui\Http\Middleware;

use vultrui\VultrLib\Server;

use Closure;

class CheckServerExists
{


    protected $servers;

    
    function __construct( Server $server ){

        $this->servers = $server;

    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {

        if ( array_key_exists( $request->serverid, $this->servers->list() ) ) {

            return $next($request);

        }


        return redirect()->route('servers.index')->with('warning', 'Invalid server <strong>'.$request->serverid.'</strong>');

    }
}
