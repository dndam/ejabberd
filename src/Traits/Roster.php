<?php

namespace Ejabberd\Rest\Traits;

trait Roster
{
    /**
     * Creates a chat relation between two accounts
     *
     * @param string $user1
     * @param string $user2
     * @return mixed
     * @internal param string $param
     */
    public function addRosterItem($user1, $user2)
    {
        $response = $this->sendRequest(
            'add_rosteritem',
            [
                "localuser" => $user1,
                "localserver" => $this->host,
                "user" => $user2,
                "server" => $this->host,
                "nick" => $user2,
                "group" => "Friends",
                "subs" => "both"
            ]
        );

        return $response == 0;
    }

    /**
     * Removes a chat relation between two accounts
     *
     * @param string $user1
     * @param string $user2
     * @return mixed
     * @internal param string $param
     */
    public function removeRosterItem($user1, $user2)
    {
        $response = $this->sendRequest(
            'delete_rosteritem',
            [
                "localuser" => $user1,
                "localserver" => $this->host,
                "user" => $user2,
                "server" => $this->host
            ]
        );

        return $response == 0;
    }
}
