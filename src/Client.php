<?php

namespace Ejabberd\Rest;

use GuzzleHttp\Client as GuzzleHttpClient;

/**
 * Ejabberd XMPP connection client
 *
 * @package Ejabberd\Rest
 */
class Client {

    /**
     * @var GuzzleHttpClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $url;

    public function __construct()
    {
        // Config ? uri, port? logger?
        $this->client = new GuzzleHttpClient([
            'base_uri' => $this->url
        ]);
    }

    public function callUser($entity, $payload)
    {
        // Indian style
        // Factory: no autocomplete
        // Proxy: No autocomplete
        // Traits:
        try{
            $response = $this->client->post('api/check_account', ['json' => ['user' => $user, 'host' => $this->config['domain']]])
        }catch (\Exception $exception)
        {
            //Log ?
            throw new \RuntimeException();
        }

        return $response->getBody();
    }

    public function doSmth ()
    {
        echo "essi";

    }

}