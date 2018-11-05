<?php 

namespace vultrui\VultrLib;
use Illuminate\Support\Facades\Cache;

class Plan extends VultrUI {

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

	public function list( $listtype = null ){

		$listtype = !is_null($listtype) ? '_'.$listtype : null;

    	return $this->Request( 'GET' , "plans/list{$listtype}", true );
	}


}


