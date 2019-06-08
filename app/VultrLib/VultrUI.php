<?php

namespace vultrui\VultrLib;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;

class VultrUI
{
    /**
     * Vultr API Endpoint.
     */
    public $endpoint = 'https://api.vultr.com/v1/';

    /**
     * Either to verify SSL certificate or not (false).
     */
    public $verify_ssl = false;

    /**
     * Guzzle Client.
     */
    private $client = null;

    /**
     * API Authentication Key.
     */
    public $auth_key;

    /**
     * errors handler.
     */
    public function __construct()
    {
        $this->auth_key = config('app.vultr_authkey');

        $this->client = new Client([

            'base_uri' => $this->endpoint,

        ]);
    }

    public function Request($method, $resource, $body = true, $headers = [], $params = [])
    {

        /**
         * Add API Authentication key to headers.
         */
        $Hdata = ['API-Key' => $this->auth_key];

        /*
          * Headers
          *
        */

        if (!empty($headers)) {
            foreach ($headers as $key => $value) {
                $Hdata[$key] = $value;
            }
        }

        try {
            $resp = $this->client->request($method, $resource,

            [
                'verify' => $this->verify_ssl,

                'headers' => $Hdata,

                'form_params' => $params,

            ]);

            return ($body === true) ? json_decode($resp->getBody()->getContents(), true) : $resp;
        } catch (ClientException $e) {
            return ['error' => $e->getMessage()];
        } catch (GuzzleException $b) {
            return ['error' => $b->getMessage()];
        } catch (ConnectException $c) {
            return ['error' => $c->getMessage()];
        }
    }
}
