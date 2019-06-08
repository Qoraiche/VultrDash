<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Os extends VultrUI
{
    protected $OsFamilyImages = [

        'windows' 		   => 'os/windows.svg',
        'centos' 		    => 'os/centos.svg',
        'freebsd' 		   => 'os/freebsd.svg',
        'iso' 			      => 'os/iso.svg',
        'ubuntu' 		    => 'os/ubuntu.svg',
        'snapshot' 		  => 'os/snapshot.svg',
        'coreos' 		    => 'os/coreos.svg',
        'backup' 		    => 'os/backup.svg',
        'application' 	=> 'os/application.svg',
        'debian' 		    => 'os/debian.svg',
        'fedora' 		    => 'os/fedora.svg',
        'openbsd'		    => 'os/openbsd.svg',

    ];

    public function getServerOSImage($Osfamily)
    {
        if (!empty($Osfamily)) {
            $Osfamily = strtolower($Osfamily);
        }

        return isset($this->OsFamilyImages[$Osfamily]) ? strtolower($this->OsFamilyImages[$Osfamily]) : $Osfamily;
    }

    public function list()
    {
        return Cache::remember('oslist', now()->addDays(2), function () {
            return $this->Request('GET', 'os/list', true);
        });
    }

    public function getOsByKeyId($osID, $keyName = 'name')
    {
        if (isset($osID) && !empty($osID)) {
            $list = $this->list();
        }

        if (is_array($list) && !empty($list)) {
            return isset($list[$osID][$keyName]) ? strtolower($list[$osID][$keyName]) : 'undefined';
        }
    }
}
