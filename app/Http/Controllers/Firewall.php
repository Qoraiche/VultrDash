<?php

namespace vultrui\Http\Controllers;

use Illuminate\Http\Request;
use vultrui\VultrLib\Firewall as APIFirewall;
use vultrui\VultrLib\Region;
use Illuminate\Support\Facades\Cache;

class Firewall extends Controller
{

	protected $vultr;

	public function __construct( APIFirewall $vultr )
    
	{

		$this->vultr = $vultr;

	}

    public function index()
    {

    	$View = view('dash.firewall')->with( 'firewalls', $this->vultr->group_list() );

        if ( array_key_exists( 'error', $this->vultr->group_list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->group_list()['error'] );
        }
        
        return $View;

    }

    public function delete_group(Request $request){

    	$data = [
            'FIREWALLGROUPID' => $request->firewallgroupid,
        ];

        $destroyRes = $this->vultr->group_delete( array(), $data );

        if ( !isset( $destroyRes['error'] ) ) {

            // clear cache
            Cache::forget('firewalls');

            activity()->log( __( 'Deleting Firewall Group' ) );

            // redirect and flush session
            return redirect('firewall')->with( ['type' => 'success', 'message' => 'Firewall group <strong>'.$request->firewallgroupid.'</strong> deleted' ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $destroyRes['error'], $matches) ) {

                return redirect('firewall')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

        }

        return redirect('firewall')->with( ['type' => 'error', 'message' => $destroyRes['error'] ] );

    }
}
