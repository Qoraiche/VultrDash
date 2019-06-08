<?php

namespace vultrui\VultrLib;

class BareMetal extends VultrUI
{
    public function getBackupList()
    {
        if ($this->isAuth()) {
            try {
                $response = $this->Request('GET', 'backup/list');

                if ($response->getStatusCode() == '200') {
                    return json_decode($response->getBody()->getContents());

                    //return $this->http_responses[ $response->getStatusCode() ];
                }
            } catch (GuzzleException $e) {
                return $e->getmessage();
            }
        }
    }
}
