<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Startup extends VultrUI
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
        return Cache::remember('startups', now()->addMinutes(2), function () {
            return $this->Request('GET', 'startupscript/list', true);
        });
    }

    public function create($headers, $params)
    {
        return $this->Request('POST', 'startupscript/create', true, $headers, $params);
    }

    public function destroy($headers, $params)
    {
        return $this->Request('POST', 'startupscript/destroy', true, $headers, $params);
    }
}
