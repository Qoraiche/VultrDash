<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class App extends VultrUI
{
    protected $AppImages = [

        'cpanel' 			         => 'apps/cpanel.svg',
        'docker' 			         => 'apps/docker.svg',
        'drupal' 			         => 'apps/drupal.svg',
        'gitlab' 			         => 'apps/gitlab.svg',
        'joomla' 			         => 'apps/joomla.svg',
        'lamp' 				          => 'apps/lamp.png',
        'lemp' 				          => 'apps/lemp.jpg',
        'minecraft' 		       => 'apps/minecraft.svg',
        'nextcloud' 		       => 'apps/nextcloud.svg',
        'nginx' 			          => 'apps/nginx.svg',
        'openvpn' 			        => 'apps/openvpn.svg',
        'owncloud' 			       => 'apps/owncloud.svg',
        'prestashop'		       => 'apps/prestashop.svg',
        'webmin'			          => 'apps/webmin.svg',
        'mediawiki'			       => 'apps/mediawiki.svg',
        'wordpress'			       => 'apps/wordpress.svg',
        'magento'			         => 'apps/magento.png',
        'plesk'				          => 'apps/plesk.svg',
        'pleskonyx_webpro'   => 'apps/plesk.svg',
        'pleskonyx_webadmin' => 'apps/plesk.svg',
        'pleskonyx_webhost'  => 'apps/plesk.svg',

    ];

    public function getServerAppImage($Appname)
    {
        if (!empty($Appname)) {
            $Appname = strtolower($Appname);
        }

        return isset($this->AppImages[$Appname]) ? $this->AppImages[$Appname] : 'undefined';
    }

    public function list()
    {
        return Cache::remember('applist', now()->addDays(2), function () {
            return $this->Request('GET', 'app/list', true);
        });
    }

    public function getAppByKeyId($appID, $keyName = 'short_name')
    {
        if (isset($appID) && !empty($appID)) {
            $list = $this->list();
        }

        if (is_array($list)) {
            return $list[$appID][$keyName];
        }
    }
}
