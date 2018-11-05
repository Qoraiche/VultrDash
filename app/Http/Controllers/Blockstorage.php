<?php

namespace vultrui\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use vultrui\Notifications\BlockStorageAdded;
use vultrui\Notifications\BlockStorageDeleted;
use vultrui\VultrLib\Storage;
use vultrui\VultrLib\Region;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use vultrui\User;
use Illuminate\Support\Facades\Auth;

class Blockstorage extends Controller
{

	protected $vultr;

	public function __construct(Storage $vultr, Region $region)

	{

		$this->vultr = $vultr;
        $this->region = $region;

	}

    public function index()
    {

        $View = view('dash.blockstorage')->with( [ 'storages' => $this->vultr->list(), 'regions' => $this->region->list() ] );

        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;

    }


    public function add()
    {

        $View =  view('modals.add-blockstorage')->with( [ 'regions' => $this->region->list() ] );


        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;

    }

    public function create( Request $request )
    {

        $user = User::findOrFail( Auth::id() );
        
        $data = [
            'DCID' => $request->regionid,
            'size_gb' => $request->sizegb,
            'label' => $request->label
        ];

        $results = $this->vultr->create( array(), $data );

        if ( !in_array('error', $results ) && isset( $results['SUBID'] ) ) {

            // clear cache
            Cache::forget('storages');

            $storageInfo = $this->vultr->list()[0];

            $user->notify( new BlockStorageAdded( $storageInfo ) );

            activity()->withProperties([ 

                    'blockstorage_id' => $results['SUBID'],
                    'label' => $request->label

            ])->log( __( 'Add Blockstorage' ) );

            // redirect and flush session
            return redirect('blockstorage')->with( ['type' => 'success', 'message' => 'Block storage created' ]);

        }

        if ( isset( $results['error'] ) )

            if (preg_match( '/response:\s(.*)/i', $results['error'], $matches) ) {

                return redirect('blockstorage/add')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

            return redirect('blockstorage/add')->with( ['type' => 'error', 'message' => $results['error'] ] );

    }

    public function delete( Request $request )
    {

        $user = User::findOrFail( Auth::id() );

        $data = [
            'SUBID' => $request->subid,
        ];

        $destroyRes = $this->vultr->delete( array(), $data );


        if ( !isset( $destroyRes['error'] ) ) {
            
            // clear cache
            Cache::forget('storages');

            $user->notify( new BlockStorageDeleted( $request->subid ) );

            activity()->withProperties([ 

                'blockstorage_id' => $request->subid,

            ])->log( __( 'Delete Blockstorage' ) );

            // redirect and flush session
            return redirect('blockstorage')->with( ['type' => 'success', 'message' => 'Block storage <strong>'.$request->subid.'</strong> deleted' ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $destroyRes['error'], $matches) ) {

                return redirect('blockstorage')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }
            
        }

        return redirect('blockstorage')->with( ['type' => 'error', 'message' => $destroyRes['error'] ] );
    }


}
