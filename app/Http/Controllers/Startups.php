<?php

namespace vultrui\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use vultrui\Notifications\StartupScriptAdded;
use vultrui\Notifications\StartupScriptDeleted;
use vultrui\VultrLib\Startup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use vultrui\User;
use Illuminate\Support\Facades\Auth;

class Startups extends Controller
{

	protected $vultr;

	public function __construct(Startup $vultr)

	{

		$this->vultr = $vultr;

	}

    public function index()
    {	

    	$View = view('dash.startup')->with( 'scripts', $this->vultr->list() );
        

        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;

    }

    public function add()
    {

        return view('modals.add-startup');
    }

    public function create( Request $request )
    {

        $user = User::findOrFail( Auth::id() );

        $data = [
            'name' => $request->name,
            'script' => $request->script,
            'type' => $request->type,
        ];

        $results = $this->vultr->create( array(), $data );

        if ( !in_array('error', $results ) && isset( $results['SCRIPTID'] ) ) {

            // clear cache
            Cache::forget('startups');

            $scriptInfo = $this->vultr->list()[ $results['SCRIPTID'] ];

            // $user->notify( new StartupScriptAdded( $scriptInfo ) );

            activity()->log( __( 'Creating Startup Script' ) );

            // redirect and flush session
            return redirect('startup')->with( ['type' => 'success', 'message' => 'Startup Script added Successfully' ]);

        }

        if ( isset( $results['error'] ) )

            if (preg_match( '/response:\s(.*)/i', $results['error'], $matches) ) {

                return redirect('startup/add')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );
            }

            return redirect('startup/add')->with( ['type' => 'error', 'message' => $results['error'] ] );
    }

    public function destroy( Request $request )
    {

        $user = User::findOrFail( Auth::id() );


        $data = [
            'SCRIPTID' => $request->scriptid,
        ];

        $destroyRes = $this->vultr->destroy( array(), $data );

        if ( !isset( $destroyRes['error'] ) ) {

            // clear cache
            Cache::forget('startups');

            $user->notify( new StartupScriptDeleted( $request->scriptid ) );

            // redirect and flush session
            return redirect('startup')->with( ['type' => 'success', 'message' => 'Startup script removed successfully' ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $destroyRes['error'], $matches) ) {

                return redirect('startup')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

        }

        return redirect('startup')->with( ['type' => 'error', 'message' => $destroyRes['error'] ] );

    }

}
