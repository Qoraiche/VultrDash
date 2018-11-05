<?php

namespace vultrui\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use vultrui\Notifications\DnsDeleted;
use vultrui\Notifications\DnsAdded;
use vultrui\VultrLib\Dns;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use vultrui\User;
use Illuminate\Support\Facades\Auth;


class Dnsdomains extends Controller
{

	protected $vultr;

	public function __construct(Dns $vultr)

	{

		$this->vultr = $vultr;

	}

    public function index()
    {

        $View = view('dash.dns')->with( 'dnslist', $this->vultr->list() );

        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;
    }

    public function add()
    {

        $View = view('modals.add-domain');

        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;

    }

    public function create( Request $request ) {

        $user = User::findOrFail( Auth::id() );

        $data = [
            'domain' => $request->domain,
            'serverip' => $request->serverip
        ];

        $results = $this->vultr->create_domain( array(), $data );

        if ( !isset( $results['error'] ) ) {

            // clear cache
            Cache::forget('dnsdomains');

            $dnsInfo = $this->vultr->list()[0];

            $user->notify( new DnsAdded( $dnsInfo ) );

            activity()->log( __( 'Add Domain name' ) );

            // redirect and flush session
            return redirect('dns')->with( ['type' => 'success', 'message' => 'Domain <strong>'.$request->domain.'</strong> added' ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $results['error'], $matches) ) {

                return redirect('dns/add')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

        }

            return redirect('dns/add')->with( ['type' => 'error', 'message' => $results['error'] ] );

    }

    public function delete(Request $request) {

        $user = User::findOrFail( Auth::id() );

        $data = [
            'domain' => $request->domain,
        ];

        $destroyRes = $this->vultr->delete_domain( array(), $data );

        if ( !isset( $destroyRes['error'] ) ) {

            // clear cache
            Cache::forget('dnsdomains');

            $user->notify( new DnsDeleted( $request->domain ) );

            // redirect and flush session
            return redirect('dns')->with( 
                [
                    'type' => 'success',
                    'message' => 'Domain <strong>'.$request->snapshotid.'</strong> deleted' 
                ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $destroyRes['error'], $matches) ) {

                return redirect('dns/add')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

        }

        return redirect('dns/add')->with( ['type' => 'error', 'message' => $destroyRes['error'] ] );

    }
}
