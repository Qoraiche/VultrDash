<?php

namespace vultrui\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use vultrui\Notifications\ServerDeployed;
use vultrui\Notifications\ServerDestroyed;
use vultrui\VultrLib\Server;
use vultrui\VultrLib\Plan;
use vultrui\VultrLib\Os;
use vultrui\VultrLib\Region;
use vultrui\VultrLib\Startup;
use vultrui\VultrLib\Snapshot;
use vultrui\VultrLib\Backup;
use vultrui\VultrLib\App;
use vultrui\VultrLib\Iso;
use vultrui\VultrLib\Ssh;
use vultrui\VultrLib\Firewall;
use vultrui\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class Servers extends Controller
{

    use SettingsHandler;
    
	protected $vultr;

    protected $plan;

    protected $region;

    protected $startup;

    protected $ssh;

    protected $app;

    protected $snapshot;


	public function __construct( Server $vultr, 
		Plan $plan,
		Region $region,
		Os $os, 
		Startup $startup, 
		Ssh $ssh, 
		App $app,
        Iso $iso,
		Snapshot $snapshot,
		Backup $backup,
		Firewall $firewall )
	{


		$this->vultr = $vultr;
		$this->plan = $plan;
		$this->region = $region;
		$this->os = $os;
		$this->startup = $startup;
		$this->ssh = $ssh;
		$this->app = $app;
        $this->iso = $iso;
		$this->snapshot = $snapshot;
		$this->backup = $backup;
		$this->firewall = $firewall;

	}


    public function viewSettings( $serverid ){


        Activity::all()->last()->getExtraProperty('customProperty');

        $serverInfo =      ArrayObj( $this->vultr->list()[$serverid] );
        $firewallList =    $this->firewall->group_list();
        $isoList =         $this->iso->list();
        $isoLibrary =      $this->iso->list_public();
        $isoStatus =       ArrayObj( $this->vultr->iso_status( $serverid ) );
        $appChangeList =   $this->vultr->app_change_list( $serverid );
        $osChangeList =    $this->vultr->os_change_list( $serverid );
        $upgradePlanList = $this->vultr->upgrade_plan_list( $serverid );
        $planList =        $this->plan->list();

        $serverUpgradelist = [];

        foreach ( $upgradePlanList as $key => $value) {
            $serverUpgradelist[] = $planList[$value];
        }

        return view('modals.view-server-settings')->with( 

            compact(
                'serverInfo',
                'serverid',
                'firewallList',
                'isoList',
                'isoLibrary',
                'appChangeList',
                'osChangeList',
                'serverUpgradelist',
                'isoStatus'
            )
        );
    }

    public function viewSnapshots( $serverid ){

        $serverInfo = ArrayObj( $this->vultr->list()[$serverid] );
        $snapshots = $this->snapshot->list();
        $os = $this->os;
        $app = $this->app;

        return view('modals.view-server-snapshots')->with( compact('snapshots', 'os', 'app','serverInfo', 'serverid') );
    }

    public function viewBackups( $serverid )
    {

        $serverInfo = json_decode( json_encode( $this->vultr->list()[$serverid] ), FALSE );

        $backuplist = $this->backup->list( $serverid );

        $backupSchedule = json_decode( json_encode( $this->vultr->backup_get_schedule( array(), [
            'SUBID' => $serverid,
        ] ) ), FALSE );

        return view('modals.view-server-backups')->with( compact('serverInfo', 'serverid', 'backuplist','backupSchedule') );
    }


    public function viewActivity( $serverid )
    {
        $activities = Activity::where('properties', 'LIKE', '%'.$serverid.'%')->paginate(2);

        return view('modals.view-server-activity')->with( compact( 'activities', 'serverid' ) );
    }

    public function backupEnable( Request $request )
    {

        $data = [
            'SUBID' => $request->serverid,
        ];

        $enablebackup = $this->vultr->backup_enable( array(), $data );

        if ( !isset( $enablebackup['error'] ) ) {

            // clear cache
            Cache::forget('backups'); Cache::forget('servers');

            activity()->withProperties([ 'server_id' => $request->serverid ])->log( __( 'Enabling backups' ) );

            return redirect()->route('servers.view.backups', ['serverid' => $request->serverid])->with( ['type' => 'success', 'message' => "Backups Enabled" ]);
            
        } else {

            if (preg_match( '/response:\s(.*)/i', $enablebackup['error'], $matches) ) {

                return redirect()->route('servers.view.backups', ['serverid' => $request->serverid])->with( 'message', str_replace('response:', null, $matches[0] ) );

            }

        }

        return redirect()->route('servers.view.backups', ['serverid' => $request->serverid])->with( 'message', $enablebackup['error'] );
    }


    public function backupSetSchedule( Request $request )
    {

        $data = [
            'SUBID' => $request->subid,
            'cron_type' => $request->cron_type,
            'hour' => $request->hour,
            'dow' => $request->dow
        ];

        $setschedule = $this->vultr->backup_set_schedule( array(), $data );

        if ( !isset( $setschedule['error'] ) ) {

            // clear cache
            Cache::forget('backups');
            
            Cache::forget('servers');

            activity()->withProperties([ 'server_id' => $request->subid ])->log( __( 'Schedule automatic backup' ) );

            return redirect()->route('servers.view.backups', ['serverid' => $request->subid])->with( ['type' => 'success', 'message' => "Backup schedule updated" ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $setschedule['error'], $matches) ) {

                return redirect()->route('servers.view.backups', ['serverid' => $request->subid])->with( 'message', str_replace('response:', null, $matches[0] ) );

            }

        }

        return redirect()->route('servers.view.backups', ['serverid' => $request->subid])->with( ['type' => 'error', 'message' => $setschedule['error'] ]);

    }


    public function backupDisable( Request $request )
    {

        $data = [
            'SUBID' => $request->subid,
        ];

        $setschedule = $this->vultr->backup_disable( array(), $data );

        if ( !isset( $setschedule['error'] ) ) {

            // clear cache
            Cache::forget('backups');
            
            Cache::forget('servers');

            activity()->withProperties([ 'server_id' => $request->subid ])->log( __( 'Disabling backups' ) );

            return redirect()->route('servers.view.backups', ['serverid' => $request->subid])->with( ['type' => 'success', 'message' => "Backup disabled" ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $setschedule['error'], $matches) ) {

                return redirect()->route('servers.view.backups', ['serverid' => $request->subid])->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

        }

        return redirect('servers')->with( ['type' => 'error', 'message' => $setschedule['error'] ] );
    }

    public function viewDDOS( $serverid ){

        $serverInfo = json_decode( json_encode( $this->vultr->list()[$serverid] ), FALSE );

        return view('modals.view-server-ddos')->with( compact('serverInfo', 'serverid') );
    }

    public function show( Request $request, $serverid )
    {
        
        $bandwidth = json_decode( json_encode( $this->vultr->bandwidth( $serverid ) ), FALSE );
        $os = $this->os;
        $app = $this->app;
        $serverInfo = json_decode( json_encode( $this->vultr->list()[$serverid] ), FALSE );
        $activities = Activity::where('properties', 'LIKE', '%'.$serverid.'%')->limit(4)->get();
        $plan = $this->plan->list();
        $appInfo = ArrayObj( $this->vultr->get_app_info( $serverid ) );

        return view('modals.view-server-overview')->with( compact( 'serverInfo', 'serverid', 'os', 'app', 'plan', 'bandwidth', 'appInfo', 'activities' ) );
    }


    public function deploy()
    {
    	$View = view('modals.deploy')->with( 
	    	[ 
	    		'plans' => $this->plan, 
	    		'regions' => $this->region, 'oss' => $this->os,
	    		'sshkeys' => $this->ssh->list(),
	    		'startupscripts' => $this->startup->list(),
	    		'apps' => $this->app,
	    		'snapshots' => $this->snapshot,
	    		'backups' => $this->backup,
	    		'firewalls' => $this->firewall->group_list(),
	    	] );

        if ( array_key_exists( 'error', $this->ssh->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;
        
    }


    /**
     * $this->vultr->list()['error']
     * 
     */

    public function start( Request $request )

    {

        $data = [
            'SUBID' => $request->serverid,
        ];

        $destroyRes = $this->vultr->start( array(), $data );

        if ( !isset( $destroyRes['error'] ) ) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([ 'server_id' => $request->serverid ])->log( __( 'Starting server' ) );

            // redirect and flush session

            return redirect('servers')->with( ['type' => 'success', 'message' => "Server <strong>{$request->serverid}</strong> started" ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $destroyRes['error'], $matches) ) {

                return redirect('servers')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

        }

        return redirect('servers')->with( ['type' => 'error', 'message' => $destroyRes['error'] ] );
    }

    public function halt( Request $request )

    {

    	$data = [
            'SUBID' => $request->serverid,
        ];

        $destroyRes = $this->vultr->halt( array(), $data );

        if ( !isset( $destroyRes['error'] ) ) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([ 'server_id' => $request->serverid ])->log( __( 'Stopping server' ) );

            // redirect and flush session
            return redirect('servers')->with( ['type' => 'success', 'message' => "Server <strong>{$request->serverid}</strong> stopped" ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $destroyRes['error'], $matches) ) {

                return redirect('servers')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );
            }

        }

        return redirect('servers')->with( ['type' => 'error', 'message' => $destroyRes['error'] ] );

    }

/*    public function start( Request $request ){
    	var_dump( $request->all() );
    }*/

    public function reinstall( Request $request )
    {

    	$data = [
            'SUBID' => $request->serverid,
        ];

        $destroyRes = $this->vultr->reinstall( array(), $data );

        if ( !isset( $destroyRes['error'] ) ) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([ 'server_id' => $request->serverid ])->log( __( 'Reinstalling server' ) );

            // redirect and flush session
            return redirect('servers')->with( ['type' => 'success', 'message' => "Server <strong>{$request->serverid}</strong> reinstalled" ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $destroyRes['error'], $matches) ) {

                return redirect('servers')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

        }

        return redirect('servers')->with( ['type' => 'error', 'message' => $destroyRes['error'] ] );
    }

    public function destroy( Request $request )
    {

        $user = User::find( auth()->user()->id );

    	$data = [
            'SUBID' => $request->serverid,
        ];

        $destroyRes = $this->vultr->destroy( array(), $data );

        if ( !isset( $destroyRes['error'] ) ) {

            Cache::forget('servers');

            $user->notify( new ServerDestroyed( $request->serverid ) );

            activity()->withProperties([ 'server_id' => $request->serverid ])->log( __( 'Destroying server' ) );

            // redirect and flush session
            return redirect('servers')->with( ['type' => 'success', 'message' => "Server <strong>{$request->serverid}</strong> destroyed" ]);

        } else {

            if (preg_match( '/response:\s(.*)/i', $destroyRes['error'], $matches) ) {

                return redirect('servers')->with( ['type' => 'error', 'message' => str_replace('response:', null, $matches[0] ) ] );

            }

        }

        return redirect('servers')->with( ['type' => 'error', 'message' => $destroyRes['error'] ] );

    }

    public function create( Request $request )
    {

        $user = User::findOrFail( Auth::id() );

    	//for ($i=0; $i < $request->deploy_quantity; $i++) {

    		$data = [
    		'DCID' => $request->dcid,
    		'VPSPLANID' => $request->serversize,
    		'OSID' => $request->servertype,

/*    		'ipxe_chain_url' => $request->ipxe_chain_url,	/** 
    		'ISOID' => $request->isoid,						/* TODO next Updates (Custom OS)
    		'SCRIPTID' => $request->scriptid,				*/

    		'SNAPSHOTID' => $request->snapshotid,

    		'enable_ipv6' => ($request->enable_ipv6 == 'yes') ? 'yes' : 'no',
    		'enable_private_network' => ($request->enable_private_network == 'yes') ? 'yes' : 'no',
    		'ddos_protection' => ($request->ddos_protection == 'yes') ? 'yes' : 'no',
    		'auto_backups' => ($request->auto_backups == 'yes') ? 'yes' : 'no',

    		//'NETWORKID' => $request->networkid, // TODO
    		//
    		'SSHKEYID' => $request->sshkeys,
    		'APPID' => $request->appid,
            'notify_activate' => 'no',

    		// 'userdata' => $request->userdata, // TODO
    		// 
    		//'notify_activate' => $request->notify_activate, // TODO add to admin settings
    		//
    		//'reserved_ip_v4' => $request->reserved_ip_v4, // TODO
    		'label' => $request->serverlabel,
    		'hostname' => $request->serverhostname,
    		'tag' => $request->servertag,
    		'FIREWALLGROUPID' => ($request->firewallgroupid == 'Select Firewall Group') ? null : $request->firewallgroupid,
    	];


    	$results = $this->vultr->create( array(), $data );

        if ( !in_array('error', $results ) && isset( $results['SUBID'] ) ) {

            Cache::forget('servers');

            $serverInfo = $this->vultr->list()[ $results['SUBID'] ];

            // $user->notify( new ServerDeployed( $serverInfo ) );

            activity()->withProperties([ 'server_id' => $results['SUBID'] ])->log( __( 'Deploying server' ) );
            
            return redirect('servers/'. $results['SUBID'] );
        }

        if ( isset( $results['error'] ) )
 
            if (preg_match( '/response:\s(.*)/i', $results['error'], $matches) ) {

                return redirect('servers/add')->with( 'message', str_replace('response:', null, $matches[0] )  );

            }

            return redirect('servers/add')->with( 'message', $results['error'] );

    	}
    //}
}