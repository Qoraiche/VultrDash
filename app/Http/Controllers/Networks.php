<?php

namespace vultrui\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use vultrui\Notifications\PrivateNetworkAdded;
use vultrui\Notifications\PrivateNetworkDeleted;
use vultrui\User;
use vultrui\VultrLib\Network;
use vultrui\VultrLib\Region;

class Networks extends Controller
{
    protected $vultr;

    public function __construct(Network $vultr, Region $region)
    {
        $this->vultr = $vultr;
        $this->region = $region;
    }

    public function index()
    {
        $View = view('dash.networks')->with(['networks' => $this->vultr->list(), 'regions' => $this->region->list()]);

        if (array_key_exists('error', $this->vultr->list())) {
            return view('errors.connection')->with('error', $this->vultr->list()['error']);
        }

        return $View;
    }

    public function add()
    {
        $View = view('modals.add-network')->with('regions', $this->region->list());

        if (array_key_exists('error', $this->region->list())) {
            return view('errors.connection')->with('error', $this->region->list()['error']);
        }

        return $View;
    }

    public function create(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = [
            'DCID'        => $request->dcid,
            'description' => $request->description,
            'v4_subnet'   => $request->v4_subnet,
        ];

        $results = $this->vultr->create([], $data);

        if (!in_array('error', $results) && isset($results['NETWORKID'])) {

            // clear cache
            Cache::forget('networks');

            $networkInfo = $this->vultr->list()[$results['NETWORKID']];

            $user->notify(new PrivateNetworkAdded($networkInfo));

            activity()->withProperties([

                'description' => $request->description,
                'v4_subnet'   => $request->v4_subnet,

            ])->log(__('Add Private Network'));

            // redirect and flush session
            return redirect('networks')->with(['type' => 'success', 'message' => 'Network added']);
        }

        if (isset($results['error'])) {
            if (preg_match('/response:\s(.*)/i', $results['error'], $matches)) {
                return redirect('networks/add')->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect('networks/add')->with(['type' => 'error', 'message' => $results['error']]);
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = [
            'NETWORKID' => $request->networkid,
        ];

        $destroyRes = $this->vultr->destroy([], $data);

        if (!isset($destroyRes['error'])) {

            // clear cache
            Cache::forget('networks');

            $user->notify(new PrivateNetworkDeleted($request->networkid));

            activity()->withProperties([

                'network_id' => $request->networkid,

            ])->log(__('Add Private Network'));

            // redirect and flush session
            return redirect('networks')->with(['type' => 'success', 'message' => 'Network <strong>'.$request->networkid.'</strong> destroyed']);
        } else {
            if (preg_match('/response:\s(.*)/i', $destroyRes['error'], $matches)) {
                return redirect('networks')->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect('networks')->with(['type' => 'error', 'message' => $destroyRes['error']]);
    }
}
