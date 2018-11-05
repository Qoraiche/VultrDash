<?php 

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Firewall extends VultrUI {


	public function group_list()
	{

		return Cache::remember('firewalls', now()->addHours(2), function () {

			return $this->Request( 'GET' , 'firewall/group_list', true);
		
		});
	}

	public function group_delete($headers, $params)
	{
		return $this->Request( 'POST' , 'firewall/group_delete', true, $headers , $params);

	}

}