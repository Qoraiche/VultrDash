<?php 

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Storage extends VultrUI {

	/**
	  * This method allows to retrieve information about the current account.
	  *
	  * Endpoint: account/info
	  *
	  * HTTP Method: GET
	  *
	  * HTTP parameters: No parameters
	  *
	*/

	public function list(){

		return Cache::remember('storages', now()->addMinutes(5), function () {

			return $this->Request( 'GET' , 'block/list', true);
		
		});

	}

	public function create( $headers, $params ){

		return $this->Request( 'POST' , 'block/create', true, $headers, $params);

	}


	public function delete( $headers, $params ){

		return $this->Request( 'POST' , 'block/delete', true, $headers, $params);

	}


}


