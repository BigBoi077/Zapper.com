<?php namespace Models\Brokers;

use Models\Classes\Queries;
use Models\Classes\User;
use stdClass;

class SignUpBroker extends Broker
{
    function insert(User $user): ?stdClass
    {
        $sql = Queries::getUserInsertQuery();
        $this->query($sql, [
            $user->firstname,
            $user->lastname,
            $user->username,
            $user->email,
            $user->phone,
            $user->password
        ]);
        $sql = Queries::getLastInsertQuery();
        var_dump($this->selectSingle($sql));
        $user->id = strval($this->selectSingle($sql)['currval']);
    }
}
