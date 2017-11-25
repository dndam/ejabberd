<?php

namespace Ejabberd\Rest\Traits;

trait User
{

    /**
     * Check if ejabberd user account already exists.
     *
     * @param string $user
     *
     * @return bool
     */
    public function checkAccount($user)
    {
        $response = $this->sendRequest(
            'check_account',
            [
                'user' => $user,
//                'host' => $this->host
            ]
        );

        return $response['res'] == 0;
    }
}