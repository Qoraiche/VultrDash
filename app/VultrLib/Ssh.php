<?php 

namespace vultrui\VultrLib;
use Illuminate\Support\Facades\Cache;

class Ssh extends VultrUI {

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

		return Cache::remember('sshkeys', now()->addMinutes(2), function () {

    		return $this->Request( 'GET' , 'sshkey/list', true);
    		
		});

	}

	public function create( $headers, $params ){

			return $this->Request( 'POST' , 'sshkey/create', true, $headers, $params);

	}

	public function update( $headers, $params ){

			return $this->Request( 'POST' , 'sshkey/update', true, $headers, $params);

	}

	public function destroy( $headers, $params ){

			return $this->Request( 'POST' , 'sshkey/destroy', true, $headers, $params);

	}

}


