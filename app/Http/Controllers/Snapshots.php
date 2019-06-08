<?php

namespace vultrui\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Models\Activity;
use vultrui\Notifications\SnapshotAdded;
use vultrui\Notifications\SnapshotDeleted;
use vultrui\User;
use vultrui\VultrLib\App;
use vultrui\VultrLib\Os;
use vultrui\VultrLib\Server;
use vultrui\VultrLib\Snapshot;

class Snapshots extends Controller
{
    protected $vultr;

    protected $snapshotList;

    protected $os;

    protected $app;

    protected $server;

    public function __construct(Snapshot $vultr, Os $os, App $app, Server $server)
    {
        $this->vultr = $vultr;
        $this->os = $os;
        $this->app = $app;
        $this->server = $server;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \vultrui\VultrLib\Snapshot
     */
    public function index()
    {
        $View = view('dash.snapshots')->with(

            [

                'snapshots' => $this->vultr->list(),

                'os' => $this->os,

                'app' => $this->app,

            ]
        );

        if (array_key_exists('error', $this->vultr->list())) {
            return view('errors.connection')->with('error', $this->vultr->list()['error']);
        }

        return $View;
    }

    public function add()
    {
        $View = view('modals.add-snapshot')->with(['servers' => $this->server->list()]);

        if (array_key_exists('error', $this->vultr->list())) {
            return view('errors.connection')->with('error', $this->vultr->list()['error']);
        }

        return $View;
    }

    public function upload()
    {
        return view('modals.upload-snapshot');
    }

    /**
     * Create new snapshot resource fron url.
     */
    public function createFromUrl(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = [
            'url' => $request->url,
        ];

        $results = $this->vultr->create_from_url([], $data);

        if (!in_array('error', $results) && isset($results['SNAPSHOTID'])) {

            // clear cache
            Cache::forget('snapshots');

            $snapshotInfo = $this->vultr->list()[$results['SNAPSHOTID']];

            $user->notify(new SnapshotAdded($snapshotInfo));

            activity()->withProperties([

                'url' => $request->url,

            ])->log(__('Create snapshot from url'));

            return redirect('snapshots')->with(['type' => 'success', 'message' => 'A snapshot is currently being taken of this instance. This process can take up to 60 minutes to complete. Most server actions will be unavailable until this has completed']);
        }

        if (isset($results['error'])) {
            if (preg_match('/response:\s(.*)/i', $results['error'], $matches)) {
                return redirect('snapshots/upload')->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect('snapshots/upload')->with(['type' => 'error', 'message' => $results['error']]);
    }

    /**
     * Create new snapshot resource.
     */
    public function create(Request $request)
    {

        // $user = User::where('id', '!=' , Auth::id() )->orWhereNull('id')->get();

        $user = User::findOrFail(Auth::id());

        $data = [
            'SUBID'       => $request->subid,
            'description' => $request->snapshot_label,
        ];

        $results = $this->vultr->create([], $data);

        if (!in_array('error', $results) && isset($results['SNAPSHOTID'])) {

            //snapshot
            $when = now()->addMinutes(2);

            // clear cache
            Cache::forget('snapshots');

            $snapshotInfo = $this->vultr->list()[$results['SNAPSHOTID']];

            $user->notify(new SnapshotAdded($snapshotInfo));

            activity()->withProperties([

                'server_id'   => $request->subid,
                'description' => $request->snapshot_label,

            ])->log(__('Create snapshot from server'));

            if (isset($request->page)) {
                return redirect()->route('servers.view.snapshots', ['serverid' => $request->subid])->with(['type' => 'success', 'message' => 'A snapshot is currently being taken of this instance. This process can take up to 60 minutes to complete. Most server actions will be unavailable until this has completed']);
            }

            return redirect()->route('snapshots')->with(['type' => 'success', 'message' => 'A snapshot is currently being taken of this instance. This process can take up to 60 minutes to complete. Most server actions will be unavailable until this has completed']);
        }

        if (isset($results['error'])) {
            if (preg_match('/response:\s(.*)/i', $results['error'], $matches)) {
                return redirect()->back()->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect('snapshots/add')->with(['type' => 'error', 'message' => $results['error']]);
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = [
            'SNAPSHOTID' => $request->snapshotid,
        ];

        $destroyRes = $this->vultr->destroy([], $data);

        if (!isset($destroyRes['error'])) {

            // clear cache
            Cache::forget('snapshots');

            $user->notify(new SnapshotDeleted($request->snapshotid));

            activity()->withProperties([

                'snapshot_id' => $request->snapshotid,

            ])->log(__('Destroy snapshot from server'));

            // redirect and flush session
            return redirect()->back()->with(['type' => 'success', 'message' => 'Snapshot <strong>'.$request->snapshotid.'</strong> deleted']);
        } else {
            if (preg_match('/response:\s(.*)/i', $destroyRes['error'], $matches)) {
                return redirect()->back()->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect('snapshots')->with(['type' => 'error', 'message' => $destroyRes['error']]);
    }
}
