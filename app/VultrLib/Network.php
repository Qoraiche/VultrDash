<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Network extends VultrUI
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
        return Cache::remember('networks', now()->addMinutes(2), function () {
            return $this->Request('GET', 'network/list', true);
        });
    }

    public function create($headers, $params)
    {
        return $this->Request('POST', 'network/create', true, $headers, $params);
    }

    public function destroy($headers, $params)
    {
        return $this->Request('POST', 'network/destroy', true, $headers, $params);
    }
}
