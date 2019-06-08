<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Iso extends VultrUI
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
        return Cache::remember('isos', now()->addMinutes(2), function () {
            return $this->Request('GET', 'iso/list', true);
        });
    }

    public function list_public()
    {
        return Cache::remember('isos_library', now()->addDays(2), function () {
            return $this->Request('GET', 'iso/list_public', true);
        });

        // return $isoList;
    }

    public function create_from_url($headers, $params)
    {
        return $this->Request('POST', 'iso/create_from_url', true, $headers, $params);
    }
}
