<?php

namespace vultrui\VultrLib;

use Illuminate\Support\Facades\Cache;

class Account extends VultrUI
{
    public function info()
    {
        $accountInfo = Cache::remember('accountinfo', now()->addHours(1), function () {
            return $this->Request('GET', 'account/info');
        });

        return $accountInfo;
    }

    public function AuthInfo()
    {
        $accountAuth = Cache::remember('accountauth', now()->addDays(1), function () {
            return $this->Request('GET', 'auth/info');
        });

        return $accountAuth;
    }
}
