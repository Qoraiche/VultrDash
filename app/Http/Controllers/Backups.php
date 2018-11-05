<?php

namespace vultrui\Http\Controllers;

use vultrui\VultrLib\Backup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class Backups extends Controller
{

	protected $vultr;

	public function __construct(Backup $vultr)

	{
		
		// Assign auth middleware

		$this->middleware('auth');

		// server instance

		$this->vultr = $vultr;

	}

    public function index()
    {
  
        $View =  view('dash.backups')->with( 'backuplist', $this->vultr->list() );

        if ( array_key_exists( 'error', $this->vultr->list() ) ) {

            return view('errors.connection')->with('error' , $this->vultr->list()['error'] );
        }
        
        return $View;

    }
}
