<?php

namespace vultrui\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use vultrui\Notifications\IsoAdded;
use vultrui\VultrLib\Iso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use vultrui\User;
use Illuminate\Support\Facades\Auth;

class Isos extends Controller
{

	protected $vultr;

	public function __construct(Iso $vultr)

	{

		$this->vultr = $vultr;

	}

    public function index()
    {

    	$View = view('dash.iso')->with( 'isos', $this->vultr->list() );

        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;

    }

    public function add()
    {

        return view( 'modals.add-iso' );
    }

    public function create( Request $request )
    {

        $user = User::findOrFail( Auth::id() );

        $data = [
            'url' => $request->iso_url,
        ];

        $results = $this->vultr->create_from_url( array(), $data );

        if ( !in_array('error', $results ) && isset( $results['ISOID'] ) ) {

            // clear cache
            Cache::forget('isos');

            $isoInfo = $this->vultr->list()[ $results['ISOID'] ];

            $user->notify( new IsoAdded( $isoInfo ) );

            activity()->log( __( 'Adding ISO' ) );

            // redirect and flush session
            return redirect('iso')->with( ['type' => 'success', 'message' => 'ISO added' ]);

        }

        if ( isset( $results['error'] ) )

            if (preg_match( '/response:\s(.*)/i', $results['error'], $matches) ) {

                return redirect('iso/add')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

            return redirect('iso/add')->with( ['type' => 'error', 'message' => $results['error'] ] );

    }

}
