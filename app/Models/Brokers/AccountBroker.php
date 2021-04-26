<?php namespace Models\Brokers;

use Models\Classes\Queries;
use Models\Classes\User;
use Zephyrus\Application\Session;

class AccountBroker extends Broker
{
    public function getById(string $id): User
    {
        $sql = Queries::getUserById($id);
        $result = $this->selectSingle($sql, [$id]);
        return new User($result);
    }
}
