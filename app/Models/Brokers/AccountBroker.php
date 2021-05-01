<?php namespace Models\Brokers;

use Models\Classes\Queries;
use Models\Classes\User;

class AccountBroker extends Broker
{
    public function getById(string $id): User
    {
        $sql = Queries::getUserByIdQuery();
        $result = $this->selectSingle($sql, [$id]);
        return new User($result);
    }

    public function getByUsername(string $username): User
    {
        $sql = Queries::getUserByUsernameQuery();
        $result = $this->selectSingle($sql, [$username]);
        return new User($result);
    }
}
