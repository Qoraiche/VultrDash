<?php

namespace vultrui\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

trait SettingsHandler
{
    public function firewallGroupSet(Request $request)
    {
        $data = [
            'SUBID'           => $request->serverid,
            'FIREWALLGROUPID' => $request->firewallgroup,
        ];

        $setFirewallgroup = $this->vultr->firewall_group_set([], $data);

        if (!isset($setFirewallgroup['error'])) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([

                'server_id'        => $request->serverid,
                'firewallgroup_id' => $request->firewallgroup,

            ])->log(__('Change server firewall group'));

            // redirect and flush session
            return redirect()->route('servers.view.settings', ['serverid' => $request->serverid])->with(['firewall_message' => 'Firewall group updated. It may take up to 120 seconds for these changes to apply. ']);
        } else {
            if (preg_match('/response:\s(.*)/i', $setFirewallgroup['error'], $matches)) {
                return redirect()->route('servers.view.settings', ['serverid' => $request->serverid])->with(['firewall_error' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.settings', ['serverid' => $request->serverid])->with(['firewall_error' => $setFirewallgroup['error']]);
    }

    public function isoAttach(Request $request)
    {
        $data = [
            'SUBID' => $request->serverid,
            'ISOID' => $request->customiso,
        ];

        $attachIso = $this->vultr->iso_attach([], $data);

        if (!isset($attachIso['error'])) {
            activity()->withProperties([

                'server_id' => $request->serverid,
                'iso_id'    => $request->customiso,

            ])->log(__('Attach ISO to server'));

            // redirect and flush session
            return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#iso-setting'])->with(['iso_message' => 'Attaching ISO to machine...']);
        } else {
            if (preg_match('/response:\s(.*)/i', $attachIso['error'], $matches)) {
                return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#iso-setting'])->with(['iso_error' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#iso-setting'])->with(['iso_error' => $attachIso['error']]);
    }

    public function isoDetach(Request $request)
    {
        $data = [
            'SUBID' => $request->serverid,
        ];

        $detachiso = $this->vultr->iso_detach([], $data);

        if (!isset($detachiso['error'])) {
            activity()->withProperties([

                'server_id' => $request->serverid,

            ])->log(__('Detach server ISO'));

            // redirect and flush session
            return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#iso-setting'])->with(['iso_message' => 'ISO removed from machine']);
        } else {
            if (preg_match('/response:\s(.*)/i', $detachiso['error'], $matches)) {
                return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#iso-setting'])->with(['iso_error' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#iso-setting'])->with(['iso_error' => $detachiso['error']]);
    }

    public function labelSet(Request $request)
    {
        $data = [
            'SUBID' => $request->serverid,
            'label' => $request->label,
        ];

        $setlabel = $this->vultr->label_set([], $data);

        if (!isset($setlabel['error'])) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([

                'server_id' => $request->serverid,
                'label'     => $request->label,

            ])->log(__('Set server label'));

            // redirect and flush session
            return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#label-setting'])->with(['label_tag_message' => 'Label updated']);
        } else {
            if (preg_match('/response:\s(.*)/i', $setlabel['error'], $matches)) {
                return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#label-setting'])->with(['label_tag_error' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#label-setting'])->with(['label_tag_error' => $setlabel['error']]);
    }

    public function restoreSnapshot(Request $request)
    {
        $data = [
            'SUBID'      => $request->serverid,
            'SNAPSHOTID' => $request->snapshotid,
        ];

        $snaprestore = $this->vultr->restore_snapshot([], $data);

        if (!isset($snaprestore['error'])) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([

                'server_id'   => $request->serverid,
                'snapshot_id' => $request->snapshotid,

            ])->log(__('Restore server snapshot'));

            // redirect and flush session
            return redirect()->back()->with(['message' => 'A snapshot is currently being restored of this instance.']);
        } else {
            if (preg_match('/response:\s(.*)/i', $snaprestore['error'], $matches)) {
                return redirect()->back()->with(['message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.snapshots', ['serverid' => $request->serverid])->with(['type' => 'error', 'message' => $snaprestore['error']]);
    }

    public function tagSet(Request $request)
    {
        $data = [
            'SUBID' => $request->serverid,
            'tag'   => $request->tag,
        ];

        $settag = $this->vultr->tag_set([], $data);

        if (!isset($settag['error'])) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([

                'server_id' => $request->serverid,
                'tag'       => $request->tag,

            ])->log(__('Set server tag'));

            // redirect and flush session
            return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#label-setting'])->with(['type' => 'success', 'message' => 'Tag updated']);
        } else {
            if (preg_match('/response:\s(.*)/i', $settag['error'], $matches)) {
                return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#label-setting'])->with(['type' => 'error', 'message' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#label-setting'])->with(['type' => 'error', 'message' => $settag['error']]);
    }

    public function upgradePlan(Request $request)
    {
        $data = [
            'SUBID'     => $request->serverid,
            'VPSPLANID' => $request->vpsplan,
        ];

        $planupgrade = $this->vultr->upgrade_plan([], $data);

        if (!isset($planupgrade['error'])) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([

                'server_id' => $request->serverid,
                'plan_id'   => $request->vpsplan,

            ])->log(__('Upgrade server plan'));

            // redirect and flush session
            return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#plan-setting'])->with(['plan_message' => 'Subscription upgraded']);
        } else {
            if (preg_match('/response:\s(.*)/i', $planupgrade['error'], $matches)) {
                return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#plan-setting'])->with(['plan_error' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#plan-setting'])->with(['plan_error' => $planupgrade['error']]);
    }

    public function osChange(Request $request)
    {
        $data = [
            'SUBID' => $request->serverid,
            'OSID'  => $request->osid,
        ];

        $changeos = $this->vultr->os_change([], $data);

        if (!isset($changeos['error'])) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([

                'server_id' => $request->serverid,

            ])->log(__('Change server OS'));

            // redirect and flush session
            return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#os-setting'])->with(['os_message' => 'Operating system changed']);
        } else {
            if (preg_match('/response:\s(.*)/i', $changeos['error'], $matches)) {
                return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#os-setting'])->with(['os_error' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#os-setting'])->with(['os_error' => $changeos['error']]);
    }

    public function appChange(Request $request)
    {
        $data = [
            'SUBID' => $request->serverid,
            'APPID' => $request->application,
        ];

        $changeapp = $this->vultr->app_change([], $data);

        if (!isset($changeapp['error'])) {

            // clear cache
            Cache::forget('servers');

            activity()->withProperties([

                'application_id' => $request->application,
                'server_id'      => $request->serverid,

            ])->log(__('Change server application'));

            // redirect and flush session
            return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#application-setting'])->with(['application_message' => 'Application changed']);
        } else {
            if (preg_match('/response:\s(.*)/i', $changeapp['error'], $matches)) {
                return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#application-setting'])->with(['application_error' => str_replace('response:', null, $matches[0])]);
            }
        }

        return redirect()->route('servers.view.settings', ['serverid' => $request->serverid, '#application-setting'])->with(['application_error' => $changeapp['error']]);
    }
}
