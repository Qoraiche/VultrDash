<?php

/**
 *  Server Resources.
 */

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Server extends VultrUI
{
    public function list()
    {
        return Cache::remember('servers', now()->addMinutes(2), function () {
            return $this->Request('GET', 'server/list', true);
        });
    }

    public function create($headers, $params)
    {
        return $this->Request('POST', 'server/create', true, $headers, $params);
    }

    public function halt($headers, $params)
    {
        return $this->Request('POST', 'server/halt', true, $headers, $params);
    }

    public function start($headers, $params)
    {
        return $this->Request('POST', 'server/start', true, $headers, $params);
    }

    public function reinstall($headers, $params)
    {
        return $this->Request('POST', 'server/reinstall', true, $headers, $params);
    }

    public function destroy($headers, $params)
    {
        return $this->Request('POST', 'server/destroy', true, $headers, $params);
    }

    public function firewall_group_set($headers, $params)
    {
        return $this->Request('POST', 'server/firewall_group_set', true, $headers, $params);
    }

    public function backup_enable($headers, $params)
    {
        return $this->Request('POST', 'server/backup_enable', true, $headers, $params);
    }

    public function backup_disable($headers, $params)
    {
        return $this->Request('POST', 'server/backup_disable', true, $headers, $params);
    }

    public function backup_set_schedule($headers, $params)
    {
        return $this->Request('POST', 'server/backup_set_schedule', true, $headers, $params);
    }

    public function backup_get_schedule($headers, $params)
    {
        return $this->Request('POST', 'server/backup_get_schedule', true, $headers, $params);
    }

    public function app_change($headers, $params)
    {
        return $this->Request('POST', 'server/app_change', true, $headers, $params);
    }

    public function app_change_list($subid = null)
    {
        $subid = !is_null($subid) ? '?SUBID='.$subid : null;

        return $this->Request('GET', "server/app_change_list{$subid}", true);
    }

    public function os_change($headers, $params)
    {
        return $this->Request('POST', 'server/os_change', true, $headers, $params);
    }

    public function os_change_list($subid = null)
    {
        $subid = !is_null($subid) ? '?SUBID='.$subid : null;

        return $this->Request('GET', "server/os_change_list{$subid}", true);
    }

    public function private_network_enable($headers, $params)
    {
        return $this->Request('POST', 'server/private_network_enable', true, $headers, $params);
    }

    public function private_network_disable($headers, $params)
    {
        return $this->Request('POST', 'server/private_network_disable', true, $headers, $params);
    }

    public function private_networks($subid = null)
    {
        $subid = !is_null($subid) ? '?SUBID='.$subid : null;

        return $this->Request('GET', "server/private_networks{$subid}", true);
    }

    public function neighbors($subid = null)
    {
        $subid = !is_null($subid) ? '?SUBID='.$subid : null;

        return $this->Request('GET', "server/neighbors{$subid}", true);
    }

    public function bandwidth($subid = null)
    {
        return Cache::remember("bandwidth_$subid", now()->addDays(1), function () use ($subid) {
            $subid = !is_null($subid) ? '?SUBID='.$subid : null;

            return $this->Request('GET', "server/bandwidth{$subid}", true);
        });
    }

    public function get_app_info($subid = null)
    {
        $subid = !is_null($subid) ? '?SUBID='.$subid : null;

        return $this->Request('GET', "server/get_app_info{$subid}", true);
    }

    public function restore_backup($headers, $params)
    {
        return $this->Request('POST', 'server/restore_backup', true, $headers, $params);
    }

    public function restore_snapshot($headers, $params)
    {
        return $this->Request('POST', 'server/restore_snapshot', true, $headers, $params);
    }

    public function upgrade_plan($headers, $params)
    {
        return $this->Request('POST', 'server/upgrade_plan', true, $headers, $params);
    }

    public function upgrade_plan_list($subid = null)
    {
        $subid = !is_null($subid) ? '?SUBID='.$subid : null;

        return $this->Request('GET', "server/upgrade_plan_list{$subid}", true);
    }

    public function label_set($headers, $params)
    {
        return $this->Request('POST', 'server/label_set', true, $headers, $params);
    }

    public function tag_set($headers, $params)
    {
        return $this->Request('POST', 'server/tag_set', true, $headers, $params);
    }

    public function iso_attach($headers, $params)
    {
        return $this->Request('POST', 'server/iso_attach', true, $headers, $params);
    }

    public function iso_detach($headers, $params)
    {
        return $this->Request('POST', 'server/iso_detach', true, $headers, $params);
    }

    public function iso_status($subid = null)
    {
        $subid = !is_null($subid) ? '?SUBID='.$subid : null;

        return $this->Request('GET', "server/iso_status{$subid}", true);
    }
}
