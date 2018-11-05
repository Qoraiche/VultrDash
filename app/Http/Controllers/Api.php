
<?php

namespace vultrui\Http\Controllers;

use vultrui\VultrLib\Server;
use vultrui\VultrLib\Plan;
use vultrui\VultrLib\Region;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class Api extends Controller
{

	protected $vultr;
	
	protected $plan;

	protected $region;

	public function __construct(Server $vultr, Plan $plan, Region $region)
	{
		$this->vultr  =  $vultr;
		$this->plan   =  $plan;
		$this->region =  $region;
	}

	public function getPlans(){

		return response()->json( $this->plan->list() );
	}

	public function getRegions(){

    	return response()->json( $this->region->list() );
    }

}