<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Snapshot extends VultrUI
{
    public function list()
    {
        return Cache::remember('snapshots', now()->addMinutes(5), function () {
            return $this->Request('GET', 'snapshot/list', true);
        });
    }

    public function create($headers, $params)
    {
        return $this->Request('POST', 'snapshot/create', true, $headers, $params);
    }

    public function create_from_url($headers, $params)
    {
        return $this->Request('POST', 'snapshot/create_from_url', true, $headers, $params);
    }

    public function destroy($headers, $params)
    {
        return $this->Request('POST', 'snapshot/destroy', true, $headers, $params);
    }
}
