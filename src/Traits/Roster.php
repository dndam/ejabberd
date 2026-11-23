<?php

namespace Ejabberd\Rest\Traits;

trait Roster
{
    /**
     * ejabberd 26.09 (v1) requires localhost, host and groups (array).
     * Existing two-argument calls remain supported.
     */
    public function addRosterItem($user1, $user2, $nick = null, array $groups = ['Friends'], $subscription = 'both')
    {
        return $this->commandSucceeded($this->sendRequest('add_rosteritem', [
            'localuser' => $user1,
            'localhost' => $this->host,
            'user' => $user2,
            'host' => $this->host,
            'nick' => $nick === null ? $user2 : $nick,
            'groups' => $groups,
            'subs' => $subscription,
        ]));
    }

    public function removeRosterItem($user1, $user2)
    {
        return $this->commandSucceeded($this->sendRequest('delete_rosteritem', [
            'localuser' => $user1,
            'localhost' => $this->host,
            'user' => $user2,
            'host' => $this->host,
        ]));
    }

    /** @return array Contacts from the ejabberd REST get_roster command. */
    public function getRoster($user)
    {
        $contacts = $this->sendRequest('get_roster', [
            'user' => $user, 'host' => $this->host,
        ]);
        if (!is_array($contacts)) {
            throw new \RuntimeException('Unexpected get_roster response');
        }
        return $contacts;
    }

    /** Ensure both users see each other as subscribed contacts; repeatable safely. */
    public function ensureMutualRoster($patient, $physician)
    {
        if ($patient === $physician) {
            throw new \InvalidArgumentException('Roster pair must contain two different users');
        }
        $this->ensureRosterDirection($patient, $physician, ['Medical Team']);
        $this->ensureRosterDirection($physician, $patient, ['Patients']);
        return true;
    }

    protected function ensureRosterDirection($owner, $contact, array $groups)
    {
        $jid = strtolower($contact . '@' . $this->host);
        foreach ($this->getRoster($owner) as $item) {
            if (isset($item['jid'], $item['subscription']) &&
                strtolower($item['jid']) === $jid &&
                strtolower($item['subscription']) === 'both') {
                return;
            }
        }
        if (!$this->addRosterItem($owner, $contact, $contact, $groups, 'both')) {
            throw new \RuntimeException('Cannot ensure roster for ' . $owner . ' -> ' . $contact);
        }
    }
}
