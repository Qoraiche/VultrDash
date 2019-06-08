<?php

namespace vultrui\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use vultrui\Notifications\KeyAdded;
use vultrui\Notifications\KeyDeleted;
use vultrui\User;
use vultrui\VultrLib\Ssh;

class Sshkeys extends Controller
{
    protected $vultr;

    public function __construct(Ssh $vultr)
    {
        $this->vultr = $vultr;
    }

    public function index()
    {
        $View = view('dash.ssh')->with('sshkeys', $this->vultr->list());

        if (array_key_exists('error', $this->vultr->list())) {
            return view('errors.connection')->with('error', $this->vultr->list()['error']);
        }

        return $View;
    }

    public function add()
    {
        $View = view('modals.add-ssh');

        if (array_key_exists('error', $this->vultr->list())) {
            return view('errors.connection')->with('error', $this->vultr->list()['error']);
        }

        return $View;
    }

    public function create(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = [
            'name'    => $request->name,
            'ssh_key' => $request->ssh_key,
        ];

        $results = $this->vultr->create([], $data);

        if (!in_array('error', $results) && isset($results['SSHKEYID'])) {

            // clear cache
            Cache::forget('sshkeys');

            $keyInfo = $this->vultr->list()[$results['SSHKEYID']];

            // $user->notify( new KeyAdded( $keyInfo ) );

            activity()->withProperties([

                'name' => $request->name,

            ])->log(__('Create SSH key'));

            // redirect and flush session
            return redirect('sshkeys')->with(['type' => 'success', 'message' => 'SSH key created']);
        }

        if (isset($results['error'])) {
            if (preg_match('/response:\s(.*)/i', $results['error'], $matches)) {
                return redirect('sshkeys/add')->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect('sshkeys/add')->with(['type' => 'error', 'message' => $results['error']]);
    }

    public function edit($sshkeyid)
    {
        if (isset($this->vultr->list()[$sshkeyid])) {
            return view('modals.add-ssh')->with(['sshkeyid' => $sshkeyid, 'sshkey' => $this->vultr->list()]);
        }

        return redirect('sshkeys')->with(['type' => 'error', 'message' => 'SSHKEY ID not found']);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = [

            'SSHKEYID' => $request->sshkeyid,
            'name'     => $request->name,
            'ssh_key'  => $request->ssh_key,

        ];

        $destroyRes = $this->vultr->update([], $data);

        if (!isset($destroyRes['error'])) {

            // clear cache
            Cache::forget('sshkeys');

            $keyInfo = $this->vultr->list()[$results['SSHKEYID']];

            activity()->withProperties([

                'name' => $request->name,

            ])->log(__('Update SSH key'));

            return redirect('sshkeys')->with(['type' => 'success', 'message' => 'SSH key <strong>'.$request->sshkeyid.'</strong> updated']);
        } else {
            if (preg_match('/response:\s(.*)/i', $destroyRes['error'], $matches)) {
                return redirect('sshkeys')->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect('snapshots')->with(['type' => 'error', 'message' => $destroyRes['error']]);
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = [
            'SSHKEYID' => $request->sshkeyid,
        ];

        $destroyRes = $this->vultr->destroy([], $data);

        if (!isset($destroyRes['error'])) {

            // clear cache
            Cache::forget('sshkeys');

            $user->notify(new KeyDeleted($request->sshkeyid));

            activity()->withProperties([

                'sshkey_id' => $request->sshkeyid,

            ])->log(__('Destroy SSH key'));

            // redirect and flush session
            return redirect('sshkeys')->with(['type' => 'success', 'message' => 'SSH key <strong>'.$request->sshkeyid.'</strong> deleted']);
        } else {
            if (preg_match('/response:\s(.*)/i', $destroyRes['error'], $matches)) {
                return redirect('sshkeys')->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect('snapshots')->with(['type' => 'error', 'message' => $destroyRes['error']]);
    }
}
