<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Dns extends VultrUI
{
    public function list()
    {
        return Cache::remember('dnsdomains', now()->addMinutes(5), function () {
            return $this->Request('GET', 'dns/list', true);
        });
    }

    public function create_domain($headers, $params)
    {
        return $this->Request('POST', 'dns/create_domain', true, $headers, $params);
    }

    public function delete_domain($headers, $params)
    {
        return $this->Request('POST', 'dns/delete_domain', true, $headers, $params);
    }
}
