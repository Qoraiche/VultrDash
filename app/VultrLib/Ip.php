<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Ip extends VultrUI
{
    /**
     * This method allows to retrieve information about the current account.
     *
     * Endpoint: account/info
     *
     * HTTP Method: GET
     *
     * HTTP parameters: No parameters
     */
    public function list()
    {
        return Cache::remember('ips', now()->addHours(2), function () {
            return $this->Request('GET', 'reservedip/list', true);
        });
    }
}
