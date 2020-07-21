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
                'host' => $this->host
            ]
        );

        return $response == 0;
    }

    /**
     * Creates a user account
     *
     * @param string $accountName
     * @param $password
     * @return mixed
     * @internal param string $param
     */
    public function createAccount($accountName, $password)
    {
        $response = $this->sendRequest(
            'register',
            [
                "user" => $accountName,
                "password" => $password,
                "host" => $this->host
            ]
        );

        return $response == 0;
    }

    /**
     * @param string $accountName
     * @return int
     */
    public function getOfflineCount($accountName)
    {
        $response = $this->sendRequest(
            'get_offline_count',
            [
                "user" => $accountName,
                "server" => $this->host
            ]
        );

        return $response['value'];
    }

    /**
     * @param string $accountName
     * @return mixed
     */
    public function getLastActivity($accountName)
    {
        $response = $this->sendRequest(
            'get_last',
            [
                "user" => $accountName,
                "host" => $this->host
            ]
        );

        return $response;
    }
}
