<?php namespace Models\Brokers;

use Models\Classes\Queries;
use Models\Classes\User;

class SignUpBroker extends Broker
{
    function insert(User $user)
    {
        $sql = Queries::getUserInsertQuery();
        $this->query($sql, [
            $user->firstname,
            $user->lastname,
            $user->username,
            $user->email,
            $user->phone,
            $user->password,
            $user->secret
        ]);
        $sql = Queries::getUserByUsernameQuery();
        $user->id = $this->selectSingle($sql, [$user->username])->id;
    }

    function usernameTaken(string $username): bool
    {
        $sql = Queries::getUsernameExistQuery();
        if (is_null($this->selectSingle($sql, [$username]))) {
            return false;
        }
        return true;
    }
}
