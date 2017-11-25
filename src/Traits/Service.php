<?php

namespace Ejabberd\Rest\Traits;

trait Service
{

    /**
     * Check server status
     *
     */
    public function status()
    {
        $response = $this->sendRequest(
            'status',
            [
            ]
        );

        return $response == 0;
    }
}