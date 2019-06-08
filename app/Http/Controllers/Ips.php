<?php

namespace vultrui\Http\Controllers;

use vultrui\VultrLib\Ip;
use vultrui\VultrLib\Region;

class Ips extends Controller
{
    protected $vultr;

    public function __construct(Ip $vultr, Region $region)
    {

        // Assign auth middleware

        $this->middleware('auth');

        // server/region instance

        $this->vultr = $vultr;
        $this->region = $region;
    }

    public function index()
    {
        $View = view('dash.ips')->with(['regions' => $this->region->list(), 'ips' => $this->vultr->list()]);

        if (array_key_exists('error', $this->vultr->list())) {
            return view('errors.connection')->with('error', $this->vultr->list()['error']);
        }

        return $View;
    }
}
