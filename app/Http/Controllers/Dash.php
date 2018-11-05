<?php

namespace vultrui\Http\Controllers;

use vultrui\VultrLib\Server;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use vultrui\VultrLib\Os;
use vultrui\VultrLib\Account as VultrAccount;
use vultrui\VultrLib\App;
use vultrui\User;
use vultrui\Notification;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use DB;

class Dash extends Controller
{

    protected $vultr;

    protected $os;

    protected $app;

    protected $account;

    public function __construct(Server $vultr,Os $os, App $app, VultrAccount $account)

    {

        $this->middleware('auth');
        $this->middleware('role:super-admin')->except([ 'activity', 'home', 'servers' ]);

        $this->vultr = $vultr;
        $this->os = $os;
        $this->app = $app;
        $this->account = $account;
    }


    public function activity(){

        $activity_chart_data = Activity::take(30)->where( 'created_at', '>=', \Carbon\Carbon::now()->subMonth() )
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(DB::raw('Date(created_at) as date'),
                        DB::raw('COUNT(*) as "data"')
        ));

        $activities = Activity::orderBy('id', 'desc')->paginate(15);

        return view('dash.activity', compact('activity_chart_data', 'activities'));
    }

    public function deleteActivity( $id ){

        Activity::findOrFail( $id )->delete();

        return Redirect::to(URL::previous() . "#activity")->with('status_activitylog', 'Activity log deleted');

    }

    public function deleteActivityByUser(){

        Activity::where('causer_id', '=', auth()->user()->id )->delete();
    
        return Redirect::to(URL::previous() . "#activity")->with('status_activitylog', 'Your activity log cleared');
    }

    public function clearActivity(){

        Activity::truncate();

        return Redirect::to(URL::previous() . "#activity")->with('status_activitylog', 'Activity log cleared');
    }

    public function home(){

        // dd( Notification::take(1) );

        $activity_chart_data = Activity::take(7)->where( 'created_at', '>=', \Carbon\Carbon::now()->subMonth() )
                        ->groupBy('date')
                        ->orderBy('date', 'DESC')
                        ->get(array(
                            DB::raw('Date(created_at) as date'),
                            DB::raw('COUNT(*) as "data"')
        ));

        $activities = Activity::take(6)->orderBy('id', 'desc');

        $activity_today = Activity::whereDate('created_at', Carbon::today())->get();

        $users = User::take(8);

        $View = view('home')->with([   
            'servers' => $this->vultr->list(),
            'activities' => $activities->get(),
            'activity_chart_data' => $activity_chart_data,
            'users' => $users->get(),
            'app' => $this->app,
            'os' => $this->os,
            'account' => (object) $this->account->info(),
            'activity_today' => $activity_today
        ]);

        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->account->info()['error'] );
        }

        return $View;
    }

    public function servers() {

        $View = view('dash.servers')->with(
           [
                'servers' => $this->vultr->list(),
                'os' => $this->os,
                'app' => $this->app
            ]
        );

        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;
    }



}
