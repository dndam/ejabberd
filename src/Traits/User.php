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

        return $response == 0;
    }

    /**
     * Creates a user account
     *
     * @param string $email
     * @param $password
     * @return mixed
     * @internal param string $param
     */
    public function createAccount($email, $password)
    {
        $response = $this->sendRequest(
            'register',
            [
                "user" => $email,
                "password" => $password,
                "host" => $this->host
            ]
        );

        return $response == 0;
    }
}
