<?php

namespace Ejabberd\Rest\Traits;

trait User
{
    public function checkAccount($user)
    {
        return $this->commandSucceeded($this->sendRequest('check_account', [
            'user' => $user, 'host' => $this->host,
        ]));
    }

    public function createAccount($accountName, $password)
    {
        return $this->commandSucceeded($this->sendRequest('register', [
            'user' => $accountName,
            'host' => $this->host,
            'password' => $password,
        ]));
    }

    /**
     * Idempotent provisioning: do not reset an existing account's password.
     * If registration fails due to a concurrent request, confirm existence.
     */
    public function ensureAccount($accountName, $password)
    {
        if ($this->checkAccount($accountName)) {
            return true;
        }
        try {
            if ($this->createAccount($accountName, $password)) {
                return true;
            }
        } catch (\RuntimeException $exception) {
            if ($this->checkAccount($accountName)) {
                return true;
            }
            throw $exception;
        }
        return $this->checkAccount($accountName);
    }

    public function getOfflineCount($accountName)
    {
        $response = $this->sendRequest('get_offline_count', [
            'user' => $accountName, 'host' => $this->host,
        ]);
        // ejabberd 26.09 returns a JSON number; support the old shape too.
        if (is_array($response) && isset($response['value'])) {
            $response = $response['value'];
        }
        if (!is_numeric($response)) {
            throw new \RuntimeException('Unexpected get_offline_count response');
        }
        return (int) $response;
    }

    public function getLastActivity($accountName)
    {
        return $this->sendRequest('get_last', [
            'user' => $accountName, 'host' => $this->host,
        ]);
    }
}
