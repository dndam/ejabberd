<?php

namespace Ejabberd\Rest\Traits;

trait Service
{
    public function status()
    {
        $response = $this->sendRequest('status', []);
        return is_string($response) && strpos($response, 'started') !== false;
    }
}
