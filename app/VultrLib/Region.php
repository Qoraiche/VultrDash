<?php 

namespace vultrui\VultrLib;
use Illuminate\Support\Facades\Cache;

class Region extends VultrUI {

	/**
	  * This method allows to retrieve information about the current account.
	  *
	  * HTTP Method: GET
	  *
	  * HTTP parameters: No parameters
	  *
	*/

	public function list(){


	$regionsList = Cache::remember('regions', now()->addDays(2), function () {

    	return $this->Request( 'GET' , 'regions/list', true);
    		
	});

	return $regionsList;

	}

	public function availability( $dcid, $listtype = null, $type = 'all' ){

		$listtype = !is_null($listtype) ? '_'.$listtype : null;

		return $this->Request( 'GET' , "regions/availability{$listtype}?DCID={$dcid}&type={$type}", true);

	}


}


